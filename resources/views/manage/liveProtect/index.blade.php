@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="top_title">Payment List</div>
    </div>
    <div class="col-md-6 text-right">
        <div class="tblesrch float-right">
            <input class="form-control" id="myInput" type="text" placeholder="Search..">
        </div>
    </div>
</div>

<div class="dash_section_3 mt-3 h-95">
    <div class="row position-relative h-95">
        <div class="table-responsive  position-relative" id="scroll-post-1">
            <table class="table tablefst  table-hover w-100" id="liveProtectTable">
                <thead>
                    <tr>
                        <th class="border-right-0 text-center" width="20">
                            <label class="cont check-pad">
                                <input type="checkbox" id="select-all">
                                <span class="checkmark"></span>
                            </label>
                        </th>
                        <th class="border-right-0">Beneficiary Name</th>
                        <th class="text-center border-right-0">Accounting reference</th>
                        <th class="text-center border-right-0">Scan date</th>
                        <th class="text-center border-right-0">Due date</th>
                        <th class="text-center border-right-0">Total</th>
                        <th class="text-center border-right-0">Status</th>
                    </tr>
                </thead>

            </table>

        </div>
        <div class="invitebtnarae d-md-flex align-items-center position-absolute">
            <a href="javascript:void(0);" id="pay_checked_invoce" class="invite ml-md-4 pay_checked_invoce">Pay checked invoices</a>
            <a href="javascript:void(0);" id="pay_due_invoice" class="invite ml-md-4 pay_due_invoice">Pay all due date invoices</a>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('manage.liveProtect.payment-institution-modal')
<script type="text/javascript">
    $(window).on('load', function() {

        if (isLoginChecked == 1) {
            if (subscriptionSafaPay == 1 && !cookieSafePay) {
                openSubscriptionCheckModal(
                    'You only have <strong>1</strong> safePay checks left',
                    'safePaySubscription'
                );
            }
        }
    });

    var datatable = $(".tablefst").DataTable({
        ajax: {
            url: '{{ route("liveProtect.index") }}',
        },
        "columns": [{
                name: "id",
                data: "id"
            },
            {
                name: "supplier.name",
                data: "supplier.name",
                className: 'micro'
            },
            {
                name: "bank_reference",
                data: "bank_reference",
                className: 'text-center'
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
            {
                name: "total",
                data: "total",
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
        "initComplete": function(settings, json) {
            $('#myInput').unbind();
            $('#myInput').bind('keyup', function(e) {
                datatable.search(this.value).draw();
            });
        },
        "drawCallback": function(settings) {
            $(".tablefst").removeClass('dataTable');
        }
    });

    $(document).ready(function() {
        $('#pay_checked_invoce').on('click', function() {
            if (safePayCheck()) {
                payCheckedInvoice();
            } else {
                openSubscriptionCheckModal('You have no safePay left');
            }
        });

        $('#pay_due_invoice').on('click', function() {
            if (subscriptionSafaPay) {
                payDueInvoice();
            } else {
                openSubscriptionCheckModal('You have no safePay left');
            }
        });
    });


    var invoices = [];
    var dueDateRequest = 0;

    function payCheckedInvoice() {
        dueDateRequest = 0;
        if(invoices.length > 0){
            paymentInstitutionPopup();
        }else{
            swal("Oops..", 'Please checked any checkbox', "error");
        }
    }




    function payDueInvoice() {
        dueDateRequest = 1;
        paymentInstitutionPopup();
    }

    // Handle click on "Select all" control
    $('#select-all').on('click', function() {
        // Get all rows with search applied
        var rows = datatable.rows({
            'search': 'applied'
        }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);

        if ($('#select-all').is(':checked')) {
            $('input[type="checkbox"]', rows).each(function() {
                id = $(this).data('id');
                if ($(this).is(':checked')) {
                    invoices.push(id);
                }
            })
        } else {
            invoices = [];
        }

    });


    $(document).on('click', 'input[name^=chkSafePay]', function() {
        id = $(this).data('id');
        if ($(this).is(':checked')) {
            invoices.push(id);
        } else {
            invoices = jQuery.grep(invoices, function(value) {
                return value != id;
            });
        }
    })

    function paymentInstitutionPopup(){
        $.ajax({
            url: "{{route('liveProtect.payments.institutions')}}",
            type: 'GET',

            success: function(result) {
                $('#overlay').fadeOut();
                $('#divPaymentInstitutions').html(result);
                $('#payment-institution-modal').modal();

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
    }

    $(document).on('click', 'a[name^=aInstitution]', function(){
        $('#paymentInstitutionError').html('');
        $('a[name^=aInstitution]').each(function(){
            $(this).parent().removeClass('selected-bank');
        })

        institution_id = $(this).attr('institution_id');
        $(this).parent().addClass('selected-bank');
        $('#institution_id').val(institution_id);
    })

    $('#btnPayToSelectedInvoce').click(function(){
        instituteId = $('#institution_id').val();
        $('#paymentInstitutionError').html('');
        if(instituteId){
            $('#payment-institution-modal').modal('hide');
            $.ajax({
                url: "{{route('liveProtect.payments.payment-auth-create')}}",
                type: 'POST',
                data: {
                    invoiceIds: invoices,
                    forDueDateRequest: dueDateRequest,
                    institutionId:instituteId
                },
                success: function(result) {
                    $('#overlay').fadeOut();
                    invoices = [];
                    dueDateRequest = 0;

                    window.location.href = result.auth_uri;
                },
                error: function(result) {
                    $('#overlay').fadeOut();
                    $('#payment-institution-modal').modal();
                    $('#paymentInstitutionError').html('<span class="alert alert-danger">' + result.responseJSON.message + '</span>');

                },
                beforeSend: function() {
                    $('#overlay').fadeIn();
                },
                complete: function() {
                    $('#overlay').fadeOut();
                }
            });
        }else{
            $('#paymentInstitutionError').html('<span class="alert alert-danger">Please select institution</span>');
        }
    })

    function paymentRequest(ids, forDueDateRequest) {

        $.ajax({
            url: "{{route('liveProtect.payment-request')}}",
            type: 'POST',
            data: {
                invoiceIds: ids,
                forDueDateRequest: forDueDateRequest
            },

            success: function(result) {
                // $('#overlay').fadeOut();

                // result = jQuery.parseJSON(result);
                // swal("Success", result.message, "success");
                window.location.href = result.auth_uri;
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
    }
</script>
@endsection
