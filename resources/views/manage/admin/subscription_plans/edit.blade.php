@extends('layouts.admin.app')


@section('content')
<div class="top_title">{{__('common.update')}} {{__('subscription_plan.page_title')}}</div>
<div class="row mt-5">
    <div class="col-lg-6 custom-subsciption">
        <form action="{{route('admin.subscription_plans.update',['id'=>$subscription->id])}}" method="POST" class="mnlform">
            @CSRF
            @method('patch')
            <div class="frmbx">
                <label>{{__('subscription_plan.name')}}</label>
                <input type="text" name="name" value="{{old('name')??$subscription->name}}">
            </div>
            <div class="frmbx">
                <label>{{__('subscription_plan.description')}}</label>
                <textarea name="description" class="textarea_frmbx">{{old('description')??$subscription->description}}</textarea>
            </div>
            <div class="frmbx">
                <label>Trial days</label>
                <input type="text" name="trial_days" value="{{old('trial_days')??$subscription->trial_days}}">
            </div>
            <div class="frmbx">
                <label>Trial documents</label>
                <input type="text" name="trial_days_doc_numbers" value="{{old('trial_days_doc_numbers')??$subscription->trial_days_doc_numbers}}">
            </div>
            <div class="frmbx">
                <label>Include check invoice</label>
                <input type="checkbox" name="include_check_invoice" {{ $subscription->include_check_invoice ? 'checked' : '' }}>
            </div>
            <div class="frmbx">
                <label>Include supplier check</label>
                <input type="checkbox" name="include_supplier_check" {{ $subscription->include_supplier_check ? 'checked' : '' }}>
            </div>
            <div class="frmbx">
                <label>Include safepay</label>
                <input type="checkbox" name="include_safe_payout" {{ $subscription->include_safe_payout ? 'checked' : '' }}>
            </div>
            <div class="frmbx">
                <label>Include detector records</label>
                <input type="checkbox" name="include_detector_records" {{ $subscription->include_detector_records ? 'checked' : '' }}>
            </div>
            <div class="frmbx">
                <label>Include onboarding</label>
                <input type="checkbox" name="include_onboarding" {{ $subscription->include_onboarding ? 'checked' : '' }}>
            </div>
            <div class="frmbx">
                <label>Background color for plan</label>
                <input type="color" name="bg_color" value="{{old('bg_color')??$subscription->bg_color}}">
            </div>

            <div class="list_wrapper">
                @php
                    $i = 0;
                @endphp
                @foreach($planRecords as $record)
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            {{$i == 0 ? 'Subscription count' : ''}}
                            <input name="planRecords[{{$i}}][no_of_records_count]" type="text" value="{{$record->no_of_records_count}}" placeholder="Allow no of count" class="form-control"/>                            
                        </div>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5">
                        <div class="form-group">
                            {{$i == 0 ? 'Price' : ''}}
                            <input autocomplete="off" name="planRecords[{{$i}}][price]" type="text" value="{{$record->price}}" placeholder="Price" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1">
                        @if($i == 0) 
                            <br>
                            <button class="btn btn-primary list_add_button" type="button">+</button>
                        @else
                            <a href="javascript:void(0);" class="list_remove_button btn btn-danger">-</a>
                        @endif
                    </div>
                </div>
                @php $i++ @endphp
                @endforeach
            </div>

            <div class=" text-center mt-5">
                <input type="submit" value="Submit" class="invite">
                <a type="submit" value="Cancel" class="invite bg-danger" href="{{route('admin.subscription_plans.index')}}" >{{__('common.cancel')}}</a>
            </div>
        </form>
    </div>
    @endsection
@section('scripts')
    @include('manage.admin.subscription_plans.script')
@endsection