@extends('layouts.admin.app')


@section('content')
<div class="top_title">Create New User</div>
<div class="row mt-5">
    <div class="col-lg-6">
        <form action="{{route('admin.members.store')}}" method="POST" class="mnlform">
            @CSRF
            <div class="frmbx">
                <label>Name</label>
                <input type="text" name="name" value="{{old('name')}}">

            </div>
            <div class="frmbx">
                <label>Email</label>
                <input type="text" name="email" value="{{old('email')}}">

            </div>
            <div class=" frmbx">
                <label>Contact Number</label>
                <input type="text" name="contact_number" value="{{old('contact_number')}}">

            </div>
            <div class="frmbx">
                <label>Password</label>
                <input type="password" name="password">


            </div>
            <div class="frmbx">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation">

            </div>
            <div class=" text-center mt-162">
                <input type="submit" value="Submit" class="invite">
            </div>
        </form>
    </div>
    @endsection