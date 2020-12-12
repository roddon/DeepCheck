@extends('layouts.frontend.app')

@section('content')
<!--Header-Area-->
<header class="header-area overlay" id="home-area">
    <div class="vcenter">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="header-text">
                        <h2 class="header-title wow fadeInUp">Internal Fraud Check</h2>
                        <div class="wow fadeInUp short-desc" data-wow-delay="0.5s"> <b>30%-50%</b> of all fraud is internal. How do you protect yourself? </br> Connect your company accounts and check for any anomalies. Immediately we can find internal fraud in invoices and expenses. We also audit and detect anomalies in companies house reports</div>
                        <div class="top-btn">
                        @php
                            $maintenance = config('config.maintenance');
                            $loginLink = '#signupmodal';
                            if($maintenance) {
                                $loginLink = '#maintenanceModal';
                            }
                        @endphp
                            <a href="javascript:void(0)" class="bttn bttn-lg bttn-primary" data-target="{{$loginLink}}" data-toggle="modal">Check Now</a>
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
                <div class="wow fadeInUp account-desc" data-wow-delay="0.4s">
                    <p style="text-align:left; padding 50px">It is very easy to do our checks. </br> 1. Login to your deepcheck accounts </br> 2. Click and sync using your accounting system </br> 3. Review the results.
                </div>
            </div>
        </div>
    </div>
</section>
<p style="text-align:center;">
    <!-- About Area / -->

    <!-- Services Area -->
    <section class="section-padding" id="acc-gr-area">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-6">
                    <div class="acc-gr-1">
                        <div class="acc-gr-img wow fadeInUp" data-wow-delay="0.5s"><img src="{{asset('frontend/images/acc-gr-2.png')}}" /></div>
                        <h2 class="acc-gr-title wow fadeInUp">Internal Fraud Check</h2>
                        <div class="acc-gr-desc wow fadeInUp" data-wow-delay="0.5s">You will see the company internal status in the dashboard.</div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="acc-gr-1">
                        <div class="acc-gr-img wow fadeInUp" data-wow-delay="0.5s"><img src="{{asset('frontend/images/acc-gr-3.png')}}" /></div>
                        <h2 class="acc-gr-title wow fadeInUp">Financial Check</h2>
                        <div class="acc-gr-desc wow fadeInUp" data-wow-delay="0.5s">You will gain current financial insight into your company cashflow and profit and loss</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="standard-button"><a href="javascript:void(0);" data-target="{{$loginLink}}" data-toggle="modal">Try It</a></div>
                </div>
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