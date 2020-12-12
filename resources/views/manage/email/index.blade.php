@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="top_title">Sent mail list</div>
    </div>
    <div class="col-md-6 text-right">
        <div class="tblesrch float-right">
            <input class="form-control" id="myInput" type="text" placeholder="Search..">
        </div>
    </div>
</div>
<div class="dash_section_3 h-95">
    <div class="row position-relative h-95">
        <div class="table-responsive position-relative h-95">
            <table class="table tablefst  table-hover w-100">
                <thead>
                    <tr>
                        <th class="border-right-0 normal-padding">From</th>
                        <th class="border-right-0">To</th>
                        <th class="border-right-0">Subject</th>
                        <th class="text-center border-right-0">Body</th>
                        <th class="text-center border-right-0">Status</th>
                        <th class="text-center border-right-0">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('manage.email.view-email-modal')
@endsection

@section('scripts')
<script>
    $('.hd_contact .noti_num').text(0);
    var datatable = $(".tablefst").DataTable({
        ajax: {
            url: '{{ route("email.index") }}',
        },
        "columns": [{
                name: "from",
                data: "from",
                className: 'from'
            },
            {
                name: "to",
                data: "to",
                className: 'to email-td'

            },
            {
                name: "subject",
                data: "subject",
                className: 'subject email-td'
            },
            {
                name: "emailBody",
                data: "emailBody",
                className: "emailBody",
                visible: false,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('text-center');
                }
            },
            {
                name: "read",
                data: "read",
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('text-center');
                }
            },
            {
                name: "action",
                data: "action",
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('text-center');
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
            $('.viewEmail').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{route('email.read')}}",
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        var body = $.parseHTML(result.body);

                        $('.to-data').text(result.to);
                        $('.date-data').text(result.date);
                        $('.subject-data').text(result.subject);
                        $('.emailBody-data').html(body);

                        $('#view-email').modal('show');
                    },
                    beforeSend: function() {
                        $('#overlay').fadeIn();
                    },
                    complete: function() {
                        $('#overlay').fadeOut();
                    }
                });

            });
        }
    });
</script>
@endsection