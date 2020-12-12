@extends('layouts.admin.app')


@section('content')
<div class="row mb-2">
    <div class="col-md-6">
        <div class="top_title">{{__('subscription_plan.page_title')}}</div>
    </div>
    <div class="col-md-6 text-right">
        <div class="invitebtnarae ml-3 float-right">
            <a href="{{ route('admin.subscription_plans.create') }}" class="invite" id="add-new-user">{{__('common.add')}} {{__('subscription_plan.page_title')}}</a>
        </div>
        <div class="tblesrch float-right">
            <input class="form-control" id="myInput" type="text" placeholder="Search..">
        </div>
    </div>
</div>

<div class="dash_section_3 mt-3 h-95">
    <div class="row position-relative h-95">
        {{-- <div class="tblesrch"> <input class="form-control" id="myInput" type="text" placeholder="Search.."></div> --}}
        <div class="table-responsive position-relative">
            <table class="table tablefst w-100 table-hover ">
                <thead>
                    <tr>
                        <th class="border-right-0">{{__('subscription_plan.name')}}</th>
                        <th class="border-right-0">Description</th>
                        <th class="border-right-0">Trial days</th>
                        <th class="border-right-0">No of document for trial days</th>
                        <!-- <th class="border-right-0">Include check invoice</th>
                        <th class="border-right-0">Include supplier check</th>
                        <th class="border-right-0">Include safepay</th>
                        <th class="border-right-0">Include detector records</th>
                        <th class="border-right-0">Include Onboarding</th> -->
                        <th class="border-right-0">{{__('common.action')}}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection


@section('scripts')
@include('manage.admin.subscription_plans.script')
@endsection
