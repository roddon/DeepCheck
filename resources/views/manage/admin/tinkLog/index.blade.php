@extends('layouts.admin.app')

@section('content')

<div class="row mb-1">
    <div class="col-md-6">
        <div class="top_title">{{__('tink_log.page_title')}}</div>
    </div>
    <div class="col-md-6 text-right">
        <div class="tblesrch float-right">
            <input class="form-control" id="myInput" type="text" placeholder="Search..">
        </div>
    </div>
</div>

<div class="dash_section_3 mt-3 h-95">
    <div class="row position-relative h-95">

        <div class="table-responsive position-relative">
            <table class="table tablefst table-hover w-100">
                <thead>
                    <tr>
                        <th class="border-right-0">{{__('tink_log.model_name')}}</th>
                        <th class="text-center border-right-0">{{__('tink_log.account_number')}}</th>
                        <!-- <th class="text-center border-right-0">{{__('tink_log.available_credit')}}</th>
                        <th class="text-center border-right-0">{{__('tink_log.balance')}}</th> -->
                        <th class="text-center border-right-0">{{__('tink_log.type')}}</th>
                        <th class="text-center border-right-0">{{__('tink_log.holder_name')}}</th>
                        <!-- <th class="text-center border-right-0">{{__('tink_log.currency_code')}}</th>
                        <th class="text-center border-right-0">{{__('tink_log.name')}}</th> -->
                        <th class="text-center border-right-0">{{__('tink_log.updated_at')}}</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- <div class="invitebtnarae uploadInvoice d-md-flex align-items-center ">
            <a href="{{ route('admin.subscription_plans.create') }}" class="invite" id="add-new-user">{{__('common.add')}} {{__('subscription_plan.page_title')}}</a>
        </div> -->
    </div>
</div>

@endsection

@section('scripts')
<script>
    var datatable = $(".tablefst").DataTable({

        ajax: {
            url: '{{ route("admin.tinkLog.index") }}',
        },
        "columns": [{
                name: "model_name",
                data: "model_name",
                className: 'micro',
                // width:"10%"
            },
            {
                name: "account_number",
                data: "account_number",
                className: 'text-center'
            },
            // {
            //     name: "available_credit",
            //     data: "available_credit",
            //     className: 'text-center'
            // },
            // {
            //     name: "balance",
            //     data: "balance",
            //     className: 'text-center'
            // },
            {
                name: "type",
                data: "type",
                className: 'text-center'
            },
            {
                name: "holder_name",
                data: "holder_name",
                className: 'text-center'
            },
            // {
            //     name: "currency_code",
            //     data: "currency_code",
            //     className: 'text-center'
            // },
            // {
            //     name: "name",
            //     data: "name",
            //     className: 'text-center'
            // },
            {
                name: "updated_at",
                data: "updated_at",
                className: 'text-center'
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
</script>
@endsection
