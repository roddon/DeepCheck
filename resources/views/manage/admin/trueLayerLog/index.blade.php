@extends('layouts.admin.app')

@section('content')

<div class="row mb-2">
    <div class="col-md-6">
        <div class="top_title">{{__('true_layer_log.page_title')}}</div>
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
                        <th class="border-right-0">{{__('true_layer_log.benificiary_name')}}</th>
                        <th class="text-center border-right-0">{{__('true_layer_log.benificiary_reference')}}</th>
                        <th class="text-center border-right-0">{{__('true_layer_log.benificiary_short_code')}}</th>
                        <th class="text-center border-right-0">{{__('true_layer_log.benificiary_account_number')}}</th>
                        <th class="text-center border-right-0">{{__('true_layer_log.status')}}</th>
                        <th class="text-center border-right-0">{{__('true_layer_log.updated_at')}}</th>
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
            url: '{{ route("admin.trueLayerLog.index") }}',
        },
        "columns": [{
                name: "beneficiary_name",
                data: "beneficiary_name",
                className: 'micro'
            },
            {
                name: "beneficiary_reference",
                data: "beneficiary_reference",
                className: 'text-center'
            },
            {
                name: "beneficiary_sort_code",
                data: "beneficiary_sort_code",
                className: 'text-center'
            },
            {
                name: "beneficiary_account_number",
                data: "beneficiary_account_number",
                className: 'text-center'
            },
            {
                name: "status",
                data: "status",
                className: 'text-center'
            },
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
