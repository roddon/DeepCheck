@extends('layouts.frontend.background-app')

@section('content')
@include('manage.frontend.background')
@include('manage.verification.user.verification-modal')

@endsection


@section('scripts')


<script>
    var sessionId = '';
    var numberVerified = false;

    $('#verifyPhoneNumber').click(function() {
        $('#supplier-verification-error').html('');
        // Turn off phone auth app verification.

        var phoneNumber = $('#phoneNumber').val();
        var pattern = /^\+[0-9-+]+$/;

        if (phoneNumber == null || phoneNumber == '' || !pattern.test(phoneNumber)) {
            $('#supplier-verification-error').html('<span class="alert alert-danger d-block text-center w-100">Please enter valid mobile number</span>');
            return false;
        }

        $('.preloader').fadeIn();
        $('#supplier-verification').modal('hide')




        // reCAPTCHA response.
        firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
            .then(function(confirmationResult) {
                $('.preloader').fadeOut();
                console.log(confirmationResult);
                sessionId = confirmationResult.verificationId;
                $('#contact-number-area').hide();
                $('#otp-area').show();

                $('#supplier-verification').modal({
                    backdrop: 'static',
                    keyboard: false,
                });

            }).catch(function(error) {
                $('.preloader').fadeOut();
                $('#contact-number-area').show();
                $('#otp-area').hide();
                $('#supplier-verification').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
                $('#supplier-verification-error').html('<span class="alert alert-danger d-block text-center w-100">' + error.message + '</span>');
            });
    })


    $('#OTPVerify').click(function() {

        code = $('#OTPCode').val();
        $('#OTPVerify').hide();

        if (code == null || code == '') {
            $('#supplier-verification-error').html('<span class="alert alert-danger d-block text-center w-100">Please enter valid OTP Code.</span>');
            return false;
        }
        $('#supplier-verification').hide();

        $.ajax({
            url: "{{route('verification.user.verify-otp')}}",
            type: 'POST',
            data: {
                code: code,
                verificationId: sessionId,
                user_id: "{{$user->id}}",
                contact_number: $('input[name=contact_number]').val(),
            },
            success: function(result) {
                $('.preloader').fadeOut();
                numberVerified = true;
                window.location.href = "{{ route('home') }}";
            },
            error: function(result) {
                $('.preloader').fadeOut();
                $('#OTPVerify').show();
                $('#supplier-verification-error').html('<span>' + result.message + '</span>');
                $('#supplier-verification').show();
                $('#supplier-verification').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
            },
            beforeSend: function() {
                $('.preloader').fadeIn();
            },
            complete: function() {
                $('.preloader').fadeOut();
            }
        });
    });
</script>

<script>
    $(window).on('load', function() {
        $('#supplier-verification').modal({
            backdrop: 'static',
            keyboard: false,
        });
    });
</script>

@endsection