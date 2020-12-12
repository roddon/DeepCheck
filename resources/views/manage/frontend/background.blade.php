<!--Header-Area-->
<header class="header-area overlay" id="home-area">
    <video id="bgVideo" width="100%" height="auto" playsinline autoplay muted>
        <!-- Video is embedded in the WEBM format -->
        <source src="{{asset('frontend/images/combined_videos.mp4')}}" type="video/mp4">
    </video>
    <div class="vcenter">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-md-8">
                    <div class="header-text">
                        <h2 class="header-title wow fadeInUp"><a href="{{ route('safe-pay') }}" style="color:#000000;">SafePay</a><br /> <a href="{{route('document-check')}}" style="color:#000000;">Check Invoice</a><sup>FREE</sup><br /><a href="{{route('account-check')}}" style="color:#000000;">Internal Fraud Check</a><br /> <a href="{{route('identity-check')}}" style="color:#000000;">Onboarding/AML/KYC</a></h2>
                        <!-- <div class="wow fadeInUp" data-wow-delay="0.5s"><q>We Mak Sure Best Business Solution For Our Client</q></div> -->
                        <div class="top-btn" data-wow-delay="0.7s">
                        @php
                            $maintenance = config('config.maintenance');
                            $checkInvoiceNow = '#selectInvoiceModal';
                            if($maintenance) {
                                $checkInvoiceNow = '#maintenanceModal';
                            }
                        @endphp
                            <a href="javascript:void(0)" class="bttn bttn-lg bttn-primary" data-target="{{$checkInvoiceNow}}" data-toggle="modal">Check Invoice Now</a>
                        </div>
                        <p>We stop payment fraud and losses automatically in real time for anyone</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--Header-Area-/-->

<!-- Service 1 Area -->
<section class="section-padding yellow-bg" id="about-area">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="page-title">
                    <h2 class="title wow fadeInUp">Do not be one of the victims!</h2>
                    <div class="wow fadeInUp" data-wow-delay="0.5s">
                        <p class="small-heading nomargin">Big like small, companies like people are suffering from fraud across the world.</p>
                        <br />
                    </div>
                    <div class="testimonials3">

                        <div class="single-testimonial ">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="slider_counter_cn">
                                        <div class="counter number"><span class="count-num">5</span>%</div>

                                        <div class="counter_text">
                                            <p>on average of a company revenue is lost to fraudulent payments</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="slider_counter_cn">
                                        <div class="counter number">$<span class="count-num">200</span>B</div>
                                        <div class="counter_text">
                                            <p>losses in the UK to invoice fraud annually and it is <strong>increasing.</strong> It is increasing more than card fraud.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="slider_counter_cn">
                                        <div class="counter number">$<span class="count-num">65000</span></div>
                                        <div class="counter_text">
                                            <p>is the annual loss per company on average</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="single-testimonial ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="gl_img"><img src="images/gl_lg_1.png" alt=""></div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="counter">$123 million</div>
                                        <div class="counter_text"><p>Facebook and Google lost a considerable amount towards false invoices in 2013-2015. The fraudster was an Estonian man that stole a reputable IT hardware firm’s name and falsified the invoices.</p></div>
                                    </div>
                                </div>
                            </div>

                            <div class="single-testimonial">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="gl_img"><img src="images/gl_lg_2.png" alt=""></div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="counter">€2 million</div>
                                        <div class="counter_text"><p>Worldproteins’ paid out to a long standing supplier and the reminder later was sent by a fraudster to which the payment was made. The Payment was made against a reminder sent by a fraudster that was not verified. </p></div>
                                    </div>
                                </div>
                            </div>

                            <div class="single-testimonial bg_heighlights">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="slider_counter_cn">
                                            <div class="counter number"><span class="timer"></span>%</div>
                                            <div class="counter_text">
                                                <p>on average of a company revenue is lost to fraudulent payments</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="slider_counter_cn">
                                            <div class="counter number">$<span class="timer2"></span>B</div>
                                            <div class="counter_text">
                                                <p>losses in the UK to fraud annually and it is <strong>increasing</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="slider_counter_cn">
                                            <div class="counter number">$<span class="timer3"></span>k</div>
                                            <div class="counter_text">
                                                <p>n average loss per company.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="single-testimonial ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="gl_img"><img src="images/gl_lg_3.png" alt=""></div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="counter">£10,000 to £1million</div>
                                        <div class="counter_text"><p>A number of galleries have been affected. The sums lost by them or their clients range from £10,000 to £1m,” says the insurance broker Adam Prideaux of Hallett Independent. “I suspect the problem is a lot worse than we imagine.”</p></div>
                                    </div>
                                </div>
                            </div>

                            <div class="single-testimonial">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="gl_img"><img src="images/gl_lg_4.png" alt=""></div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="counter">£1million</div>
                                        <div class="counter_text"><p>A former council employee from Manchester, who pretended to carry out building works for the local authority in a £1m fake invoicing fraud</p></div>
                                    </div>
                                </div>
                            </div>
 -->


                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>
