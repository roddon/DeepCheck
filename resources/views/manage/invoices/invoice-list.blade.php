<div class="row w-100 m-0 mt-lg-n3">
    <div class="col-lg-6">
        <!-- <div class="top_title">Invoice List</div> -->
    </div>
    <div class="col-lg-6 text-right pr-0">
        <div class="invitebtnarae ml-3 float-right m-0">
            <input type="file" name="invoice_file[]" id="upload_invoice" style="display: none;" multiple />
            <a href="javascript:void(0);" class="invite" id="upload-invoice">Upload invoice</a>
        </div>
        <div class="tblesrch float-right">
            <input class="form-control" id="searchInvoiceInfo" type="text" placeholder="Search..">
        </div>
    </div>
</div>

<div class="row w-100 row w-100 m-0 mt-2 listin-preview-wrapper h-100 border-0">
    <div class="col-md-9 pl-0 mb-4">
        <div class="dash_section_3 mt-0 w-100 h-100">
            <div class="row position-relative h-100">
                <div class="table-responsive position-relative">
                    <table class="table tablefst table-hover w-100 invoice-table border-0">
                        <thead>
                            <tr>
                                <th class="border-right-0">Name</th>
                                <!-- <th class="text-center border-right-0">Country</th> -->
                                <th class="text-center border-right-0">Uploaded At</th>
                                <th class="text-center border-right-0">Status</th>

                                <th class="text-center border-right-0">Scan date</th>
                                <th class="text-center border-right-0">Due date</th>
                                <!-- <th class="text-center border-right-0">Total</th>-->
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mt-3">
        <div class="mt-mbl" id="documentArea">
            <ul class="flasi row no-status justify-content-left align-items-center main-ul-button">
                <li class="falabtn col-md-12 pl-md-0 not-active" id="liDocMainStatus">
                    <a href="javascript:void(0);" id="docMainStatus" title="">Not Active </a>
                </li>
            </ul>
            <ul class="flasi row no-status justify-content-left align-items-center">
                <li class="falabtn col-md-6 pl-md-0 not-active" id="liDocStatus">
                    <a href="javascript:void(0);" id="docStatus" title="">Not Active <br> <span>Malware Check</span></a>
                </li>
                <li class="falabtn col-md-6 pr-md-0 not-active" id="liDocAreaDetected">
                    <a href="javascript:void(0);" id="docAreaDetected">Not Active <span class="d-block">Falsification</span></a>
                </li>
            </ul>

            <div class="imgbx no-invoice mb-4">
                <span>No document selected</span>
                <embed style="display: none;" src="assets/images/dcmntimg.png" type="" id="docImgSrc">
            </div>
            <a id="enlargeReviewButton" href="" style="display: none;" class="invite mt-md-5 mt-3 review col-md-12 text-center">Review/Edit enlarged</a>
        </div>
    </div>
</div>