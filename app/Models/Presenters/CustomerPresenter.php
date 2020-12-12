<?php

namespace App\Models\Presenters;

use App\Models\Customer;
use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class CustomerPresenter extends Presenter
{
    public function name(): string
    {
        return $this->entity->name ?: '';
    }

    public function status(): string
    {
        return Customer::STATUS[$this->entity->status];
    }

    public function statusColor(): string
    {
        return Customer::STATUS_COLOUR[$this->entity->status];
    }

    public function bankAccountStatus(): string
    {
        return Customer::BANK_ACCOUNT_STATUS[$this->entity->bank_account_status];
    }

    public function bankAccountStatusColor(): string
    {
        return Customer::BANK_ACCOUNT_STATUS_COLOUR[$this->entity->bank_account_status];
    }

    public function documentStatus(): string
    {
        return Customer::DOCUMENT_STATUS[$this->entity->document_status];
    }

    public function documentStatusColor(): string
    {
        return Customer::DOCUMENT_STATUS_COLOUR[$this->entity->document_status];
    }

    public function gender(): string
    {
        return Customer::GENDER[$this->entity->gender];
    }

    public function dob(): string
    {
        return $this->entity->date_of_birth ? Carbon::parse($this->entity->date_of_birth)->format('d/m/Y') : '';
    }

    public function verificationDate()
    {
        return $this->entity->verification_date ? Carbon::parse($this->entity->verification_date)->format('d/m/Y') : '';
    }

    public function dateOfIssue()
    {
        return $this->entity->date_of_issue ? Carbon::parse($this->entity->date_of_issue)->format('d/m/Y') : '';
    }


    public function dateOfExpiry()
    {
        return $this->entity->date_of_expiry ? Carbon::parse($this->entity->date_of_expiry)->format('d/m/Y') : '';
    }

    public function validatyThrough()
    {
        return $this->entity->validity_thorugh ? Carbon::parse($this->entity->validity_thorugh)->format('d/m/Y') : '';
    }

    public function validateThrough()
    {
        return $this->entity->validate_through ? Carbon::parse($this->entity->validate_through)->format('d/m/Y') : '';
    }


    public function getMedia()
    {
        return $this->entity->getMedia(Customer::DOCUMENT);
    }


    public function getPassportPhoto()
    {
        $storagePath =  storage_path() . '/app/public';
        $path = str_replace($storagePath, 'storage', $this->entity->passport_photo);

        return $this->entity->passport_photo
            ? url($path) : asset('assets/images/no-image.jpg');
    }

    public function getCapturePhoto()
    {
        $storagePath =  storage_path() . '/app/public';
        $path = str_replace($storagePath, 'storage', $this->entity->capture_photo);

        return $this->entity->capture_photo ? url($path) : asset('assets/images/no-image.jpg');
    }


    public function vatNumberStatus()
    {
        return Customer::VAT_NUMBER_STATUS[$this->entity->is_vat_number_verified];
    }

    public function vatNumberStatusPageColor()
    {
        return Customer::VAT_NUMBER_STATUS_PAGE_COLOR[$this->entity->is_vat_number_verified];
    }


    public function contactNumberStatus()
    {
        return Customer::CONTACT_NUMBER_STATUS[$this->entity->is_contact_number_verified];
    }

    public function contactNumberStatusPageColor()
    {
        return Customer::CONTACT_NUMBER_STATUS_PAGE_COLOR[$this->entity->is_contact_number_verified];
    }


    public function emailStatus()
    {
        return Customer::EMAIL_STATUS[$this->entity->is_email_verified];
    }

    public function emailStatusPageColor()
    {
        return Customer::EMAIL_STATUS_PAGE_COLOR[$this->entity->is_email_verified];
    }


    public function companyNumberStatus()
    {
        return Customer::COMPANY_NUMBER_STATUS[$this->entity->is_company_number_verified];
    }

    public function companyNumberStatusPageColor()
    {
        return Customer::COMPANY_NUMBER_STATUS_PAGE_COLOR[$this->entity->is_company_number_verified];
    }

    public function addressStatus()
    {
        return Customer::ADDRESS_STATUS[$this->entity->is_address_verified];
    }

    public function addressStatusPageColor()
    {
        return Customer::ADDRESS_STATUS_PAGE_COLOR[$this->entity->is_address_verified];
    }

    public function bankAccountPageStatus(): string
    {
        return Customer::BANK_ACCOUNT_PAGE_STATUS[$this->entity->bank_account_status];
    }

    public function bankAccountStatusColorPage(): string
    {
        return Customer::BANK_ACCOUNT_STATUS_PAGE_COLOR[$this->entity->bank_account_status];
    }


    public function verified()
    {
        return $this->entity->status = Customer::APPROVED;
    }


    public function accountHolderName()
    {
        return $this->bank_firstname . ' ' . $this->bank_lastname;
    }

    public function bankDOB()
    {
        return $this->entity->bank_dob && $this->entity->bank_dob != '0000-00-00' ? Carbon::parse($this->entity->bank_dob)->format('d/m/Y') : '';
    }

    public function accountHolderNameCorrect()
    {
        return $this->first_lastname_correct;
    }

    public function bankDOBCorrect()
    {
        return $this->dob_correct;
    }


    public function accountHolderNameStatusColor()
    {
        if ($this->bank_firstname) {
            return !is_null($this->first_lastname_correct) ?
                Customer::BANK_ACCOUNT_STATUS_PAGE_COLOR[$this->entity->bank_account_status] : 'awiting';
        }

        return 'awiting';
    }

    public function bankDOBStatusColor()
    {
        if ($this->entity->bank_dob && $this->entity->bank_dob != '0000-00-00') {
            return !is_null($this->dob_correct) ?
                Customer::BANK_ACCOUNT_STATUS_PAGE_COLOR[$this->entity->dob_correct] : 'awiting';
        }

        return 'awiting';
    }
}
