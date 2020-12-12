@extends('layouts.frontend.app')

@section('content')
<!--Header-Area-->
<header class="header-area overlay" id="home-area">
    <div class="vcenter">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="header-text">
                        <h2 class="header-title wow fadeInUp">Check Invoice and Supplier</h2>
                        <div class="wow fadeInUp short-desc" data-wow-delay="0.5s">Have you ever wondered if the document you have in your hand is falsified? </br>Do not worry. We can see it. Just upload the document to us and you quickly understand if it is viable. It does not matter if it is an invoice or a document. We will also verify the supplier information is correct. </br> <b>We detect it all.</b> </div>
                        <div class="top-btn" data-wow-delay="0.7s">
                        @php
                            $maintenance = config('config.maintenance');
                            $checkInvoiceNow = '#selectInvoiceModal';
                            if($maintenance) {
                                $checkInvoiceNow = '#maintenanceModal';
                            }
                        @endphp
                            <a href="javascript:void(0)" class="bttn bttn-lg bttn-primary" data-target="{{$checkInvoiceNow}}" data-toggle="modal">Check Now</a>
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
                <div class="wow fadeInUp account-desc" data-wow-delay="0.4s">We have the latest technology and deep learning algorithms to detect any falsified areas in the document and the supplier. </div>
            </div>
        </div>
    </div>
</section>
<!-- About Area / -->

<!-- Services Area -->
<section class="section-padding" id="acc-gr-area">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-6">
                <div class="acc-gr-1">
                    <div class="acc-gr-img wow fadeInUp" data-wow-delay="0.5s"><img src="{{asset('frontend/images/dcc-gr-1.png')}}" /></div>
                    <h2 class="acc-gr-title wow fadeInUp">Upload the file</h2>
                    <div class="acc-gr-desc wow fadeInUp" data-wow-delay="0.5s">You can upload a PDF file or any image file to our system and it will quickly find if the document is falsified or not.</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="acc-gr-1">
                    <div class="acc-gr-img wow fadeInUp" data-wow-delay="0.5s"><img src="{{asset('frontend/images/dcc-gr-2.png')}}" /></div>
                    <h2 class="acc-gr-title wow fadeInUp">Supplier verification</h2>
                    <div class="acc-gr-desc wow fadeInUp" data-wow-delay="0.5s">The invoice can be correct but the supplier may have been kidnapped and wrong recipient information is used which means you will lose big money. We prevent that too. </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @php
                $maintenance = config('config.maintenance');
                $checkInvoiceNow = '#selectInvoiceModal';
                if($maintenance) {
                    $checkInvoiceNow = '#maintenanceModal';
                }
            @endphp
                <div class="standard-button"><a href="javascript:void(0);" data-target="{{$checkInvoiceNow}}" data-toggle="modal">Try It</a></div>
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