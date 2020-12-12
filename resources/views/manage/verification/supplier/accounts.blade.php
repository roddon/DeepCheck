@extends('layouts.iframe')


@section('styles')
<link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
@endsection

@section('content')

<div class="enter-info" id="account-area">
    <h3>Select your account </h3>
    <div class="ln"></div>
    <div>
        <ul class="nav flex-column">
            @foreach($tinkAccountList as $key => $account)
            <li class='nav-item'>
                <input type="radio" name="supplierAccountList" value="{{ $key }}" id="radio">

                @php
                    $accountNumber = '';
                    foreach($account->accountIdentifications as $accountIdentifications){
                        if($accountIdentifications->type = 'ACCOUNT_NUMBER'){
                            $accountNumber = $accountIdentifications->identification;
                        }
                    }
                @endphp

                {{ $accountNumber }}
            </li>

            @endforeach
        </ul>
    </div>
</div>
<div class="text-center enter-info" id="account-success-area" style="display: none;">
    <p>Thank you for verification</p>
</div>
<div class="text-center enter-info" id="account-error-area" style="display: none;">
    <p>Verification Failed, Please try again. <span><a href="{{ route('verification.supplier.kyc', ['supplier_id' => $supplierId]) }}">Retry</a></span></p>
</div>
@endsection


@section('scripts')


<script>
    $('input[name=supplierAccountList]').click(function() {
        accountId = $(this).val()

        $.ajax({
            url: "{{route('verification.supplier.add-account')}}",
            type: 'POST',
            data: {
                account_id: accountId,
            },
            success: function(result) {
                $('.preloader').fadeOut();
                $('#account-area').html(result)
            },
            error: function(result) {
                $('.preloader').fadeOut();

            },
            beforeSend: function() {
                $('.preloader').fadeIn();
            },
            complete: function() {
                $('.preloader').fadeOut();
            }
        });
    })

    $(document).on('click', 'input[name=address]', function(){
        addressId = $(this).val();
        $('#account-area').hide();
        $.ajax({
            url: "{{route('verification.supplier.add-address')}}",
            type: 'POST',
            data: {
                addressId: addressId,
            },
            success: function(result) {
                $('.preloader').fadeOut();
                $('#account-success-area').show()
            },
            error: function(result) {
                $('.preloader').fadeOut();
                $('#account-error-area').show()
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
@endsection
