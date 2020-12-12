@extends('layouts.app-2')

@section('styles')

@endsection

@section('content')


<div class="row">

    <div class="col-lg-12 mt-mbl">
        <div class="dash_main_container sm-hgt">

            <div class="inrcontsec tab-content-sec">
                <div class="tab-menu">
                    <ul>
                        <li><a href="javascript:void(0);" class="tab-a active-a" data-id="user-management-tab">User Management</a></li>
                        <li><a href="javascript:void(0);" class="tab-a" data-id="billing-information-tab">Billing Information</a></li>
                        <li><a href="javascript:void(0);" class="tab-a" data-id="sync-slient-tab">Sync client </a></li>
                    </ul>
                </div>
                @include('manage.settings.user-management')
                @include('manage.settings.billing-information')
                @include('manage.settings.sync-client')
                <!-- @include('manage.settings.bronze-pricing-plan-modal')
                @include('manage.settings.silver-pricing-plan-modal')
                @include('manage.settings.gold-pricing-plan-modal')
                @include('manage.settings.enterprise-pricing-plan-modal')
                @include('manage.settings.payment-modal')
                @include('manage.settings.payment-information-modal') -->
            </div>
        </div>
    </div>
</div>



@endsection


@section('scripts')
@include('manage.settings.user-management-script')
@endsection