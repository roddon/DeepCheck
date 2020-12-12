<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.admin.header')
</head>

<body>
    @include('layouts.admin.top')
    <div id="overlay" style="display:none;">
        <div class="spinner"></div>
        <br />
        Loading...
    </div>
    <div class="small_nav"></div>
    <div class="clearfix"></div>
    <div class="dashboard_container">
        @include('layouts.admin.sidebar')
        <div class="dash_main">
            <div class="dash_main_container">
                @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
                @endif

                @if(isset($errors) && $errors->count())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                    {{ $error }} <br />
                    @endforeach
                </div>
                @endif

                @if(Session::has('status'))
                <div class="alert alert-warning">
                    {{ Session::get('status') }}
                </div>
                @endif
                @yield('content')
            </div>
        </div>
        @include('layouts.admin.scripts')

        @yield('scripts')
</body>

</html>
