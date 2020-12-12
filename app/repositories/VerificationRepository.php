<?php

namespace App\Repositories;

use App\Helpers\ApiService;
use App\Helpers\Firebase;
use App\Helpers\Tink;
use App\Helpers\Yapili;
use App\Helpers\VatValidation;
use App\Services\CityService;
use App\Services\CountryService;
use App\Services\CustomerService;
use App\Services\SupplierService;
use Carbon\Carbon;
use Illuminate\Http\Request;



class VerificationRepository extends BaseRepository
{

    public function __construct(
        CustomerService $customerService,
        SupplierService $supplierService,
        CountryService $countryService,
        CityService $cityService
    ) {

        $this->supplierService = $supplierService;
        $this->customerService = $customerService;
        $this->countryService = $countryService;
        $this->cityService = $cityService;
    }


    public function startSupplierVerification(Request $request)
    {
        if ($request->verification_code) {
            $supplier = $this->supplierService->findBy([
                'verification_token' => $request->verification_code
            ]);
            if ($supplier) {
                request()->session()->put('supplier_id', $supplier->id);
                $this->supplierService->updateById($supplier->id, [
                    'is_email_verified' => true
                ]);
                return view('manage.verification.supplier.start-verification', compact('supplier'));
            } else {
                return view('manage.customer.invalid-link', compact('supplier'));
            }
        }
    }

