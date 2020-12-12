@extends('layouts.admin.app')

@section('content')

<div class="row mb-1">
    <div class="col-md-6">
        <div class="top_title">Customer log</div>
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
                        <th class="text-center border-right-0">Date of birth</th>
                        <th class="text-center border-right-0">Country</th>
                        <th class="text-center border-right-0">Verification date</th>
                        <th class="text-center border-right-0">Bank account status</th>
                        <th class="text-center border-right-0">Document status</th>
                        <th class="text-center border-right-0">status</th>
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
            url: '{{ route("admin.customerLog.index") }}',
        },
        "columns": [{
                name: "name",
                data: "name",
                className: 'micro',
                // width:"10%"
            },
            {
                name: "verification_date",
                data: "verification_date",
                className: 'text-center'
            },
            {
                name: "date_of_birth",
                data: "date_of_birth",
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
                className: 'text-center'
            },
            {
                name: "document_status",
                data: "document_status",
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
