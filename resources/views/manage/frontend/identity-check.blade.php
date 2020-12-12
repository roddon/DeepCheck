@extends('layouts.frontend.app')

@section('content')
<!--Header-Area-->
<header class="header-area overlay" id="home-area">
    <div class="vcenter">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="header-text">
                        <h2 class="header-title wow fadeInUp">Onboarding and Identity Check</h2>
                        <div class="wow fadeInUp short-desc" data-wow-delay="0.5s">Do you want to onboard a person to your company. We can help you fulfill the new regulations and it is more or less plug an play in a few hours only. The procedure includes the person's bank account, identity and can include any documents too</div>
                        <div class="top-btn" data-wow-delay="0.7s">
                            <a href="https://play.google.com/store/apps/details?id=id.deepcheck" class="id-img" target="_blank"><img src="{{asset('frontend/images/IDCheck-android.png') }}" /></a> <a href="https://apps.apple.com/us/app/id1527237781" class="id-img" target="_blank"><img src="{{asset('frontend/images/IDCheck-apple.png')}}" /></a>
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
                <div class="wow fadeInUp account-desc" data-wow-delay="0.4s">The Onboarding is a two step identification. Verify your Address and then your identity. In the case of additional documents should be added we can include them. They are then checked for fraud and various anomalies.
                    We only detect peoples identity based on the new biometric documents most governments have approved as official identification documents. If you want to make sure your document is a biometric passport or national ID card you can have a look here <a href="https://en.wikipedia.org/wiki/Biometric_passport" target="_blank">Countries with biometric passports</a>. </div>
            </div>
        </div>
    </div>
</section>
<!-- About Area / -->

<!-- Services Area -->
<section class="section-padding gray-bg identity-slide">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <div class="testimonials">
                    <div class="single-testimonial">
                        <div class="testimonial-text">
                            <div class="slide-image"><img src="{{ asset('frontend/images/map.png') }}" /></div>
                            <div class="slide-text">
                                <h3>Address verification</h3>
                                <h6>Step 01</h6>
                                <p>Click the invitation link and follow the address verification we will guide you to do.</p>
                            </div>
                        </div>
                    </div>
                    <div class="single-testimonial">
                        <div class="testimonial-text">
                            <div class="slide-image"><img src="{{ asset('frontend/images/IDCheckb.png') }}" /></div>
                            <div class="slide-text">
                                <h3>Biometric Verification</h3>
                                <h6>Step 02</h6>
                                <p>Download the app and add your reference number. Scan ID document.</p>
                            </div>
                        </div>
                    </div>

                    <div class="single-testimonial">
                        <div class="testimonial-text">
                            <div class="slide-image"><img src="{{ asset('frontend/images/IDCheck2b.png')}}" /></div>
                            <div class="slide-text">
                                <h3>Take a Selfie</h3>
                                <h6>Step 03</h6>
                                <p>Time to smile. Snap a photo. <br /><b> All Done!</b> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!-- Services Area / -->

<!-- Get Checked Area -->
<!--<section class="section-padding" id="checked-area">
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