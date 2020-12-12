@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="top_title">Supplier/Creditor verification</div>
    </div>
    <div class="col-md-6 text-right">
        <div class="invitebtnarae ml-3 float-right">
            <a href="javascript:void(0);" class="invite" id="btnFormSubmit">Invite checked</a>
        </div>
        <div class="tblesrch float-right">
            <input class="form-control" id="searchSupplierInfo" type="text" placeholder="Search..">
        </div>
    </div>
</div>

<!-- <div class="top_title">Supplier/Creditor verification</div> -->

<div class="dash_section_3 mt-3">
    <form action="{{ route('sVault.supplier.invite') }}" method="POST" id="formSupplier">
        @csrf
        <div class="row position-relative">
            <!-- <div class="tblesrch"> <input class="form-control" id="searchSupplierInfo" type="text" placeholder="Search.."></div> -->
            <div class="table-responsive" id="scroll-post-1">

                <table class="table tablefst  table-hover" id="supplierTabel">

                    <thead>
                        <tr class=>
                            <th class="border-right-0 text-center" width="20">
                                <label class="cont">
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


@include('manage.suppliers.invite-supplier-modal')
@endsection


@section('scripts')
<script>
    $('#btnFormSubmit').click(function() {
        var countCheckbox = $('tbody input:checkbox:checked').length;
        if (countCheckbox > 0) {
            $('#formSupplier').submit();
        } else {
            // swal("Oops..", 'Please checked any checkbox', "error");
            $('#invite-supplier').modal('show');
        }

    })

    $('#sendInvitaion').click(function() {

        company_name = $.trim($('#company_name').val());
        lastname = $.trim($('#lastname').val());
        email = $.trim($('#email').val());

        if (company_name == '') {
            $('#company_name').focus()
            $('#error_onboarding_invite').html('<span class="alert alert-danger">Please enter company name</span>')
            return false;
        } else if (email == '') {
            $('#email').focus()
            $('#error_onboarding_invite').html('<span class="alert alert-danger">Please valid email</span>')
            return false;
        }
        $('#overlay').fadeIn();
        $('#invite-supplier').hide();
        $('#frmInviteCustomer').submit();
    });

    $('#upload_supplier_csv').click(function() {
        $('#supplier_csv').click();
    })

    $('#supplier_csv').change(function() {
        var fileExtension = ['csv'];
        if ($(this).val() != '' && $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            swal('Error', 'invalid csv format', 'error');
            $('#supplier_csv').val('')
            return false;
        }

        var jform = new FormData();

        if ($(this).val() != '') {
            jform.append('supplier_csv', $('#supplier_csv').get(0).files[0]);

        } else {
            jform.append('supplier_csv', '');
        }

        $('#supplier_csv').val('')
        $.ajax({
            url: "{{route('sVault.supplier.import')}}",
            type: 'POST',
            data: jform,
            mimeType: 'multipart/form-data',
            contentType: false,
            processData: false,
            success: function(result) {
                $('#overlay').fadeOut();
                swal("Success", result.message, "success");
                window.location.reload();
            },
            error: function(data) {
                $('#overlay').fadeOut();

                result = jQuery.parseJSON(data.responseText);

                swal("Oops..", result.message, "error");
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });
    })

    var datatable = $(".tablefst").DataTable({
        ajax: {
            url: '{{ route("sVault.supplier.list") }}',
        },
        "columns": [{
                name: "id",
                data: "id",
                className: 'text-center',
            },
            {
                name: "name",
                data: "name",
                className: 'micro',
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('d-flex align-items-center');
                }
            },
            {
                name: "country.name",
                data: "country.name",
                className: 'text-center'
            },
            {
                name: "verification_date",
                data: "verification_date",
                className: 'text-center'
            },
            {
                name: "bank_account_number",
                data: "bank_account_number",
                className: 'text-center'
            },
            {
                name: "bank_name",
                data: "bank_name",
                className: 'text-center'
            },
            {
                name: "updatedAt",
                data: "updatedAt",
                className: 'text-center'
            },
            {
                name: "status",
                data: "status",
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('text-center ' + rowData.statusColorClass);
                }
            }
        ],
        "drawCallback": function(settings) {
            $(".tablefst").removeClass('dataTable');
        }
    });

    $('#searchSupplierInfo').keyup(function() {
        datatable.search($(this).val()).draw();
    })

    // Handle click on "Select all" control
    $('#select-all').on('click', function() {
        // Get all rows with search applied
        var rows = datatable.rows({
            'search': 'applied'
        }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Handle click on checkbox to set state of "Select all" control
    $('#supplierTabel tbody').on('change', 'input[type="checkbox"]', function() {
        // If checkbox is not checked
        if (!this.checked) {
            var el = $('#select-all').get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if (el && el.checked && ('indeterminate' in el)) {
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
            }
        }
    });
</script>
@endsection