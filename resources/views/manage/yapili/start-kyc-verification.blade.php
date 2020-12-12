@extends('layouts.iframe')


@section('styles')
<link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
@endsection

@section('content')

<div id="account-area">

    <div id="dvInstitutions" class="mt-4">

    </div>
</div>


@endsection


@section('scripts')


<script>
    $(window).on('load', function() {
        $.ajax({
            url: "{{route('verification.institution-list')}}",
            type: 'GET',

            success: function(result) {
                $('#overlay').fadeOut();
                $('#dvInstitutions').html(result)
            },
            error: function(result) {
                $('#overlay').fadeOut();
                $('#account-error-area').show();
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });
    });

    $(document).on('click', 'a[name^=aInstitution]', function(){
        $.ajax({
            url: "{{route('verification.account-auth-request')}}",
            type: 'POST',
            data: {
                institutionId: $(this).attr('institution_id')
            },
            success: function(result) {
                $('#overlay').fadeOut();
                window.location.href = result.auth_uri;
            },
            error: function(result) {
                $('#overlay').fadeOut();

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
