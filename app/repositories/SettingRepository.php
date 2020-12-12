<?php

namespace App\Repositories;

use App\Helpers\Yapili;
use App\Models\Company;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Notifications\SendEmail;
use App\Services\CompanyService;
use App\Services\InvoiceService;
use App\Services\SubscriptionPlanService;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use App\Services\TrueLayerPaymentService;
use Carbon\Carbon;

class SettingRepository extends BaseRepository
{

    public function __construct(
        UserService $userService,
        CompanyService $companyService,
        SubscriptionPlanService $subscriptionPlanService,
        InvoiceService $invoiceService,
        TrueLayerPaymentService $trueLayerPaymentService
    ) {

        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->subscriptionPlanService = $subscriptionPlanService;
        $this->invoiceService = $invoiceService;
        $this->trueLayerPaymentService = $trueLayerPaymentService;
    }


    /**
     * Edit user settings view
     * @return Illuminate\Http\Response
     */
    public function edit()
    {
        // $bodyClass = 'home-page';
        // $siteSeo = config('config.seo.home_page');
        // return view('manage.frontend.home', compact('bodyClass', 'siteSeo'));

        $user = \Auth::user();
        $settingsMail = $this->userService->getUserSettingEmail();
        // return view('manage.settings.edit', compact('user', 'settingsMail'));
        $subscriptionPlans = $this->subscriptionPlanService->get()->map(function ($plan) use ($user) {
            $plan['activePlanId'] = $plan->purchasePlan ? optional(optional($plan->purchasePlan)->where('user_id', $user->id)->where('is_active', 1)->first())->subscription_id : null;
            $plan['activePlanRecordId'] = $plan->purchasePlan ? optional(optional($plan->purchasePlan)->where('user_id', $user->id)->where('is_active', 1)->first())->subscription_plan_record_id : null;
            if ($plan['slug'] == 'checkinvoice') {
                $plan['class'] = SubscriptionPlan::CHECKINVOICE;
            } else if ($plan['slug'] == 'detector') {
                $plan['class'] = SubscriptionPlan::DETECTOR;
            } else if ($plan['slug'] == 'safepay') {
                $plan['class'] = SubscriptionPlan::SAFEPAY;
            } else {
                $plan['class'] = SubscriptionPlan::ONBOARDING;
            }

            return $plan;
        });


        // $stageId = config('config.mautic.stages.setting');
        $segmentId = config('config.mautic.segment.setting');
        $contactParam['firstname'] = $user->name;
        $contactParam['email'] = $user->email;
        $contactParam['ipAddress'] = request()->ip();
        $contactParam['lastActive'] = date('Y-m-d H:m:i');
        $contactParam['overwriteWithBlank'] = true;
        
        $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);
        // return view('manage.settings.edit', compact('user', 'subscriptionPlans', 'settingsMail'));
        $intent = $user->createSetupIntent();

