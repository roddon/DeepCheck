@extends('layouts.frontend.background-app')

@section('content')
@include('manage.frontend.background')

@include('manage.verification.supplier.verification-modal')

@include('manage.verification.supplier.kyc-verification-modal')

@include('manage.verification.supplier.download-app-modal')

@include('manage.verification.supplier.finish-modal')

@include('manage.verification.supplier.bank-statement-verification-modal')

@endsection


@section('scripts')


<script>
    var sessionId = '';
    var numberVerified = false;

    $('#verifyPhoneNumber').click(function() {
        $('#supplier-verification-error').html('');
        // Turn off phone auth app verification.

        var phoneNumber = $('#phoneNumber').val();
        var pattern = /^\+[0-9-+]+$/;

        if (phoneNumber == null || phoneNumber == '' || !pattern.test(phoneNumber)) {
            $('#supplier-verification-error').html('<span class="alert alert-danger d-block text-center w-100">Please enter valid mobile number</span>');
            return false;
        }

        $('.preloader').fadeIn();
        $('#supplier-verification').modal('hide')




        // reCAPTCHA response.
        firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
            .then(function(confirmationResult) {
                $('.preloader').fadeOut();
                console.log(confirmationResult);
                sessionId = confirmationResult.verificationId;
                $('#contact-number-area').hide();
                $('#otp-area').show();

                $('#supplier-verification').modal({
                    backdrop: 'static',
                    keyboard: false,
                });

            }).catch(function(error) {
                $('.preloader').fadeOut();
                $('#contact-number-area').show();
                $('#otp-area').hide();
                $('#supplier-verification').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
                $('#supplier-verification-error').html('<span class="alert alert-danger d-block text-center w-100">' + error.message + '</span>');
            });
    })


    $('#OTPVerify').click(function() {

        code = $('#OTPCode').val();
        $('#OTPVerify').hide();

        if (code == null || code == '') {
            $('#supplier-verification-error').html('<span class="alert alert-danger d-block text-center w-100">Please enter valid OTP Code.</span>');
            return false;
        }
        $('#supplier-verification').hide();

        $.ajax({
            url: "{{route('verification.supplier.verify-otp')}}",
            type: 'POST',
            data: {
                code: code,
                verificationId: sessionId,
                supplier_id: "{{$supplier->id}}",
                contact_number: $('input[name=contact_number]').val(),
            },
            success: function(result) {
                $('.preloader').fadeOut();
                numberVerified = true;

                $('#bank-statement-verification').modal({
                    backdrop: 'static',
                    keyboard: false,
                });

            },
            error: function(result) {
                $('.preloader').fadeOut();
                $('#OTPVerify').show();
                $('#supplier-verification-error').html('<span>' + result.message + '</span>');
                $('#supplier-verification').show();
                $('#supplier-verification').modal({
                    backdrop: 'static',
                    keyboard: false,
                });
            },
            beforeSend: function() {
                $('.preloader').fadeIn();
            },
            complete: function() {
                $('.preloader').fadeOut();
            }
        });
    });
</script>

