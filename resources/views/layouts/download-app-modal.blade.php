<div class="modal fade custverifcatn" id="subscription-verification-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <button type="button" class="close close_two" data-dismiss="modal" aria-label="Close">
                <img src="{{asset('assets/images/close.svg')}}" alt="">
            </button>
            <div class="modal-body">
                <div class="logo_intp newlgo-into">
                    <img src="{{ asset('assets/images/onboard5-logo.svg') }}" alt="">
                </div>
                <h3>Identification</h3>
                <div class="ln"></div>
                <div class="thankuarea ">
                    <h2>Thank you</h2>
                    <p>Final step is now to identify yourself. Please collect your passport or national ID. They must
                        have a sign like this to work <img src="{{asset('assets/images/camera.svg')}}" alt=""></p>
                    <p>
                        Then please download our identification app and follow the instructions. Use the reference
                        number <span id="sp-customer-onboarding-number"></span>.
                    </p>


                    <div class="text-center">
                        <a class="d-block" target="_blank" href="https://apps.apple.com/us/app/id1527237781"><img src="{{asset('assets/images/apple.png')}}" class="mb-4" alt="" width="140"></a>
                        <a class="d-block" target="_blank" href="https://play.google.com/store/apps/details?id=id.deepcheck"><img src="{{asset('assets/images/android.png')}}" alt="" width="140"></a>
                    </div>

                    <div class="d-flex align-items-center justify-content-center mt-3 mb-2">
                        <a href="{{ route('settings.edit') . '?billing=1' }}" class="invite m-0 nw-ivt" id="continueSubscriptionBilling">
                            Continue after verification
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
