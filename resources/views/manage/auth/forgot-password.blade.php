@extends('layouts.blank')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
@endsection

@section('content')
<div class="text-center forgot-password">
    <p>{{__('auth.forgot-password-title')}}</p>
</div>
<div class="worry-text">
    <p>Don't worry, we'll send you an email to reset your password</p>
</div>
<form action="{{route('auth.forgot-password.post')}}" method="POST">
    {{csrf_field()}}
    <div class="input-group email-field">
        <input type="text" name="email" class="form-control form-control-sm" placeholder="Your {{__('auth.email')}}" />
        @foreach($errors->get('email') as $error)
        <div class="text-danger font-weight-bold">{{ $error }}</div>
        @endforeach
    </div>
    <div class="reset-password-btn">
        <button class="btn btn-s input-group text-center d-flex align-items-center justify-content-center" type="submit">
            <span class="reset-password-text">{{__('auth.reset-your-password')}}</span>
        </button>
    </div>
</form>
<div class="text-center">
    <p class="dont-remember">Don't remember your email? <a href="#">Contact Support</a></p>
</div>
@endsection