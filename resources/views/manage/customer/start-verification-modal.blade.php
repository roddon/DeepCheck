<div class="modal fade custverifcatn common-modal big-modal bg-white" id="start-customer-verification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">

            <div class="modal-body">
                <div class="logo_intp newlgo-into">
                    <img src="{{ asset('assets/images/onboard5-logo.svg') }}" alt="">
                </div>
                <h3>Customer verification </h3>

                <div class="ln"></div>
                <div class="thankuarea">
                    <p>Thank you for allowing us to verify you on behalf of {{$customer->user->name}}.
                        When you click on the link below you will be brought to your bank's login screen and
                        you will then need to use your own credentials to login.</p>

                    <p>Our system is verifying that your bank account number belongs to you and we will also get you
                        home address automatically without any need for additional verification.</p>

                    <p>Your customer is happy to help you on phone number {{$customer->user->contact_number}}
                        or via email {{$customer->user->email}}.</p>
                    <p id="otp-text">Please add your information below to verify your information</p>


                    <p id="phoneVerificationStatus"></p>
                    <div id="verification-area">
                        <ul>
                            <li>
                                <div class="frmbx">
                                    <label>Phone number</label>
                                    <input type="text" id="phoneNumber" placeholder="Eg: +11111222333" />
                                </div>
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="javascript:void(0);" class="invite mb-2" id="verifyPhoneNumber"> Start verification</a>
                        </div>
                    </div>
                    <div id="otp-area" style="display: none;">
                        <ul>
                            <li>
                                <div class="frmbx">
                                    <label>OTP</label>
                                    <input type="text" id="OTPCode" />
                                </div>
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="javascript:void(0);" class="invite mb-2" id="OTPVerify">Verify</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>