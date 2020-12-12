<?php

namespace App\Exports;


use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SupplierExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;
    /**
     * @var Builder
     */
    private $query;

    /**
     * BankExport constructor.
     * @param Builder|null $query
     */
    public function __construct(Builder $query = null)
    {
        $this->query = $query;
    }

    /**
     * @return Builder|\Illuminate\Database\Query\Builder|null
     */
    public function query()
    {
        return $this->query ?? Supplier::latest();
    }

    /**
     * @param mixed $supplier
     * @return array
     */
    public function map($supplier): array
    {
        return [
            $supplier->name,
            $supplier->email,
            $supplier->contact_number,
            $supplier->present()->dob,
            $supplier->present()->gender,
            optional($supplier->country)->name,
            optional($supplier->city)->name,
            $supplier->address_1,
            $supplier->address_2,
            $supplier->post_code,
            $supplier->present()->verificationDate,
            $supplier->bank_account_number,
            $supplier->sort_code,
            $supplier->i_ban_number,
            $supplier->bank_name,
            $supplier->vat_number,
            $supplier->currency_code,
            $supplier->website_url,
            $supplier->comments,
            $supplier->present()->status,
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Supplier Name',
            'Email',
            'Contact Number',
            'DOB',
            'Gender',
            'Country',
            'City',
            'Address 1',
            'Address 2',
            'Post Code',
            'Verification Date',
            'Bank Account',
            'Sort Code',
            'IBan Number',
            'Bank',
            'VAT Number',
            'Currency Code',
            'Website URL',
            'Comments',
            'Status',
        ];
    }
}
