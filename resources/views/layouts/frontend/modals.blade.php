<div class="modal fade common-modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="loginmodal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Login</h4>
            </div>
            <div class="modal-body">
                <div class="fuelux center-box">
                    <div class="block-wizard center-screen">
                        <div class="wizard wizard-ux onboarding-box" id="wizard0">
                            <div class="text-center logo newlogo">
                                <img src="{{asset('frontend/images/loginlogo.svg')}}" alt="logo">
                            </div>
                            <div class="text-center enter-info">
                                <p>Please enter your user information</p>
                            </div>
                            <div class="input-group username-field">
                                <input type="text" class="form-control form-control-sm" placeholder="Username" name="loginUsername">
                                <div class="text-danger font-weight-bold" id="loginEmailError"></div>
                            </div>
                            <div class="input-group password-field">
                                <input type="password" class="form-control form-control-sm" placeholder="Password" name="loginPassword">
                                <div class="text-danger font-weight-bold" id="loginPasswordError"></div>
                            </div>
                            <div class="custom-control custom-control-sm custom-checkbox remember-checkbox">
                                <input class="custom-control-input remember-me-checkbox" type="checkbox" id="check2">
                                <label class="custom-control-label remember-me" for="check2"> Remember me</label>
                                <a class="forgot-password-link" data-target="#forgotmodal" data-toggle="modal" data-dismiss="modal">Forgot password?</a>
                            </div>
                            <div class="login-btn">
                                <button class="btn btn-s text-center register-btn" data-target="#signupmodal" data-toggle="modal" data-dismiss="modal">Register</button>
                                <button class="btn btn-s text-center sign-in-btn" type="submit" id="btnUserLogin">Sign in</button>
                            </div>
                        </div>
                    </div>
                    <p class="text-center copy-right">@2020 DEEPCHECK</p>
                </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade common-modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="signupmodal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Register</h4>
            </div>
            <div class="modal-body">
                <div class="fuelux center-box ">
                    <div class="block-wizard center-screen">
                        <div class="wizard wizard-ux onboarding-box" id="wizard0">
                            <div class="text-center logo newlogo">
                                <img src="{{asset('frontend/images/loginlogo.svg')}}" alt="logo">
                            </div>
                            <div class="text-center enter-info">
                                <p>Please enter your user information</p>
                            </div>
                            <div class="text-center sign-up">
                                <p>Sign Up</p>
                            </div>
                            <div class="input-group username-field">
                                <input type="text" class="form-control form-control-sm" placeholder="Name" name="signupName">
                                <div class="text-danger font-weight-bold" id="signupNameError"></div>
                            </div>
                            <div class="input-group email-field onboarding-text">
                                <input type="text" class="form-control form-control-sm" placeholder="E-mail" name="singupEmail">
                                <div class="text-danger font-weight-bold" id="singupEmailError"></div>
                            </div>
                            <div class="input-group password-field">
                                <input type="password" class="form-control form-control-sm sign-password" placeholder="Password" name="signupPassword">
                                <input type="password" class="form-control form-control-sm sign-confirm" placeholder="Confirm" name="signupPasswordConfirm">

                                <div class="text-danger font-weight-bold" id="signupPasswordError"></div>
                            </div>
                            <div class="sign-up-btn">
                                <button class="btn btn-s text-center input-group" type="submit" id="btnUserSignup">Sign Up</button>
                            </div>

                            <!-- <div class="text-center sign-up-or">
                                <p>or</p>
                            </div> -->

                            <!-- <div class="login-btn">
                                <button class="btn btn-s text-center facebook" type="submit"><img src="images/fb-icon.png"> Facebook</button>
                                <button class="btn btn-s text-center google-plus" type="submit"><img src="images/gp-icon.png"> Google Plus</button>
                            </div> -->

                            <div class="custom-control custom-control-sm custom-checkbox terms-checkbox">
                                <input class="custom-control-input" type="checkbox" id="signuptermsandcondtions">
                                <label class="custom-control-label" for="check2"> By creating an account, you agree the
                                    <a href="{{ route('terms-and-conditions') }}">terms and conditions.</a></label>
                                <div class="text-danger font-weight-bold" id="signuptermsandcondtionsError"></div>
                            </div>
                        </div>
                    </div>
                    <p class="text-center copy-right">@2020 DEEPCHECK</p>
                </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade common-modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="forgotmodal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Forgot Password</h4>
            </div>
            <div class="modal-body">
                <div class="fuelux center-box">
                    <div class="block-wizard center-screen">
                        <div class="wizard wizard-ux onboarding-box" id="wizard0">
                            <div class="text-center logo newlogo">
                                <img src="{{asset('frontend/images/loginlogo.svg')}}" alt="logo">
                            </div>
                            <div class="text-center forgot-password">
                                <p>Forgot your password?</p>
                            </div>
                            <div class="worry-text">
                                <p>Don't worry, we'll send you an email to reset your password</p>

                            </div>
                            <div class="input-group email-field">
                                <input type="text" class="form-control form-control-sm" placeholder="Your E-mail" name="forgotPasswordEmail">
                                <div class="text-danger font-weight-bold" id="forgotPasswordEmailError"></div>
                                <div class="text-success font-weight-bold" id="forgotPasswordEmailSuccess"></div>
                            </div>
                            <div class="reset-password-btn">
                                <button class="btn btn-s input-group text-center d-flex align-items-center justify-content-center" id="btnUserForgotPassword" type="submit">
                                    <span class="reset-password-text">Reset your password</span>
                                </button>
                            </div>
                            <div class="text-center">
                                <p class="dont-remember">Don't remember your email? <a href="#">Contact Support</a></p>
                            </div>
                        </div>
                    </div>

                    <p class="text-center copy-right">@2020 DEEPCHECK</p>
                </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal fade common-modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="selectInvoiceModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="fuelux center-box">
                    <div class="block-wizard center-screen">
                        <div class="wizard wizard-ux onboarding-box" id="wizard0">
                            <div class="text-center logo newlogo">
                                <img src="{{asset('frontend/images/loginlogo.svg')}}" alt="logo">
                            </div>

                            <div class="worry-text">
                                <p>Great you want to check the invoice. We can help you</p>
                            </div>

                            <div class="reset-password-btn">

                                <button class="btn btn-s input-group text-center d-flex align-items-center justify-content-center" id="btnSelectInvoiceModal" type="submit">
                                    <span class="reset-password-text select-invoice-text">Select Invoice</span>
                                </button>
                            </div>

                        </div>
                    </div>

                    <p class="text-center copy-right">@2020 DEEPCHECK</p>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade common-modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="uploadInvoiceModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="fuelux center-box">
                    <div class="block-wizard center-screen">
                        <div class="wizard wizard-ux onboarding-box" id="wizard0">
                            <div class="text-center logo newlogo">
                                <img src="{{asset('frontend/images/loginlogo.svg')}}" alt="logo">
                            </div>

                            <div class="worry-text">
                                <p>But before you go, we need some more information from you so we can send you the results</p>
                            </div>
                            <div class="worry-text" id="document-upload-msg-invoice">

                            </div>
                            <div id="invoiceUploadArea">
                                <div class="input-group email-field">
                                    <input type="text" class="form-control form-control-sm" placeholder="Your Name" id="uploadInvoiceName">
                                    <div class="text-danger font-weight-bold" id="uploadInvoiceNameError"></div>
                                </div>
                                <div class="input-group email-field">
                                    <input type="text" class="form-control form-control-sm" placeholder="Your E-mail" id="uploadInvoiceEmail">
                                    <div class="text-danger font-weight-bold" id="uploadInvoiceEmailError"></div>
                                </div>
                                <div class="input-group email-field">
                                    <input type="text" class="form-control form-control-sm" placeholder="Your Contact Number (eg: +19876543210)" id="uploadInvoiceContactNumber">
                                    <div class="text-danger font-weight-bold" id="uploadInvoiceContactNumberError"></div>
                                </div>
                                <div class="reset-password-btn">
                                    <input type="file" name='checkUploadInvoiceFile' id="checkUploadInvoiceFile" style="display: none;" />
                                    <button class="btn btn-s input-group text-center d-flex align-items-center justify-content-center" id="btnUploadInvoice" type="submit">
                                        <span class="reset-password-text select-invoice-text">Upload Invoice</span>
                                    </button>
                                </div>
                                <div class="custom-control custom-control-sm custom-checkbox terms-checkbox">

                                    &nbsp;
                                </div>
                            </div>
                            <div id="invoiceVerificationCodeArea" style="display: none;">
                                <div class="worry-text">
                                    <p>Verification code has been sent your phone number, Please enter code here.</p>
                                </div>
                                <div class="input-group email-field">
                                    <input type="text" class="form-control form-control-sm" placeholder="Enter verification Code" id="otpCode">
                                    <div class="text-danger font-weight-bold" id="otpCodeError"></div>
                                </div>
                                <div class="reset-password-btn">
                                    <button class="btn btn-s input-group text-center d-flex align-items-center justify-content-center" id="btnInvoiceVerifyOtpCode" type="submit">
                                        <span class="reset-password-text select-invoice-text">Verify OTP</span>
                                    </button>
                                </div>
                                <div class="custom-control custom-control-sm custom-checkbox terms-checkbox"></div>
                            </div>
                        </div>
                    </div>

                    <p class="text-center copy-right">@2020 DEEPCHECK</p>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade common-modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="maintenanceModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="fuelux center-box">
                    <div class="block-wizard center-screen">
                        <div class="wizard wizard-ux onboarding-box" id="wizard0">
                            <div class="text-center logo newlogo">
                                <img src="{{asset('frontend/images/loginlogo.svg')}}" alt="logo">
                            </div>

                            <div class="worry-text">
                                <p class="thanksNote">Thank you for comming back.</p>
                                <p>We are currently rolling out new cool functions for you so bear with us. You will soon be able to login again.</p>
                            </div>

                            <div class="reset-password-btn mainten-button">

                                <button class="btn btn-s input-group text-center d-flex align-items-center justify-content-center" id="btnSelectInvoiceModal" type="submit">
                                    <span class="reset-password-text select-invoice-text">Continue</span>
                                </button>
                            </div>

                        </div>
                    </div>

                    <p class="text-center copy-right">@2020 DEEPCHECK</p>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>