<!-- Start Payment Modal -->
<div class="modal fade" id="companyLogoImage" tabindex="-1" role="dialog" aria-labelledby="PaymentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content d-flex">
            <div class="modal-header mt-5 p-0 align-self-center text-center border-0">
                <h3>Upload Company Image</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('assets/media/icons/close.svg') }}" />
                </button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" id="companyLogoImage" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Payment Modal -->