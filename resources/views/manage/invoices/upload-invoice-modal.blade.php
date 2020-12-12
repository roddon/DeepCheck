<div class="modal fade custverifcatn cstveri_three" id="upload-invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <button type="button" class="close close_two" data-dismiss="modal" aria-label="Close">
                <img src="{{ asset('assets/images/close.svg')  }}" alt="">
            </button>
            <div class="modal-body">
                <div class="logo_intp newlgo-into">
                    <img src="{{ asset('assets/images/onbrd6-logo.svg') }}" alt="">
                </div>
                <h3>Upload invoice</h3>
                <div class="ln"></div>
                <form name="frmInvoiceUpload" id="frmInvoiceUpload" action="{{ route('invoice.store') }}" method="post" enctype="multipart/form-data">
                    @CSRF
                    <div class="col-md-12">
                        <input type="file" class="form-control-file" name="invoice_file[]" multiple>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-sm btn-primary m-top-10">Upload Invoice</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>