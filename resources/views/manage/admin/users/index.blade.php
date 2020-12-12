@extends('layouts.admin.app')


@section('content')

<div class="row mb-2">
    <div class="col-md-6">
        <div class="top_title">Members List</div>
    </div>
    <div class="col-md-6 text-right">

        <div class="invitebtnarae ml-3 float-right">
            <a href="{{ route('admin.users.create') }}" class="invite" id="add-new-user">Add new user</a>
        </div>

        <div class="tblesrch float-right">
            <input class="form-control" id="myInput" type="text" placeholder="Search..">
        </div>
    </div>
</div>

<div class="dash_section_3 m-3 h-95">
    <div class="row position-relative h-95">
        <!-- <div class="tblesrch"> <input class="form-control" id="myInput" type="text" placeholder="Search.."></div> -->
        <div class="table-responsive position-relative">
            <table class="table tablefst  table-hover ">
                <thead>
                    <tr>
                        <th class="border-right-0">Name</th>
                        <th class="text-center border-right-0">User Type</th>
                        <th class="text-center border-right-0">Email</th>
                        <th class="text-center border-right-0">Contact Number</th>
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
        "targets": 'no-sort',
        "bSort": false,
        "order": [],
        ajax: {
            url: '{{ route("admin.users.index") }}',
        },
        "columns": [{
                name: "name",
                data: "name",
                className: 'micro'
            },
            {
                name: "role",
                data: "role",
                className: 'text-center'
            },
            {
                name: "email",
                data: "email",
                className: 'text-center'
            },
            {
                name: "contact_number",
                data: "contact_number",
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
