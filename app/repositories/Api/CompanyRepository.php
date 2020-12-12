<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Auth;

class CompanyRepository extends BaseRepository
{
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }


    public function verifyAccountNumber(string $accountNumber)
    {
        if ($this->companyService->findBy(['account_number' => $accountNumber, 'user_id' => Auth::user()->id])) {
            return response()->json(['status' => true, 'message' => 'Account number verified'], 200);
        }

        return response()->json(['status' => false, 'message' => 'Account number not exists'], 422);
    }

    public function verifyCompanyAccountNumber(Request $request)
    {
        if ($request->cno_customer_id && $this->companyService->findBy(['account_number' => $request->cno_customer_id])) {
            return response()->json(['status' => true, 'message' => 'Account number verified'], 200);
        }

        return response()->json(['status' => false, 'message' => 'Account number not exists'], 422);
    }
}
