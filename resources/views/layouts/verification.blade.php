<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="" />
    <link rel="shortcut icon" href="assets/img/logo-fav.png" />
    <title>Verification | DeepCheck</title>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/fonts/fonts.css')}}" rel="stylesheet">
    @yield('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.responsive.css')}}" type="text/css" />
    <link href="{{url('style.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}" />
</head>

<body class="bodysky">
    <div class="be-wrapper">
        <div class="row">
            <div class="fuelux center-box ">
                <div class="block-wizard center-screen">
                    <div class="wizard wizard-ux onboarding-box" id="wizard0">
                        @yield('content')
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('layouts.scripts')
    @yield('scripts')
</body>

</html>