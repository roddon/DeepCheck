<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $image = $this->getMedia(Company::COMPANY_IMAGE);
        $imageUrl = isset($image[0]) ? $image[0]->getUrl() : '';

        return [
            'id' => $this->id,
            'languageId' => $this->language_id,
            'companyName' => $this->name,
            'logoImage' => $imageUrl,
            'accountNumber' => $this->account_number,
            'companyNumber' => $this->company_number,
            'phoneNumber' => $this->phone_number,
            'address1' => $this->address_1,
            'address2' => $this->address_2,
            'postCode' => $this->post_code,
            'country' => $this->country,
            'city' => $this->city,
            'websiteUrl' => $this->website_url,
            'vatNumber' => $this->vat_number,
            'iBanNumber' => $this->i_ban_number,
            'onboardingMessage' => $this->onboarding_mail,
            'existingSupplierMessage' => $this->existing_supplier_mail,
            'isCompanyNumberVerified' => $this->is_company_verified,
            'isVatNumberVerified' => $this->is_vat_number_verified,
            'isBankNumberVerified' => $this->is_ban_number_verified,
            'isClientSynced' => $this->is_client_synced,
            'isOnboarding' => $this->is_onboarding,
            'isIdDocument' => $this->is_id_document,
            'isUtilityBillUploaded' => $this->is_utility_bill_uploaded,
            'invoiceResultMessage' => $this->check_the_invoice_mail,
            'supplierVerificationMessage' => $this->supplier_verification_mail,
            'newSupplierVerification' => $this->new_supplier_verification,
            'onboardingSubject' => $this->onboarding_mail_subject,
            'invoiceResultSubject' => $this->invoice_result_mail_subject,
            'supplierVerificationSubject' => $this->supplier_verification_mail_subject,
            'existingSupplierSubject' => $this->existing_supplier_mail_verification,
        ];
    }
}
