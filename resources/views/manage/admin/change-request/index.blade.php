@extends('layouts.admin.app')

@section('content')

<div class="row mb-2">
    <div class="col-md-6">
        <div class="top_title">Admin Change requests</div>
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
                        <th class="border-right-0">Customer name</th>
                        <th class="text-center border-right-0">Supplier verification</th>
                        <th class="text-center border-right-0">Country</th>
                        <th class="text-center border-right-0">File name</th>
                        <th class="text-center border-right-0">Invoice no</th>
                        <th class="text-center border-right-0">Date of request</th>
                        <th class="text-center border-right-0">Action</th>
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
            url: '{{ route("admin.change-request.index") }}',
        },
        "columns": [{
                name: "name",
                data: "name",
                className: 'micro',
            },
            {
                name: "supplierVerification",
                data: "supplierVerification",
                className: 'text-center'
            },
            {
                name: "country",
                data: "country",
                className: 'text-center'
            },
            {
                name: "fileName",
                data: "fileName",
                className: 'text-center'
            },
            {
                name: "invoiceNo",
                data: "invoiceNo",
                className: 'text-center'
            },
            {
                name: "dateOfRequest",
                data: "dateOfRequest",
                className: 'text-center'
            },
            {
                name: "action",
                data: "action",
                className: 'text-center'
            },
            {
                name: "status",
                data: "status",
                className: 'text-center',
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
</script>
@endsection
