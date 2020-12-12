<?php

namespace App\Repositories;

use Auth;
use App\Helpers\Tink;
use App\Helpers\Firebase;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Services\ActivityLogService;

use App\Notifications\InviteCustomer;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class CustomerRepository extends BaseRepository
{
    protected $customerService;

    public function __construct(CustomerService $customerService, ActivityLogService $activityLogService, UserService $userService)
    {
        $this->customerService = $customerService;
        $this->activityLogService = $activityLogService;
        $this->userService = $userService;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->customerService->paginate();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function detail($id)
    {
        $customer =  $this->customerService->find($id);

        $customers = $this->customerService->paginate();

        return view('manage.onboarding.customer-detail', compact('customer', 'customers', 'id'));
    }


    public function dataTables(Request $request)
    {
        $user = \Auth::user();
        // $stageId = config('config.mautic.stages.onboarding');
        $segmentId = config('config.mautic.segment.onboarding');
        $contactParam['firstname'] = $user->name;
        $contactParam['email'] = $user->email;
        $contactParam['ipAddress'] = request()->ip();
        $contactParam['lastActive'] = date('Y-m-d H:m:i');
        $contactParam['overwriteWithBlank'] = true;
        
        $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);

        return $this->customerService->dataTables();
    }

    public function inviteCustomer(Request $request)
    {
        try {

            $email = $request->email;
            $name = $request->company_name;
            $user = Auth::user();
            $customer = $this->customerService->findBy([
                'email' => $email,
                'user_id' => $user->id
            ]);
            $totalOnboarding = $user->subscriptionCheck($user, config('config.subscription.onboarding'));
            
            // $stageId = config('config.mautic.stages.onboarding-invite-customer');
            $segmentId = config('config.mautic.segment.onboarding-invite-customer');
            $contactParam['firstname'] = $user->name;
            $contactParam['email'] = $user->email;
            $contactParam['ipAddress'] = request()->ip();
            $contactParam['lastActive'] = date('Y-m-d H:m:i');
            $contactParam['overwriteWithBlank'] = true;
            
            $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);

            if (!$totalOnboarding) {
                return redirect(route('onboarding.index'))->with('error', 'You have no onboarding left');
            }

            if (!$customer) {
                $customer = $this->customerService->createCustomer([
                    'email' => $email,
                    'user_id' => $user->id,
                    'name' => $name,
                    'account_number' => $user->company->account_number,
                ]);

                $this->customerService->activityLog($customer, 'New onboarding', 'success', 'Onboarding');
                $user->useSubscription($user, 1, config('config.subscription.onboarding'));
            } else {
                return redirect(route('onboarding.index'))->with('error', $email . ' email already verified');
            }

            Notification::route('mail', $email)->notify(new InviteCustomer($customer));
            $this->customerService->activityLog($customer, 'Onboarding mail sent', 'success', 'Mail sent');
            return redirect(route('onboarding.index'))->with('status', 'Send mail to customer successfully');
        } catch (\Exception $e) {
            return redirect(route('onboarding.index'))->with('error', 'Failed to send mail');
        }
    }

    public function customerVerification($verficationCode)
    {
        if ($verficationCode) {
            $customer = $this->customerService->findBy([
                'verification_token' => $verficationCode
            ]);

            if ($customer) {
                $this->customerService->updateById($customer->id, [
                    'is_email_verified' => true
                ]);
                $this->customerService->activityLog($customer, 'Onboarding email verified', 'success', 'Onboarding verfication');
                return view('manage.customer.dashboard', compact('customer'));
            } else {
                return view('manage.customer.invalid-link', compact('customer'));
            }
        }
    }

    public function verifyPhoneOtp(Request $request)
    {
        try {
            $firebase = new Firebase();
            $response = $firebase->verifyOtp($request->code, $request->verificationId);
            $customer = $this->customerService->find($request->customerId);
            if ($response->phoneNumber) {
                $this->customerService->verifyCustomerById($request->customerId, $response->phoneNumber);
                $this->customerService->activityLog($customer, 'Phone number varify successfully', 'success', 'Onboarding verification');
                return response()->json(['message' => 'Phone number verify successfully'], 200);
            } else {
                $this->customerService->activityLog($customer, 'Phone number varify failed', 'Failed', 'Onboarding verification');
                return response()->json(['message' => 'Phone number verify failed'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function accountVerification(Request $request)
    {
        request()->session()->put('customer_id', $request->customer_id);

        $tink = new Tink();

        return redirect($tink->verificationLink());
    }

    public function tinkCallback($code)
    {
        try {
            $customerId = request()->session()->get('customer_id');

            $customer = $this->customerService->find($customerId);

            if ($customer) {

                $tink = new Tink();

                $tinkAuthentication = $tink->authenticateToken($code);

                $userProfile = $tink->getUserProfile($tinkAuthentication->access_token);

                $accountList = $tink->getAccountList($tinkAuthentication->access_token);
                $customer->name = $userProfile->name;
                $customer->currency_code = $userProfile->currency;
                $customer->gender = $userProfile->gender == 'male' ? 1 : 2;
                $customer->save();


                $customer = $this->customerService->createCustomerAccount($customer, $accountList);

                return view('manage.customer.successfull-verification', compact('customerId'));
            }

            return view('manage.customer.error-verification', compact('customerId'));
        } catch (\Exception $e) {
            return view('manage.customer.error-verification', compact('customerId'));
        }
    }

    public function uploadDocument(Request $request)
    {
        if ($request->has('customerDocument')) {

            if ($this->customerService->addMultipleDocument($request->customerDocument, $request->customer_id)) {
                return response()->json(['message' => 'Document uploaded successfully',], 200);
            }

            return response()->json(['message' => 'Document upload failed',], 422);
        }
    }

    public function updateCustomerSanctionList($id)
    {
        try {
            $customer =  $this->customerService->find($id);
            $isInSanctionList = $this->customerService->checkCustomerIsInSanctionList($customer);
            if ($isInSanctionList) {
                $customer->is_in_sanction_list = 1;
                $customer->save();
            }
            return response()->json(['message' => 'Sanction list updated'], 200);
        } catch (\Exception $e) {
            \Log::info($e);
            return response()->json(['message' => 'Something went wrong'], 422);
        }
    }

    public function checkCustomerVerification($request)
    {
        try {
            $customer =  $this->customerService->find($request->customerId);
            if ($customer->is_address_verified) {
                return 1;
            }
            return 0;
        } catch (\Exception $e) {
            \Log::info($e);
            return response()->json(['message' => 'Something went wrong'], 422);
        }
    }
}
