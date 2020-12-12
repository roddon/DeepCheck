@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="top_title">Onboarding List</div>
    </div>
    <div class="col-md-6 text-right">
        <div class="invitebtnarae ml-3 float-right">
            <a href="javascript:void(0);" class="invite" id="inviteNewCustomer">Invite new customer</a>
        </div>
        <div class="tblesrch float-right">
            <input class="form-control" id="searchCustomerInfo" type="text" placeholder="Search..">
        </div>
    </div>
</div>
<div class="dash_section_3 mt-3 h-95">
    <div class="row position-relative h-95">

        <div class="table-responsive position-relative" id="scroll-post-1">

            <table class="table tablefst table-hover w-100">

                <thead>
                    <tr>
                        <th class="border-right-0">Authenticated Name</th>
                        <th class="text-center border-right-0">Verification date</th>
                        <th class="text-center border-right-0">Country</th>
                        <th class="text-center border-right-0">Bank account</th>
                        <th class="text-center border-right-0">Document</th>
                        <th class="text-center border-right-0">ID Number</th>
                        <th class="text-center border-right-0">D.O.B</th>
                        <th class="text-center border-right-0">Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>


@include('manage.onboarding.invite-modal')
@endsection

@section('scripts')

<script>
    $(window).on('load', function() {
        if (isLoginChecked == 1) {
            if (subscriptionOnboarding == 1 && !cookieOnboarding) {
                openSubscriptionCheckModal(
                    'You only have <strong>1</strong> onboarding verification left',
                    'OnboardingSubscription'
                );
            }
        }
    });

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
        $('#invite-customer-view').hide();
        $('#frmInviteCustomer').submit();

    });


    var datatable = $(".tablefst").DataTable({
        ajax: {
            url: '{{ route("onboarding.index") }}',
        },
        "columns": [{
                name: "name",
                data: "name",
                className: 'micro',
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('d-flex align-items-center');
                }
            },
            {
                name: "verification_date",
                data: "verification_date",
                className: 'text-center'
            },
            {
                name: "country.name",
                data: "country.name",
                className: 'text-center'
            },
            {
                name: "bank_account_status",
                data: "bank_account_status",
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('text-center ' + rowData.bankStatusColorClass);
                }
            },
            {
                name: "document_status",
                data: "document_status",
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('text-center ' + rowData.documentStatusColorClass);
                }
            },
            {
                name: "passport_number",
                data: "passport_number",
                className: 'text-center'
            },
            {
                name: "date_of_birth",
                data: "date_of_birth",
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

    $('#searchCustomerInfo').keyup(function() {
        datatable.search($(this).val()).draw();
    })

    $('#inviteNewCustomer').click(function() {
        if (subscriptionOnboarding > 0) {
            $('#invite-customer-view').modal('show');
        } else {
            openSubscriptionCheckModal('You have no onboarding left');
        }
    });
</script>
@endsection