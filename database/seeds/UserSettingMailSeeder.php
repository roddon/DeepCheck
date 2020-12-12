<?php

use App\Models\UserSettingMail;
use Illuminate\Database\Seeder;

class UserSettingMailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('user_setting_mails')->truncate();
        UserSettingMail::create([
            'onboarding_content' => '<span class="mb-2 mt-2">You simply <a>&lt;click here&gt;</a>,
                                        and follow
                                        the simple process.</span>

                                    <span>We understand this can be perceived as
                                        a spam email to fish for your data.
                                    </span>
                                    <span class="mb-2">For this please contact
                                        me &lt;First Name&gt; &lt;Last Name&gt;
                                        on email &lt;person email&gt; or give me
                                        a call on &lt;phone number&gt; and I can
                                        ensure it is correct.</span>

                                    <span>Kind regards,</span>
                                    <span>&lt;First Name&gt; &lt;Last Name&gt;</span>',
            'check_the_invoice_content' => '<span class="mb-2 mt-2">You simply <a>&lt;click here&gt;</a>,
                                    and follow
                                    the simple process.</span>

                                <span>We understand this can be perceived as
                                    a spam email to fish for your data.
                                </span>
                                <span class="mb-2">For this please contact
                                    me &lt;First Name&gt; &lt;Last Name&gt;
                                    on email &lt;person email&gt; or give me
                                    a call on &lt;phone number&gt; and I can
                                    ensure it is correct.</span>

                                <span>Kind regards,</span>
                                <span>&lt;First Name&gt; &lt;Last Name&gt;</span>',
            'supplier_verification_content' => '<span class="mb-2 mt-2">You simply <a>&lt;click here&gt;</a>,
                                        and follow
                                        the simple process.</span>

                                    <span>We understand this can be perceived as
                                        a spam email to fish for your data.
                                    </span>
                                    <span class="mb-2">For this please contact
                                        me &lt;First Name&gt; &lt;Last Name&gt;
                                        on email &lt;person email&gt; or give me
                                        a call on &lt;phone number&gt; and I can
                                        ensure it is correct.</span>

                                    <span>Kind regards,</span>
                                    <span>&lt;First Name&gt; &lt;Last Name&gt;</span>',
            'existing_supplier_content' => '<span class="mb-2 mt-2">You simply <a>&lt;click here&gt;</a>,
                                    and follow
                                    the simple process.</span>

                                <span class="mb-2">For this please contact
                                    me &lt;First Name&gt; &lt;Last Name&gt;
                                    on email &lt;person email&gt; or give me
                                    a call on &lt;phone number&gt; and I can
                                    ensure it is correct.</span>

                                <span>Kind regards,</span>'
        ]);
    }
}
