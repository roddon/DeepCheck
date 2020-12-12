<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Country;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'account_number' => $faker->numberBetween(10000000, 99999999),
        'bank_name' => 'RSPL-Bank',
        'date_of_birth' => Carbon::now()->subYear($faker->numberBetween(10, 25)),
        'gender' => $faker->randomElement([0, 1, 2]),
        'contact_number' => $faker->numberBetween(9000000000, 9999999999),
        'verification_date' => Carbon::now()->toDateString(),
        'country_id' => Country::first()->id,
        'bank_account_status' => $faker->randomElement([0, 1, 2]),
        'document_status' => $faker->randomElement([0, 1, 2]),
        'status' => $faker->randomElement([0, 1, 2]),
        'user_id' => 3,
        'sort_code' => rand(100000, 999999),
        'created_at' => Carbon::now()->subDays(rand(1, 30))
    ];
});
