<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CompanyService extends BaseService
{
    protected $companyNumberPrefix = '';

    const COMPANY_ACTIVE = 'active';
    const COMPANY_INACTIVE = 'inactive';

    const COMPANY_STATUS = [
        self::COMPANY_ACTIVE => true,
        self::COMPANY_INACTIVE => false,
    ];

    public function __construct(Company $company)
    {
        $this->model = $company;
    }

    /**
     * get comoany info by authenticated user id
     */
    public function getUserCompanyInfo()
    {
        return $this->model->where('user_id', \Auth::user()->id)->first();
    }


    /**
     * add image
     * @param file $image
     */
    public function addCompanyImage($image)
    {
        $company = $this->getUserCompanyInfo();
        return $company->addMedia($image)
            ->preservingOriginal()
            ->toMediaCollection(Company::COMPANY_IMAGE);
    }

    /**
     * remove company image
     */
    public function delteCompanyImage()
    {
        $company = $this->getUserCompanyInfo();
        $company
            ->clearMediaCollection(Company::COMPANY_IMAGE);
    }

    /**
     * create company
     * @param array $companyData
     */
    public function createCompany($companyData)
    {
        $company = $this->getUserCompanyInfo();

        $companyData['status'] = isset(self::COMPANY_STATUS[strtolower($companyData['status'])])
            ? self::COMPANY_STATUS[strtolower($companyData['status'])] : false;
        $companyData['user_id'] = \Auth::user()->id;


        if ($company) {
            $this->model->where('id', $company->id)->update($companyData);
        } else {
            $companyData['account_number'] = strtoupper(Str::random(8));
            $companyData = $this->companyMailContent();
            $company = $this->model->create($companyData);
            $company->account_number = $this->companyNumberPrefix . strtoupper(Str::random(8) . $company->id);
            $company->is_id_document = true;
            $company->save();
        }

        return $company;
    }


    /**
     * create company
     * @param array $companyData
     */
    public function newCompanyCreate($userId)
    {
        $companyData['account_number'] = strtoupper(Str::random(8));
        $companyData = $this->companyMailContent();
        $companyData['user_id'] = $userId;
        $company = $this->model->create($companyData);
        $company->account_number = $this->companyNumberPrefix . strtoupper(Str::random(8) . $company->id);
        $company->is_id_document = true;
        $company->save();
        $this->directoryCreate($company->account_number);

        if (strtolower($company->user->name) == 'admin') {
            Storage::makeDirectory($company->account_number . '/identification', 7777, true);
            Storage::makeDirectory($company->account_number . '/identification/passport');
            Storage::makeDirectory($company->account_number . '/identification/selfie');
        }

        return $company;
    }

    private function directoryCreate($accountNumber)
    {
        Storage::makeDirectory($accountNumber, 7777, true);
    }


    private function companyMailContent()
    {
        $companyData['onboarding_message'] = '<span class="mb-2 mt-2">You simply <a>&lt;click here&gt;</a>, and follow the instructions what you need to add to confirm the information.</span>

                                    <span class="mb-2">For  more information this please contact
                                        me &lt;First Name&gt; &lt;Last Name&gt;
                                        on email &lt;person email&gt; or give me
                                        a call on &lt;phone number&gt; and I can
                                        ensure it is correct.</span>

                                    <span>Alternatively, you can contact the Deepcheck team and they can take you through the steps.</span>

                                    <span>Kind regards,</span>
                                    <span>&lt;First Name&gt; &lt;Last Name&gt;</span>';

        $companyData['invoice_result_message'] = '<span class="mb-2 mt-2">You simply <a>&lt;click here&gt;</a>,
                                    and follow
                                    the instructions what you need to add to confirm the information.</span>

                                <span class="mb-2">For more information this please contact
                                    me &lt;First Name&gt; &lt;Last Name&gt;
                                    on email &lt;person email&gt; or give me
                                    a call on &lt;phone number&gt; and I can
                                    ensure it is correct.</span>

                                <span>Alternatively, you can contact the Deepcheck team and they can take you through the steps.</span>

                                <span>Kind regards,</span>
                                <span>&lt;First Name&gt; &lt;Last Name&gt;</span>';

        $companyData['supplier_verification_message'] = '<span class="mb-2 mt-2">You simply <a>&lt;click here&gt;</a>,
                                        and follow
                                        the instructions what you need to add to confirm the information.</span>

                                    <span class="mb-2">For more information this please contact
                                        me &lt;First Name&gt; &lt;Last Name&gt;
                                        on email &lt;person email&gt; or give me
                                        a call on &lt;phone number&gt; and I can
                                        ensure it is correct.</span>
                                    <span>Alternatively, you can contact the Deepcheck team and they can take you through the steps.</span>

                                    <span>Kind regards,</span>
                                    <span>&lt;First Name&gt; &lt;Last Name&gt;</span>';

        $companyData['existing_supplier_message'] = '<span class="mb-2 mt-2">You simply <a>&lt;click here&gt;</a>,
                                    and follow
                                    the instructions what you need to add to confirm the information.</span>
                                <span>We understand this can be perceived as a spam email to fish for your data.</span>
                                <span class="mb-2">For more information this please contact
                                    me &lt;First Name&gt; &lt;Last Name&gt;
                                    on email &lt;person email&gt; or give me
                                    a call on &lt;phone number&gt; and I can
                                    ensure it is correct.</span>
                                <span>Alternatively, you can contact the Deepcheck team and they can take you through the steps.</span>
                                <span>Kind regards,</span>
                                <span>&lt;First Name&gt; &lt;Last Name&gt;</span>';

        $companyData['onboarding_mail'] = "We are inviting you to confirm your identity with your passport and confirming utility bills or bank statement documents.";
        $companyData['check_the_invoice_mail'] = "We have received your invoice and we would like to confirm a few things before we pay it.";
        $companyData['supplier_verification_mail'] = "We have received your invoice and we would like to confirm a few things before we pay it.";
        $companyData['existing_supplier_mail'] = "We have received your invoice and noticed some information have changed. This can be someone trying to get money on your behalf or they can have kidnapped your company identity.

We would like to confirm a few things before we pay it.";
    
        return $companyData;
    }

    /**
     * update company info
     * @param array $companyData
     */
    public function updateCompany($companyData)
    {
        $company = $this->getUserCompanyInfo();

        if ($company) {
            foreach ($companyData as $key => $value) {
                $company->{$key} = $value;
            }

            $company->save();
        }

        return $company;
    }


    public function addSpecialCustomer()
    {
        $user = \Auth::user();
        $company = $user->company;
        $customer = null;
        if ($company->cust_no) {
            $customer = Customer::where('cust_no', $company->cust_no)->first();
        }

        if (!$customer) {
            $customer = Customer::create([
                'name' => $user->name,
                'user_id' => $user->id
            ]);
        }

        $customer->cust_no = $company->account_number . '-' . $customer->id;

        $selfiPath = $company->account_number . '/' . $customer->cust_no . '/identification/selfie';
        $passportPath = $company->account_number . '/' . $customer->cust_no . '/identification/passport';

        Storage::makeDirectory($selfiPath, 7777, true);
        Storage::makeDirectory($passportPath, 7777, true);

        $customer->save();


        $company->cust_no = $company->account_number . '-' . $customer->id;
        $company->save();

        return $company;
    }
}
