@extends('layouts.app')

@section('content')

<div class="row position-relative">

    <div class="col-xl-3 check-accounting-button">
        <div class="acnt_chk_sec">

            <a href="javascript:void(0);" id="checkAccountingForMautic" class="btn_chk_ac mt-0 mb-1 mr-0 mt-n1" >Check accounting</a>
            <div class="ac_flx accntngBrdr" style="display: none;">
                <button type="button" class="close ttCls">
                    <img src="{{asset('assets/images/close.svg')}}" alt="">
                </button>
                <div class="ac_cn">
                    <p>Automatically check accounts one time per week. tick to start.</p>
                    <p class="pb-0">If you sync your invoices or upload journals our system is protecting your bank payments if you use our <span>SafePay</span> system.</p>
                </div>
                <div class="ac_chk">
                    <label class="chkcn">One
                        <input type="checkbox" class="account_sync" name="account_sync" {{ $accountData['accountingSync'] ? 'checked' : ''}}>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="acnt_chk col-md-3 d-table mb-0">Accounting check</div>
        <div class="hd_border h-auto"></div>
        <div class="row">
            <div class="col-xl-9">
                <div class="inco_box">
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="inco_box_cn">
                                €{{$accountData['revenue']}}
                                <span>Revenue</span>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="inco_box_cn">
                                €{{$accountData['profitOrLoss']}}
                                <span>+Profit/Loss</span>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="inco_box_cn">
                                {{$accountData['noOfRecords']}}
                                <span>No. of Records</span>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="inco_box_cn">
                                <ul>
                                    <li><span>No. of Sales Invoice</span><span>{{$accountData['noOfSalesInvoice']}}</span></li>
                                    <li><span>No. of Supplier Invoices</span><span>{{$accountData['noOfSuppliersInvoice']}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="inco_box_cn {{$accountData['crossBgColorClass']}}">
                                {{$accountData['crossBgColorClass'] == 'redbg' ? 'WARNING' : 'GOOD' }}
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="inco_box_cn {{$accountData['countWeekendInvoice'] > 2 ? 'redbg' : 'greenbg'}}">
                                {{$accountData['countWeekendInvoice']}}
                                <span>Weekend Invoices</span>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="inco_box_cn {{$accountData['zScoreBgColor']}}">
                                {{$accountData['zScore']}}
                                <span>Cross Score</span>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="inco_box_cn {{$accountData['devianceInvoiceBgColor']}}">
                                {{$accountData['devianceInvoice']}}
                                <span>Deviance in invoices</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mid_graph_section">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mid_graph_holder">
                                <span id="cash-flow">FusionCharts will render here</span>
                                <h3>Cash Flow Per Month</h3>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="mid_graph_holder2">
                                <span id="revenue-chart-container">FusionCharts will render here</span>
                                <h3>Revenue Per Month</h3>
                            </div>
                            <div class="mid_graph_holder2">
                                <span id="profitOrLoss-chart-container2">FusionCharts will render here</span>
                                <h3>Profit Per Month</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@include('manage.detector.account-sync-modal')
@endsection

@section('scripts')
<script>
    function modelPopupOpen(url) {
        window.open(url, 'deepcheckConnectors',
            'location=no,width=600,height=600,scrollbars=yes,top=100,left=700,resizable = no')
    }

    $(window).on('load', function() {

        if (isLoginChecked == 1) {
            if (subscriptionDetector == 1 && !cookieDetector) {
                openSubscriptionCheckModal(
                    'You only have <strong>1</strong> Detector checks left',
                    'DetectorSubscription'
                );
            }
        }
    });

    $('#checkAccountingForMautic').on('click', function() {        
        $.ajax({
            url: "{{route('detector.checkAccountingForMautic')}}",
            type: 'GET',

            success: function(result) {
                $('#overlay').fadeOut();
                $('#checkaccounting1').modal('show');
            },
            error: function(data) {
                $('#overlay').fadeOut();
                swal("Oops..", 'Mautic api not working', "error");
            },
            beforeSend: function() {
                $('#overlay').fadeIn();
            },
            complete: function() {
                $('#overlay').fadeOut();
            }
        });
    });

    $(document).ready(function() {
        $(".btn_chk_ac").hover(function() {
            $('.ac_flx').show();
        }, function() {
            // $('.ac_flx').hide();
        });

        $('input[name="account_sync"]').change('click', function() {
            isAccountingSync = $(this).prop('checked');

            $.ajax({
                url: "{{route('detector.accountingSync')}}",
                type: 'POST',
                data: {
                    isAccountingSync: isAccountingSync
                },

                success: function(result) {
                    $('#overlay').fadeOut();
                    swal("Success", result.message, "success");
                },
                error: function(data) {
                    $('#overlay').fadeOut();
                    result = jQuery.parseJSON(data.responseText);
                    swal("Oops..", result.message, "error");
                },
                beforeSend: function() {
                    $('#overlay').fadeIn();
                },
                complete: function() {
                    $('#overlay').fadeOut();
                }
            });
        });

        $(".ttCls").on("click", function() {
            $('.ac_flx').hide();
        });

        $("#cash-flow").insertFusionCharts({
            type: 'column2d',
            id: 'chart25',
            width: '100%',
            height: '300',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "chartLeftMargin": "0",
                    "chartRightMargin": "0",
                    "chartBottomMargin": "0",
                    "yAxisName": "Cash Flow",
                    "yAxisMaxValue": "100000",
                    "placevaluesInside": "0",
                    "valueFontColor": "000000",
                    "palettecolors": "008ae6",
                    "rotateValues": "0",
                    "showValues": "1",
                    "showLegend": "1",
                    "divLineAlpha": "30",
                    "theme": "zune"
                },
                "data": @php echo $accountData["monthWiseCashFlow"] @endphp
            }
        });

        $("#revenue-chart-container").insertFusionCharts({
            type: 'mscombi2d',
            id: 'chart35',
            width: '100%',
            height: '150',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "palette": "2",
                    "showvalues": "0",
                    "yAxisMaxValue": "10000",
                    "numDivLines": "2",
                    "plotfillalpha": "20",
                    "lineThickness": "4",
                    "divlinealpha": "20",
                    "formatnumberscale": "0",
                    "showlegend": "0",
                    "labelStep": "6",
                    "palettecolors": "008ae6",
                    "labelDisplay": "NONE",
                    "chartLeftMargin": "10",
                    "chartRightMargin": "10",
                    "chartBottomMargin": "10",
                    "yAxisValuesPadding": "10",
                    "plotToolText": "<div><b>$label, <br/>Total Hits: $datavalue</b></div>",
                    "theme": "zune"
                },
                "categories": [{
                    'category': @php echo $accountData["monthWiseRevenue"]['months'] @endphp
                }],
                "dataset": [{
                        "seriesname": "Sessions",
                        "renderas": "Area",
                        "data": @php echo $accountData["monthWiseRevenue"]['revenue'] @endphp
                    },
                    {
                        "seriesname": "Sessions",
                        "renderas": "Line",
                        "color": "0075C2",
                        "anchorRadius": "3",
                        "anchorBgColor": "008ae6",
                        "data": @php echo $accountData["monthWiseRevenue"]['revenue'] @endphp
                    }
                ]
            }
        });

        $("#profitOrLoss-chart-container2").insertFusionCharts({
            type: 'mscombi2d',
            id: 'chart36',
            width: '100%',
            height: '150',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "palette": "2",
                    "showvalues": "0",
                    "yAxisMaxValue": "10000",
                    "numDivLines": "2",
                    "plotfillalpha": "20",
                    "lineThickness": "4",
                    "divlinealpha": "20",
                    "formatnumberscale": "0",
                    "showlegend": "0",
                    "labelStep": "6",
                    "palettecolors": "008ae6",
                    "labelDisplay": "NONE",
                    "chartLeftMargin": "10",
                    "chartRightMargin": "10",
                    "chartBottomMargin": "10",
                    "yAxisValuesPadding": "10",
                    "plotToolText": "<div><b>$label, <br/>Total Hits: $datavalue</b></div>",
                    "theme": "zune"
                },
                "categories": [{
                    'category': @php echo $accountData["monthWiseProfitOrLoss"]['months'] @endphp
                }],
                "dataset": [{
                        "seriesname": "Sessions",
                        "renderas": "Area",
                        "data": @php echo $accountData["monthWiseProfitOrLoss"]['profitOrLoss'] @endphp
                    },
                    {
                        "seriesname": "Sessions",
                        "renderas": "Line",
                        "color": "0075C2",
                        "anchorRadius": "3",
                        "anchorBgColor": "008ae6",
                        "data": @php echo $accountData["monthWiseProfitOrLoss"]['profitOrLoss'] @endphp
                    }
                ]
            }
        });


    });
</script>
@endsection