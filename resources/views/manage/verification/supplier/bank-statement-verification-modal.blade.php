<div class="modal fade custverifcatn common-modal big-modal bg-white" id="bank-statement-verification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="logo_intp newlgo-into">
                    <img src="{{ asset('assets/images/onboard5-logo.svg') }}" alt="">
                </div>
                <h3>Supplier verification </h3>
                <div class="ln"></div>
                <div class="thankuarea">
                    <div class="text-center">
                        <p>Please upload your bank statement and name the file bankstatement.pdf</p>
                        <p id="bankstatement-upload-msg"></p>
                    </div>

                    <form action="">
                        <div class="bankStatementOuter row justify-content-center align-items-center" id="bankStatementOuter">

                            <span class="dragBox col-md-6" id="bankDragBox">
                                Drag and Drop<br>
                                or <br>
                                Click to upload
                                <input type="file" id="bankStatement" />
                            </span>

                            <div id="bankPreview" class="col-md-6"></div>
                        </div>

                    </form>

                    <div class="d-flex align-items-center justify-content-between mt-3 mb-2 modal-actions">
                        <a href="javascript:void(0);" class="invite m-0 graybg nw-ivt" id="">
                            < Back &nbsp</a> <a href="javascript:void(0);" class="invite m-0 nw-ivt graybg" disabled="disabled" id="nextDownloadModal"> Next >
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
