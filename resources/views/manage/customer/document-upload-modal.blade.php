<div class="modal fade custverifcatn common-modal big-modal bg-white" id="customer-verification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="logo_intp newlgo-into">
                    <img src="{{ asset('assets/images/onboard5-logo.svg') }}" alt="">
                </div>
                <h3>Document upload </h3>
                <div class="ln"></div>
                <div class="thankuarea">
                    <div class="text-center">
                        <p>Please upload the documents and add a copy of your bank statement and name the file bankstatement.pdf</p>
                        <p id="document-upload-msg"></p>
                    </div>

                    <form action="">
                        <div class="uploadOuter row justify-content-center align-items-center" id="uploadOuter">

                            <span class="dragBox col-md-6" id="dragBox">
                                Drag and Drop<br>
                                or <br>
                                Click to upload
                                <input type="file" multiple id="customerDocument"/>
                            </span>

                            <div id="preview" class="col-md-6"></div>
                        </div>

                    </form>

                    <div class="d-flex align-items-center justify-content-between mt-3 mb-2 modal-actions">
                        <a href="javascript:void(0);" class="invite m-0 graybg nw-ivt">
                            < Back &nbsp</a> <a href="javascript:void(0);" class="invite m-0 nw-ivt" id="nextDownloadModal"> Next >
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
