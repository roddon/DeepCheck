<?php

namespace App\Services;

use Auth;
use Hash;
use DataTables;
use Carbon\Carbon;
use Stripe\Charge;
use App\Models\User;
use App\Helpers\Mautic;
use Stripe\StripeClient;
use Illuminate\Support\Str;
use App\Models\UserPlanCheck;
use App\Services\BaseService;
use App\Models\UserSettingMail;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Laravel\Cashier\Subscription;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\SubscriptionPlanRecord;
use App\Helpers\SubscriptionPlan as SubscriptionPlanHelper;

class UserService extends BaseService
{
    protected $model;
    protected $isUpdatedPlan = false;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * find user by email and password
     * @param string $email
     * @param string $password
     */
    public function login(string $email, string $password)
    {
        return $this->model->get()->filter(function ($user) use ($email, $password) {

            if ($password == $user->password && $user->email == $email) {
                return $user;
            }
        })->first();
    }


    /**
     * find user by email and password
     * @param string $email
     * @param string $password
     */
    public function adminLogin(string $email, string $password)
    {
        return $this->model->whereHas('roles', function ($query) {
            return $query->where('name', User::ADMIN);
        })->get()->filter(function ($user) use ($email, $password) {

            if ($password == $user->password && $user->email == $email) {
                return $user;
            }
        })->first();
    }

    /**
     * create new user information
     * @param array $user
     */
    public function memberUserCreate($userData)
    {

        $userData['email']  = $userData['username'] = $userData['email'];
        if (isset($userData['password_confirmation'])) {
            unset($userData['password_confirmation']);
        }

        $email = $userData['email'];

        $user = $this->model->get()->filter(function ($user) use ($email) {
            // Checking email is already exists
            if ($user->email == $email || $user->username == $email) {
                return $user;
            }
        })->first();

        if (!$user) {
            $userData['verification_token'] = $this->encrypt(Carbon::now()->getTimestamp() .  Str::random(10));
            $member = $this->model->create($userData);
            $member->assignRole(User::MEMBER);
            return $member;
        }

        return false;
    }

    /**
     * create new user information
     * @param array $user
     */
    public function memberFromCheckInvoceCreate($userData)
    {

        $userData['email']  = $userData['username'] = $userData['email'];
        if (isset($userData['password_confirmation'])) {
            unset($userData['password_confirmation']);
        }

        $email = $userData['email'];

        $userData['verification_token'] = $this->encrypt(Carbon::now()->getTimestamp() .  Str::random(10));
        $member = $this->model->create($userData);
        $member->assignRole(User::MEMBER);
        return $member;
    }


    public function checkEmailExists($email)
    {
        return $this->model->get()->filter(function ($user) use ($email) {
            // Checking email is already exists
            if ($user->email == $email) {
                return $user;
            }
        })->first();
    }


    public function checkContactExists($contactNumber)
    {
        return $this->model->get()->filter(function ($user) use ($contactNumber) {
            // Checking email is already exists
            if ($user->contact_number == $contactNumber) {
                return $user;
            }
        })->first();
    }


    /**
     * create new user information
     * @param array $user
     */
    public function createAdminUser($userData)
    {

        $userData['email']  = $userData['userDataname'] = $userData['email'];
        $userData['status'] = true;
        if (isset($userData['password_confirmation'])) {
            unset($userData['password_confirmation']);
        }
        $email = $userData['email'];

        $user = $this->model->where('status', true)->get()->filter(function ($user) use ($email) {
            // Checking email is already exists
            if ($user->email == $email) {
                return $user;
            }
        })->first();

        if (!$user) {
            $user = $this->model->create($userData);
            $user->assignRole(User::ADMIN);
            return $user;
        }
        return false;
    }

    /**
     * update user information
     * @param array $userData
     */
    public function updateUser(array $userData)
    {
        if (isset($userData['password']) && $userData) {
            $userData['password'] = $userData['password'];
        }

        return $this->model->where('id', Auth::user()->id)->update($userData);
    }

