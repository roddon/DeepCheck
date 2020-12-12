@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="top_title">Invoice List</div>
    </div>
    <div class="col-md-6 text-right">
        <div class="invitebtnarae ml-3 float-right">
            <input type="file" name="invoice_file[]" id="upload_invoice" style="display: none;" multiple />
            <a href="javascript:void(0);" class="invite" id="upload-invoice">Upload invoice</a>
        </div>
        <div class="tblesrch float-right">
            <input class="form-control" id="myInput" type="text" placeholder="Search..">
        </div>
    </div>
</div>


<div class="dash_section_3 mt-3">
    <div class="row position-relative">
        <!-- <div class="tblesrch"> <input class="form-control" id="myInput" type="text" placeholder="Search.."></div> -->
        <div class="table-responsive position-relative">
            <table class="table tablefst  table-hover w-100">
                <thead>
                    <tr>
                        <th class="border-right-0">Supplier name</th>
                        <th class="text-center border-right-0">Country</th>
                        <th class="text-center border-right-0">Scan date</th>
                        <th class="text-center border-right-0">Due date</th>
                        <th class="text-center border-right-0">Total</th>
                        <th class="text-center border-right-0">Updated at</th>
                        <th class="text-center border-right-0">Status</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- <div class="invitebtnarae uploadInvoice d-md-flex align-items-center ">
            <input type="file" name="invoice_file[]" id="upload_invoice" style="display: none;" />
            <a href="javascript:void(0);" class="invite" id="upload-invoice">Upload invoice</a>
        </div> -->
    </div>
</div>
@endsection

@section('scripts')
<script>
    var datatable = $(".tablefst").DataTable({
        // "targets": 'no-sort',
        // "bSort": false,
        // "order": [],
        ajax: {
            url: '{{ route("invoice.index") }}',
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
                name: "country.name",
                data: "country.name",
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

    $('#upload-invoice').click(function() {
        $('#upload_invoice').click();
    })

    $('#upload_invoice').change(function() {
        // var fileExtension = ['csv'];
        // if ($(this).val() != '' && $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        //     swal('Error', 'invalid csv format', 'error');
        //     $('#supplier_csv').val('')
        //     return false;
        // }

        var jform = new FormData();
        var invoiceFiles = $('input[type=file]')[0].files;

        for (var i = 0; i < invoiceFiles.length; i++) {
            jform.append('invoice_file[]', invoiceFiles[i], invoiceFiles[i]['name']);
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
</script>
@endsection