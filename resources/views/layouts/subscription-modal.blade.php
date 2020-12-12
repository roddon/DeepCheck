<div class="modal fade custverifcatn" id="subscription-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div class="modal-body">
                <div class="logo_intp newlgo-into">
                    <img src="{{ asset('assets/images/onboard5-logo.svg') }}" alt="">
                </div>
                <div class="ln"></div>
                <div class="thankuarea">
                    <div>
                        <p>Thank you for showing interest in this area.</p>
                        <p>Please access to this area you must subscribe to our services and identify yourself as
                            our services in these area becomes banking services</p>

                        <p>
                            When you continue you will be shown the identification page where you must identify yourself
                            and then we will bring you to the billing to select a subscription level.
                        </p>
                    </div>

                    <div class="d-flex align-items-center justify-content-center mt-3 mb-2">
                        <a href="javascript:void(0);" class="invite m-0 nw-ivt" id="continueSubscriptionVerification">
                            Continue
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade custverifcatn cstveri_two" id="subscription-check-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <button type="button" class="close close_two" data-dismiss="modal" aria-label="Close">
                <img src="{{asset('assets/images/close.svg')}}" alt="">
            </button>
            <div class="modal-body">
                <div class="logo_intp newlgo-into pt-1">
                    <img src="{{ asset('assets/images/onboard5-logo.svg') }}" alt="">
                </div>
                <div class="ln mb-3"></div>
                <div class="thankuarea px-2 more-check">
                    <div class=''>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="pb-0 mb-2"> Almost all used up</h3>
                                <p class="pb-0" id='subscription-check-text'></p>
                                <p class="pb-0">
                                    Would you like to upgrade to have <strong id='subscription-check-text-suggestion'>more</strong> number of checks
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right" id="divSubscriptionChk">
                                <p class="pb-0">
                                    <input class="form-check-input cursor-pointer" type="checkbox" checked value="" id="chkSubscriptionModal" />
                                    <label class="cursor-pointer" for="onboarding-area"> Do not show again </label>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-center mt-3 mb-2">
                        <input type="hidden" id="hidSubscriptionType" value="" />
                        <a href="#" class="invite m-0 nw-ivt" id="btnContinueSubscription">
                            Upgrade to more check
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade custverifcatn cstveri_two" id="subscription-login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <button type="button" class="close close_two" data-dismiss="modal" aria-label="Close">
                <img src="{{asset('assets/images/close.svg')}}" alt="">
            </button>
            <div class="modal-body">
                <div class="logo_intp newlgo-into pt-1">
                    <img src="{{ asset('assets/images/onboard5-logo.svg') }}" alt="">
                </div>
                <div class="ln mb-3"></div>
                <div class="thankuarea px-2 more-check">
                    <div class='text-left'>
                        <h3 class="pb-0 mb-2">Welcome Back</h3>
                        @if(isset($unreadNotification) && $unreadNotification > 0)
                        <p class="pb-0 more-plan-text">
                            Since your last login there are {{ isset($unreadNotification) ? $unreadNotification : 0 }} new notification.
                            click <a href="{{ route('activityLog.index') }}"> here </a>to see them.
                        </p>
                        @endif
                        <p class="pb-0">
                            <div class="row mb-2">
                                <div class="col-md-5">
                                    <h4>You now have</h4>
                                </div>
                                <div class="col-md-7">
                                    <p class="pb-0 left-item">
                                        <strong>{{isset($subscriptionNoOfCheckInvoices) ?  $subscriptionNoOfCheckInvoices : 0}}</strong> document scan left
                                    </p>
                                    <p class="pb-0 left-item"> <strong>{{isset($subscriptionSafaPay) ?  $subscriptionSafaPay : 0}}</strong> safePay checks left</p>
                                    <p class="pb-0 left-item"> <strong>{{isset($subscriptionOnboarding) ?  $subscriptionOnboarding : 0}}</strong> onboarding verification left</p>
                                    <p class="pb-0 left-item"> <strong>{{isset($subscriptionSupplierVerification) ?  $subscriptionSupplierVerification : 0}}</strong> supplier verification left</p>
                                    <p class="pb-0 left-item"> <strong>{{isset($subscriptionDetector) ?  $subscriptionDetector : 0}}</strong> detector checks left</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    &nbsp;
                                </div>
                                <div class="col-md-7">
                                    <input class="form-check-input cursor-pointer" type="checkbox" checked value="" id="chkLoginSubscriptionModal" />
                                    <label class="cursor-pointer" for="onboarding-area"> Do not show again </label>
                                </div>
                            </div>
                        </p>
                    </div>

                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <a href="#" class="invite m-0 nw-ivt" id="closeLoginNotificationPopup">
                            Continue
                        </a>
                    </div>

                    <span class="opt-text">This site is optimised for Google Chrome browser.</span>
                </div>
            </div>

        </div>
    </div>
</div>