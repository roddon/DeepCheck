<script>
    $('#verifyCompanyNumber').click(function() {
        companyNumber = $('input[name=companyNumber]').val();

        if ($.trim(companyNumber) == '') {
            return false;
        }

        $.ajax({
            url: "{{route('company.company-number-verify')}}",
            type: 'POST',
            data: {
                'companyNumber': companyNumber,
            },
            success: function(result) {
                $('#overlay').fadeOut()
                updateCompanyPageData(result.company)

                swal("Success", result.message, "success");

            },
            error: function(result) {
                $('#overlay').fadeOut();
                companyPageElementHide();
                swal("Oops..", result.responseJSON.message, "error");
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });
    })

    $('#varify_iban_number').click(function() {
        iBanNumber = $('input[name=iBanNumber]').val();

        if ($.trim(iBanNumber) == '') {
            return false;
        }

        $.ajax({
            url: "{{route('company.iban-number-verify')}}",
            type: 'POST',
            data: {
                'iBanNumber': iBanNumber,
            },
            success: function(result) {
                updateCompanyPageData(result.company)
                swal("Success", result.message, "success");
            },
            error: function(result) {
                $('#overlay').fadeOut();
                swal("Oops..", result.responseJSON.errors.iBanNumber, "error");
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });
    })

    $('#verifyVatNumber').click(function() {
        vatNumber = $('input[name=vatNumber]').val();

        if ($.trim(vatNumber) == '') {
            return false;
        }

        $.ajax({
            url: "{{route('company.vat-number-verify')}}",
            type: 'POST',
            data: {
                'vatNumber': vatNumber,
            },
            success: function(result) {
                updateCompanyPageData(result.company)
                swal("Success", result.message, "success");
            },
            error: function(result) {
                $('#overlay').fadeOut();
                swal("Oops..", result.responseJSON.message, "error");
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });
    })

    $('#companyLogoImage').change(function() {

        var fileExtension = ['jpg', 'png', 'jpeg'];
        if ($(this).val() != '' && $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {

            swal({
                icon: "error",
                title: 'Oops..',
                text: "Invalid image format, we accept only (jpg, png, jpeg)"
            });
            this.value = ''; // Clean field
            return false;
        }

        var jform = new FormData();
        if ($(this).val() != '') {
            jform.append('companyLogoImage', $('#companyLogoImage').get(0).files[0]);
        } else {
            jform.append('companyLogoImage', '');
        }


        $.ajax({
            url: "{{route('company.upload-logo-image')}}",
            type: 'POST',
            data: jform,
            mimeType: 'multipart/form-data',
            contentType: false,
            processData: false,
            success: function(result) {
                $('#overlay').fadeOut();
                result = jQuery.parseJSON(result);
                swal("Success", result.message, "success");
                $('#companyLogo').prop('src', result.fileUrl);
            },
            error: function(result) {
                $('#overlay').fadeOut();
                swal("Oops..", result.responseJSON.message, "error");
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });
    })

    $('#changeImage').click(function() {
        $('#companyLogoImage').trigger('click');
    });

    $('#deleteImage').click(function() {
        $('#companyLogoImage').val('');
        $('#companyLogoImage').trigger('change');
    });





    $('#edit_company_address_detail').click(function() {
        $('#company_address_detail_edit').show();
        $('#company_address_detail').hide();
    });

    $('#cancel_company_address_detail').click(function() {
        $('#company_address_detail_edit').hide();
        $('#company_address_detail').show();
    })

    $('#save_company_address_detail').click(function() {
        address1 = $('input[name=address_1').val();
        address2 = $('input[name=address_2').val();
        postCode = $('input[name=post_code').val();
        city = $('input[name=city').val();
        country = $('input[name=country').val();
        companyUpdate({
            address_1: address1,
            address_2: address2,
            post_code: postCode,
            city: city,
            country: country
        });
    })


    $('#edit_office_phone_number').click(function() {
        $('#office_phone_number').hide();
        $('#office_phone_number_edit').show();
    });

    $('#cancel_office_phone_number').click(function() {
        $('#office_phone_number').show();
        $('#office_phone_number_edit').hide();
    })

    $('#save_office_phone_number').click(function() {
        phoneNumber = $('input[name=companyPhoneNumber').val();
        companyUpdate({
            phone_number: phoneNumber
        });
    })

    $('#edit_website_url').click(function() {
        $('#website_url').hide();
        $('#website_url_edit').show();
    });


    $('#cancel_website_url').click(function() {
        $('#website_url').show();
        $('#website_url_edit').hide();
    });


    $('#save_website_url').click(function() {
        websiteUrl = $('input[name=companyWebsiteUrl]').val();
        companyUpdate({
            website_url: websiteUrl
        });
    });


    $('#sync_client').change(function() {
        isClientSynced = $('#sync_client').prop('checked') ? 1 : 0;
        companyUpdate({
            is_client_synced: isClientSynced
        });
    })

    $('#onboarding-area').change(function() {
        isOnboarding = $('#onboarding-area').prop('checked') ? 1 : 0;
        companyUpdate({
            is_onboarding: isOnboarding
        });
    })

    $('#id-verification').change(function() {
        isIdDocument = $(this).prop('checked') ? 1 : 0;
        companyUpdate({
            is_id_document: isIdDocument
        });
    })


    $('#utility-document').change(function() {
        isUtilityBillUpload = $(this).prop('checked') ? 1 : 0;
        companyUpdate({
            is_utility_bill_uploaded: isUtilityBillUpload
        });
    })

    $('#new-supplier-verification').change(function() {
        newSupplierVerification = $(this).prop('checked') ? 1 : 0;
        companyUpdate({
            new_supplier_verification: newSupplierVerification
        });
    })

    $('#languageId').change(function() {
        languageId = $(this).val();
        companyUpdate({
            language_id: languageId
        });
    })

    $('#currencyId').change(function() {
        currencyId = $(this).val();        
        $.ajax({
            url: "{{route('company.update')}}",
            type: 'POST',
            data: {currency_id: currencyId},
            success: function(result) {
                $('#overlay').fadeOut();
                swal("Success", result.message, "success");
                window.location.reload();
            },
            error: function(result) {
                $('#overlay').fadeOut();
                swal("Oops..", result.responseJSON.message, "error");
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });
    })


    $('#edit_onboarding_message').click(function() {
        $('#onboarding_text_edit').show();
        $('#onboarding_text').hide();
        $('#onboarding_message').focus();
    });

    $('#cancel_onboarding_message').click(function() {
        $('#onboarding_text_edit').hide();
        $('#onboarding_text').show();
    })

    $('#save_onboarding_message').click(function() {
        onboarding_mail = $('#onboarding_mail_content').html();
        onboarding_mail = onboarding_mail.replace('textarea', 'span')
        onboarding_mail = onboarding_mail.replace('</textarea', '</span')

        onboarding_mail_subject = $('#onboarding_mail_subject').val();
        companyUpdate({
            onboarding_mail: $('#onboarding_message').val(),
            onboarding_message: onboarding_mail,
            onboarding_mail_subject: onboarding_mail_subject
        })
    })

    $('#edit_invoice_result_message').click(function() {
        $('#invoice_result_text_edit').show();
        $('#invoice_result_text').hide();
        $('#invoice_result_message').focus();
    });

    $('#cancel_invoice_result_message').click(function() {
        $('#invoice_result_text_edit').hide();
        $('#invoice_result_text').show();
    })

    $('#save_invoice_result_message').click(function() {
        check_the_invoice_mail = $('#check_the_invoice_mail').html().replace('textarea', 'span');
        check_the_invoice_mail = check_the_invoice_mail.replace('</textarea', '<span');
        invoice_result_mail_subject = $('#invoice_result_mail_subject').val();
        companyUpdate({
            invoice_result_message: check_the_invoice_mail,
            check_the_invoice_mail: $('#invoice_result_message').val(),
            invoice_result_mail_subject: invoice_result_mail_subject
        })
    })

    $('#edit_supplier_verification_message').click(function() {
        $('#supplier_verification_text_edit').show();
        $('#supplier_verification_text').hide();
    });

    $('#cancel_supplier_verification_message').click(function() {
        $('#supplier_verification_text_edit').hide();
        $('#supplier_verification_text').show();
    })

    $('#save_supplier_verification_message').click(function() {
        supplier_verification_mail = $('#supplier_verification_mail').html().replace('textarea', 'span');
        supplier_verification_mail = supplier_verification_mail.replace('</textarea', '<span');
        supplier_verification_mail_subject = $('#supplier_verification_mail_subject').val();
        companyUpdate({
            supplier_verification_message: supplier_verification_mail,
            supplier_verification_mail: $('#supplier_verification_message').val(),
            supplier_verification_mail_subject: supplier_verification_mail_subject
        })
    })

    $('#edit_existing_supplier').click(function() {
        $('#existing_supplier_text_edit').show();
        $('#existing_supplier_text').hide();
    });

    $('#cancel_existing_supplier').click(function() {
        $('#existing_supplier_text_edit').hide();
        $('#existing_supplier_text').show();
    })


    $('#save_existing_supplier').click(function() {
        existing_supplier_mail = $('#existing_supplier_mail').html().replace('textarea', 'span');
        existing_supplier_mail = existing_supplier_mail.replace('</textarea', '<span');
        existing_supplier_mail_verification = $('#existing_supplier_mail_verification').val();

        companyUpdate({
            existing_supplier_message: existing_supplier_mail,
            existing_supplier_mail: $('#existing_supplier').val(),
            existing_supplier_mail_verification: existing_supplier_mail_verification
        })
    })

    companyUpdate = function(requestData) {
        $.ajax({
            url: "{{route('company.update')}}",
            type: 'POST',
            data: requestData,
            success: function(result) {
                updateCompanyPageData(result.company)

                if (requestData.is_utility_bill_uploaded != null || requestData.is_onboarding != null) {
                    window.location.reload();
                }

                swal("Success", result.message, "success");

            },
            error: function(result) {
                $('#overlay').fadeOut();
                swal("Oops..", result.responseJSON.message, "error");
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });
    }

    companyPageElementHide = function() {
        $('#company-profile').hide();

        $('#cancel_company_address_detail').trigger('click');

        $('#cancel_office_phone_number').trigger('click');

        $('#cancel_website_url').trigger('click');
    }

    updateCompanyPageData = function(result) {
        // Profile Section
        $('#company-profile').show();


        $('#company_number').hide();

        $('#cancel_company_address_detail').trigger('click');

        $('#cancel_office_phone_number').trigger('click');

        $('#cancel_website_url').trigger('click');

        $('#cancel_existing_supplier').trigger('click');

        $('#cancel_supplier_verification_message').trigger('click');

        $('#cancel_invoice_result_message').trigger('click');

        $('#cancel_onboarding_message').trigger('click');

        if (result.companyNumber) {
            $('#company_number').show();
            $('#edit_company_number').hide();
        }

        if (result.isVatNumberVerified) {
            $('#vat_number').show();
            $('#edit_vat_number').hide();
        }

        if (result.isBankNumberVerified) {
            $('#bank_number').show();
            $('#edit_bank_number').hide();
        }

        $('#company-name').html(result.companyName);
        $('#account-number').html(result.accountNumber);
        $('#vat-number').html(result.vatNumber);
        $('#company-number').html(result.companyNumber);
        $('#companyAddress1').html(result.address1);
        $('#companyAddress2').html(result.address2);
        $('#companyPostCode').html(result.postCode);
        $('#companyCity').html(result.city);
        $('#companyCountry').html(result.country);

        $('#office-phone-number').html(result.phoneNumber);
        $('#iban_number').html(result.iBanNumber);
        $('#onboarding-message').html(result.onboardingMessage);
        $('#invoice-result-message').html(result.invoiceResultMessage);
        $('#supplier-verification-message').html(result.supplierVerificationMessage);
        $('#existing-supplier-message').html(result.existingSupplierMessage);
        $('#companyWebsiteUrl').html(result.websiteUrl);

        $('#show_onboarding_mail_subject').html(result.onboardingSubject);
        $('#show_invoice_result_mail_subject').html(result.invoiceResultSubject);
        $('#show_supplier_verification_mail_subject').html(result.supplierVerificationSubject);
        $('#show_existing_supplier_mail_verification').html(result.existingSupplierSubject);

        $('#companyWebsiteUrl').attr('href', result.websiteUrl);
    }

    $('#edit_user_info').click(function() {
        $('#user_info').hide();
        $('#user_info_edit').show();
    })

    $('#cancel_user_info').click(function() {
        $('#user_info').show();
        $('#user_info_edit').hide();
    })

    $('#save_user_info').click(function() {


        updateUserData({
            'name': $('input[name=name]').val(),
            'email': $('input[name=email]').val(),
            'contact_number': $('input[name=contact_number]').val(),
            'password': $('input[name=password]').val(),
            'password_confirmation': $('input[name=password_confirmation]').val()

        });
        $('input[name=password]').val('');
        $('input[name=password_confirmation]').val('');
    })

    updateUserData = function(requestData) {
        $.ajax({
            url: "{{route('users.update')}}",
            type: 'POST',
            data: requestData,
            success: function(result) {
                $('#overlay').fadeIn();
                swal("Success", result.message, "success");
                $('#user-name').html(result.user.name);
                $('#user-email').html(result.user.email);
                $('#user-contact-number').html(result.user.contact_number);

                $('#cancel_user_info').trigger('click');
            },
            error: function(result) {
                $('#overlay').fadeOut();
                console.log(result);
                swal("Oops..", result.responseJSON.message, "error");
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });
    }

    $('#editCompanyNumber').click(function() {
        $('#company_number').hide();
        $('#cancelVerifyCompanyNumber').show();
        $('#edit_company_number').show();
    });

    $('#cancelVerifyCompanyNumber').click(function() {
        $('#edit_company_number').hide();
        $('#company_number').show();
    })

    $('#editVatNumber').click(function() {
        $('#vat_number').hide();
        $('#edit_vat_number').show();
        $('#cancelVerifyVatNumber').show()
    })

    $('#cancelVerifyVatNumber').click(function() {
        $('#vat_number').show();
        $('#edit_vat_number').hide();
    })

    $('#editIbanNumber').click(function() {
        $('#bank_number').hide();
        $('#edit_bank_number').show();
        $('#cancel_iban_number').show()
    })

    $('#cancel_iban_number').click(function() {
        $('#bank_number').show();
        $('#edit_bank_number').hide();
    })
</script>

<script>

    //Default subscription price display when page load
    $(document).ready(function(){        
        $.each($('.brngbx'), function(){
            var price = $(this).find(':selected').data('price');
            $(this).find('.plan-price').text(price);
            
        });

        var totalPrice = 0;
        $.each($('.brngbx.blubg'), function(){
            totalPrice += parseFloat($(this).find('.plan-price').text());
        });
        totalPrice= Math.round(totalPrice * 100) / 100
        $('.price').text(totalPrice);
    });

    //Chnage price when record count change
    $('.plan_record_count').on('change', function(e){
        var price = $(this).find(':selected').data('price');
        $(this).parents('.brngbx').find('.plan-price').text(price);
    });

    $('.brngbx').on('click', function() {
        $('.select-subscription').text('');

        if ($(this).hasClass('blubg')) {
            $(this).removeClass('blubg');
            $(this).find('h2').text('');
        } else {
            $(this).addClass('blubg');
            $(this).find('h2').text('Your subscription');
        }

        //set text when unselect all the subscription
        var flag = 1;
        $.each($('.brngbx'), function(){
            if ($(this).hasClass('blubg')) {
                flag = 0;
            }
        });       

        if (flag) {
            $('.select-subscription').text('Click to select subscription');
        }

        //calculating price for selected subscription
        var price = 0;
        $.each($('.brngbx.blubg'), function(){
            price += parseFloat($(this).find('span.plan-price').text());
        });
        $('.price').text(price);
    });
</script>

<script>
    const stripe = Stripe('{{env("STRIPE_KEY")}}');

    const elements = stripe.elements();
    const cardElement = elements.create('card');


    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');

    cardButton.addEventListener('click', async (e) => {

        const {
            paymentMethod,
            error
        } = await stripe.createPaymentMethod(
            'card', cardElement, {
                billing_details: {
                    name: cardHolderName.value
                }
            }
        );

        if (error) {
            if (error.code == "parameter_invalid_empty") {
                swal("Oops..", 'Please enter the card holder name', "error");
            } else {
                swal("Oops..", error.message, "error");
            }
        } else {
            var isAutoTopUp = $(".autotopup").is(":checked") ? 1 : 0;
            var price = 0;
            var planDetails = [];
            var i = 0;
            $.each($('.brngbx.blubg'), function(){
                price += parseFloat($(this).find('span.plan-price').text());                
                var attrs = {
                    'subPlanId' : $(this).find('input[name=subPlanId]').val(),
                    'subPlanRecordId' : $(this).find(':selected').val()
                };
                planDetails[i++] = attrs;
               
            });
            var requestData = {
                'planDetails': planDetails,
                'paymentMethodId': paymentMethod.id,
                'isAutoTopUp': isAutoTopUp,
                'totalAmount': price
            };
            console.log(requestData);
            $('#overlay').fadeIn();

            $.ajax({
                url: "{{route('users.payment-plan')}}",
                type: 'POST',
                data: requestData,
                success: function(result) {
                    console.log(result);
                    $('#overlay').fadeOut();
                    swal("Success", result.message, "success");
                    // window.location.reload();
                },
                error: function(result) {
                    $('#overlay').fadeOut();
                    swal("Oops..", result.responseJSON.message, "error");
                }
            });
        }
    });
</script>

@if(request()->get('billing'))
<script>
    $('a[data-id=user-management-tab]').removeClass('active-a');
    $('div[data-id=user-management-tab]').removeClass('tab-active');
    $('a[data-id=billing-information-tab]').addClass('active-a');
    $('div[data-id=billing-information-tab]').addClass('tab-active');
</script>

@endif