    /**
     * find user by email
     * @param string $email
     */
    public function findByEmail(string $email)
    {
        return $this->model->whereEmail($email)->first();
    }



    public function allMembers()
    {
        $query = $this->newQuery()->whereHas('roles', function ($query) {
            return $query->where('name', User::MEMBER);
        });
        $query = QueryBuilder::for($query)
            ->defaultSort('-id')->with(['company']);

        return DataTables::of($query)
            ->editColumn('status', function (User $user) {
                return $user->present()->status;
            })
            ->addColumn('statusColorClass', function (User $user) {
                return $user->present()->statusColor;
            })
            ->addColumn('role', function (User $user) {
                return $user->hasRole('admin') ? 'Admin' : 'Member';
            })
            ->editColumn('company.name', function (User $user) {
                return optional($user->company)->name;
            })
            ->editColumn('company.account_number', function (User $user) {
                return optional($user->company)->account_number;
            })
            ->rawColumns(['name', 'status', 'statusColor'])
            ->addIndexColumn()
            ->toJson();
    }



    public function allAdminUsers()
    {
        $query = $this->newQuery()->whereHas('roles', function ($query) {
            return $query->where('name', User::ADMIN);
        })->where('id', '!=', Auth::user()->id);

        $query = QueryBuilder::for($query)
            ->defaultSort('-id');

        return DataTables::of($query)
            ->editColumn('status', function (User $user) {
                return $user->present()->status;
            })
            ->addColumn('statusColorClass', function (User $user) {
                return $user->present()->statusColor;
            })
            ->addColumn('role', function (User $user) {
                return $user->hasRole('admin') ? 'Admin' : 'Member';
            })

            ->rawColumns(['name', 'status', 'statusColor'])
            ->addIndexColumn()
            ->toJson();
    }

    public function update($data, $userId)
    {
        $user = $this->model->where('id', $userId)->update($data);
    }

    public function userDetailBySftpToken($request)
    {
        return $this->model->where('sftp_token', $request->sftp_token)->first();
    }


    public function getUserSettingEmail()
    {
        return UserSettingMail::first();
    }

    public function paymentPlan($request)
    {
        try {
            $planDetails = $request->planDetails;
            $paymentMethodId = $request->paymentMethodId;
            $isAutoTopUp = $request->isAutoTopUp;
            $totalAmount = $request->totalAmount;
            

            $user = $request->user();

            $stripePayment = 100 * $request->totalAmount;
            $subscriptionPlanHelper = new SubscriptionPlanHelper();

            if ($user->stripe_id) {
                $this->isUpdatedPlan = true;
                $stripePayment = $this->calculatePaymentPrice($user, $planDetails, $totalAmount);
                $subscriptionPlanHelper->autoPayment($user, $stripePayment);
            } else {
                $stripePayment = $this->calculatePaymentPrice($user, $planDetails, $totalAmount);
                $subscriptionPlanHelper->chargePayment($user, $stripePayment, $paymentMethodId);
            }

            $userSubscriptionIds = [];

            if ($this->isUpdatedPlan) {
                UserSubscription::where('user_id', $user->id)->update(
                    [
                        'is_active' => 0
                    ]
                );
            }

            foreach ($planDetails as $plan) {
                $subscriptionPlan = SubscriptionPlan::find($plan['subPlanId']);
                $subscriptionPlanRecord = SubscriptionPlanRecord::find($plan['subPlanRecordId']);

                $dates = $this->calculateDate($subscriptionPlan);

                $planWisePrice = $this->planWisePrice($plan['subPlanId'], $user, $subscriptionPlanRecord->price);

                $userSubscription = UserSubscription::create(
                    [
                        'user_id' => $user->id,
                        'subscription_id' => $plan['subPlanId'],
                        'start_date' => $dates['startDate'],
                        'end_date' => $dates['endDate'],
                        'next_due_date' => $dates['endDate'],
                        'automatic_top_up' => $isAutoTopUp,
                        'is_active' => 1,
                        'subscription_plan_record_id' => $plan['subPlanRecordId'],
                        'paid_price' => $planWisePrice
                    ]
                );

                $userSubscriptionIds[] = $userSubscription->id;
            }
            $userSubIds = implode(',', $userSubscriptionIds);
            $this->userSubscriptionCheck($user, $userSubIds, $subscriptionPlan, $subscriptionPlanRecord, $planDetails);

            $userDetails = $this->find($user->id);
            $userDetails->status = 1;
            $userDetails->save();

            return response()->json(['message' => 'Your plan subscribed successfully'], 200);
        } catch (\Exception $e) {
            \Log::info($e);
            return response()->json(['message' => 'Something went wrong'], 422);
        }
    }


