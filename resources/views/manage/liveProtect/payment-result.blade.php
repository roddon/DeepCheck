@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="top_title">Payment Results</div>
    </div>
    <div class="col-md-6 text-right">
        <div class="invitebtnarae ml-3 float-right">
            <a href="javascript:void(0);" class="invite">Show paid only</a>
        </div>
        <div class="tblesrch float-right">
            <input class="form-control" id="myInput" type="text" placeholder="Search..">
        </div>
    </div>
</div>

<div class="dash_section_3 mt-3 h-95">
    <div class="row position-relative h-95">
        <div class="table-responsive  position-relative" id="scroll-post-1">
            <table class="table tablefst table-hover w-100" id="paymentRequestTable">
                <thead>
                    <tr>
                        <th class="border-right-0 ">Invoice Number</th>
                        <th class="text-center border-right-0">Bank reference</th>
                        <th class="text-center border-right-0">Transfer date</th>
                        <th class="text-center border-right-0">Total</th>
                        <th class="text-center border-right-0">Paid out</th>
                        <th class="text-center border-right-0">Difference</th>
                        <th class="text-center border-right-0">Status</th>
                    </tr>
                </thead>
                <tbody id="myTable_three">
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    var datatable = $(".tablefst").DataTable({
        ajax: {
            url: '{{ route("liveProtect.paymentResult", ["invoiceIds" => $invoiceIds])  }}',
        },
        "columns": [{
                name: "invoice_number",
                data: "invoice_number",
                className: 'micro'
            },
            {
                name: "bank_reference",
                data: "bank_reference",
                className: 'text-center'
            },
            {
                name: "transfer_date",
                data: "transfer_date",
                className: 'text-center'
            },
            {
                name: "total",
                data: "total",
                className: 'text-center'
            },
            {
                name: "paid_out",
                data: "paid_out",
                className: 'text-center'
            },
            {
                name: "difference",
                data: "difference",
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
</script>
@endsection
