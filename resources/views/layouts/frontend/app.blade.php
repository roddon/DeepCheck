<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="author" content="{{ isset($siteSeo['author']) ? $siteSeo['author'] : 'Deepcheck'}}">
    <meta name="description" content="{{ isset($siteSeo['description']) ? $siteSeo['description'] : 'Is that invoice safe to pay? Is it falsified? Is the account number really to the supplier or will you lose money? We can help you detecting this and we also prevent suppliers that are not approved getting paid.' }}
    ">
    <meta name="keywords" content="{{ isset($siteSeo['keywords']) ? $siteSeo['keywords'] : 'safe payment, check invoice, safe pay, check an invoice, document fraud, invoice fraud, supplier verification, safe payments, false invoice, malware, ransomware' }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title> {{ isset($siteSeo['title']) ? $siteSeo['title'] : 'SafePay, Check Invoice and fraud detection' }} | Deepcheck</title>
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
    <link rel="stylesheet" href="{{asset('frontend/login.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/responsive.css')}}">
    <script src="{{asset('frontend/js/vendor/modernizr-2.8.3.min.js')}}"></script>

    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9RPGNNVMND"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-9RPGNNVMND');
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PLVQ5JN');
    </script>
    <!-- End Google Tag Manager -->



</head>

<body data-spy="scroll" data-target=".mainmenu-area" class="{{ isset($bodyClass) ? $bodyClass : 'home-page' }}">

    @include('layouts/frontend/topbar')

    @yield('content')

    @include('layouts/frontend/footer')
    @include('layouts/frontend/modals')

    @include('layouts/frontend/scripts')
    @yield('scripts')

</body>
<script>
    (function(w,d,t,u,n,a,m){w['MauticTrackingObject']=n;
        w[n]=w[n]||function(){(w[n].q=w[n].q||[]).push(arguments)},a=d.createElement(t),
        m=d.getElementsByTagName(t)[0];a.async=1;a.src=u;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://mtc.safepay.to/mtc.js','mt');

    mt('send', 'pageview');
</script>
</html>
