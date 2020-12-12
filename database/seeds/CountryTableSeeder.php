<?php

use App\Models\Country;
use Illuminate\Database\Seeder;


class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'name' => 'India'
        ]);

        Country::create([
            'name' => 'USA'
        ]);

        Country::create([
            'name' => 'UK'
        ]);
    }
}
