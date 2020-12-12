 @extends('layouts.frontend.app')

 @section('content')
 <!--Header-Area-->
 <header class="header-area overlay" id="home-area">
     <div class="vcenter">
         <div class="container">
             <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     <div class="header-text">
                         <h2 class="header-title wow fadeInUp">About Us</h2>
                         <div class="wow fadeInUp short-desc" data-wow-delay="0.5s">We are scientists that has come together and enjoyed the creation of this platform as we found a market for it. We have used extremely advanced algorithms as we have seen the fraud that is out there in real the production environments and is not just made up scenarios. The system is in the forefront of AI; deep learning, neural networks, image processing and we have furthered the proceses to a level where we are top leaders of the detection of fraud and identities. We have patent pending and are unique in the market space</div>

                     </div>
                 </div>
             </div>
         </div>
     </div>
 </header>
 <!--Header-Area-/-->

 <!-- Contact-Area -->
 <section class="section-padding" id="contact-area">
     <div class="contact-area">
         <div class="container">
             <div class="row">
                 <div class="col-xs-12">
                     <h2>Contact Us</h2>
                 </div>
             </div>
             <div class="row">
                 <div class="col-xs-12 col-md-12 col-lg-12">
                     <div class="contact-form">
                         <form action="process.php" id="contact-form" method="post">
                             <div class="form-double">
                                 <input type="text" id="form-name" name="form-name" placeholder="Full Name" required="required">
                                 <input type="number" placeholder="Phone Number">
                             </div>
                             <div class="form-double">
                                 <input type="email" name="form-email" name="email" id="form-email" placeholder="Your Email" required="required">
                                 <input type="text" name="form-subject" id="form-subject" placeholder="Subject" required="required">
                             </div>
                             <textarea name="form-message" id="message" id="form-message" rows="5" required="required" placeholder="Message"></textarea>
                             <div class="center-btn"><button class="bttn bttn-primary">Send Now</button></div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <!-- Contact-Area -->

 @endsection