    public function userSubscriptionCheck(User $user, $userSubIds, SubscriptionPlan $subscriptionPlan,  SubscriptionPlanRecord $subscriptionPlanRecord, $planDetails)
    {
        $userSubscriptionCheck = $user->subscriptionPlanCheck;

        $noOfRecords = $this->calcluateNoOfRecords($user, $subscriptionPlan, $subscriptionPlanRecord, $planDetails);

        if (!$userSubscriptionCheck) {
            $userSubscriptionCheck = new UserPlanCheck();
        }

        $userSubscriptionCheck->user_id = $user->id;
        $userSubscriptionCheck->user_subscription_ids = $userSubIds;
        $userSubscriptionCheck->no_of_check_invoice = $noOfRecords['noOfCheckInvoice'];
        $userSubscriptionCheck->no_of_supplier_check = $noOfRecords['noOfSupplierCheck'];
        $userSubscriptionCheck->no_of_safe_payout = $noOfRecords['noOfSafePayout'];
        $userSubscriptionCheck->no_of_detector_records = $noOfRecords['noOfDetectorRecords'];
        $userSubscriptionCheck->no_of_onboarding = $noOfRecords['noOfOnboarding'];
        $userSubscriptionCheck->save();
    }


    public function calculateDate($subscriptionPlan)
    {
        $extraDays = 0;
        if (!$this->isUpdatedPlan) {
            $extraDays = $subscriptionPlan->trial_days ?: 0;
        }
        $startDate = Carbon::now()->format("Y-m-d");
        $endDate = Carbon::now()->addDays($extraDays + 30)->format("Y-m-d");
        $dueDate = Carbon::now()->addDays($extraDays + 23)->format("Y-m-d");

        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'dueDate' => $dueDate,
        ];
    }

    public function calcluateNoOfRecords(User $user, SubscriptionPlan $subscriptionPlan, SubscriptionPlanRecord $subscriptionPlanRecord, $planDetails)
    {
        $noOfCheckInvoice = 0;
        $noOfSupplierCheck = 0;
        $noOfSafePayout = 0;
        $noOfDetectorRecords = 0;
        $noOfOnboarding = 0;
        $userSubscriptionCheck = null;

        foreach ($planDetails as $plan) {
            $subscriptionPlan = SubscriptionPlan::find($plan['subPlanId']);
            $subscriptionPlanRecord = SubscriptionPlanRecord::find($plan['subPlanRecordId']);

            if ($this->isUpdatedPlan) {
                $userSubscriptionCheck = $user->subscriptionPlanCheck;
            }

            $prevActiveRecordId = optional(UserSubscription::where('user_id', $user->id)->where('is_active', 1)
                ->where('subscription_id', $plan['subPlanId'])->first())->subscription_plan_record_id;

            if ($subscriptionPlan->include_check_invoice) {
                $noOfCheckInvoice += $subscriptionPlanRecord->no_of_records_count + optional($userSubscriptionCheck)->no_of_check_invoice;
            }
            if ($subscriptionPlan->include_supplier_check) {
                $noOfSupplierCheck += $subscriptionPlanRecord->no_of_records_count + optional($userSubscriptionCheck)->no_of_supplier_check;
            }
            if ($subscriptionPlan->include_safe_payout) {
                $noOfSafePayout += $subscriptionPlanRecord->no_of_records_count + optional($userSubscriptionCheck)->no_of_safe_payout;
            }
            if ($subscriptionPlan->include_detector_records) {
                $noOfDetectorRecords += $subscriptionPlanRecord->no_of_records_count + optional($userSubscriptionCheck)->no_of_detector_records;
            }
            if ($subscriptionPlan->include_onboarding) {
                $noOfOnboarding += $subscriptionPlanRecord->no_of_records_count + optional($userSubscriptionCheck)->no_of_onboarding;
            }
        }

        return [
            'noOfCheckInvoice' => $noOfCheckInvoice,
            'noOfSupplierCheck' => $noOfSupplierCheck,
            'noOfSafePayout' => $noOfSafePayout,
            'noOfDetectorRecords' => $noOfDetectorRecords,
            'noOfOnboarding' => $noOfOnboarding,
        ];
    }

    public function calculatePaymentPrice($user, $planDetails, $totalAmount)
    {
        $planPaidPrice = 0;
        foreach ($planDetails as $plan) {
            $subscriptionPlan = SubscriptionPlan::find($plan['subPlanId']);
            $subscriptionPlanRecord = SubscriptionPlanRecord::find($plan['subPlanRecordId']);

            $prevActiveRecordPrice = UserSubscription::where('user_id', $user->id)->where('is_active', 1)
                ->where('subscription_id', $plan['subPlanId'])->sum('paid_price');
            $currentPlanPrice = $subscriptionPlanRecord->price;

            $planPaidPrice += $currentPlanPrice - $prevActiveRecordPrice;
        }
        return $planPaidPrice * 100;
    }

    public function planWisePrice($subPlanId, $user, $subscriptionPlanRecordPrice)
    {
        $prevActiveRecordPrice = optional(UserSubscription::where('user_id', $user->id)->where('subscription_id', $subPlanId)->latest('created_at')->first())->sum('paid_price');
        $currentPlanPrice = $subscriptionPlanRecordPrice;

        return $currentPlanPrice - $prevActiveRecordPrice;
    }

    public function mauticAPI_old($stageId=null, $segmentId, $contactParam)
    {
        $mautic = new Mautic();
        
        if ($stageId) {
            $stageId = $stageId;
        } else {
            $stageId = \Auth::user()->login_no > 1 ? config('config.mautic.stages.registered') : config('config.mautic.stages.firstTimeLogin');
        }
        
        $contact = $mautic->request('post', 'contacts/new', $contactParam);
        $segmentUrl = 'segments/'.$segmentId.'/contact/'.$contact['contact']['id'].'/add';
        $stageUrl = 'stages/'.$stageId.'/contact/'.$contact['contact']['id'].'/add';
        $mautic->request('post', $segmentUrl, null);
        $mautic->request('post', $stageUrl, null);
    }
    public function mauticAPI($stageId=null, $segmentId, $contactParam)
    {
        $mautic = new Mautic();
        
        if ($stageId) {
            $stageId = $stageId;
        } else {
            $stageId = \Auth::user() && \Auth::user()->login_no > 1 ? config('config.mautic.stages.registered') : config('config.mautic.stages.firstTimeLogin');
        }
        $contact = $mautic->create('contacts', $contactParam);
        if($segmentId!==null && !empty($segmentId)){
            $mautic->addStageSegmentContact('segments',$contact['contact']['id'],$segmentId);
        }
        if($stageId!==null && !empty($stageId)){
            $mautic->addStageSegmentContact('stages',$contact['contact']['id'],$stageId);
        }
    }
}
