@extends('layouts.blank')


@section('styles')
<link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
@endsection

@section('content')
<form action="{{ route('admin.login.post') }}" class="form-signin" method="POST">
    {{ csrf_field() }}

    <div class="text-center enter-info">
        <p>{{__('auth.login-title')}}</p>
    </div>

    <div class="input-group password-field">
        <input type="email" name="email" class="form-control form-control-sm" placeholder="{{__('auth.email')}}" value="{{old('email')}}" />
        @foreach($errors->get('email') as $error)
        <div class="text-danger font-weight-bold">{{ $error }}</div>
        @endforeach
    </div>

    <div class="input-group password-field">
        <input type="password" name="password" class="form-control form-control-sm" placeholder="{{__('auth.password')}}" />
    </div>



    <div class="login-btn custom-control custom-control-sm custom-checkbox remember-checkbox">
        <input class="custom-control-input remember-me-checkbox" type="checkbox" id="check2" />
        <label class="custom-control-label remember-me" for="check2">
            {{__('auth.remember-me') }}</label>
        <button class="btn btn-s text-center sign-in-btn" type="submit">
            {{__('auth.login') }}
        </button>
    </div>
</form>
@endsection