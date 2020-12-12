<?php

namespace App\Models;

use App\Models\Country;

use App\Models\ActivityLog;
use Spatie\MediaLibrary\HasMedia;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Presenters\CustomerPresenter;
// use App\Models\Traits\Encryptable;

class Customer extends BaseModel implements HasMedia
{

    use InteractsWithMedia, PresentableTrait;

    const DOCUMENT = 'ONBOARDING';
    const PASSPORT_PHOTO = 'PASSPORT_PHOTO';
    const CAPTURE_PHOTO = 'CAPTURE_PHOTO';


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
        self::APPROVED => 'Approved',
        self::FAILED => 'Failed',
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


    const MEDIA_SCAN_STATUS = [
        "1" => 'OK',
        '2' => 'Invalid',
        '3' => 'Fraudulent',
        '4' => 'Duplicate Document',
        '5' => 'Malware Found',
        '6' => 'Processing Error',
        'malware' => 'Malware',
        'duplicate' => 'Duplicate',
        'New DRS' => 'New DRS'
    ];

    const MEDIA_SCAN_STATUS_CLASS = [
        "OK" => 'valid-doc',
        'Invalid' => 'invalid-doc',
        'Fraudulent' => 'fraud-doc',
        'Processing Error' => 'error-doc',
        'Malware' => 'malware-doc',
        'Duplicate' => 'duplicate-doc',
        'New DRS' => 'new-drs-doc'
    ];

    const MEDIA_SCAN_STATUS_BG_CLASS = [
        "OK" => 'valid-doc-bg',
        'Invalid' => 'invalid-doc-bg',
        'Fraudulent' => 'fraud-doc-bg',
        'Processing Error' => 'error-doc-bg',
        'Malware' => 'malware-doc-bg',
        'Duplicate' => 'duplicate-doc-bg',
        'New DRS' => 'new-drs-doc-bg'
    ];

    const MEDIA_SCAN_STATUS_FONT_CLASS = [
        "OK" => 'font-valid-doc-bg',
        'Invalid' => 'font-invalid-doc-bg',
        'Fraudulent' => 'font-fraud-doc-bg',
        'Processing Error' => 'font-error-doc-bg',
        'Malware' => 'font-malware-doc-bg',
        'Duplicate' => 'font-duplicate-doc-bg',
        'New DRS' => 'font-new-drs-doc-bg'
    ];



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $presenter = CustomerPresenter::class;


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::DOCUMENT);
        $this->addMediaCollection(self::PASSPORT_PHOTO)->singleFile();
        $this->addMediaCollection(self::CAPTURE_PHOTO)->singleFile();
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

    public function activityLog()
    {
        return $this->morphMany(ActivityLog::class, 'model');
    }
}
