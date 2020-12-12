<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Presenters\SupplierPresenter;
use Laracasts\Presenter\PresentableTrait;

class Supplier extends BaseModel implements HasMedia
{
    use InteractsWithMedia, PresentableTrait;

    const DOCUMENT = 'documents';

    const INVOICE = 'invoices';


    const BANK_ACCOUNT_PENDING_APPROVAL = 0;
    const BANK_ACCOUNT_APPROVED = 1;
    const BANK_ACCOUNT_FAILED = 2;
    const BANK_ACCOUNT_STATUS = [
        self::BANK_ACCOUNT_PENDING_APPROVAL => 'Pending Approval',
        self::BANK_ACCOUNT_APPROVED => 'Approved',
        self::BANK_ACCOUNT_FAILED => 'Failed',
    ];

    const BANK_ACCOUNT_STATUS_COLOUR = [
        self::BANK_ACCOUNT_PENDING_APPROVAL => 'text-info',
        self::BANK_ACCOUNT_APPROVED => 'success',
        self::BANK_ACCOUNT_FAILED => 'failed',
    ];

    const BANK_ACCOUNT_PAGE_STATUS = [
        self::BANK_ACCOUNT_PENDING_APPROVAL => 'Failed',
        self::BANK_ACCOUNT_APPROVED => 'Verified',
        self::BANK_ACCOUNT_FAILED => 'Failed',
    ];

    const BANK_ACCOUNT_STATUS_PAGE_COLOR = [
        self::BANK_ACCOUNT_PENDING_APPROVAL => 'veri faild',
        self::BANK_ACCOUNT_APPROVED => 'veri',
        self::BANK_ACCOUNT_FAILED => 'veri faild',
    ];


    const VAT_NUMBER_VERIFIED = true;
    const VAT_NUMBER_FAILED = false;
    const VAT_NUMBER_STATUS = [
        self::VAT_NUMBER_VERIFIED => 'Verified',
        self::VAT_NUMBER_FAILED => 'Failed',
    ];

    const VAT_NUMBER_STATUS_PAGE_COLOR = [
        self::VAT_NUMBER_VERIFIED => 'veri',
        self::VAT_NUMBER_FAILED => 'veri faild',
    ];


    const EMAIL_VERIFIED = true;
    const EMAIL_FAILED = false;
    const EMAIL_STATUS = [
        self::EMAIL_VERIFIED => 'Verified',
        self::EMAIL_FAILED => 'Failed',
    ];

    const EMAIL_STATUS_PAGE_COLOR = [
        self::EMAIL_VERIFIED => 'veri',
        self::EMAIL_FAILED => 'veri faild',
    ];


    const CONTACT_NUMBER_VERIFIED = true;
    const CONTACT_NUMBER_FAILED = false;
    const CONTACT_NUMBER_STATUS = [
        self::CONTACT_NUMBER_VERIFIED => 'Verified',
        self::CONTACT_NUMBER_FAILED => 'Failed',
    ];

    const CONTACT_NUMBER_STATUS_PAGE_COLOR = [
        self::CONTACT_NUMBER_VERIFIED => 'veri',
        self::CONTACT_NUMBER_FAILED => 'veri faild',
    ];

    const COMPANY_NUMBER_VERIFIED = true;
    const COMPANY_NUMBER_FAILED = false;
    const COMPANY_NUMBER_STATUS = [
        self::COMPANY_NUMBER_VERIFIED => 'Verified',
        self::COMPANY_NUMBER_FAILED => 'Failed',
    ];

    const COMPANY_NUMBER_STATUS_PAGE_COLOR = [
        self::COMPANY_NUMBER_VERIFIED => 'veri',
        self::COMPANY_NUMBER_FAILED => 'veri faild',
    ];


    const ADDRESS_VERIFIED = true;
    const ADDRESS_FAILED = false;
    const ADDRESS_STATUS = [
        self::ADDRESS_VERIFIED => 'Verified',
        self::ADDRESS_FAILED => 'Failed',
    ];

    const ADDRESS_STATUS_PAGE_COLOR = [
        self::ADDRESS_VERIFIED => 'veri',
        self::ADDRESS_FAILED => 'veri faild',
    ];




    const DOCUMENT_PENDING_APPROVAL = 0;
    const DOCUMENT_APPROVED = 1;
    const DOCUMENT_FAILED = 2;
    const DOCUMENT_STATUS = [
        self::DOCUMENT_PENDING_APPROVAL => 'Pending Approval',
        self::DOCUMENT_APPROVED => 'Approved',
        self::DOCUMENT_FAILED => 'Failed',
    ];

    const DOCUMENT_STATUS_COLOUR = [
        self::DOCUMENT_PENDING_APPROVAL => 'text-info',
        self::DOCUMENT_APPROVED => 'success',
        self::DOCUMENT_FAILED => 'failed',
    ];


    const PENDING_APPROVAL = 0;
    const APPROVED = 1;
    const FAILED = 2;
    const STATUS = [
        self::PENDING_APPROVAL => 'Pending Approval',
        self::APPROVED => 'Verified',
        self::FAILED => 'Vefication Failed',
    ];

    const STATUS_COLOUR = [
        self::PENDING_APPROVAL => 'text-info',
        self::APPROVED => 'success',
        self::FAILED => 'failed',
    ];


    const NOT_SPECIFY = 0;
    const MALE = 1;
    const FEMALE = 2;
    const GENDER = [
        self::NOT_SPECIFY => 'Not Specify',
        self::MALE => 'Male',
        self::FEMALE => 'Female',
    ];

    protected $guarded = ['id'];

    protected $presenter = SupplierPresenter::class;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::DOCUMENT);

        $this->addMediaCollection(self::INVOICE);
    }

    /**
     * Relationship
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'supplier_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
