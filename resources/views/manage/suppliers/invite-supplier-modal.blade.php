<div class="modal fade custverifcatn cstveri_three" id="invite-supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <button type="button" class="close close_two" data-dismiss="modal" aria-label="Close">
                <img src="{{ asset('assets/images/close.svg')  }}" alt="">
            </button>
            <div class="modal-body">
                <div class="logo_intp newlgo-into">
                    <img src="{{ asset('assets/images/onbrd6-logo.svg') }}" alt="">
                </div>
                <h3>Invite new supplier</h3>
                <div class="ln"></div>
                <div class="thankuarea">
                    <div class="text-center">
                        <p>Please add your suppliers's email address so we can invite him to be onboarded
                        </p>
                    </div>

                    <form name="frmInviteCustomer" class="mnlform" id="frmInviteCustomer" action="{{ route('sVault.supplier.invite-by-email') }}" method="post">
                        @CSRF
                        <p id="error_supplier_invite"></p>
                        <div class="row">

                            <div class="frmbx">
                                <label>Company Name</label>
                                <input type="text" name="company_name" id="company_name">
                            </div>
                            <div class="frmbx">
                                <label>Email</label>
                                <input type="email" name="email" id="email">
                            </div>

                        </div>
                        <div class="text-center mt-3">
                            <a href="javascript:void(0);" class="invite mb-2" id="sendInvitaion">Send Invite</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>