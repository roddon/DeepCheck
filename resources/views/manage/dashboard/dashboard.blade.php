@extends('layouts.app')

@section('content')
<div class="top_title text-center">Health Check</div>
<div class="dash_top_section">
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="dash_top_box">
                <h3>Invoices</h3>
                <div class="chat_con">
                    <div class="arrow_up">
                        <img src="{{asset('assets/images/arrow_grn_up.png')}}" alt="">
                    </div>
                    <div class="chart_name">
                        {{ $invoiceCount }}
                    </div>
                    <div class="chart_img">
                        <span id="invoices-chart-container"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dash_top_box">
                <h3>False Documents</h3>
                <div class="chat_con">
                    <div class="arrow_up">
                        <img src="{{ asset('assets/images/arrow_2.png') }}" alt="">
                    </div>
                    <div class="chart_name">
                        {{ $falseDocumentsCount }}
                    </div>
                    <div class="chart_img">
                        <span id="false-document-container"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dash_top_box">
                <h3>Suppliers not verified</h3>
                <div class="chat_con">
                    <div class="arrow_up">
                        <img src="{{ asset('assets/images/arrow_3.png') }}" alt="">
                    </div>
                    <div class="chart_name">
                        {{ $notVerifiedSupplierCount }}
                    </div>
                    <div class="chart_img">
                        <span id="supplier-not-verified-container"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dash_top_box">
                <h3>Savings</h3>
                <div class="chat_con">
                    <div class="arrow_up">
                        <img src="assets/images/arrow_4.png" alt="">
                    </div>
                    <div class="chart_name">
                        {{ $savingsCount }}
                    </div>
                    <div class="chart_img">
                        <span id="savings-count-container"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dash_section_2">
    <div class="row">
        <div class="col-xl-3">
            <div class="chk_sec">
                @php
                $dashboardStatusText = 'GOOD';
                $dashboardStatusImage = 'assets/images/green-tick.png';
                if($dashboardStatus == 1){
                $dashboardStatusText = 'ALERT';
                $dashboardStatusImage = 'assets/images/red-tick.png';
                }elseif($dashboardStatus == 2){
                $dashboardStatusText = 'ALERT';
                $dashboardStatusImage = 'assets/images/yellow-tick.png';
                }
                @endphp
                <div class="grn_chk">
                    <img src="{{asset($dashboardStatusImage)}}" width="132" alt="">
                </div>
                <div class="chk_txt">
                    <h3>
                        <span> {{ $dashboardStatusText }}</span>
                        Company fraud health<br>

                        @if($lastDetection > 0)
                        Last detection {{$lastDetection}} days ago
                        @elseif($maxDate)
                        Last detection is today
                        @endif
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="dash_bar_con">
                @php
                    $liveProtectClass = $notPaidInvoiceCount ? 'bar_color_4' : 'bar_color_1';
                    $liveProtectImage = $notPaidInvoiceCount ? 'assets/images/tick_4.png' : 'assets/images/tick_1.png';
                    $liveProtectText = $notPaidInvoiceCount ? "<a class='dash_bar_coment_a' href=" . route('liveProtect.index') .">Immediate actions</a>" : 'No Risk';
                    $safePayTitle = 'SafePay';
                    $safepayBarBoxClass = '';

                    if (!$checkUserPurchasedPlan['includeSafePayout']){
                        $liveProtectClass = 'disablePlan';
                        $liveProtectText = 'Not used';
                        $safePayTitle = 'SafePay<span class="no-sub ml-1">no subscription</span>';
                        $safepayBarBoxClass = 'disablePlan';
                        $liveProtectImage = 'assets/images/no-plan.png';
                    }
                @endphp

                <div class="dash_bar_holder {{ $liveProtectClass }}">
                    <div class="dash_banr_icon"><img src="{{ asset('assets/images/nav_icon_5.png') }}" alt=""></div>
                    <div class="dash_bar_title">{!! $safePayTitle !!}</div>
                    <div class="dash_bar_coment"> {!! $liveProtectText !!} </div>
                    <div class="dash_bar_action"><img src="{{ $liveProtectImage }}" alt=""></div>
                </div>

                @php
                $invoiceClass = 'bar_color_1';
                $invoiceImage = 'assets/images/tick_1.png';
                $invoiceText = 'No Risk';
                $invoiceTitle = 'Check Invoice';
                $invoiceBarBoxClass = '';

                if($falseDocumentsCount){
                    $invoiceClass = 'bar_color_4';
                    $invoiceImage = 'assets/images/tick_4.png';
                    $invoiceText = "<a class='dash_bar_coment_a' href=" . route('invoice.index') .">Immediate actions</a>";
                }elseif($checktextInvoiceInvoicesCount){
                    $invoiceClass = 'bar_color_2';
                    $invoiceImage = 'assets/images/tick_2.png';
                    $invoiceText = 'Attention needed';
                }

                if (!$checkUserPurchasedPlan['includeInvoiceCheck']){
                    $invoiceClass = 'disablePlan';
                    $invoiceText = 'Not used';
                    $invoiceTitle = 'Check Invoice<span class="no-sub ml-1">no subscription</span>';
                    $invoiceBarBoxClass = 'disablePlan';
                    $invoiceImage = 'assets/images/no-plan.png';
                }

                @endphp
                <div class="dash_bar_holder {{ $invoiceClass }}">
                    <div class="dash_banr_icon"><img src="{{ asset('assets/images/nav_icon_3.png') }}" alt=""></div>
                    <div class="dash_bar_title">{!! $invoiceTitle !!}</div>
                    <div class="dash_bar_coment">{!! $invoiceText !!}</div>
                    <div class="dash_bar_action"><img src="{{ asset($invoiceImage) }}" alt=""></div>
                </div>

                @php
                $supplierClass = 'bar_color_1';
                $supplierImage = 'assets/images/tick_1.png';
                $supplierText = 'No Risk';
                $supplierTitle = 'Supplier Verification';
                $supplierBarBoxClass = '';

                if($failedVerificationSupplierCount){
                    $supplierClass = 'bar_color_4';
                    $supplierImage = 'assets/images/tick_4.png';
                    $supplierText = "<a class='dash_bar_coment_a' href=" . route('invoice.index') .">Immediate actions</a>";
                }elseif($notVerifiedSupplierCount){
                    $supplierClass = 'bar_color_2';
                    $supplierImage = 'assets/images/tick_2.png';
                    $supplierText = 'Attention needed';
                }

                if (!$checkUserPurchasedPlan['includeSupplierCheck']){
                    $supplierClass = 'disablePlan';
                    $supplierText = 'Not used';
                    $supplierTitle = 'Supplier Verification<span class="no-sub ml-1">no subscription</span>';
                    $supplierBarBoxClass = 'disablePlan';
                    $supplierImage = 'assets/images/no-plan.png';
                }

                @endphp


                <div class="dash_bar_holder {{ $supplierClass }}">
                    <div class="dash_banr_icon"><img src="{{ asset('assets/images/nav_icon_3.png') }}" alt=""></div>
                    <div class="dash_bar_title">{!! $supplierTitle !!}</div>
                    <div class="dash_bar_coment"> {!! $supplierText !!} </div>
                    <div class="dash_bar_action"><img src="{{ asset($supplierImage) }}" alt=""></div>
                </div>

                @php

                $detectorClass = 'bar_color_1';
                $detectorImage = 'assets/images/tick_1.png';
                $detectorText = 'No Risk';
                $detectorTitle = 'Detector';
                $detectorBarBoxClass = '';

                if($detectorStatus){
                    $detectorClass = 'bar_color_4';
                    $detectorImage = 'assets/images/tick_4.png';
                    $detectorText = "<a class='dash_bar_coment_a' href=" . route('detector.accountingCheck') .">Immediate actions</a>";
                }

                if (!$checkUserPurchasedPlan['includeDetector']){
                    $detectorClass = 'disablePlan';
                    $detectorText = 'Not used';
                    $detectorTitle = 'Detector<span class="no-sub ml-1">no subscription</span>';
                    $detectorBarBoxClass = 'disablePlan';
                    $detectorImage = 'assets/images/no-plan.png';
                }

                @endphp

                <div class="dash_bar_holder {{ $detectorClass }}">
                    <div class="dash_banr_icon"><img src="{{ asset('assets/images/nav_icon_4.png') }}" alt=""></div>
                    <div class="dash_bar_title">{!! $detectorTitle !!}</div>
                    <div class="dash_bar_coment">{!!$detectorText !!} </div>
                    <div class="dash_bar_action"><img src="{{ asset($detectorImage) }}" alt=""></div>
                </div>


                @php
                    $onboardingClass = $notVerifiedCustomerCount ? 'bar_color_4' : 'bar_color_1';
                    $onboardingImage = $notVerifiedCustomerCount ? 'assets/images/tick_4.png' : 'assets/images/tick_1.png';
                    $onboardingText = $notVerifiedCustomerCount ? "<a class='dash_bar_coment_a' href=" . route('onboarding.index') .">Immediate actions</a>" : 'No Risk';
                    $onboardingTitle = 'Onboarding';
                    $onboardingBarBoxClass = '';

                    if (!$checkUserPurchasedPlan['includeOnboarding']){
                        $onboardingClass = 'disablePlan';
                        $onboardingText = 'Not used';
                        $onboardingTitle = 'Onboarding<span class="no-sub ml-1">no subscription</span>';
                        $onboardingBarBoxClass = 'disablePlan';
                        $onboardingImage = 'assets/images/no-plan.png';
                    }

                @endphp
                <div class="dash_bar_holder {{ $onboardingClass }}">
                    <div class="dash_banr_icon"><img src="{{ asset('assets/images/nav_icon_2.png') }}" alt=""></div>
                    <div class="dash_bar_title">{!! $onboardingTitle !!}</div>
                    <div class="dash_bar_coment">{!! $onboardingText !!}</div>
                    <div class="dash_bar_action"><img src="{{ asset($onboardingImage) }}" alt=""></div>
                </div>

            </div>
        </div>
        <div class="col-xl-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="bar_box">
                        {{$totalInvoiceCount}} <span>Total</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bar_box">
                        {{ $onboardingBarBoxClass ? 0 : $customerCount }} <span>Onboarding</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bar_box">
                        {{ $invoiceBarBoxClass ? 0 : $allInvoiceCount }} <span>Check Invoice</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bar_box">
                        {{ $supplierBarBoxClass ? 0 : $supplierCount }} <span>Supplier Verification</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bar_box">
                        {{$safepayBarBoxClass ? 0 : $paidInvoiceCount}} <span>SafePay</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bar_box">
                        {{ $detectorBarBoxClass ? 0 : $detectorCount }} <span>Detector</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dash_section_3">
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Log</th>
                    <th class="text-center">Date/Time</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                <tr>
                    <td class="micro"><img src="{{asset('assets/images/micro_icon.png')}}" alt=""> {{ $activity->name }}</td>
                    <td class="text-center">{{ optional($activity->country)->name }}</td>
                    <td class="text-center">{{ $activity->log }}</td>
                    <td class="text-center"> {{ $activity->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">{{ $activity->type }}</td>
                    <td class="text-center success">{{ $activity->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


@section('scripts')
@include('manage.dashboard.scripts')
@endsection