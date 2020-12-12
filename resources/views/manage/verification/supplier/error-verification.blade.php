@extends('layouts.iframe')


@section('styles')
<link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
@endsection

@section('content')
<div class="text-center enter-info">
    <p>Verification Failed, Please try again <span><a href="{{ route('verification.supplier.kyc', ['supplier_id' => $supplierId]) }}">Retry</a></span></p>
</div>
@endsection