<?php

namespace App\Repositories;

use App\Helpers\ApiService;
use App\Helpers\VatValidation;
use App\Http\Resources\CompanyResource;

use App\Services\CompanyCategoryService;
use App\Services\CompanyService;

use Illuminate\Http\Request;

use Throwable;

class CompanyRepository extends BaseRepository
{


    public function __construct(
        CompanyService $companyService,
        CompanyCategoryService $companyCategoryService
    ) {
        $this->companyService = $companyService;
        $this->companyCategoryService = $companyCategoryService;
    }

    /**
     * Upload image for company media
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function uploadImage(Request $request)
    {

        $image = $request->companyLogoImage;

        if ($image) {
            $image = $this->companyService->addCompanyImage($image);
            return response()->json(
                ['message' => 'Company image file uploaded', 'fileUrl' => $image->getUrl()],
                200
            );
        } else {
            $this->companyService->delteCompanyImage();
            return response()->json(
                ['message' => 'Company image file removed', 'fileUrl' => ''],
                200
            );
        }
    }


    /**
     * Verify company number
     * @param string $companyNumber
     * @return Illuminate\Http\Response
     */
    public function companyNumberVerify(string $companyNumber)
    {
        try {
            $apiService = new ApiService();
            $res = $apiService->companyNumberVerify($companyNumber);


            $company = json_decode($res->getBody());

            $companyCategory = $this->companyCategoryService->getCompanyByName($company[0]->CompanyCategory);

            $countryName = $company[0]->RegAddress_Country == '' ?
                $company[0]->CountryOfOrigin :  $company[0]->RegAddress_Country;

            $cityName = $company[0]->RegAddress_PostTown;


            $companyData = [
                'name' => $company[0]->CompanyName,
                'category_id' => $companyCategory ? $companyCategory->id : null,
                'company_number' => $company[0]->CompanyNumber,
                'status' => $company[0]->CompanyStatus,
                'address_1' => $company[0]->RegAddress_AddressLine1,
                'address_2' => $company[0]->RegAddress_AddressLine2,
                'country' => $countryName,
                'post_code' => $company[0]->RegAddress_PostCode,
                'city' => $cityName,
                'website_url' => $company[0]->URI,
                'is_company_verified' => true
            ];

            $company = $this->companyService->createCompany($companyData);

            if ($company) {
                return response()->json(
                    [
                        'message' => 'Company number verified',
                        'company' => new  CompanyResource($company)
                    ],
                    200
                );
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid Company Number'], 422);
        }
    }

    /**
     * Verify Vat Number
     * @param string $taxVatNumber
     * @return Illuminate\Http\Response
     */
    public function vatNumberVerify(string $taxVatNumber)
    {
        try {

            $vatValidation = new VatValidation();
            // $vatValidation->validate('HU66861328');
            $vatValidation->validate($taxVatNumber);
            if ($vatValidation->valid) {
                $company = $this->companyService->updateCompany([
                    'is_vat_number_verified' => true,
                    'vat_number' => $taxVatNumber
                ]);
                if ($company) {
                    return response()->json(
                        [
                            'message' => 'Vat number verified',
                            'company' => new  CompanyResource($company)
                        ],
                        200
                    );
                } else {
                    return response()->json(['message' => 'Please verify company number first'], 422);
                }
            }

            return response()->json(['message' => 'Invalid Vat Number'], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * Verify IBan Number
     * @param string $ibanNumber
     * @return Illuminate\Http\Response
     */
    public function ibanNumberVerify(string $ibanNumber)
    {
        try {

            $company = $this->companyService->updateCompany([
                'is_ban_number_verified' => true,
                'i_ban_number' => $ibanNumber
            ]);
            if ($company) {
                return response()->json(['message' => 'IBan number updated successfully', 'company' => new  CompanyResource($company)], 200);
            } else {
                return response()->json(['message' => 'Please verify company number first'], 422);
            }

            return response()->json(['message' => 'Invalid iban Number'], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid iban Number'], 422);
        }
    }

    /**
     * Update company info
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $updateData = $request->all();

        $company = $this->companyService->updateCompany($updateData);

        if ($company) {
            return response()->json([
                'message' => 'Company Detail Updated',
                'company' => new  CompanyResource($company)
            ], 200);
        } else {
            return response()->json(['message' => 'Please verify company number first'], 422);
        }
    }


    public function addSpecialCustomer()
    {
        $company = $this->companyService->addSpecialCustomer();

        return $company->cust_no;
    }
}