        return view('manage.settings.edit', compact('user', 'subscriptionPlans', 'intent', 'settingsMail'));
    }

    public function sendMail($request)
    {
        try {
            $userId = $request->userId;
            $email = $request->email;
            $company = Company::where('user_id', $userId)->first();
            if ($company) {
                /*Dev 04122020 check hashlink there or not ,if not then create new*/
                if(isset($request->mailTemplate)){
                    switch ($request->mailTemplate) {
                        case 'SUPPLIER_VERIFICATION_MESSAGE':
                        case 'EXISTING_SUPPLIER_MESSAGE':
                            if(!isset($request->hasLink) || (empty($request->hasLink))){
                                $request->hasLink = \Illuminate\Support\Facades\Crypt::encryptString($email . '' . $userId);
                                \App\Models\Supplier::where('email', $email)->update(['verification_token'=>$request->hasLink]);
                            }
                    }
                }
                Notification::route('mail', $email)->notify(new SendEmail($company, $request));
                return response()->json(['message' => 'Mail send successfully'], 200);
            }
            return response()->json(['message' => 'User additional info missing'], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }


    public function getInstitutions()
    {
        try {
            $yapili = new Yapili();

            $response = $yapili->institutions();

            $institutions =  $response->data;

            return view('manage.liveProtect.institutions', compact('institutions'));
        } catch (\Exception $e) {
        }
    }

    public function createPaymentConsentToken(Request $request)
    {
        if ($request->forDueDateRequest) {
            $invoiceIds = $this->invoiceService->getDueDatePaymentInvoices();
        } else {
            $invoiceIds = $request->invoiceIds;
        }

        if (count($invoiceIds) > 0) {

            $paymentRequest = $this->makePaymentRequest($invoiceIds);
            $request->session()->put('paymentRequest', $paymentRequest);
            $request->session()->put('invoiceIds',  $invoiceIds);

            $isBulkPayment = false;

            if (count($request->invoiceIds) > 1) {
                $isBulkPayment = true;
            }

            return $this->createPaymentAuthentication($paymentRequest, $request->institutionId, $isBulkPayment);
        }

        return response()->json([
            'message' => 'No Invoices for due payment',
        ], 422);
    }

    public function makePayment(Request $request)
    {
        try {

            $yapili = new Yapili();
            $paymentRequest = $request->session()->get('paymentRequest');
            $invoiceIds = $request->session()->get('invoiceIds');
            $consentToken = $request->get('consent');

            if (count($invoiceIds) > 1) {
                $response = $yapili->makeBulkPayment($paymentRequest, $consentToken);
            } else {
                $response = $yapili->makePayment($paymentRequest, $consentToken);
            }

            if (isset($response->data)) {
                if (count($invoiceIds) > 1) {
                    $this->invoiceService->createBulkPayment(
                        $invoiceIds,
                        $response->data,
                        $response->meta->tracingId,
                        $paymentRequest
                    );
                } else {
                    $this->invoiceService->createPayment(
                        implode(',', $invoiceIds),
                        $response->data,
                        $response->meta->tracingId,
                    );
                }

                foreach ($invoiceIds as $invoiceId) {
                    $this->invoiceService->updatedPaymentStatus($invoiceId);
                }
            }

            $request->session()->remove('paymentRequest');
            $request->session()->remove('invoiceIds');
            return redirect()->route('liveProtect.paymentResult', ['invoiceIds' => implode(',', $invoiceIds)])
                ->with('status', 'Payment Successful');
        } catch (\Exception $e) {
            return redirect()->route('liveProtect.index')
                ->with('error', 'Payment Failed');
        }
    }


    protected function createPaymentAuthentication($paymentRequest, $institutionId, $isBulkPayment = false)
    {
        try {


            $yapili = new Yapili();
            if ($isBulkPayment) {
                $response = $yapili->createBulkPaymentAuthentication($paymentRequest, $institutionId);
            } else {
                $response = $yapili->paymentAuthRequest($paymentRequest, $institutionId);
            }


            if (isset($response->data) && $response->data) {
                return response()->json([
                    'message' => 'Payment Auth Created',
                    'auth_uri' => $response->data->authorisationUrl
                ], 200);
            }

            return response()->json([
                'message' => 'Payment Auth failed',
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }



    protected function makePaymentRequest($invoiceIds)
    {
        $paymentRequest = [];
        $paymentReference = 'INV' . '' .  strtoupper(Str::random(8));
        $user = \Auth::user();



        if (count($invoiceIds) > 1) {
            $payment = [];
            // $paymentRequest['executionDateTime'] = Carbon::now()->format('Y-m-d H:i:s');
            foreach ($invoiceIds as $invoiceId) {
                $invoice = $this->invoiceService->find($invoiceId);
                $paymentIdempotencyId = 'INV' . '' . Str::random(10) . '-' . $invoice->id;
                $paymentType = 'DOMESTIC_PAYMENT';

                $paymentContextType = "OTHER";

                $payment = [
                    "type" => $paymentType,
                    "paymentIdempotencyId" => $paymentIdempotencyId,
                    "reference" => $paymentReference,
                    "contextType" => $paymentContextType,
                    "amount" => [
                        "amount" => $invoice->total,
                        "currency" => $user->company->currency->code
                    ],
                    "payee" => [
                        "name" => $invoice->supplier->name,
                        "address" => [
                            "country" => $invoice->supplier->country->code
                        ],
                        "accountIdentifications" => [
                            [
                                "type" => "SORT_CODE",
                                "identification" => $invoice->supplier->sort_code
                            ],
                            [
                                "type" => "ACCOUNT_NUMBER",
                                "identification" => $invoice->supplier->bank_account_number
                            ]
                        ]
                    ]
                ];

                $paymentRequest['payments'][] = $payment;
            }
        } else {
            $invoice = $this->invoiceService->find($invoiceIds[0]);
            $paymentIdempotencyId = 'INV' . '' . Str::random(10) . '-' . $invoice->id;
            $paymentType = 'DOMESTIC_PAYMENT';
            // $paymentReference = 'INV' . '' .  strtoupper(Str::random(5)) . '-' . $invoice->id;
            $paymentContextType = "OTHER";

            $paymentRequest = [
                "type" => $paymentType,
                "paymentIdempotencyId" => $paymentIdempotencyId,
                "reference" => $paymentReference,
                "contextType" => $paymentContextType,
                "amount" => [
                    "amount" => $invoice->total,
                    "currency" => $user->company->currency->code
                ],
                "payee" => [
                    "name" => $invoice->supplier->name,
                    "address" => [
                        "country" => $invoice->supplier->country->code
                    ],
                    "accountIdentifications" => [
                        [
                            "type" => "SORT_CODE",
                            "identification" => $invoice->supplier->sort_code
                        ],
                        [
                            "type" => "ACCOUNT_NUMBER",
                            "identification" => $invoice->supplier->bank_account_number
                        ]
                    ]
                ]
            ];
        }

        return $paymentRequest;
    }
}
