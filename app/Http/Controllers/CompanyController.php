<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public function __construct(CompanyRepository $company)
    {
        $this->company = $company;
    }

    /**
     * Upload image for company media
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function uploadImage(Request $request)
    {
        return $this->company->uploadImage($request);
    }


    /**
     * Verify company number
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function companyNumberVerify(Request $request)
    {
        $companyNumber = $request->companyNumber;
        return $this->company->companyNumberVerify($companyNumber);
    }

    /**
     * Verify vat number
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function vatNumberVerify(Request $request)
    {
        $vatNumber = $request->vatNumber;
        return $this->company->vatNumberVerify($vatNumber);
    }

    /**
     * Verify IBan Number
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function ibanNumberVerify(Request $request)
    {

        $this->validate($request, [
            'iBanNumber' => 'required|iban',
        ], [
            'iBanNumber.required' => 'The email address field is required.',
            'iBanNumber.iban' => 'Invalid iban number'
        ]);

        $iBanNumber = $request->iBanNumber;
        return $this->company->ibanNumberVerify($iBanNumber);
    }

    /**
     * Update company detail
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $this->company->update($request);
    }


    public function addSpecialCustomer()
    {
        return $this->company->addSpecialCustomer();
    }
}
