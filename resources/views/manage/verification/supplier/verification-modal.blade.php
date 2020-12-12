<div class="modal fade custverifcatn common-modal big-modal bg-white" id="supplier-verification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <!-- <button type="button" class="close close_two" data-dismiss="modal" aria-label="Close">
                <img src="assets/images/close.svg" alt="">
            </button> -->
            <div class="modal-body">
                <div class="logo_intp newlgo-into">
                    <img src="{{ asset('assets/images/onboard5-logo.svg') }}" alt="">
                </div>
                <h3>Supplier verification </h3>
                <div class="ln"></div>
                <div class="thankuarea">
                    <p>Thank you for allowing us to verify you on behalf of ({{ $supplier->user->name }}).
                        When you click on the link below you will be brought to your bank's login screen and
                        you will then need to use your own credentials to login.</p>

                    <p>Our system is verifying that your bank account number belongs to you so
                        your buyer is paying the money to the correct account.</p>

                    <p>Your customer is happy to help you on phone number {{ $supplier->user->contact_number }}
                        or via email {{ $supplier->user->email }}.</p>
                    <p class="mb-2">Please add your information below to verify your company information</p>

                    <p id="supplier-verification-error"></p>
                    <div id="contact-number-area">
                        <ul>

                            <li id="verification-area">
                                <div class="frmbx">
                                    <label>Contact Number</label>
                                    <input type="text" placeholder="Eg. +11111222333" name="contact_number" id="phoneNumber" value="" />

                                </div>
                            </li>

                        </ul>
                        <div class="text-center">
                            <a href="javascript:void(0);" class="invite mb-3" id="verifyPhoneNumber"> Verify Phone number</a>
                        </div>
                    </div>

                    <div style="display: none;" id="otp-area">
                        <ul>

                            <li id="otp-area">
                                <div class="frmbx">
                                    <label>OTP Code</label>
                                    <input type="text" name="OTPCode" id="OTPCode" value="" />
                                </div>
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="javascript:void(0);" class="invite mb-3" id="OTPVerify"> Verify OTP</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>