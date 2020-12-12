@extends('layouts.admin.app')

@section('content')

<div class="row mb-1">
    <div class="col-md-6">
        <div class="top_title">Stripe log</div>
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
                        <th class="border-right-0">User Name</th>
                        <th class="text-center border-right-0">Purchase Plan</th>
                        <th class="text-center border-right-0">Start date</th>
                        <th class="text-center border-right-0">End date</th>
                        <th class="text-center border-right-0">Price</th>
                        <th class="text-center border-right-0">Status</th>
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
            url: '{{ route("admin.stripeLog.index") }}',
        },
        "columns": [{
                name: "name",
                data: "name",
                className: 'micro',
                // width:"10%"
            },
            {
                name: "subscriptionPlan",
                data: "subscriptionPlan",
                className: 'text-center'
            },
            {
                name: "startDate",
                data: "startDate",
                className: 'text-center'
            },
            {
                name: "endDate",
                data: "endDate",
                className: 'text-center'
            },
            {
                name: "price",
                data: "price",
                className: 'text-center'
            },
            {
                name: "status",
                data: "status",
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
