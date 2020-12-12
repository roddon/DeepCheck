<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Api\CompanyRepository;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public function __construct(CompanyRepository $company)
    {
        $this->company = $company;
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function verifyAccountNumber(Request $request)
    {
        return $this->company->verifyCompanyAccountNumber($request);
    }
}
