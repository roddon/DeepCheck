 <meta charset="utf-8">
 <!-- <meta name="google-site-verification" content="8j7kZ44d3NAA96kcBF8YqHl0pIzVohdvsC7Mul4P4sw" /> -->
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <meta name="description" content="">
 <meta name="author" content="">
 <link rel="icon" href="{{asset('favicon.ico')}}">
 <title>{{ __('common.app_name') }}</title>
 <!-- Bootstrap core CSS -->
 <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
 <link href="{{asset('assets/fonts/fonts.css')}}" rel="stylesheet">
 <!-- <link href="{{asset('assets/dropify/dist/css/dropify.min.css')}}" rel="stylesheet"> -->


 <link rel='stylesheet' href='https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css'>
 <link rel='stylesheet' href='https://cdn.datatables.net/responsive/1.0.4/css/dataTables.responsive.css'>
 <!-- Custom styles for this template -->
 <link href="{{ asset('style.css') }}" rel="stylesheet">

 <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
 <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet">


 @yield('styles')
 <style>
     table.dataTable thead th {

         word-wrap: break-word !important;
         overflow-wrap: break-word !important;
         white-space: normal;
     }

     table.dataTable tbody td {
         max-width: 50px !important;
         word-wrap: break-word !important;
         overflow-wrap: break-word !important;
         white-space: normal;
     }
 </style>
 <style>
     .dash_section_3 .table tbody td p.success {
         color: #12C171
     }

     .dash_section_3 .table tbody td p.failed {
         color: #E47266
     }

     .dash_section_3 .table tbody td a.micro {
         font-size: 16px;
         color: #1A5596;
         line-height: 20px;
     }

     .dash_section_3 .table tbody td p.micro {
         font-size: 18px;
         color: #1A5596;
     }

     .dash_section_3 .table tbody td p.micro img {
         margin: 0 15px 0 0
     }

     .user-management-img {
         width: 150px;
     }

     #overlay {
         background: #ffffff;
         color: #666666;
         position: fixed;
         height: 100%;
         width: 100%;
         z-index: 5000;
         top: 0;
         left: 0;
         float: left;
         text-align: center;
         padding-top: 25%;
         opacity: .80;
     }


     .spinner {
         margin: 0 auto;
         height: 64px;
         width: 64px;
         animation: rotate 0.8s infinite linear;
         border: 5px solid firebrick;
         border-right-color: transparent;
         border-radius: 50%;
     }

     @keyframes rotate {
         0% {
             transform: rotate(0deg);
         }

         100% {
             transform: rotate(360deg);
         }
     }
 </style>