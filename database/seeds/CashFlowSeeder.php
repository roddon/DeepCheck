<?php

use App\Models\Cashflow;
use Illuminate\Database\Seeder;

class CashFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cashflow::class, 50)->create();
    }
}
