<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cashflow;
use Faker\Generator as Faker;

$factory->define(Cashflow::class, function (Faker $faker) {
    return [
        'cust_no' => rand(1, 100),
        'month' => $faker->randomElement(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']),
        'year' => '2020',
        'revenue' => rand('2000', '50000'),
        'cashflow' => rand('2000', '50000'),
        'profit_loss' => rand('2000', '50000'),
        'fluctuation' => 'test',
        'trendcashflow' => 'test'
    ];
});
