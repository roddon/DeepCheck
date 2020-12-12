<div class="row w-100 m-0 mt-lg-n3">
    <div class="col-lg-6">
        <!-- <div class="top_title">Supplier/Creditor verification</div> -->
    </div>
    <div class="col-lg-6 text-right pr-0">
        <div class="invitebtnarae ml-3 float-right m-0">
            <a href="javascript:void(0);" data-toggle="tooltip" title="You can tick the supplier to invite them to verify themselves 
or add a new supplier you would like to invite to verify their invoices or bank accounts." class="invite" id="btnFormSubmit">Invite Supplier</a>
        </div>
        <div class="tblesrch float-right">
            <input class="form-control" id="searchSupplierInfo" type="text" placeholder="Search..">
        </div>
    </div>
</div>

<div class="dash_section_3 mt-3 w-100 h-100">
    <form action="{{ route('sVault.supplier.invite') }}" method="POST" id="formSupplier" class="h-100">
        @csrf
        <div class="row position-relative h-100">
            <div class="table-responsive" id="scroll-post-1">

                <table class="table tablefst table-hover w-100 supplier-table" id="supplierTabel">

                    <thead>
                        <tr class=>
                            <th class="border-right-0 text-center" width="20">
                                <label class="cont check-pad">
                                    <input type="checkbox" id="select-all">
                                    <span class="checkmark"></span>
                                </label>
                            </th>
                            <th class="border-right-0">Supplier name</th>
                            <th class="text-center border-right-0">Country</th>
                            <th class="text-center border-right-0">Verification date</th>

                            <th class="text-center border-right-0">Bank account</th>

                            <th class="text-center border-right-0">Bank</th>

                            <th class="text-center border-right-0">Updated at</th>

                            <th class="text-center border-right-0">Status</th>
                        </tr>
                    </thead>

                </table>


            </div>

            <div class="invitebtnarae newinvitrn">

                <div class="d-md-flex upldbx">

                    <a href="javascript:void(0);" id="upload_supplier_csv"> <b>Upload</b> CSV file with
                        <span class="brk">existing suppliers</span></a>
                    <a href="{{ route('sVault.supplier.export') }}"> Download CSV template
                        <span class="brk">file for existing suppliers</span></a>
                    <input type="file" name='supplier_csv' id="supplier_csv" style="display: none;" />
                </div>

            </div>
        </div>
    </form>
</div>