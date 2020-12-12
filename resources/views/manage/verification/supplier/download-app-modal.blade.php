<div class="modal fade custverifcatn common-modal big-modal bg-white" id="download-app-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <!-- <button type="button" class="close close_two" data-dismiss="modal" aria-label="Close">
                <img src="assets/images/close.svg" alt="">
            </button> -->
            <div class="modal-body">
                <div class="logo_intp newlgo-into">
                    <img src="{{ asset('assets/images/onboard5-logo.svg') }}" alt="">
                </div>
                <h3>Supplier verification<br>
                    Identification</h3>
                <div class="ln"></div>
                <div class="thankuarea ">
                    <h2>Thank you</h2>
                    <p>Final step is now to identify yourself. Please collect your passport or national ID. They must
                        have a sign like this to work <img src="{{asset('assets/images/camera.svg')}}" alt=""></p>
                    <p>
                        Then please download our identification app and follow the instructions. Use the reference
                        number {{ $supplier->cust_no }}.
                    </p>


                    <div class="text-center">
                        <a class="d-block" target="_blank" href="https://apps.apple.com/us/app/id1527237781"><img src="{{asset('assets/images/apple.png')}}" class="mb-4" alt="" width="140"></a>
                        <a class="d-block" target="_blank" href="https://play.google.com/store/apps/details?id=id.deepcheck"><img src="{{asset('assets/images/android.png')}}" width="140" alt=""></a>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-3 mb-2 modal-actions">
                        <a href="javascript:void(0);" class="invite m-0 graybg nw-ivt" id="backKycVerification">
                            < Back</a> <a href="javascript:void(0);" class="invite m-0 nw-ivt" id="nextFinishProcess"> Next >
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