    public function verifyPhoneOtp(Request $request)
    {
        try {
            $firebase = new Firebase();
            $response = $firebase->verifyOtp($request->code, $request->verificationId);

            $supplier = $this->supplierService->find($request->supplier_id);
            if ($response->phoneNumber) {
                $this->supplierService->updateById($supplier->id, [
                    'verification_token' => null,
                    'contact_number' => $request->contact_number,
                    'is_contact_number_verified' => true
                ]);
                return response()->json(['message' => 'Phone number verify successfully'], 200);
            } else {
                return response()->json(['message' => 'Phone number verification failed'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Phone number verification failed'], 422);
        }
    }


    public function updateSupplier(Request $request)
    {
        $supplier = $this->supplierService->find($request->supplier_id);
        if ($supplier) {

            $apiService = new ApiService();
            $res = $apiService->companyNumberVerify($request->company_number);
            $company = json_decode($res->getBody());

            if (count($company) <= 0) {
                return response()->json(['message' => 'Invalid Company Number'], 422);
            }


            $vatValidation = new VatValidation();
            // $vatValidation->validate('HU66861328');
            $vatValidation->validate($request->vat_number);
            if (!$vatValidation->valid) {
                return response()->json(['message' => 'Invalid Vat Number'], 422);
            }


            $this->supplierService->updateById($supplier->id, [
                'verification_token' => null,
                'company_number' => $request->company_number,
                'vat_number' => $request->vat_number,
                'contact_number' => $request->contact_number,
                'company_name' => $company[0]->CompanyName,
                'website_url' => $company[0]->URI,
            ]);
            return response()->json(['message' => 'Updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to verify'], 422);
        }
    }


    public function kycVerification(Request $request)
    {
        request()->session()->put('customer_id', $request->customer_id);
        request()->session()->put('supplier_id', $request->supplier_id);


        return view('manage.yapili.start-kyc-verification');
    }


    public function getInstitutions()
    {
        try {
            $yapili = new Yapili();

            $response = $yapili->institutions();

            $institutions =  $response->data;

            return view('manage.yapili.institutions', compact('institutions'));
        } catch (\Exception $e) {
        }
    }

    public function accountAuthRequest(Request $request)
    {
        try {
            $yapili = new Yapili();

            $response = $yapili->accountAuthRequest($request->institutionId);

            if ($response->data) {
                return response()->json([
                    'message' => 'Payment Auth Created',
                    'auth_uri' => $response->data->authorisationUrl
                ], 200);
            }

            return view('manage.yapili.institutions', compact('institutions'));
        } catch (\Exception $e) {
        }
    }

    public function tinkCallback(Request $request)
    {
        $customerId = request()->session()->get('customer_id');
        $supplierId = request()->session()->get('supplier_id');
        $code = $request->code;

        $credentialsId = $request->credentialsId;

        $yapili = new Yapili();

        $accountList = $yapili->getAccounts($code);
        $identities = $yapili->getIdentities($code);


        $tinkAccountList = [];

        if ($accountList->data) {
            foreach ($accountList->data as $account) {

                $tinkAccountList[$account->id] = $account;
            }
            $request->session()->put('tinkAccountList', $tinkAccountList);

            $request->session()->put('tinkIdentities', $identities);


            if ($supplierId) {
                return view('manage.verification.supplier.accounts', compact('supplierId', 'tinkAccountList'));
            } elseif ($customerId) {
                return view('manage.verification.customer.accounts', compact('customerId', 'tinkAccountList'));
            }
        }
    }

    public function supplierTinkVerification(Request $request)
    {
        try {
            $supplierId = request()->session()->get('supplier_id');
            $supplier = $this->supplierService->find($supplierId);

            if ($supplier) {

                $tinkAccountList = $request->session()->get('tinkAccountList')[$request->account_id];
                $tinkIdentities = $request->session()->get('tinkIdentities');

                $accountHolderName = '';
                $accountNumber = '';
                $accountSortCode = '';

                foreach ($tinkAccountList->accountNames as $name) {
                    $accountHolderName = $name->name;
                }

                foreach ($tinkAccountList->accountIdentifications as $accountIdentifications) {
                    if ($accountIdentifications->type = 'SORT_CODE') {
                        $accountSortCode = $accountIdentifications->identification;
                    } elseif ($accountIdentifications->type = 'ACCOUNT_NUMBER') {
                        $accountNumber = $accountIdentifications->identification;
                    }
                }

                $supplier->name = $accountHolderName;
                $supplier->bank_account_number = $accountNumber;
                $supplier->sort_code = $accountSortCode;
                $supplier->bank_account_status = true;
                $supplier->verification_date = Carbon::now();
                $supplier->save();

                $addresses = isset($tinkIdentities->data) ? $tinkIdentities->data->addresses : [];
                $request->session()->remove('tinkAccountList');
                return view('manage.yapili.address', ['addresses' => $addresses]);
            }
            return response()->json(['message' => 'Failed to verify'], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }


    public function customerTinkVerification(Request $request)
    {
        try {

            $customerId = request()->session()->get('customer_id');

            $customer = $this->customerService->find($customerId);

            if ($customer) {

                $tinkAccountList = $request->session()->get('tinkAccountList')[$request->account_id];

                $tinkIdentities = $request->session()->get('tinkIdentities');

                $accountHolderName = '';
                $accountNumber = '';
                $accountSortCode = '';

                foreach ($tinkAccountList->accountNames as $name) {
                    $accountHolderName = $name->name;
                }

                foreach ($tinkAccountList->accountIdentifications as $accountIdentifications) {
                    if ($accountIdentifications->type = 'SORT_CODE') {
                        $accountSortCode = $accountIdentifications->identification;
                    } elseif ($accountIdentifications->type = 'ACCOUNT_NUMBER') {
                        $accountNumber = $accountIdentifications->identification;
                    }
                }

                $name = explode(' ', $accountHolderName);

                $customer->bank_firstname = isset($name[0]) ? $name[0] : '';
                $customer->bank_lastname = isset($name[1]) ? $name[1] : '';
                $customer->bank_account_number = $accountNumber;
                $customer->sort_code = $accountSortCode;
                $customer->bank_account_status = true;
                $customer->verification_date = Carbon::now();
                $customer->save();

                $addresses = isset($tinkIdentities->data) ? $tinkIdentities->data->addresses : [];

                return view('manage.yapili.address', ['addresses' => $addresses]);
            }

            return view('manage.customer.error-verification', compact('customerId'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return view('manage.customer.error-verification', compact('customerId'));
        }
    }


    public function addSupplierAddress(Request $request)
    {
        try {
            $supplierId = request()->session()->get('supplier_id');
            $supplier = $this->supplierService->find($supplierId);

            if ($supplier) {

                $tinkIdentities = $request->session()->get('tinkIdentities');
                $addresses = $tinkIdentities->data->addresses;

                foreach ($addresses as $key => $address) {
                    if ($key == $request->addressId) {

                        if (isset($address->addressLines[0])) {
                            $supplier->address_1 = $address->addressLines[0];
                            unset($address->addressLines[0]);
                        }

                        $supplier->address_2 = implode(',', $address->addressLines);
                        $supplier->post_code = $address->postalCode;

                        $country = $this->countryService->findBy(['code' => $address->country]);

                        if (!$country) {
                            $country = $this->countryService->create([
                                'code' => $address->country,
                                'name' => $address->country
                            ]);
                        }

                        $supplier->country_id = $country->id;

                        $city = $this->cityService->findBy(['name' =>  strtolower($address->city)]);
                        if (!$city) {
                            $city = $this->cityService->create([
                                'name' => strtolower($address->city)
                            ]);
                        }

                        $supplier->city_id = $city->id;
                    }
                }
                $supplier->save();
                $request->session()->remove('tinkIdentities', null);
                $supplierId = request()->session()->remove('supplier_id');
                return response()->json(['message' => 'Updated successfully'], 200);
            }
            return response()->json(['message' => 'Failed to verify'], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }


    public function addCustomerAddress(Request $request)
    {
        try {
            $customerId = request()->session()->get('customer_id');
            $customer = $this->customerService->find($customerId);

            if ($customer) {

                $tinkIdentities = $request->session()->get('tinkIdentities');
                $addresses = $tinkIdentities->data->addresses;

                foreach ($addresses as $key => $address) {
                    if ($key == $request->addressId) {

                        if (isset($address->addressLines[0])) {
                            $customer->address_1 = $address->addressLines[0];
                            unset($address->addressLines[0]);
                        }

                        $customer->address_2 = implode(',', $address->addressLines) . ' ' . $address->city;
                        $customer->post_code = $address->postalCode;

                        $country = $this->countryService->findBy(['code' => $address->country]);

                        if (!$country) {
                            $country = $this->countryService->create([
                                'code' => $address->country,
                                'name' => $address->country
                            ]);
                        }

                        $customer->country_id = $country->id;
                    }
                }
                $customer->save();
                $request->session()->remove('tinkIdentities', null);
                $request->session()->remove('customer_id', null);
                return response()->json(['message' => 'Updated successfully'], 200);
            }
            return response()->json(['message' => 'Failed to verify'], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
