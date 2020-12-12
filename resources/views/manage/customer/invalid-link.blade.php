@extends('layouts.frontend.app')

@section('content')
@include('manage.frontend.background')

<div class="modal fade common-modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="invalidLinkModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Login</h4>
            </div>
            <div class="modal-body">
                <div class="fuelux center-box">
                    <div class="block-wizard center-screen">
                        <div class="wizard wizard-ux onboarding-box" id="wizard0">
                            <div class="text-center logo newlogo">
                                <img src="{{asset('frontend/images/loginlogo.svg')}}" alt="logo">
                            </div>
                            <div class="text-center enter-info">
                                <p>Invalid Link</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-center copy-right">@2020 DEEPCHECK</p>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection


@section('scripts')

<script>
    $(window).on('load', function() {
        $('#invalidLinkModal').modal();
    })
</script>

@endsection