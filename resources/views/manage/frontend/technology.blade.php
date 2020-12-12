@extends('layouts.frontend.app')

@section('content')
<!--Header-Area-->
<header class="header-area overlay" id="home-area">
    <div class="vcenter">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="header-text">
                        <h2 class="header-title wow fadeInUp">Technology</h2>
                        <div class="wow fadeInUp short-desc" data-wow-delay="0.5s">The technology behind the platform has taken us 5 years to develop to its excellence. Behind the scenes we have Artificial intelligence working in many dimensions. Our KPI's and cashflow analysis is also working the platform. They are the simpler of all analysis we do. </br>Our 8 different AI systems, some patented, and approximately 200 KPIs are making analysis to provide you with a robust and accurate solution. With all analysis we realise is pretty difficult avoid detecting fraud and anomalies which is the correct name to use. </br> <b> </b></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--Header-Area-/-->



<!-- Service 1 Area -->
<section class="section-padding" id="about-area">
    <div class="container">
        <div class="row">
            <div class="hidden-xs col-sm-6">
                <img src="{{asset('frontend/images/display-dummy-3513220_1920.jpg')}}" alt="">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5">
                <div class="page-title">
                    <h2 class="title wow fadeInUp">Artificial Intelligence</h2>
                    <div class="wow fadeInUp" data-wow-delay="0.5s">
                        <p>
                            <p class="small-heading">Our solution is not one AI system. It is In total 8 AI systems detecting falsifications. </p>
                            <p>We do document fraud detection with Deep Learning and Neural Networks and we run all document detection through two paralell systems to make sure it is correctly analysed, facial detection is made by neural networks, internal fraud detection is run through 5 different AI Deep learning tools on the platform to analyse the accounting systems.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Service 1 Area / -->

<!-- Service 2 Area -->
<section class="section-padding" id="about-area">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-5">
                <div class="page-title">
                    <h2 class="title wow fadeInUp">Malware and Ransomware</h2>
                    <div class="wow fadeInUp" data-wow-delay="0.5s">
                        <p>
                            <p class="small-heading">Our system can detect malware and ransomware when you receive documents you want to check and verify if they are correct. We will immediately notify you if the files you have sent to us hold such dangerous scripts and we will also isolate those files immediately from your system.
                            </p>
                    </div>
                </div>

            </div>
            <div class="hidden-xs col-sm-6 col-md-offset-1">
                <img src="{{asset('frontend/images/ransomware-2321110_1920.jpg')}}" alt="Malware and ransomware">
            </div>
        </div>
    </div>
</section>
<!-- Service 2 Area / -->

<!-- Service 3 Area -->
<section class="section-padding" id="about-area">
    <div class="container">
        <div class="row">
            <div class="hidden-xs col-sm-6">
                <img src="{{asset('frontend/images/pexels-markus-spiske-1089438.jpg')}}" alt="">
                <!--<img src="images/pexels-markus-spiske-1089438.jpg" alt="">-->
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5">
                <div class="page-title">
                    <h2 class="title wow fadeInUp">Encryption</h2>
                    <div class="wow fadeInUp" data-wow-delay="0.5s">
                        <p>
                            <p class="small-heading">The data on our platform is encrypted all through to protect our customers' data. It is so safe that we can not look at the data without you logging us in to your account.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Service 3 Area / -->


<!-- Service 2 Area -->
<section class="section-padding" id="about-area">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-5">
                <div class="page-title">
                    <h2 class="title wow fadeInUp">Security</h2>
                    <div class="wow fadeInUp" data-wow-delay="0.5s">
                        <p>
                            <p class="small-heading">All communication is encrypted to and from our servers, but also to apps, local software and of course any communication with your bank.
                            </p>
                    </div>
                </div>

            </div>
            <div class="hidden-xs col-sm-6 col-md-offset-1">
                <img src="{{asset('frontend/images/cyber-security-3374252_1920.jpg')}}" alt="Malware and ransomware">
            </div>
        </div>
    </div>
</section>
<!-- Service 2 Area / -->

@endsection