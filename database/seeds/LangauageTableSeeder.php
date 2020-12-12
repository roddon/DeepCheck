<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class LangauageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'name' => 'English (UK)'
        ]);

        Language::create([
            'name' => 'Español'
        ]);

        Language::create([
            'name' => 'English (USA)'
        ]);

        Language::create([
            'name' => 'French'
        ]);

        Language::create([
            'name' => 'German'
        ]);
    }
}
