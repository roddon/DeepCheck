<script>
    var datatable = $(".tablefst").DataTable({

        ajax: {
            url: '{{ route("admin.subscription_plans.index") }}',
        },
        "columns": [{
                name: "{{__('suscription_plans.name')}}",
                data: "name",
                className: 'micro'
            },
            {
                name: "description",
                data: "description",
                className: 'text-center'
            },
            {
                name: "trial_days",
                data: "trial_days",
                className: 'text-center'
            },
            {
                name: "trial_days_doc_numbers",
                data: "trial_days_doc_numbers",
                className: 'text-center'
            },
            // {
            //     name: "include_check_invoice",
            //     data: "include_check_invoice",
            //     className: 'text-center'
            // },
            // {
            //     name: "include_supplier_check",
            //     data: "include_supplier_check",
            //     className: 'text-center'
            // },
            // {
            //     name: "include_safe_payout",
            //     data: "include_safe_payout",
            //     className: 'text-center'
            // },
            // {
            //     name: "include_detector_records",
            //     data: "include_detector_records",
            //     className: 'text-center'
            // },
            // {
            //     name: "include_onboarding",
            //     data: "include_onboarding",
            //     className: 'text-center'
            // },
            {
                name: "{{__('common.action')}}",
                data: "action",
                className: 'text-center',
                width:"10%"
            },
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

<script type="text/javascript">
    $(document).ready(function() {
        var x = $('.list_wrapper .row').length; //Initial field counter
        
            //Once add button is clicked
        $('.list_add_button').click(function() {            
            x++; //Increment field counter
            var list_fieldHTML = '<div class="row"><div class="col-xs-6 col-sm-6 col-md-6"><div class="form-group"><input name="planRecords['+x+']['+'no_of_records_count'+']" type="text" placeholder="Allow no of count" class="form-control"/></div></div><div class="col-xs-5 col-sm-5 col-md-5"><div class="form-group"><input name="planRecords['+x+']['+'price'+']" type="text" placeholder="Price" class="form-control"/></div></div><div class="col-xs-1 col-sm-7 col-md-1"><a href="javascript:void(0);" class="list_remove_button btn btn-danger">-</a></div></div>'; //New input field html 
            $('.list_wrapper').append(list_fieldHTML); //Add field html
        });
        
        //Once remove button is clicked
        $('.list_wrapper').on('click', '.list_remove_button', function() {
            $(this).closest('div.row').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>