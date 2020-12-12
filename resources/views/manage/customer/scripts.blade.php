<script>
    function documentDragNdrop(event) {}

    function documentDrag() {
        document.getElementById('customerDocument').parentNode.className = 'draging dragBox';
        document.getElementById('bankStatement').parentNode.className = 'draging dragBox';
    }

    function documentDrop(event) {

        document.getElementById('customerDocument').parentNode.className = 'dragBox';
        document.getElementById('bankStatement').parentNode.className = 'dragBox';
    }

    $(document).on('drop', '#uploadOuter', function(e) {
        $(".uploadOuter").trigger('click');
        var files = e.originalEvent.dataTransfer.files;
        $("#customerDocument").prop("files", files);
        $('#dragBox').addClass('draging');
        $('#dragBox').removeClass('col-md-12');
        $('#dragBox').addClass('col-md-6');
        $("#customerDocument").trigger('change');
        return false;
    });

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


    $(document).on('drop', '#uploadOuter', function(e) {
        $('#dragBox').addClass('draging');
    });

    $(document).on('drop', '#bankStatementOuter', function(e) {
        $('#bankDragBox').addClass('draging');
    });


    $(window).on('load', function() {
        $('#start-customer-verification').modal({
            backdrop: 'static',
            keyboard: false,
        });
    });

    $('#finishVerfication').click(function() {
        url = "{{route('auth.login')}}";
        window.location.replace(url);
    })

    $('#backDocumentUpload').click(function() {
        $('#download-app-modal').modal('hide')
        $('#customer-verification').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $('#nextKycVerification').click(function() {
        $('#customer-verification').modal('hide')
        $('#kyc-verification').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $('#backKycVerification').click(function() {

        $.ajax({
            url: "{{route('check-customer-verification')}}",
            type: 'POST',
            data: {
                customerId: "{{$customer->id}}",
            },
            success: function(result) {
                // $('#kyc-verification').modal('hide')
                $('#download-app-modal').modal('hide');
                if (result == 1 || result == '1') {
                    $('#kyc-verification').modal({
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

    $('#nextDownloadApp').click(function() {
        $.ajax({
            url: "{{route('check-customer-verification')}}",
            type: 'POST',
            data: {
                customerId: "{{$customer->id}}",
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

    $('#backToKyc').click(function() {
        $('#bank-statement-verification').modal('hide')
        $('#kyc-verification').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $('#nextDownloadModal').click(function() {
        // $('#bank-statement-verification').modal('hide');
        $('#customer-verification').modal('hide')
        $('#download-app-modal').modal({
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

    var counterFilesUpload = 0;
</script>

<script>
    let dropArea = document.getElementById('uploadOuter')

    ;
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false)
    })

    function preventDefaults(e) {
        e.preventDefault()
        e.stopPropagation()
    }


    ;
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false)
    })

    ;
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false)
    })

    function highlight(e) {
        dropArea.classList.add('highlight')
    }

    function unhighlight(e) {
        dropArea.classList.remove('highlight')
    }


    dropArea.addEventListener('drop', handleDrop, false)

    function handleDrop(e) {
        let dt = e.dataTransfer
        let files = dt.files
        let evFiles = e.target.files;
        $("#preview").css("display", "inline-block");
        handleFiles(files, evFiles)
    }

    var formData;
    var fileCounter = 0;
    var fileFlag = 1;

    function handleFiles(files, evFiles) {
        formData = new FormData()
        fileFlag = 1;
        ([...files]).forEach(uploadFile);
        if (fileFlag == 1) {
            customer_id = '{{ $customer->id }}'
            formData.append('customer_id', customer_id);

            $.ajax({
                url: "{{route('onboarding.upload-document')}}",
                type: 'POST',
                data: formData,
                mimeType: 'multipart/form-data',
                contentType: false,
                processData: false,
                success: function(result) {
                    $('.preloader').fadeOut();

                    $('#document-upload-msg').html('<span class="alert alert-warning">Document upload successfully</span>')
                    $('#document-upload-msg').attr('class', 'success');
                },
                error: function(result) {
                    $('.preloader').fadeOut();
                    $('#document-upload-msg').html('<span class="alert alert-danger">Document upload failed</span>')
                    $('#document-upload-msg').attr('class', 'error');
                },
                beforeSend: function() {
                    $('.preloader').fadeIn();
                },
                complete: function() {
                    $('.preloader').fadeOut();
                }
            });
        } else {

        }

        return false;
    }


    function uploadFile(file) {

        if (fileCounter < 10) {
            var fileExtension = ['png', 'pdf', 'jpg', 'jpeg'];
            altName = filename = file.name;
            ext = filename.split('.').pop().toLowerCase();

            filename = filename.length > 10 ? filename.slice(0, 9) + "…" : filename;
            if ($.inArray(ext, fileExtension) == -1) {
                $('#document-upload-msg')
                    .html('<span class="alert alert-danger">Invalid document format, we accept only (png, jpg, jpeg, pdf)</span>')
                $('#customerDocument').val('')

                fileFlag = 0;
                return false;
            }

            formData.append('customerDocument[]', file)

            if (ext == 'jpg' || ext == 'jpeg') {
                fileicon = "{{ asset('assets/images/jpg.svg') }}";
            } else if (ext == 'png') {
                fileicon = "{{ asset('assets/images/png.svg') }}";
            } else if (ext == 'pdf') {
                fileicon = "{{ asset('assets/media/icons/pdf.svg') }}";
            }

            $('#preview').append('<div class="float-left"  style="font-size:9px; word-break: break-word;"><div> <img title="' + altName + '" src="' + fileicon + '" /></div><div>' + filename + '</div></div>');

            fileCounter++;
        } else {
            $('#document-upload-msg')
                .html('<span class="alert alert-danger">You are not allowed to upload more than 10 files</span>')
            fileFlag = 0;
        }

    }

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

    function bankStatementHandleDrop(e) {
        let dt = e.dataTransfer
        let files = dt.files
        let evFiles = e.target.files;
        $("#bankPreview").css("display", "inline-block");
        bankStatementHandleFiles(files, evFiles)
    }

    var bankStatementformData;
    var fileCounter = 0;

    function bankStatementHandleFiles(files, evFiles) {
        bankStatementformData = new FormData()
            ([...files]).forEach(bankStatementUploadFile);
    }


    function bankStatementUploadFile(file) {

        var fileExtension = ['pdf'];
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

        bankStatementformData.append('customerDocument[]', file)

        if (ext == 'jpg' || ext == 'jpeg') {
            fileicon = "{{ asset('assets/images/jpg.svg') }}";
        } else if (ext == 'png') {
            fileicon = "{{ asset('assets/images/png.svg') }}";
        } else if (ext == 'pdf') {
            fileicon = "{{ asset('assets/media/icons/pdf.svg') }}";
        }

        $('#bankPreview').html('<div class="float-left"  style="font-size:9px; word-break: break-word;"><div> <img title="' + altName + '" src="' + fileicon + '" /></div><div>' + filename + '</div></div>');

        customer_id = '{{ $customer->id }}'
        bankStatementformData.append('customer_id', customer_id);

        $.ajax({
            url: "{{route('onboarding.upload-document')}}",
            type: 'POST',
            data: bankStatementformData,
            mimeType: 'multipart/form-data',
            contentType: false,
            processData: false,
            success: function(result) {
                $('.preloader').fadeOut();

                $('#bankstatement-upload-msg').html('<span class="alert alert-warning">Document upload successfully</span>')
                $('#bankstatement-upload-msg').attr('class', 'success');
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
