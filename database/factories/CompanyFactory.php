<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'category_id' => 1,
        'country' => $faker->country,
        'city' => $faker->city,
        'user_id' => 1,
        'language_id' => 1,
        'name' => $faker->name,
        'account_number' => $faker->bankAccountNumber,
        'company_number' => $faker->randomNumber(),
        'phone_number' => $faker->phoneNumber,
        'status' => 1,
        'vat_number' => 'BG0123456789',
        'i_ban_number' => $faker->bankAccountNumber,
        'website_url' => $faker->url,
        'onboarding_message' => $faker->text(50),
        'existing_supplier_message' => $faker->text(60),
        'address_1' => $faker->address,
        'address_2' => $faker->address,
        'post_code' => $faker->postcode,
        'is_company_verified' => 1,
        'is_vat_number_verified' => 1,
        'is_ban_number_verified' => 1,
        'is_client_synced' => 1,
        'is_onboarding' => 1,
        'is_id_document' => 1,
        'is_utility_bill_uploaded' => 1
    ];
});
