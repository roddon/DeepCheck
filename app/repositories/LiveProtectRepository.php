<?php

namespace App\Repositories;

use App\Helpers\TrueLayer;
use App\Services\LiveProtectService;
use App\Services\TrueLayerPaymentService;
use App\Services\UserService;
use Illuminate\Http\Request;

class LiveProtectRepository extends BaseRepository
{
    protected $liveProtectService;

    public function __construct(
        LiveProtectService $liveProtectService,
        TrueLayerPaymentService $trueLayerPaymentService,
        UserService $userService
    ) {
        $this->liveProtectService = $liveProtectService;
        $this->trueLayerPaymentService = $trueLayerPaymentService;
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->liveProtectService->index();
    }

    public function paymentRequest(Request $request)
    {
        try {

            $request->session()->put('paymentRequset', [
                'invoiceIds' => $request->invoiceIds,
                'forDueDateRequest' => $request->forDueDateRequest
            ]);

            if ($request->forDueDateRequest) {
                $invoiceIds = $this->liveProtectService->getDueDatePaymentInvoices();
            } else {

                $invoiceIds = $request->invoiceIds;
            }

            $request->session()->put('invoiceIds', $invoiceIds);

            if (!empty($invoiceIds)) {
                if (count($invoiceIds) == 1) {

                    $resopnse = $this->singlePayment($invoiceIds[0]);
                    foreach ($resopnse->results as $result) {
                        $this->trueLayerPaymentService->create([
                            'simp_id' => $result->simp_id,
                            'auth_uri' => $result->auth_uri,
                            'amount' => $result->amount,
                            'currency' => $result->currency,
                            'beneficiary_name' => $result->beneficiary_name,
                            'beneficiary_sort_code' => $result->beneficiary_sort_code,
                            'beneficiary_account_number' => $result->simp_id,
                            'beneficiary_reference' => $result->beneficiary_reference,
                            'remitter_reference' => $result->remitter_reference,
                            'redirect_uri' => $result->redirect_uri,
                            'webhook_uri' => $result->webhook_uri,
                            'status' => $result->status,
                            'created_date' => $result->created_at,
                            'user_id' => \Auth::user()->id,
                            'invoices_id' => implode(',', $invoiceIds)
                        ]);
                    }
                    return response()->json([
                        'message' => 'Payment Successful',
                        'auth_uri' => $resopnse->results[0]->auth_uri
                    ], 200);
                } else {
                    // $this->batchPayment($invoiceIds);
                    return response()->json(['message' => 'Multiple invoice feature coming soon'], 422);
                }
            } else {
                return response()->json(['message' => 'No invoices are pending for payment'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => "Something went wrong"], 422);
        }
    }



    public function dataTables(Request $request)
    {
        $user = \Auth::user();
        // $stageId = config('config.mautic.stages.safepay');
        $segmentId = config('config.mautic.segment.safepay');
        $contactParam['firstname'] = $user->name;
        $contactParam['email'] = $user->email;
        $contactParam['ipAddress'] = $request->ip();
        $contactParam['lastActive'] = date('Y-m-d H:m:i');
        $contactParam['overwriteWithBlank'] = true;
        
        $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);

        return $this->liveProtectService->dataTables();
    }

    public function callback(Request $request)
    {
        try {

            if ($request->payment_id) {

                $trueLayer = new TrueLayer();

                $resopnse = $trueLayer->singleImmidiatePaymentStatus($request->payment_id);
                foreach ($resopnse->results as $result) {
                    $trueLayerPayment = $this->trueLayerPaymentService->findBy([
                        'simp_id' => $result->simp_id
                    ]);

                    if ($trueLayerPayment) {
                        $this->trueLayerPaymentService->updateById(
                            $trueLayerPayment->id,
                            [
                                'simp_id' => $result->simp_id,
                                'amount' => $result->amount,
                                'currency' => $result->currency,
                                'beneficiary_name' => $result->beneficiary_name,
                                'beneficiary_sort_code' => $result->beneficiary_sort_code,
                                'beneficiary_account_number' => $result->simp_id,
                                'beneficiary_reference' => $result->beneficiary_reference,
                                'remitter_reference' => $result->remitter_reference,
                                'redirect_uri' => $result->redirect_uri,
                                'webhook_uri' => $result->webhook_uri,
                                'status' => $result->status,
                                'created_date' => $result->created_at,
                                'remitter_provider_id' => $result->remitter_provider_id
                            ]
                        );
                    }
                }

                $invoiceIds = $request->session()->get('invoiceIds');
                foreach ($invoiceIds as $invoiceId) {
                    $this->liveProtectService->updatedPaymentStatus($invoiceId, $request->payment_id);
                }
                $user = \Auth::user();
                $user->useSubscription($user, count($invoiceIds), config('config.subscription.safepay'));
                return redirect()->route('liveProtect.paymentResult', ['invoiceIds' => $invoiceIds])->with('status', 'Payment Successful');
            } else {
                return redirect()->route('liveProtect.index')->with('error', 'Payment Failed');
            }
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->route('liveProtect.index')->with('error', 'Payment Failed');
        }
    }


    private function singlePayment($invoiceId)
    {

        $invoice = $this->liveProtectService->find($invoiceId);
        $refno = 'REF' . rand(1000000, 9999999);
        $trueLayer = new TrueLayer();
        $body = [
            "amount" => $invoice->total * 100,
            "currency" => $invoice->supplier->currency_code,
            "beneficiary_reference" => $refno,
            "beneficiary_name" => $invoice->supplier->name,
            "beneficiary_sort_code" => $invoice->supplier->sort_code,
            "beneficiary_account_number" => $invoice->supplier->bank_account_number,
            "remitter_reference" => $invoice->invoice_number
        ];

        return $trueLayer->singleImmidiatePayment($body);
    }


    private function batchPayment($invoiceId)
    {
    }

    public function paymentResult($request)
    {
        return $this->liveProtectService->paymentResult($request);
    }
}
