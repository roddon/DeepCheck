@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="top_title">Onboarding logs</div>
    </div>
    <div class="col-md-6 text-right">
        <div class="tblesrch float-right">
            <input class="form-control" id="myInput" type="text" placeholder="Search..">
        </div>
    </div>
</div>

<div class="dash_section_3 mt-3 h-95">
    <div class="row position-relative h-95">
        <!-- <div class="tblesrch"> <input class="form-control" id="myInput" type="text" placeholder="Search.."></div> -->
        <div class="table-responsive position-relative">
            <table class="table tablefst  table-hover ">
                <thead>
                    <tr>
                        <th class="border-right-0">Name</th>
                        <th class="text-center border-right-0">Log</th>
                        <th class="text-center border-right-0">Date/Time</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>

        $('.hd_notification .noti_num').text(0);

        var datatable = $(".tablefst").DataTable({
            ajax: {
                url: '{{ route("admin.activityLog.index") }}',
            },
            "columns": [{
                    name: "name",
                    data: "name",
                    className: 'name'
                },
                {
                    name: "log",
                    data: "log",
                    className: 'log'
                },
                {
                    name: "dateTime",
                    data: "dateTime",
                    className: 'dateTime'
                }
            ],
            "initComplete": function(settings, json) {
                $('#myInput').unbind();
                $('#myInput').bind('keyup', function(e) {
                    datatable.search( this.value ).draw();
                });
            },
            "drawCallback": function(settings) {
                $(".tablefst").removeClass('dataTable');
            }
        });
    </script>
@endsection
