<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/js/popper.min.js')}}"></script>
<script src="https://kit.fontawesome.com/7972fb5649.js" crossorigin="anonymous"></script>

<script type="text/javascript" src="{{ asset('assets/fusioncharts/fusioncharts.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/fusioncharts/themes/fusioncharts.theme.zune.js?cacheBust=56')}}"></script>
<script type="text/javascript" src="{{ asset('assets/fusioncharts/fusioncharts.jqueryplugin.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/data.js')}}"></script>
<script src='https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js'></script>
<script src='https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js'></script>
<!-- <script src="{{ asset('assets/dropify/dist/js/dropify.min.js')}} "></script> -->
<script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script type="text/javascript" src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function onload() {
        $('#overlay').fadeIn();
    }
</script>