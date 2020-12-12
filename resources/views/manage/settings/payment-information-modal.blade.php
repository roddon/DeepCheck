<div class="modal fade set-mdl" id="Payment-Information" tabindex="-1" role="dialog" aria-labelledby="Payment-InformationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content d-flex">
            <div class="modal-header mt-5 p-0 align-self-center text-center border-0">		
                    <h3>Payment Information</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="assets/images/close.svg">
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-1"><p>Please select a Payment method for purchange the subscription. It won’t take too much time.</p></div>
                <form class="form mb-4 px-sm-5 py-sm-4 rounded padnew">

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="name">Card Holder Name</label>
                            <input type="text" class="form-control input" placeholder="Michel sem">
                        </div>
                        <div class="col-md-6">
                            <label for="Card-Number">Card Number</label>
                            <input type="text" placeholder="Number" id="Card-Number" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Expiry-Date">Expiry Date</label>
                            <input type="text" class="form-control" id="Expiry-Date" placeholder="Month | Year">
                        </div>
                        <div class="col-md-6">
                            <label for="CVV-Pin">CVV/PIN</label>
                            <input type="text" class="form-control" id="CVV-Pin" placeholder="Code">
                        </div>
                    </div>
                </form>

                <div class="text-center">
                    <button type="button" class="btn btn-lg-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>