<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Country;
use App\Models\Customer;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'account_number' => "SB" . $faker->numberBetween(100000, 99999999),
        'date_of_birth' => Carbon\Carbon::now()->subYear($faker->numberBetween(10, 25)),
        'gender' => $faker->randomElement([0, 1, 2]),
        'contact_number' => $faker->numberBetween(9000000000, 9999999999),
        'passport_number' => "PP" . $faker->numberBetween(10000, 999999),
        'date_of_issue' => Carbon\Carbon::now()->addWeek()->toDateString(),
        'date_of_expiry' => Carbon\Carbon::now()->addYears(15)->toDateString(),
        'validity_through' =>  Carbon\Carbon::now()->addYears(15)->toDateString(),
        'verification_date' => Carbon\Carbon::now()->toDateString(),
        'country_id' => Country::first()->id,
        'bank_account_status' => $faker->randomElement([0, 1, 2]),
        'document_status' => $faker->randomElement([0, 1, 2]),
        'status' => $faker->randomElement([0, 1, 2]),
        'user_id' => User::all()->random(),
        'sort_code' => rand(1, 99)
    ];
});
