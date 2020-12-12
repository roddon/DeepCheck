@extends('layouts.frontend.background-app')

@section('content')
@include('manage.frontend.background')
@include('manage.customer.start-verification-modal')
@include('manage.customer.document-upload-modal')
{{-- @include('manage.customer.kyc-verification-modal') --}}
{{-- @include('manage.customer.bank-statement-verification-modal') --}}
@include('manage.customer.download-app-modal')
@include('manage.customer.finish-modal')



@endsection


@section('scripts')


<script>
    var sessionId = '';

    $('#verifyPhoneNumber').click(function() {
        $('#phoneVerificationStatus').html('');
        // Turn off phone auth app verification.

        var phoneNumber = $('#phoneNumber').val();
        var pattern = /^\+[0-9-+]+$/;

        if (phoneNumber == null || phoneNumber == '' || !pattern.test(phoneNumber)) {
            $('#phoneVerificationStatus').html('<span class="alert alert-danger w-100 d-block text-center">Please enter valid mobile number</span>');
            return false;
        }

        $('.preloader').fadeIn();
        $('#start-customer-verification').modal('hide')

        // reCAPTCHA response.
        firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
            .then(function(confirmationResult) {
                $('.preloader').fadeOut();
                console.log(confirmationResult);
                sessionId = confirmationResult.verificationId;
                $('#verification-area').hide();
                $('#otp-area').show();
                $('#otp-text').html('Please see reference code on your mobile and add it in the below field');

                $('#start-customer-verification').modal({
                    backdrop: 'static',
                    keyboard: false,
                });

            }).catch(function(error) {
                $('.preloader').fadeOut();
                $('#start-customer-verification').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
                console.log(error.message);
                $('#phoneVerificationStatus').html('<span class="alert alert-danger w-100 d-block text-center">' + error.message + '</span>');
            });
    })


    $('#OTPVerify').click(function() {
        code = $('#OTPCode').val();
        $('#OTPVerify').hide();

        if (code == null || code == '') {
            $('#phoneVerificationStatus').html('<span class="alert alert-danger w-100 d-block text-center">Please enter valid OTP Code.</span>');
            return false;
        }


        $.ajax({
            url: "{{route('onboarding.verify-phone-number')}}",
            type: 'POST',
            data: {
                code: code,
                verificationId: sessionId,
                customerId: "{{$customer->id}}"
            },
            success: function(result) {
                $('.preloader').fadeOut();
                $('#start-customer-verification').modal('hide')
                $('#customer-verification').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
            },
            error: function(result) {
                $('.preloader').fadeOut();
                $('#OTPVerify').show();
                $('#phoneVerificationStatus').html(result.message);
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

@include('manage.customer.scripts')

@endsection
