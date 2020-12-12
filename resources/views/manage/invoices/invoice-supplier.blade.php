@extends('layouts.app-2')
@section('content')
<div class="row h-100">
    <div class="col-lg-12 h-100">
        <div class="dash_main_container sm-hgt mt-mbl h-100">
            <ul class="upperul in-sup border-0 col-lg-6">
                <li id="invoice-list" class='active'><a href="javascript:void(0);">Invoice List</a></li>
                <li id="supplier-list"><a href="javascript:void(0);" id="invoiceSupplierList">Supplier List</a></li>
            </ul>

            <div class="inrcontsec h-100 pt-0" id="invoice-list-area">
                <div class="row h-100">
                    @include('manage.invoices.invoice-list')
                </div>
            </div>

            <div class="inrcontsec h-100 pt-0" id="supplier-list-area" style="display: none;">
                <div class="row h-95">
                    @include('manage.suppliers.supplier-for-invoice')
                    @include('manage.suppliers.invite-supplier-modal')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection


@section('scripts')

<script>
    $(window).on('load', function() {
        if (isLoginChecked == 1) {
            if (subscriptionNoOfCheckInvoices == 1 && !cookieInvoiceCheck) {
                openSubscriptionCheckModal(
                    'You only have <strong>1</strong> invoice check left',
                    'InvoiceCheckSubscription'
                );
            }
        }
    });

    $(document).on('click', 'a[name^=aInvoiceImage]', function() {
        invoice_id = $(this).attr('invoiceId');
        $('.table tbody tr').css('background', '');
        $(this).parent().parent().css('background', '#ebeded 0% 0% no-repeat padding-box')


        $.ajax({
            url: "{{route('invoice.get-detail')}}",
            type: 'POST',
            data: {
                'invoice_id': invoice_id,
            },
            success: function(result) {
                $('#documentArea').html(result);
                $('#overlay').fadeOut();
            },
            error: function(result) {
                $('#overlay').fadeOut();
                swal("Oops..", result.responseJSON.message, "error");
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });

    });

    $('#inviteSupplierForVerification').click(function() {
        $('#invite-supplier').modal('show');
    });

    $('#invoice-list').click(function() {
        $('#supplier-list').removeClass('active');
        $('#invoice-list').addClass('active');

        $('#invoice-list-area').show();
        $('#supplier-list-area').hide();
    })

    $('#supplier-list').click(function() {
        $('#supplier-list').addClass('active');
        $('#invoice-list').removeClass('active');

        $('#invoice-list-area').hide();
        $('#supplier-list-area').show();
    })
</script>
<script>
    var datatable1 = $(".invoice-table").DataTable({
        ajax: {
            url: '{{ route("invoice.index") }}',
            data: {
                'table': 'invoice'
            }
        },
        "columns": [{
                name: "supplier.name",
                data: "supplier.name",
                className: 'micro',
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('d-flex align-items-center');
                }
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
            },
            {
                name: "scan_date",
                data: "scan_date",
                className: 'text-center'
            },
            {
                name: "due_date",
                data: "due_date",
                className: 'text-center'
            },
            // {
            //     name: "total",
            //     data: "total",
            //     className: 'text-center'
            // },


        ],
        "drawCallback": function(settings) {
            $(".tablefst").removeClass('dataTable');
        }
    });

    $('#searchInvoiceInfo').keyup(function() {
        datatable1.search($(this).val()).draw();
    })

    $('#upload-invoice').click(function() {
        $('#upload_invoice').click();
    })

    $('#upload_invoice').change(function() {

        var jform = new FormData();
        var invoiceFiles = $('input[type=file]')[0].files;
        countFile = 0;
        for (var i = 0; i < invoiceFiles.length; i++) {
            jform.append('invoice_file[]', invoiceFiles[i], invoiceFiles[i]['name']);
            countFile++;
        }

        if (countFile > 10) {
            swal("Oops..", "You can't upload more than 10 files at a time", "error");
            return false;
        }

        var token = "{{ csrf_token() }}";
        jform.append("_token", token);

        $.ajax({
            url: "{{route('invoice.store')}}",
            type: 'POST',
            data: jform,
            mimeType: 'multipart/form-data',
            contentType: false,
            processData: false,
            success: function(result) {
                $('#overlay').fadeOut();
                swal("Success", result.message, "success");
                subscriptionNoOfCheckInvoices = subscriptionNoOfCheckInvoices - countFile;
                window.location.reload();
            },
            error: function(data) {
                $('#overlay').fadeOut();
                result = jQuery.parseJSON(data.responseText);

                if (result.errors.message) {
                    openSubscriptionCheckModal(result.errors.message)
                } else {

                    if (result.errors["invoice_file.0"]) {
                        result.message = result.errors["invoice_file.0"];
                    }
                    swal("Oops..", result.message, "error");
                    window.location.reload();
                }
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });
    })
</script>

<script>
    $('#btnFormSubmit').click(function() {
        if (subscriptionSupplierVerification) {
            var countCheckbox = $('tbody input:checkbox:checked').length;
            if (countCheckbox > 0) {
                $('#formSupplier').submit();
            } else {
                // swal("Oops..", 'Please checked any checkbox', "error");
                $('#invite-supplier').modal('show');
            }
        } else {
            openSubscriptionCheckModal('You have no supplier verification left');
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

    var datatable = $(".supplier-table").DataTable({
        ajax: {
            url: '{{ route("sVault.supplier.list") }}',
            data: {
                'table': 'supplier'
            }
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