<!-- Service 1 Area / -->
<!-- Service 1 Area -->
<section class="section-padding" id="about-area">
    <div class="container">
        <div class="row">
            <div class="hidden-xs col-sm-6">
                <img src="{{asset('frontend/images/account_check.png')}}" alt="">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5">
                <div class="page-title">
                    <h2 class="title wow fadeInUp">SafePay</h2>
                    <div class="wow fadeInUp" data-wow-delay="0.5s">
                        <p>
                            <p class="small-heading">We protect you. Our SafePay solution is unique. </p>
                            <p>If you have an ERP system, local accounting system or a smaller on line accounting system we have the solution for you. We can protect you from losing money on payments to bank accounts that are going to fraudsters. If you have your accounts in smaller accounting packages you can use our system. If you need a bigger solution to be fully integrated with your ERP system we can help you.</p>
                    </div>
                </div>
                <div class="wow fadeInUp" data-wow-delay="0.7s">
                @php
                    $maintenance = config('config.maintenance');
                    $loginLink = '#signupmodal';
                    if($maintenance) {
                        $loginLink = '#maintenanceModal';
                    }
                @endphp
                    <a href="javascript:void(0);" data-target="{{$loginLink}}" data-toggle="modal" class="bttn bttn-primary">SafePay Now</a>
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
                    <h2 class="title wow fadeInUp">Check invoice</h2>
                    <div class="wow fadeInUp" data-wow-delay="0.5s">
                        <p>
                            <p class="small-heading">Stop the the problems early. We detect false invoices with AI and we check the supplier too. </p>
                            <p> Do you know how to detect a false invoice? There are about 50 different areas you must detect in a one page invoice that can be fraud. Some you can not even see. And it is getting worse but you are not alone. <br> Facebook and Google lost $123 million in false invoices in 2019. Councils lose millions and companies are losing in general 5% of their expenses on frauduluent expenses.</br> <b>Our solution removes your losses immediately! </b>
                            </p>
                    </div>
                </div>
                <div class="wow fadeInUp" data-wow-delay="0.7s">
                    <a href="javascript:void(0);" data-target="{{$checkInvoiceNow}}" data-toggle="modal" class="bttn bttn-primary">Check Invoice Now</a>
                </div>
            </div>
            <div class="hidden-xs col-sm-6 col-md-offset-1">
                <img src="{{asset('frontend/images/fraud_invoice3.png')}}" alt="">
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
                <img src="{{asset('frontend/images/doc_check.png')}}" alt="">
                <!--<img src="images/identity_check.png" alt="">-->
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5">
                <div class="page-title">
                    <h2 class="title wow fadeInUp">Internal Fraud Check</h2>
                    <div class="wow fadeInUp" data-wow-delay="0.5s">
                        <p>
                            <p class="small-heading">We detect internal fraud and protect you</p>
                            <p>Fraud in companies is comprehensive and complex. Between 30-50% of all fraud is internal and made by employees. It is difficult to detect. Our system can detect fraudulent records and invoices with advanced AI with the absolutely latest technology that is patent pending. It is easy to connect your accounting system to us and and we can on a near real time basis detect fraud in your books. If it is big or small does not matter we can support you</p>
                    </div>
                </div>
                <div class="wow fadeInUp" data-wow-delay="0.7s">
                    <a href="javascript:void(0);" data-target="{{$loginLink}}" data-toggle="modal" class="bttn bttn-primary">Internal Fraud Check Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Service 3 Area / -->

<!--<section class="section-padding gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                    <div class="page-title text-center">
                        <h2 class="title">Testimonials</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="testimonials">
                        <div class="single-testimonial text-center">
                            <div class="testimonial-text">
                                <em>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus.</em>
                            </div>
                            <h3>Samirao Boekeo</h3>
                            <h6>CEO, Classic Group</h6>
                            <div class="testimonial-img">
                                <img src="images/testimonial-1.png" alt="">
                            </div>
                        </div>
                        <div class="single-testimonial text-center">
                            <div class="testimonial-text">
                                <em>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus.</em>
                            </div>
                            <h3>Samirao Boekeo</h3>
                            <h6>CEO, Classic Group</h6>
                            <div class="testimonial-img">
                                <img src="images/testimonial-2.png" alt="">
                            </div>
                        </div>
                        <div class="single-testimonial text-center">
                            <div class="testimonial-text">
                                <em>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus.</em>
                            </div>
                            <h3>Samirao Boekeo</h3>
                            <h6>CEO, Classic Group</h6>
                            <div class="testimonial-img">
                                <img src="images/testimonial-1.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
-->