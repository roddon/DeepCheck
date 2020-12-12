<div class="modal fade custverifcatn cstveri_two_an_half" id="payment-institution-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <button type="button" class="close close_two" data-dismiss="modal" aria-label="Close">
                <img src="{{ asset('assets/images/close.svg')  }}" alt="">
            </button>
            <div class="modal-body">
                <div class="logo_intp newlgo-into d-inline-block pt-0">
                    <img src="{{ asset('assets/images/onbrd6-logo.svg') }}" alt="">
                </div>
                <h3 class="d-inline-block pl-md-5 pt-2">Institution List</h3>
                <div class="ln mb-0"></div>
                <div class="thankuarea pl-0 pr-0">
                    <div class="text-center mt-4">
                        <p id="paymentInstitutionError"></p>
                    </div>

                    <form name="frmPaymentInstitution" class="mnlform" id="frmPaymentInstitution"
                        action="{{ route('onboarding.send-mail') }}" method="post">
                        @CSRF

                        <div class="row" id="divPaymentInstitutions">

                        </div>
                        <div class="text-center mt-3">
                            <input type="hidden" id="institution_id" value=""/>
                            <a href="javascript:void(0);" class="invite mb-2" id="btnPayToSelectedInvoce">Make Payment</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
