@extends('layouts.app-2')

@section('content')
<div class="page-content-wrapper">
    <div class="row" style="vertical-align: middle;">
        <div class="modal modal-dialog enterprise-modal" style="vertical-align: middle;">
            <div class="modal-content">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="assets/media/icons/close.svg">
                </button> -->
                <div class="card-logo mt-3 mb-3 text-center">
                    <img src="assets/media/Deepcheck-Logo.svg">
                </div>
                <div class="ln enterprise-line"></div>
                <div class="" style="padding: 0px 20px">
                    <p>Thank you for showing interest in our Enterprise solution.</p>
                    <p>Please contact our team via <a href="mailto:support@deepcheck.one" class="support">support@deepcheck.one</a> and we will assist you..</p>
                </div>
                <!-- <div style="padding: 20px 0px" class="text-center">
                    <button type="button" class="btn btn-lg-primary">Close</button>
                </div> -->

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // $(window).on('load', function() {
    //     $('#enterprise-modal').modal({
    //         backdrop: 'static',
    //         keyboard: false,
    //     });
    // });
</script>
@endsection