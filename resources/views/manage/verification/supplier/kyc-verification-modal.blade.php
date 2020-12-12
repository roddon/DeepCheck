<div class="modal fade custverifcatn common-modal big-modal bg-white" id="kyc-verification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div class="modal-body">
                <div class="logo_intp newlgo-into d-inline-block pt-0">
                    <img src="{{ asset('assets/images/onboard5-logo.svg') }}" alt="">
                </div>
                <h3 class="d-inline-block pl-md-5 pt-2"> Bank verification </h3>
                <div class="ln"></div>
                <div class="thankuarea new-thank row pl-0">
                    <div class="col-sm-4 pl-0">
                        <h2>Thank you</h2>
                        <p>To verify your address we can quickly connect to your bank and also verify address, name and bank
                            account.<br /> We will not see anything on your accounts and can not do anything.<br /> Your bank will only
                            verify the correctness and all is encrypted between you and your bank
                        </p>
                    </div>

                    <div class="ifarmearea col-sm-8 h-auto">
                        <iframe src="{{ route('verification.supplier.kyc', ['supplier_id' => $supplier->id]) }}" style="width: 100%;height:600px;"></iframe>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-4 mb-2 col-md-12 modal-actions">
                        <a href="javscript:void(0);" class="invite m-0 nw-ivt graybg">
                            < Back</a> <a href="javscript:void(0);" class="invite m-0 nw-ivt" id="nextDownloadApp"> Next >
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
