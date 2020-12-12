<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Country;
use App\Models\Supplier;
use App\Notifications\InviteSuppliers;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Notification;

class SupplierImport implements ToModel, WithHeadingRow, WithValidation
{

    /**
     * @param array $row
     *
     * @return Supplier|null
     */
    public function model(array $row)
    {

        $country = Country::where('name', strtolower($row['country']))->first();
        if (!$country && $row['country']) {
            $country = Country::create([
                'name' => $row['country']
            ]);
        }

        $city = City::where('name', strtolower($row['city']))->first();
        if (!$city && $row['city']) {
            $city = City::create([
                'name' => $row['city']
            ]);
        }

        if (strtolower($row['status']) == 'ok') {
            $status = Supplier::APPROVED;
        } else {
            $status = array_search($row['status'], Supplier::STATUS);
        }

        $gender = array_search($row['gender'], Supplier::GENDER);


        $supplier = Supplier::where('email', $row['email'])->where('user_id', Auth::user()->id)->first();
        $flag = false;

        $supplierData = [
            'name'     => $row['supplier_name'],
            'email'    => $row['email'],
            'contact_number'    => $row['contact_number'],
            'date_of_birth'    => $row['dob'],
            'email'    => $row['email'],
            'country_id' => $country->id,
            'city_id' => $city->id,
            'gender'    => $row['gender'],
            'address_1'    => $row['address_1'],
            'address_2'    => $row['address_2'],
            'post_code'    => $row['post_code'],
            'bank_account_number'    => $row['bank_account'],
            'sort_code'    => $row['sort_code'],
            'i_ban_number'    => $row['iban_number'],
            'vat_number'    => $row['vat_number'],
            'currency_code' => $row['currency_code'],
            'website_url' => $row['website_url'],
            'currency_code' => $row['currency_code'],
            'comments' => $row['comments'],
            'bank_name' => $row['bank'],
            'verification_date' => $row['verification_date'] ? Carbon::parse($row['verification_date']) : null,
            'status' => $status,
            'user_id' => Auth::user()->id,
            'is_csv_update' => true
        ];

        if (!$supplier) {
            $supplier = new Supplier($supplierData);
        } else {
            $supplier->update($supplierData);
            $flag = true;
        }

        if ($status != Supplier::APPROVED) {
            $date = Carbon::now() . '' . $supplier->id;
            $supplier->verification_token = Crypt::encrypt($date);
            $supplier->save();
            Notification::route('mail', $supplier->email)->notify(new InviteSuppliers($supplier, $flag));
        }
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'country' => 'required'
        ];
    }
}
