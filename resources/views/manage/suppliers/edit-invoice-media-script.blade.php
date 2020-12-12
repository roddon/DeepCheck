<script>
    $('#vatNumber').dblclick(function(){
        $(this).hide();
        $('.vatNumber').show();
    });

    $('#city').dblclick(function(){
        $(this).hide();
        $('.city').show();
    });

    $('#country').dblclick(function(){
        $(this).hide();
        $('.country').show();
    });

    $('#total').dblclick(function(){
        $(this).hide();
        $('.total').show();
    });

    $('#address1').dblclick(function(){
        $(this).hide();
        $('.address1').show();
    });

    $('#address2').dblclick(function(){
        $(this).hide();
        $('.address2').show();
    });

    $('#email').dblclick(function(){
        $(this).hide();
        $('.email').show();
    });

    $('#phone').dblclick(function(){
        $(this).hide();
        $('.phone').show();
    });

    $('#web').dblclick(function(){
        $(this).hide();
        $('.web').show();
    });
    
    $('#tax').dblclick(function(){
        $(this).hide();
        $('.tax').show();
    });

    $('#listItem').dblclick(function(){
        $(this).hide();
        $('.listItem').show();
    });

    $('.edit-line-item').click(function() {
        items = $('.listItem input').serialize();

        $.ajax({
            url: "{{route('sVault.supplier.update-invoice-media-items')}}",
            type: 'POST',
            data: items,
            contentType: "application/x-www-form-urlencoded",
            success: function(result) {
                $('#overlay').fadeOut();
                $('.listItem').hide();
                $('#listItem').show();
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

    $('.edit-vat').click(function() {
        VAT_Number = $('input[name=VAT_Number]').val();
        mediaId = $('input[name=mediaId]').val();

        if ($.trim(VAT_Number) == '') {
            return false;
        }

        updateInvoiceMedia({
            VAT_Number: VAT_Number,
            mediaId: mediaId
        });

        $('.vatText').addClass('changedText');
    })

    $('.edit-city').click(function() {
        city = $('input[name=city]').val();
        mediaId = $('input[name=mediaId]').val();

        if ($.trim(city) == '') {
            return false;
        }

        updateInvoiceMedia({
            city: city,
            mediaId: mediaId
        });

        $('.cityText').addClass('changedText');
    })

    $('.edit-country').click(function() {
        Country = $('input[name=Country]').val();
        mediaId = $('input[name=mediaId]').val();

        if ($.trim(Country) == '') {
            return false;
        }

        updateInvoiceMedia({
            Country: Country,
            mediaId: mediaId
        });

        $('.countryText').addClass('changedText');
    })

    $('.edit-total').click(function() {
        Total_price = $('input[name=Total_price]').val();
        mediaId = $('input[name=mediaId]').val();

        if ($.trim(Total_price) == '') {
            return false;
        }

        updateInvoiceMedia({
            Total_price: Total_price,
            mediaId: mediaId
        });

        $('.totalText').addClass('changedText');
    })

    $('.edit-address1').click(function() {
        address1 = $('input[name=address1]').val();
        mediaId = $('input[name=mediaId]').val();

        if ($.trim(address1) == '') {
            return false;
        }

        updateInvoiceMedia({
            address1: address1,
            mediaId: mediaId
        });

        $('.address1Text').addClass('changedText');
    })

    $('.edit-address2').click(function() {
        address2 = $('input[name=address2]').val();
        mediaId = $('input[name=mediaId]').val();

        if ($.trim(address2) == '') {
            return false;
        }

        updateInvoiceMedia({
            address2: address2,
            mediaId: mediaId
        });

        $('.address2Text').addClass('changedText');
    })

    $('.edit-email').click(function() {
        Email = $('input[name=Email]').val();
        mediaId = $('input[name=mediaId]').val();

        if ($.trim(Email) == '') {
            return false;
        }

        updateInvoiceMedia({
            Email: Email,
            mediaId: mediaId
        });

        $('.emailText').addClass('changedText');
    })

    $('.edit-phone').click(function() {
        phone = $('input[name=phone]').val();
        mediaId = $('input[name=mediaId]').val();

        if ($.trim(phone) == '') {
            return false;
        }

        updateInvoiceMedia({
            phone: phone,
            mediaId: mediaId
        });

        $('.phoneText').addClass('changedText');
    })

    $('.edit-web').click(function() {
        web = $('input[name=web]').val();
        mediaId = $('input[name=mediaId]').val();

        if ($.trim(web) == '') {
            return false;
        }

        updateInvoiceMedia({
            web: web,
            mediaId: mediaId
        });

        $('.webText').addClass('changedText');
    })

    $('.edit-tax').click(function() {
        tax = $('input[name=tax]').val();
        mediaId = $('input[name=mediaId]').val();

        if ($.trim(tax) == '') {
            return false;
        }

        updateInvoiceMedia({
            tax: tax,
            mediaId: mediaId
        });

        $('.taxText').addClass('changedText');
    })

    updateInvoicePageData = function (result) {
        $('.vatNumber').hide();
        $('#vatNumber').show();

        $('.city').hide();
        $('#city').show();

        $('.country').hide();
        $('#country').show();

        $('.total').hide();
        $('#total').show();

        $('.address1').hide();
        $('#address1').show();

        $('.address2').hide();
        $('#address2').show();

        $('.email').hide();
        $('#email').show();

        $('.phone').hide();
        $('#phone').show();

        $('.web').hide();
        $('#web').show();

        $('.tax').hide();
        $('#tax').show();

        $('#vatNumber').find('.vatText').text(result.corrected_VAT_number ??'');
        $('#city').find('.cityText').text(result.corrected_city??'');
        $('#country').find('.countryText').text(result.corrected_country??'');
        $('#total').find('.totalText').text(result.corrected_total_price??'');
        $('#address1').find('.address1Text').text(result.corrected_address1??'');
        $('#address2').find('.address2Text').text(result.corrected_address2??'');
        $('#email').find('.emailText').text(result.corrected_email??'');
        $('#phone').find('.phoneText').text(result.corrected_phone??'');
        $('#web').find('.webText').text(result.corrected_web??'');
        $('#tax').find('.taxText').text(result.corrected_tax??'');
    };

    updateInvoiceMedia = function(requestData) {
        $.ajax({
            url: "{{route('sVault.supplier.update-invoice-media')}}",
            type: 'POST',
            data: requestData,
            success: function(result) {
                $('#overlay').fadeOut();
                updateInvoicePageData(result.invoiceMedia)               

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

    $('.sendToAdmin').click(function(){
        mediaId = $('input[name=mediaId]').val();
        $.ajax({
            url: "{{route('sVault.supplier.send-to-admin-review')}}",
            type: 'POST',
            data: {mediaId:mediaId},
            success: function(result) {
                $('#overlay').fadeOut();
                $('.sendToAdmin').hide();
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
    });
</script>

<script>
	function fixTitle() {
    $('div.affix').each(function () {
        var $this = $(this);
        var offset = $this.offset().top;
        var scrollTop = $(window).scrollTop();

        if (scrollTop > offset) {
            $this.addClass('fixed');
        } else {
            $this.removeClass('fixed');
        }
    });
}

$(document).ready(function () {
    $(window).scroll(fixTitle);
});
</script>