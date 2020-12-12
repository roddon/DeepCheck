<?php

namespace App\Models\Presenters;

use App\Models\Supplier;
use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class SupplierPresenter extends Presenter
{
    public function name()
    {
        return $this->entity->name ?: $this->entity->company_name;
    }

    public function status(): string
    {
        return Supplier::STATUS[$this->entity->status];
    }

    public function statusColor(): string
    {
        return Supplier::STATUS_COLOUR[$this->entity->status];
    }

    public function bankAccountStatus(): string
    {
        return Supplier::BANK_ACCOUNT_STATUS[$this->entity->bank_account_status];
    }

    public function bankAccountStatusColor(): string
    {
        return Supplier::BANK_ACCOUNT_STATUS_COLOUR[$this->entity->bank_account_status];
    }

    public function bankAccountStatusColorPage(): string
    {
        return Supplier::BANK_ACCOUNT_STATUS_PAGE_COLOR[$this->entity->bank_account_status];
    }

    public function documentStatus(): string
    {
        return Supplier::DOCUMENT_STATUS[$this->entity->document_status];
    }

    public function documentStatusColor(): string
    {
        return Supplier::DOCUMENT_STATUS_COLOUR[$this->entity->document_status];
    }

    public function gender(): string
    {
        return Supplier::GENDER[$this->entity->gender];
    }

    public function dob(): string
    {
        return $this->entity->date_of_birth ? Carbon::parse($this->entity->date_of_birth)->format('d/m/Y') : '';
    }


    public function verificationDate()
    {
        return $this->entity->verification_date ? Carbon::parse($this->entity->verification_date)->format('d/m/Y') : '';
    }


    public function getMedia()
    {
        return $this->entity->getMedia(Supplier::DOCUMENT);
    }


    public function vatNumberStatus()
    {
        return Supplier::VAT_NUMBER_STATUS[$this->entity->is_vat_number_verified];
    }

    public function vatNumberStatusPageColor()
    {
        return Supplier::VAT_NUMBER_STATUS_PAGE_COLOR[$this->entity->is_vat_number_verified];
    }


    public function contactNumberStatus()
    {
        return Supplier::CONTACT_NUMBER_STATUS[$this->entity->is_contact_number_verified];
    }

    public function contactNumberStatusPageColor()
    {
        return Supplier::CONTACT_NUMBER_STATUS_PAGE_COLOR[$this->entity->is_contact_number_verified];
    }


    public function emailStatus()
    {
        return Supplier::EMAIL_STATUS[$this->entity->is_email_verified];
    }

    public function emailStatusPageColor()
    {
        return Supplier::EMAIL_STATUS_PAGE_COLOR[$this->entity->is_email_verified];
    }


    public function companyNumberStatus()
    {
        return Supplier::COMPANY_NUMBER_STATUS[$this->entity->is_company_number_verified];
    }

    public function companyNumberStatusPageColor()
    {
        return Supplier::COMPANY_NUMBER_STATUS_PAGE_COLOR[$this->entity->is_company_number_verified];
    }

    public function addressStatus()
    {
        return Supplier::ADDRESS_STATUS[$this->entity->is_address_verified];
    }

    public function bankAccountPageStatus(): string
    {
        return Supplier::BANK_ACCOUNT_PAGE_STATUS[$this->entity->bank_account_status];
    }

    public function addressStatusPageColor()
    {
        return Supplier::ADDRESS_STATUS_PAGE_COLOR[$this->entity->is_address_verified];
    }

    public function verified()
    {
        return $this->entity->status == Supplier::APPROVED;
    }
}
