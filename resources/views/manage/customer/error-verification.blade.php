@extends('layouts.iframe')


@section('styles')
<link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
@endsection

@section('content')
<div class="text-center enter-info">
    <p>Verification Failed, Please try again <span><a href="{{ route('kyc-verification', ['customer_id' => $customerId]) }}">retry</a></span></p>
</div>
@endsection