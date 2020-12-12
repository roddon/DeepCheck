<?php

namespace App\Models;

use App\Models\Media;
use App\Models\Company;
use App\Models\Country;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use App\Models\Presenters\InvoicePresenter;
use Spatie\MediaLibrary\InteractsWithMedia;

class Invoice extends Model implements HasMedia
{
    use InteractsWithMedia, PresentableTrait;

    const NOT_ACTIVE = 0;
    const OK = 1;
    const INVALID_DOCUMENT = 2;
    const FRAUD_DOCUMENT = 3;
    const DUPLICATE_DOCUMENT = 4;
    const MALWARE_FOUND = 5;
    const PROCESSING_ERROR = 6;

    const UPLOADED = 0;
    const CHECK_TEXT = 1;
    const NO_RISK = 2;
    const FALSFIED = 3;
    const FAILED_RUN = 4;

    const PAID = 5;
    const NOT_PAID = 6;
    const SUPPLIER_NOT_VERIFIED = 7;
    const FALSE_INVOICE = 8;
    const ACCPAY = 9;
    const ACCREC = 10;


    const INVOICE_MEDIA_STATUS = [
        self::NOT_ACTIVE => 'Uploaded',
        self::OK => 'Ok',
        self::INVALID_DOCUMENT => 'Invalid',
        self::FRAUD_DOCUMENT => 'Fraudulent',
        self::DUPLICATE_DOCUMENT => 'Duplicate',
        self::MALWARE_FOUND => 'Malware',
        self::PROCESSING_ERROR => 'Processing error',
    ];

    const INVOICE_MEDIA_STATUS_COLOR = [
        self::NOT_ACTIVE => 'not_active',
        self::OK => 'Ok',
        self::INVALID_DOCUMENT => 'yellw',
        self::FRAUD_DOCUMENT => 'failed',
        self::DUPLICATE_DOCUMENT => 'yellw',
        self::MALWARE_FOUND => 'failed',
        self::PROCESSING_ERROR => 'failed',
    ];

    const STATUS = [
        self::UPLOADED => 'Uploaded',
        self::CHECK_TEXT => 'Check Text',
        self::NO_RISK => 'No Risk',
        self::FALSFIED => 'Falsfied',
        self::FAILED_RUN => 'Failed Run',
        self::PAID => 'Paid',
        self::NOT_PAID => 'Not Paid',
        self::SUPPLIER_NOT_VERIFIED => 'Supplier not verified',
        self::FALSE_INVOICE => 'False invoice',
        self::ACCPAY => 'Payable',
        self::ACCREC => 'Receivable',
    ];

    const STATUS_COLOUR = [
        self::UPLOADED => 'blck',
        self::CHECK_TEXT => 'yellw',
        self::NO_RISK => 'success',
        self::FALSFIED => 'failed',
        self::FAILED_RUN => 'failed',
        self::PAID => 'success',
        self::NOT_PAID => 'notpaid',
        self::SUPPLIER_NOT_VERIFIED => 'splerveri',
        self::FALSE_INVOICE => 'failed',
        self::ACCPAY => 'yellw',
        self::ACCREC => 'yellw',
    ];


    const DOCUMENT = 'SUPPLIERS';

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
    protected $guarded = [];

    protected $presenter = InvoicePresenter::class;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::DOCUMENT)->singleFile();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function documentMedia()
    {
        return $this->morphOne(Media::class, 'model');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
