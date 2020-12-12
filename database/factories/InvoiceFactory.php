<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invoice;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'supplier_id' => Supplier::inRandomOrder()->first()->id,
        'invoice_number' => 'INV' . Str::random(9),
        'user_id' => 2,
        'country_id' => 1,
        'scan_date' => Carbon::now(),
        'due_date' => Carbon::now()->addWeek(),
        'total' => random_int(0, 10000000),
        'status' => rand(0, 11),
        'created_at' => Carbon::now()->subDays(rand(1, 30))
    ];
});
