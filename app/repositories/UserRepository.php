<?php

namespace App\Repositories;

use App\Services\CompanyService;
use App\Services\InvoiceService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\Firebase;
use App\Notifications\UserVerified;
use Illuminate\Support\Facades\Notification;

class UserRepository extends BaseRepository
{

    public function __construct(UserService $userService, CompanyService $companyService, InvoiceService $invoiceService)
    {
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->invoiceService = $invoiceService;
    }

    /**
     * Update user information
     * @param Illumincate\Http|request $request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $userData['name'] = $request->name;
            $userData['email'] = $request->email;
            $userData['contact_number'] = $request->contact_number;
            if (trim($request->password)) {
                $userData['password'] = $request->password;
            }

            $this->userService->updateUser($userData);
            $user = $this->userService->find(\Auth::user()->id);
            return response()->json(['message' => 'User information has beeen updated', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong'], 422);
        }
    }

    public function paymentPlan(Request $request)
    {
        return $this->userService->paymentPlan($request);
    }


    public function checkInvoice(Request $request)
    {
        try {
            $userData['username'] = $userData['email'] = $request->email;
            $userData['name'] = $request->name;
            $userData['contact_number'] = $request->contactNumber;
            $userData['password'] = Str::random(8);
            $response = '';
            if ($user = $this->userService->checkEmailExists($request->email)) {
                $response = response()->json(['errors' => ['message' =>  'Invoice upload failed. ' .
                    $request->email . ' email account already exits']], 422);
            } elseif ($user = $this->userService->checkContactExists($request->contactNumber)) {
                $response = response()->json(['errors' => ['message' => 'Invoice upload failed. ' .
                    $request->contactNumber . ' contact number already exits']], 422);
            }

            if (!$user) {
                $user = $this->userService->memberFromCheckInvoceCreate($userData);
                if (!$user->company) {
                    $this->companyService->newCompanyCreate($user->id);
                }
                $stageId = config('config.mautic.stages.notLoggedIn');
                $segmentId = config('config.mautic.segment.upload-invoice');
                $contactParam['firstname'] = $user->name;
                $contactParam['email'] = $user->email;
                $contactParam['ipAddress'] = $request->ip();
                $contactParam['lastActive'] = date('Y-m-d H:m:i');
                $contactParam['overwriteWithBlank'] = true;

                $this->userService->mauticAPI($stageId, $segmentId, $contactParam);

                $response = response()->json(['message' => 'Ýour invoice uploaded successfully'], 200);
            }

            $invoice = $this->invoiceService->create([
                'user_id' => $user->id,
                'status' => 0
            ]);

            $file = $request->invoiceFile;
            $this->invoiceService->addInvoice($file, $invoice->id);
            return $response;
        } catch (\Exception $e) {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 422);
        }
    }


    public function verifyOtpCode(Request $request)
    {
        try {
            $firebase = new Firebase();
            $response = $firebase->verifyOtp($request->code, $request->verificationId);

            $user = $this->userService->findBy([
                'email' => $request->email
            ]);
            if ($response->phoneNumber) {
                $password = $userData['password'] = Str::random(8);
                Notification::route('mail', $user->email)->notify(new UserVerified($user, $password));
                $this->userService->updateById($user->id, [
                    'verification_token' => null,
                    'password' => $password,
                    'status' => true
                ]);
                return response()->json(['message' => 'Thank you for verification, your login information has been sent to your email account'], 200);
            } else {
                return response()->json(['message' => 'Phone number verification failed'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Phone number verification failed'], 422);
        }
    }
}