<script>
    $(window).on('load', function() {
        $('#supplier-verification').modal({
            backdrop: 'static',
            keyboard: false,
        });
    });

    $('#nextDownloadApp').click(function() {

        $.ajax({
            url: "{{route('check-supplier-verification')}}",
            type: 'POST',
            data: {
                supplierId: "{{$supplier->id}}",
            },
            success: function(result) {
                $('#kyc-verification').modal('hide')
                if (result == 1 || result == '1') {
                    $('#download-app-modal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                } else {
                    $('#bank-statement-verification').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }
            },
            error: function(result) {
                $('.preloader').fadeOut();
                $('#document-upload-msg').html('<span class="alert alert-danger">Customer address not varified</span>')
                $('#document-upload-msg').attr('class', 'error');
            },
            beforeSend: function() {
                $('.preloader').fadeIn();
            },
            complete: function() {
                $('.preloader').fadeOut();
            }

        });
    });

    $('#nextDownloadModal').click(function() {
        var attr = $(this).attr('disabled');

        // For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
        if (typeof attr === typeof undefined || attr === false) {
            $('#bank-statement-verification').modal('hide');
            $('#download-app-modal').modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });

    $('#backKycVerification').click(function() {

        $('#download-app-modal').modal('hide')
        $('#bank-statement-verification').modal({
            backdrop: 'static',
            keyboard: false
        });
        // $.ajax({
        //     url: "{{route('check-supplier-verification')}}",
        //     type: 'POST',
        //     data: {
        //         supplierId: "{{$supplier->id}}",
        //     },
        //     success: function(result) {
        //         // $('#kyc-verification').modal('hide')

        //         if (result == 1 || result == '1') {
        //             $('#kyc-verification').modal({
        //                 backdrop: 'static',
        //                 keyboard: false
        //             });
        //         } else {
        //             $('#bank-statement-verification').modal({
        //                 backdrop: 'static',
        //                 keyboard: false
        //             });
        //         }
        //     },
        //     error: function(result) {
        //         $('.preloader').fadeOut();
        //         $('#document-upload-msg').html('<span class="alert alert-danger">Customer address not varified</span>')
        //         $('#document-upload-msg').attr('class', 'error');
        //     },
        //     beforeSend: function() {
        //         $('.preloader').fadeIn();
        //     },
        //     complete: function() {
        //         $('.preloader').fadeOut();
        //     }

        // });
    });

    $('#backToKyc').click(function() {
        $('#bank-statement-verification').modal('hide')
        $('#kyc-verification').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $('#backDownloadApp').click(function() {
        $('#finish-modal').modal('hide')
        $('#download-app-modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $('#nextFinishProcess').click(function() {
        $('#download-app-modal').modal('hide')
        $('#finish-modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });


    $('#start_supplier_verification').click(function() {
        if (numberVerified) {
            $('#supplier-verification').hide();
            $.ajax({
                url: "{{route('verification.supplier.update')}}",
                type: 'POST',
                data: {
                    supplier_id: "{{$supplier->id}}",
                    contact_number: $('input[name=contact_number]').val(),
                },
                success: function(result) {
                    $('.preloader').fadeOut();

                    $('#kyc-verification').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                },
                error: function(result) {
                    $('.preloader').fadeOut();
                    $('#supplier-verification-error').html('<span>' + result.message + '</span>');
                    $('#supplier-verification').show();
                    $('#supplier-verification').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                },
                beforeSend: function() {
                    $('.preloader').fadeIn();
                },
                complete: function() {
                    $('.preloader').fadeOut();
                }
            });
        } else {
            $('#supplier-verification-error').html('<span>Please verify your contact number</span>');
        }
    })
</script>

<script>
    function documentDragNdrop(event) {}

    function documentDrag() {
        document.getElementById('bankStatement').parentNode.className = 'draging dragBox';
    }

    function documentDrop(event) {
        document.getElementById('bankStatement').parentNode.className = 'dragBox';
    }

    $(document).on('drop', '#bankStatementOuter', function(e) {
        $(".bankStatementOuter").trigger('click');
        var files = e.originalEvent.dataTransfer.files;
        $("#bankStatement").prop("files", files);
        $('#bankDragBox').addClass('draging');
        $('#bankDragBox').removeClass('col-md-12');
        $('#bankDragBox').addClass('col-md-6');
        $("#bankStatement").trigger('change');
        return false;
    });

    $(document).on('drop', '#bankStatementOuter', function(e) {
        $('#bankDragBox').addClass('draging');
    });



    let bankStatementDropArea = document.getElementById('bankStatementOuter')

    ;
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        bankStatementDropArea.addEventListener(eventName, preventDefaults, false)
    })

    function preventDefaults(e) {
        e.preventDefault()
        e.stopPropagation()
    }


    ;
    ['dragenter', 'dragover'].forEach(eventName => {
        bankStatementDropArea.addEventListener(eventName, highlight, false)
    })

    ;
    ['dragleave', 'drop'].forEach(eventName => {
        bankStatementDropArea.addEventListener(eventName, unhighlight, false)
    })

    function highlight(e) {
        bankStatementDropArea.classList.add('highlight')
    }

    function unhighlight(e) {
        bankStatementDropArea.classList.remove('highlight')
    }


    bankStatementDropArea.addEventListener('drop', bankStatementHandleDrop, false)

    $(document).on('change', "#bankStatement", function(e) {
        bankStatementHandleDrop(e,'change');
    });

    function bankStatementHandleDrop(e,type='drop') {
        /*let dt = e.dataTransfer
        let files = dt.files*/
        let evFiles;
        if(type=='change'){
        evFiles = e.target.files;
        }else{
            evFiles = e.dataTransfer.files;
        }
        $("#bankPreview").css("display", "inline-block");
        bankStatementHandleFiles(evFiles, evFiles)
    }
    /*function bankStatementHandleDrop(e) {
        let dt = e.dataTransfer
        let files = dt.files
        let evFiles = e.target.files;
        $("#bankPreview").css("display", "inline-block");
        bankStatementHandleFiles(files, evFiles)
    }*/

    var bankStatementformData;
    var fileCounter = 0;

    function bankStatementHandleFiles(files, evFiles) {
        ([...files]).forEach(bankStatementUploadFile);
    }


    function bankStatementUploadFile(file) {
        var fileExtension = ['pdf'];
        bankStatementformData = new FormData();
        altName = filename = file.name;
        ext = filename.split('.').pop().toLowerCase();
        if ($.inArray(ext, fileExtension) == -1) {
            $('#bankstatement-upload-msg').html('<span class="alert alert-danger">Invalid document format, we accept only pdf</span>')
            $('#customerDocument').val('')
            return false;
        }

        if (altName != 'bankstatement.pdf') {
            return $('#bankstatement-upload-msg').html('<span class="alert alert-danger">File name must be bankstatement.pdf</span>')
            return false;
        }

        bankStatementformData.append('customerDocument', file)

        if (ext == 'jpg' || ext == 'jpeg') {
            fileicon = "{{ asset('assets/images/jpg.svg') }}";
        } else if (ext == 'png') {
            fileicon = "{{ asset('assets/images/png.svg') }}";
        } else if (ext == 'pdf') {
            fileicon = "{{ asset('assets/media/icons/pdf.svg') }}";
        }

        $('#bankPreview').html('<div class="float-left"  style="font-size:9px; word-break: break-word;"><div> <img title="' + altName + '" src="' + fileicon + '" /></div><div>' + filename + '</div></div>');

        supplier_id = '{{ $supplier->id }}'
        bankStatementformData.append('supplier_id', supplier_id);

        $.ajax({
            url: "{{route('supplier.upload-document')}}",
            type: 'POST',
            data: bankStatementformData,
            //mimeType: 'multipart/form-data',
            contentType: false,
            processData: false,
            success: function(result) {
                $('.preloader').fadeOut();

                $('#bankstatement-upload-msg').html('<span class="alert alert-warning">Document upload successfully</span>')
                $('#bankstatement-upload-msg').attr('class', 'success');
                $('#bank-statement-verification').find('a#nextDownloadModal').removeClass('graybg').removeAttr('disabled');
            },
            error: function(result) {
                $('.preloader').fadeOut();
                $('#bankstatement-upload-msg').html('<span class="alert alert-danger">Document upload failed</span>')
                $('#bankstatement-upload-msg').attr('class', 'error');
            },
            beforeSend: function() {
                $('.preloader').fadeIn();
            },
            complete: function() {
                $('.preloader').fadeOut();
            }
        });

    }
</script>

@endsection
