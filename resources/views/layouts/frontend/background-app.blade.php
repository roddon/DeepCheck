<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="author" content="DeepCheck">
    <meta name="description" content="Is that invoice safe to pay? Is it falsified? Is the account number really to the supplier or will you lose money? We can help you detecting this and we also prevent suppliers that are not approved getting paid.">
    <meta name="keywords" content="safe payment, check invoice, safe pay, check an invoice, document fraud, invoice fraud, supplier verification, safe payments, false invoice, malware, ransomware">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title> {{ isset($title) ? $title : 'SafePay, Check Invoice and fraud detection' }} | Deepcheck</title>
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" href="{{asset('frontend/images/apple-touch-icon.png')}}">
    <link rel="shortcut icon" type="image/ico" href="{{asset('frontend/images/favicon.ico')}}" />
    <!-- Plugin-CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/icofont.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/login.css')}}">
    <!-- Main-Stylesheets -->
    <link rel="stylesheet" href="{{asset('frontend/css/normalize.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/style.css')}}">

    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/login.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/responsive.css')}}">
    <script src="{{asset('frontend/js/vendor/modernizr-2.8.3.min.js')}}"></script>

</head>

<body data-spy="scroll" data-target=".mainmenu-area" class="{{ isset($bodyClass) ? $bodyClass : 'home-page' }}">

    @include('layouts/frontend/topbar')

    @yield('content')

    @include('layouts/frontend/footer')

    @include('layouts/frontend/scripts')
    @yield('scripts')

</body>

</html>