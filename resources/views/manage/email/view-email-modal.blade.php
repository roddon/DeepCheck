<div class="modal fade custverifcatn cstveri_three" id="view-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <button type="button" class="close close_two" style="display: none;" data-dismiss="modal" aria-label="Close">
                <img src="{{ asset('assets/images/close.svg')  }}" alt="">
            </button>
            <div class="modal-body">
                <div class="logo_intp newlgo-into d-inline-block pt-0">
                    <img src="{{ asset('assets/images/onbrd6-logo.svg') }}" alt="">
                </div>
                <h3 class="d-inline-block float-right mb-0 pt-3 email-head">View E-mail</h3>
                <div class="ln"></div>
                <div class="emailData">
                    <ul>
                        <li class="d-block mb-2">
                            <span>Date:</span>
                            <span class="date-data response-data mb-0"></span>
                        </li>
                        <li class="d-block mb-2">
                            <span>To:</span>
                            <span class="to-data response-data mb-0"></span>
                        </li>
                        <li class="d-block mb-2">
                            <span>Subject:</span>
                            <span class="subject-data response-data mb-0"></span>
                        </li>
                        <li class="d-block mb-2">
                            <span></span>
                            <span class="emailBody-data response-data mb-0"></span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>