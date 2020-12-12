<?php

use Illuminate\Database\Seeder;
use App\Models\SubscriptionExpiryMail;

class SubscriptionPlanExpiryMailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('subscription_expiry_mails')->truncate();
        SubscriptionExpiryMail::create(
            [
                'seven_days_before_exp' => '<span>Your subscription will finish in &lt;no of days&gt;. We are happy with you onboard so please do not leave us. If you are happy to give us some feedback on our service please send me an email below and tell me more how we can help you.</span>
                                        <span>If you have cancelled by mistake, do not worry, please <a>&lt;press here&gt;</a> to continue subscribing to the same plans that you were subscribing to right now.</span>
                                        <span>If you would like to have some help please email me on perf@deepcheck.one.</span>
                                        <span>Regards,</span>
                                        <span>Per Frennbro</span>',
                'three_days_before_exp' => '<span>Your subscription will finish in &lt;no of days&gt; days. Do not leave our service. Help us enhance and help us fulfil your needs as a company.</span>
                                        <span>If you have cancelled by mistake, do not worry, please <a>&lt;press here&gt;</a> to continue subscribing to the same plans that you were subscribing to right now.</span>
                                        <span>If you would like to have some help please email me on perf@deepcheck.one.</span>
                                        <span>Regards,</span>
                                        <span>Per Frennbro</span>',
                'one_days_before_exp' => '<span>Tomorrow is the first day without us. We do not understand how this will work out for us and you.</span>
                                        <span>How will you be able to:</span>
                                        <span>Check for fake suppliers?</span>
                                        <span>Check fake invoices?</span>
                                        <span>Check internal fraud?</span>
                                        <span>5% of your revenue is lost to false invoices or on average this is $65,000 for each company. It is a lot of money.</span>
                                        <span>If you have cancelled by mistake, do not worry, please <a>&lt;press here&gt;</a> to continue subscribing to the same plans that you were subscribing to right now.</span>
                                        <span>If you would like to have some help please email me on perf@deepcheck.one.</span>
                                        <span>Regards,</span>
                                        <span>Per Frennbro</span>',
                'one_days_after_exp' => '<span>Your subscription finished yesterday. We guess it is a mistake and you forgot to update the subscription.</span>
                                        <span>If it is a mistake, do not worry, please <a>&lt;press here&gt;</a> to continue subscribing to the same plans that you were subscribing to earlier.</span>
                                        <span>If you would like to have some help please email me on perf@deepcheck.one.</span>
                                        <span>Regards,</span>
                                        <span>Per Frennbro</span>',
                'three_days_after_exp' => '<span>We miss you! Why not continue your subscription and get a discount</span>
                                        <span>We can give you &lt;discount&gt;% reduction of your subscription fees for 60 days.</span>
                                        <span>If you would like to continue subscribing, please <a>&lt;press here&gt;</a>.</span>
                                        <span>If you would like to have some help please email me on perf@deepcheck.one.</span>
                                        <span>Regards,</span>
                                        <span>Per Frennbro</span>',
                'seven_days_after_exp' => '<span>We gave you some discount in our last email, why not get that discount and get the check invoice for free for the same time (discount is valid for invoice check and detector check).</span>
                                        <span>We still can give you &lt;discount&gt;% reduction of your subscription fees for 60 days.</span>
                                        <span>If you would like to continue subscribing, please <a>&lt;press here&gt;</a>.</span>
                                        <span>If you would like to have some help please email me on perf@deepcheck.one.</span>
                                        <span>Regards,</span>
                                        <span>Per Frennbro</span>'
            ]
        );
    }
}
