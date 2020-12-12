@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-xs-12 col-md-6 col-md-offset-3">
    <form action="{{ route('auth.login') }}" class="form-signin" method="POST">
          {{ csrf_field() }}
          <h1 class="h3 mb-3 font-weight-normal">{{__('auth.change-password-title')}}</h1>

          <div class="form-group">
              <label for="password">{{__('auth.password')}}</label>
              <input type="password" name="password" class="form-control" placeholder="{{__('auth.password')}}"/>
          </div>

          <div class="form-group">
            <label for="confirm_password">{{__('auth.confirm_password')}}</label>
            <input type="confirm_password" name="confirm_password" class="form-control" placeholder="{{__('auth.confirm_password')}}"/>
        </div>

          <div class="form-group">
              <button class="btn btn-primary">{{__('auth.change_password')}}</button>
          </div>
      </form>

    </div>
  </div>
@endsection
