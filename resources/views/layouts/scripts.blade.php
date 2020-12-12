@include('layouts.subscription-modal')
@include('layouts.download-app-modal')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="{{ asset('assets/js/popper.min.js')}}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script src="https://kit.fontawesome.com/7972fb5649.js" crossorigin="anonymous"></script>

<script type="text/javascript" src="{{ asset('assets/fusioncharts/fusioncharts.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/fusioncharts/themes/fusioncharts.theme.zune.js?cacheBust=56')}}"></script>
<script type="text/javascript" src="{{ asset('assets/fusioncharts/fusioncharts.jqueryplugin.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/data.js')}}"></script>
<script src='https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js'></script>
<script src='https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js'></script>
<!-- <script src="{{ asset('assets/dropify/dist/js/dropify.min.js')}} "></script> -->
<script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script type="text/javascript" src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>

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

    var cookieSafePay = getCookie('safePaySubscription');
    var cookieDetector = getCookie('DetectorSubscription');
    var cookieOnboarding = getCookie('OnboardingSubscription');
    var cookieInvoiceCheck = getCookie('InvoiceCheckSubscription');
    var cookieSupplierVerification = getCookie('SupplierVerificationSubscription');
</script>

<script type="text/javascript">
    var subscriptionOnboarding = "{{isset($subscriptionOnboarding) ?  $subscriptionOnboarding : 0}}";
    var subscriptionDetector = "{{isset($subscriptionDetector) ?  $subscriptionDetector : 0}}";
    var subscriptionSafaPay = "{{isset($subscriptionSafaPay) ?  $subscriptionSafaPay : 0}}";
    var subscriptionSupplierVerification = "{{isset($subscriptionSupplierVerification) ?  $subscriptionSupplierVerification : 0}}";
    var subscriptionNoOfCheckInvoices = "{{isset($subscriptionNoOfCheckInvoices) ?  $subscriptionNoOfCheckInvoices : 0}}";

    var userSubscriptionStatus = "{{isset($userSubscriptionStatus) ? $userSubscriptionStatus : 0}}";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function onload() {
        $('#overlay').fadeIn();
    }
    var datatable = null;

    function reportWindowSize() {
        height = window.innerHeight;
        wdth = window.innerWidth;

        ext = height > 800 ? parseInt(((height - 700) / 100) - 1) : 0;
        pageLength = parseInt((height - 4) / (120)) + ext;

        $.extend(true, $.fn.dataTable.defaults, {
            pageLength: pageLength,
            order: [],
        });

        if (datatable) {
            datatable.page.len(pageLength).draw();
        }
    }

    reportWindowSize();

    window.onresize = reportWindowSize;


    $('a[name^=subscription]').click(function() {
        return subscriptionCheck();
    })

    $('#invoiceSupplierList').click(function() {
        if (userSubscriptionStatus) {
            if (isLoginChecked == 1) {
                if (subscriptionSupplierVerification == 1 && !cookieSupplierVerification) {
                    openSubscriptionCheckModal(
                        'You only have <strong>1</strong> supplier verification left',
                        'SupplierVerificationSubscription'
                    );
                }
            }
        } else {
            return subscriptionCheck();
        }
    })

    subscriptionCheck = function() {
        if (userSubscriptionStatus) {
            return true;
        }

        $('.enterprise-modal').hide();

        $('#subscription-modal').modal();

        return false;
    }

    $('#continueSubscriptionVerification').click(function() {
        $('#subscription-modal').modal('hide');

        $.ajax({
            url: "{{route('company.add-special-customer')}}",
            type: 'POST',
            success: function(result) {
                $('#overlay').fadeOut();
                $('#sp-customer-onboarding-number').html(result)
                $('#subscription-verification-modal').modal();
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


    function openSubscriptionCheckModal(text, subscriptionType) {
        $('#divSubscriptionChk').show();
        if (!subscriptionType) {
            $('#divSubscriptionChk').hide();
        }
        $('#hidSubscriptionType').val(subscriptionType);

        $('#subscription-check-text').html(text);
        $('#subscription-check-modal').modal();
    }


    function safePayCheck() {
        if (subscriptionSafaPay > 0) {
            return true;
        } else {
            openSubscriptionCheckModal('You have no safePay checks left');
            return false;
        }
    }

    isLogin = "{{ isset($userLogin) ? $userLogin : 0 }}";

    var isLoginChecked = getCookie('isLoginChecked');


    $('#closeLoginNotificationPopup').click(function() {

        checked = $('#chkLoginSubscriptionModal').is(':checked');
        eraseCookie('isLoginChecked')
        if (checked) {
            setCookie('isLoginChecked', '1', '1');
        }

        $('#subscription-login-modal').modal('hide');
    });

    $('#btnContinueSubscription').click(function() {
        subscriptionType = $('#hidSubscriptionType').val();
        checked = $('#chkSubscriptionModal').is(':checked');
        if (checked) {
            setCookie(subscriptionType, '1', '1');
        }
        window.location.href = "{{ route('settings.edit') . '?billing=1' }}";
    })
</script>
