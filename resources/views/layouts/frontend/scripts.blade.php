 <!--Vendor-JS -->
 <script src="{{asset('frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
 <script src="{{asset('frontend/js/vendor/bootstrap.min.js')}}"></script>
 <!--Plugin-JS -->
 <script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
 <script src="{{asset('frontend/js/appear.js')}}"></script>
 <script src="{{asset('frontend/js/bars.js')}}"></script>
 <script src="{{asset('frontend/js/waypoints.min.js')}}"></script>
 <script src="{{asset('frontend/js/counterup.min.js')}}"></script>
 <script src="{{asset('frontend/js/easypiechart.min.js')}}"></script>
 <script src="{{asset('frontend/js/mixitup.min.js')}}"></script>
 <script src="{{asset('frontend/js/contact-form.js')}}"></script>
 <script src="{{asset('frontend/js/scrollUp.min.js')}}"></script>
 <script src="{{asset('frontend/js/magnific-popup.min.js')}}"></script>
 <script src="{{asset('frontend/js/wow.min.js')}}"></script>
 <!--Main-active-JS-->

 <script src="{{asset('frontend/js/main.js')}}"></script>
 <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXZ3vJtdK6aKAEWBovZFe4YKj1SGo9V20&callback=initMap"> -->
 </script>
 <!-- <script src="{{asset('frontend/js/maps.js')}}"></script> -->

 @include('manage.verification.scripts')
 <script type="text/javascript">
     function setCookie(key, value, expiry) {
         var expires = new Date();
         expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
         document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
     }

     function getCookie(key) {
         var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
         return keyValue ? keyValue[2] : null;
     }

     function eraseCookie(key) {
         var keyValue = getCookie(key);
         setCookie(key, keyValue, '-1');
     }

     eraseCookie('isLoginChecked');
     eraseCookie('safePaySubscription');
     eraseCookie('DetectorSubscription');
     eraseCookie('OnboardingSubscription');
     eraseCookie('InvoiceCheckSubscription');
     eraseCookie('SupplierVerificationSubscription');
 </script>
 <script>
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });


     $('input[name=loginUsername], input[name=loginPassword]').keyup(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            $('#btnUserLogin').trigger('click');
        }
     })



     $(document).on('click', '#btnUserLogin', function() {
         username = $('input[name=loginUsername]').val();
         password = $('input[name=loginPassword]').val();
         $('#btnUserLogin').attr('disabled', true)

         $('#loginEmailError').html('');
         $('#loginPasswordError').html('');
         $.ajax({
             url: "{{route('auth.login')}}",
             type: 'POST',
             data: {
                 email: username,
                 password: password
             },
             success: function(result) {
				 window.location.href = "{{route('dashboard.create')}}"
             },
             error: function(result) {
                 $('.preloader').fadeOut();
                 $('#btnUserLogin').attr('disabled', false)
                 errors = result.responseJSON.errors;

                 if (errors.email) {
                     $('#loginEmailError').html(errors.email);
                 }

                 if (errors.password) {
                     $('#loginPasswordError').html(errors.password);
                 }
             },
             beforeSend: function() {
                 $('.preloader').fadeIn();
             }
         });
     })


     $('input[name=signupName], input[name=singupEmail], input[name=signupPassword], input[name=signupPasswordConfirm]')

     .keyup(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            $('#btnUserSignup').trigger('click');
        }
     })

     $(document).on('click', '#btnUserSignup', function() {
         $('#signuptermsandcondtionsError').html('');
         if ($('#signuptermsandcondtions').is(':checked') == false) {
             $('#signuptermsandcondtionsError').html('Please accept the terms and condtions');
             return false;
         }

         name = $('input[name=signupName]').val();
         email = $('input[name=singupEmail]').val();
         password = $('input[name=signupPassword]').val();
         password_confirmation = $('input[name=signupPasswordConfirm]').val();
         $('#btnUserSignup').attr('disabled', true)

         $('#signupNameError').html('');
         $('#signupEmailError').html('');
         $('#signupPasswordError').html('');
         $.ajax({
             url: "{{route('auth.store')}}",
             type: 'POST',
             data: {
                 name: name,
                 email: email,
                 password: password,
                 password_confirmation: password_confirmation
             },
             success: function(result) {
                 window.location.href = "{{route('dashboard.create')}}"
             },
             error: function(result) {
                 $('.preloader').fadeOut();
                 $('#btnUserSignup').attr('disabled', false)
                 errors = result.responseJSON.errors;

                 if (errors.name) {

                     $('#signupNameError').html(errors.name);
                 }

                 if (errors.email) {
                     console.log(errors.email);
                     $('#singupEmailError').html(errors.email);
                 }

                 if (errors.password) {
                     $('#signupPasswordError').html(errors.password);
                 }

                 if (errors.password_confirmation) {
                     $('#signupPasswordError').html(errors.password_confirmation);
                 }
             },
             beforeSend: function() {
                 $('.preloader').fadeIn();
             }
         });
     })

     $('input[name=forgotPasswordEmail]')
     .keyup(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            $('#btnUserForgotPassword').trigger('click');
        }
     })

     $(document).on('click', '#btnUserForgotPassword', function() {
         email = $('input[name=forgotPasswordEmail]').val();


         $('#btnUserForgotPassword').attr('disabled', true)

         $('#forgotPasswordEmailError').html('');
         $('#forgotPasswordEmailSuccess').html('');
         $.ajax({
             url: "{{route('auth.forgot-password.post')}}",
             type: 'POST',
             data: {
                 email: email
             },
             success: function(result) {
                 $('.preloader').fadeOut();

                 $('#btnUserForgotPassword').attr('disabled', false)
                 $('#forgotPasswordEmailSuccess').html("Your new password has been sent on your email account");
             },
             error: function(result) {
                 $('.preloader').fadeOut();
                 $('#btnUserForgotPassword').attr('disabled', false)
                 errors = result.responseJSON.errors;

                 if (errors.email) {
                     console.log(errors.email);
                     $('#forgotPasswordEmailError').html(errors.email);
                 }
             },
             beforeSend: function() {
                 $('.preloader').fadeIn();
             }
         });
     })


     $('#btnSelectInvoiceModal').click(function() {
         $('#checkUploadInvoiceFile').click();

     });


     $(document).on('click', '#btnUploadInvoice', function() {
         $('#uploadInvoiceNameError').html('');
         $('#uploadInvoiceEmailError').html('');
         $('#uploadInvoiceContactNumberError').html('');


         name = $('#uploadInvoiceName').val();
         email = $('#uploadInvoiceEmail').val();
         contactNumber = $('#uploadInvoiceContactNumber').val();

         flag = true;
         if (!name) {
             $('#uploadInvoiceNameError').html('Please enter name');
             flag = false;
         }
         var emailPattern = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

         if (!email || !emailPattern.test(email)) {
             $('#uploadInvoiceEmailError').html('Please enter valid email');
             flag = false;
         }


         var pattern = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;

         if (!contactNumber || !pattern.test(contactNumber)) {
             $('#uploadInvoiceContactNumberError').html('Please enter valid contact number');
             flag = false;
         }

         if (flag) {
             var jform = new FormData();
             var invoiceFiles = $('#checkUploadInvoiceFile')[0].files;
             filename = ''
             for (var i = 0; i < invoiceFiles.length; i++) {
                 filename = invoiceFiles[i]['name'];
                 jform.append('invoiceFile', invoiceFiles[i], invoiceFiles[i]['name']);
             }
             name = $('#uploadInvoiceName').val();
             email = $('#uploadInvoiceEmail').val();
             contactNumber = $('#uploadInvoiceContactNumber').val();

             jform.append("email", email);
             jform.append("name", name);
             jform.append("contactNumber", contactNumber);

             $.ajax({
                 url: "{{route('check-invoice')}}",
                 type: 'POST',
                 data: jform,
                 mimeType: 'multipart/form-data',
                 contentType: false,
                 processData: false,
                 success: function(result) {

                     firebaseVerification(contactNumber, appVerifier)
                     $('#document-upload-msg-invoice').html('<span class="alert alert-warning">Your invoice (' + filename + ') uploaded successfully</span>')

                 },
                 error: function(result) {
                     $('.preloader').fadeOut();

                     errors = jQuery.parseJSON(result.responseText).errors
                     if (errors.message) {

                         $('#document-upload-msg-invoice').html('<span class="alert alert-danger">' + errors.message + '</span>')
                     }
                 },
                 beforeSend: function() {
                     $('.preloader').fadeIn();
                 }
             });
         }
     });


     $('#checkUploadInvoiceFile').change(function() {
         $('#document-upload-msg').html('');

         var fileExtension = ['png', 'jpg', 'pdf', 'jpeg'];
         if ($(this).val() != '' && $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
             $('#document-upload-msg').html('<span class="alert alert-danger">Invalid invoice format, we accept only (png, jpg, jpeg, pdf)</span>')
             return false;
         }

         var invoiceFiles = $('#checkUploadInvoiceFile')[0].files;
         filename = ''
         for (var i = 0; i < invoiceFiles.length; i++) {
             filename = invoiceFiles[i]['name'];
         }

         $('#document-upload-msg-invoice').html('<span class="alert alert-danger">File: ' + filename + '</span>')

         $('#selectInvoiceModal').modal('hide');
         $('#uploadInvoiceModal').modal();
     });
     var sessionId = '';

     firebaseVerification = function(phoneNumber, appVerifier) {

         firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
             .then(function(confirmationResult) {
                 $('.preloader').fadeOut();
                 $('#invoiceUploadArea').hide();
                 $('#invoiceVerificationCodeArea').show()
                 sessionId = confirmationResult.verificationId;

             }).catch(function(error) {
                 $('.preloader').fadeOut();
                 $('#document-upload-msg').html('<span class="alert alert-danger">' + error.message + '</span>');
             });
     }



     $('#btnInvoiceVerifyOtpCode').click(function() {
         email = $('#uploadInvoiceEmail').val();
         otpCode = $('#otpCode').val();

         $.ajax({
             url: "{{route('verify-otp-code')}}",
             type: 'POST',
             data: {
                 email: email,
                 code: otpCode,
                 verificationId: sessionId,
             },
             success: function(result) {
                 $('.preloader').fadeOut();
                 $('#uploadInvoiceName').val('');
                 $('#uploadInvoiceEmail').val('');
                 $('#uploadInvoiceContactNumber').val('');
                 $('#checkUploadInvoiceFile').val('');
                 $('#document-upload-msg-invoice').html("<span class='alert alert-warning'>Thank you for verification, your login information has been sent to your email account</span>");
                 setTimeout(function() {
                     window.location.reload();
                 }, 2000);
             },
             error: function(result) {
                 $('.preloader').fadeOut();
                 $('#document-upload-msg-invoice').html("<span class='alert alert-warning'>Phone number verification failed</span>");
             },
             beforeSend: function() {
                 $('.preloader').fadeIn();
             }
         });
     })
 </script>
