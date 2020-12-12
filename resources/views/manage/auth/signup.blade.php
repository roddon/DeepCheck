@extends('layouts.blank')


@section('styles')
<link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
@endsection

@section('content')


<form action="{{ route('auth.store') }}" class="form-signin" method="POST">
    {{ csrf_field() }}
    <div class="text-center enter-info">
        <p>{{__('auth.signup-title')}}</p>
    </div>

    <div class="text-center sign-up">
        <p>Sign Up</p>
    </div>

    <div class="input-group username-field">

        <input type="name" name="name" class="form-control form-control-sm" placeholder="{{__('auth.name')}}" value="{{old('name')}}" />
        @foreach($errors->get('name') as $error)
        <div class="text-danger font-weight-bold">{{ $error }}</div>
        @endforeach
    </div>

    <div class="input-group username-field">

        <input type="email" name="email" class="form-control form-control-sm" placeholder="{{__('auth.email')}}" value="{{old('email')}}" />
        @foreach($errors->get('email') as $error)
        <div class="text-danger font-weight-bold">{{ $error }}</div>
        @endforeach

        @foreach($errors->get('error') as $error)
        <div class="text-danger font-weight-bold">{{ $error }}</div>
        @endforeach
    </div>

    <div class="input-group username-field">

        <input type="password" name="password" class="form-control form-control-sm sign-password" placeholder="{{__('auth.password')}}" />
        <input type="password" name="password_confirmation" class="form-control form-control-sm sign-confirm" placeholder="Confirm">

        @foreach($errors->get('password') as $error)
        <div class="text-danger font-weight-bold">{{ $error }}</div>
        @endforeach
        @foreach($errors->get('password_confirmation') as $error)
        <div class="text-danger font-weight-bold">{{ $error }}</div>
        @endforeach
    </div>



    <div class="sign-up-btn">
        <button class="btn btn-s text-center input-group">{{__('auth.signup')}}</button>
    </div>

    <div class="text-center sign-up-or">

    </div>
</form>

@endsection