@extends('layouts.frontend.app')

@section('content')
<!--Header-Area-->
<header class="header-area overlay" id="home-area">
    <div class="vcenter">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="header-text">
                        <h2 class="header-title wow fadeInUp">SafePay</h2>
                        <div class="wow fadeInUp short-desc" data-wow-delay="0.5s">A seamless 360 degree integration between your ERP/Accounting system and your bank with top level security checks that reduces the risks of overpayments and losing money. Bank payments are easy but very insecure. Without SafePay you use the bank as a blind payment tool. SafePay creates safety measures and adds an additional layer of verfication before pay out. </br> <b> We use top bank security in SafePay</b></div>
                        <div class="top-btn" data-wow-delay="0.7s">
                        @php
                            $maintenance = config('config.maintenance');
                            $loginLink = '#signupmodal';
                            if($maintenance) {
                                $loginLink = '#maintenanceModal';
                            }
                        @endphp
                            <a href="javascript:void(0);" class="bttn bttn-lg bttn-primary" data-target="{{$loginLink}}" data-toggle="modal">Check Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--Header-Area-/-->


<!-- About Area -->
<section class="section-padding" id="about-area">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="wow fadeInUp account-desc" data-wow-delay="0.4s">SafePay is verifying every step of your internal payment process when you register invoices and suppliers whilst you prepare for pay outs. </div>
            </div>
        </div>
    </div>
</section>
<!-- About Area / -->

<!-- Services Area -->
<section class="section-padding" id="acc-gr-area">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="acc-gr-1">
                <div class="acc-gr-img wow fadeInUp" data-wow-delay="0.5s"><img src="{{asset('frontend/images/dcc-gr-1.png')}}" /></div>
                    <h2 class="acc-gr-title wow fadeInUp">Check The Invoice</h2>
                    <div class="acc-gr-desc wow fadeInUp" data-wow-delay="0.5s">Check the invoice scans the invoice for malware/ransomware, falsification and verifies the supplier. </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="acc-gr-1">
                <div class="acc-gr-img wow fadeInUp" data-wow-delay="0.5s"><img src="{{asset('frontend/images/acc-gr-2.png')}}" /></div>
                    <h2 class="acc-gr-title wow fadeInUp">Internal Fraud check</h2>
                    <div class="acc-gr-desc wow fadeInUp" data-wow-delay="0.5s">It detects any anomalies in your accounts and creates transparency of any fraud attempts internally.</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="acc-gr-1">
                <div class="acc-gr-img wow fadeInUp" data-wow-delay="0.5s"><img src="{{asset('frontend/images/safep-gr-3.png')}}" /></div>
                    <h2 class="acc-gr-title wow fadeInUp">SafePay</h2>
                    <div class="acc-gr-desc wow fadeInUp" data-wow-delay="0.5s">Adds a layer of security on top of your bank system and integrates it with you accounting system preventing you from losing money.</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @php
                $maintenance = config('config.maintenance');
                $loginLink = '#signupmodal';
                if($maintenance) {
                    $loginLink = '#maintenanceModal';
                }
            @endphp
                <div class="standard-button"><a href="javascript:void(0);" data-target="{{$loginLink}}" data-toggle="modal">Try It</a></div>
            </div>
        </div>
    </div>
</section>
<!-- Services Area / -->

<!-- Get Checked Area -->
<!-- <section class="section-padding" id="checked-area">
        <div class="container">
            <div class="row">
			    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="wow fadeInUp get-checked-title" data-wow-delay="0.4s"><h2>Get Checked Now</h2></div>
					<div class="wow fadeInUp checked-desc" data-wow-delay="0.4s">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type</div>
					<div class="wow fadeInUp get-checked-btns" data-wow-delay="0.4s"><a class="btn1" href="#">Get in Touch</a> <a class="btn2" href="#">Download the App</a></div>
                </div>
            </div>
        </div>
    </section>
    <!-- Get Checked Area / -->
@endsection
