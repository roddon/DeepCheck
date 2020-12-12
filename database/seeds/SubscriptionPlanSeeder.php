<?php

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    protected $total = [1 => 1000, 2 => 2000, 3 => 3000, 4 => 4000];
    protected $no_of_days = [1 => 100, 2 => 200, 3 => 300, 4 => 400];
    protected $no_of_doc_check = [1 => 2000, 2 => 3000, 3 => 4000, 4 => 5000];
    protected $no_of_detector_records = [1 => 5000, 2 => 6000, 3 => 7000, 4 => 8000];
    protected $no_of_verification = [1 => 350, 2 => 450, 3 => 550, 4 => 650];
    protected $no_of_onboarding = [1 => 350, 2 => 450, 3 => 550, 4 => 650];
    protected $no_of_live_protect = [1 => 10, 2 => 20, 3 => 30, 4 => 40];
    protected $free_trial_months = [1 => 1, 2 => 2, 3 => 3, 4 => 4];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        collect(SubscriptionPlan::PLANS)->each(function ($plan, $i) {
            SubscriptionPlan::create([
                'name' => $plan,
                'description' => $plan . " Plan Description.",
                'total' => $this->total[$i],
                'no_of_days' => $this->no_of_days[$i],
                'no_of_doc_check' => $this->no_of_doc_check[$i],
                'no_of_detector_records' => $this->no_of_detector_records[$i],
                'no_of_verification' => $this->no_of_verification[$i],
                'no_of_onboarding' => $this->no_of_onboarding[$i],
                'no_of_live_protect' => $this->no_of_live_protect[$i],
                'free_trial_months' => $this->free_trial_months[$i],
            ]);
        });
    }
}
