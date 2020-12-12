<?php

use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Str;
use App\Models\CompanyCateogry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(LangauageTableSeeder::class);
        $this->call(CountryTableSeeder::class);

        

        Country::create([
            'name' => 'India'
        ]);

        Country::create([
            'name' => 'USA'
        ]);

        Country::create([
            'name' => 'UK'
        ]);

        CompanyCateogry::updateOrCreate([
            'name' => 'category1'
        ]);

        factory(App\Models\Customer::class, 50)->create();
        factory(App\Models\Supplier::class, 50)->create();
        // $this->call(CompanySeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(CashFlowSeeder::class);
    }
}
