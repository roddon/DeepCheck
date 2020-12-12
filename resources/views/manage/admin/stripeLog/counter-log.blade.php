@extends('layouts.admin.app')

@section('content')

<div class="row mb-2">
    <div class="col-md-6">
        <div class="top_title">Counter log</div>
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
                        <th class="border-right-0">Name</th>
                        <th class="text-center border-right-0">Subscription plan</th>
                        <th class="text-center border-right-0">Invoice check count</th>
                        <th class="text-center border-right-0">Supplier check count</th>
                        <th class="text-center border-right-0">Detector records</th>
                        <th class="text-center border-right-0">No of Safepay</th>
                        <th class="text-center border-right-0">No of onboarding</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    var datatable = $(".tablefst").DataTable({

        ajax: {
            url: '{{ route("admin.counterLog.index") }}',
        },
        "columns": [{
                name: "name",
                data: "name",
                className: 'micro',
            },
            {
                name: "subscriptionPlan",
                data: "subscriptionPlan",
                className: 'text-center'
            },
            {
                name: "no_of_check_invoice",
                data: "no_of_check_invoice",
                className: 'text-center'
            },
            {
                name: "no_of_supplier_check",
                data: "no_of_supplier_check",
                className: 'text-center'
            },
            {
                name: "no_of_safe_payout",
                data: "no_of_safe_payout",
                className: 'text-center'
            },
            {
                name: "no_of_detector_records",
                data: "no_of_detector_records",
                className: 'text-center'
            },
            {
                name: "no_of_onboarding",
                data: "no_of_onboarding",
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
