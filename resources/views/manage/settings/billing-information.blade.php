<div class="tab" data-id="billing-information-tab">
    <div class="inrcontsec">
        <form>
            @php $curreny = optional($company->currency)->code?:'EUR'; @endphp
            <div class="mt-3">
                <div class="allbongbx">
                    @php 
                        $totalActivePlan = $subscriptionPlans->pluck('activePlanRecordId')->filter()->unique()->count();
                    @endphp
                    <div class="select-subscription">{{$totalActivePlan == 0 ? 'Click to select subscription' : ''}}</div>
                    @foreach ($subscriptionPlans as $plan)
                    <div class="brngbx {{$plan->class}} {{$plan->activePlanId ? 'blubg' : ''}}" style="color: blue; background-color: white; border-radius: 1px; border-style: solid; border-top: 4px solid rgba(10, 10, 0, 0.6); box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.3);" data-toggle="modal" data-target="#{{$plan->name}}-Pricing-Plan">
                        <h5>{{$plan->name}}</h5>

                        <div class="parea {{$plan->description ? 'text-center' : ''}}">
                            <p> 
                                <span class="big-fnt">
                                <select class="plan_record_count">
                                    @foreach($plan->planRecords as $record)
                                    @php 
                                        $recordPrice = convertRate($record->price, 'EUR', $curreny);
                                        $selected = $record->id == $plan->activePlanRecordId ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{$record->id}}" data-price="{{$recordPrice}}" {{$selected}}>{{$record->no_of_records_count}}</option>
                                    @endforeach
                                </select>
                                </span>
                                <span>{{$plan->description}}</span>
                            </p>
                            @if($plan->trial_days)
                            <p>
                                <span class="big-fnt">{{$plan->trial_days}}</span>
                                <span>Days free trial on document {{$plan->trial_days_doc_numbers}} records</span>
                            </p>
                            @endif
                        </div>

                        <input type="hidden" value="{{$plan->id}}" name="subPlanId" class="subPlanId">
                        <!-- <p class="subscriptionId" style="display: none;">{{$plan->id}} </p> -->
                        <h6>{{$curreny}} <span class="plan-price"></span><span>/month</span></h6>
                        <h2>{{$plan->activePlanId ? 'Your subscription' : ''}}</h2>
                    </div>
                    @endforeach
                </div>

            </div>
            <hr class="row-divider">
            <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                <div class="tab-col-1 min-width-220 d-flex align-self-center">
                    <div class="tab-row-title">
                        <h5 class="font-weight-bold">Charges</h5>
                    </div>
                </div>
                <div class="tab-col-2 min-width-260">
                    <div class="tab-row-label">
                        <label class="Next-Charge-Date">Next charge date: <span>{{date('d/m/Y')}}</span></label>
                    </div>
                </div>
                <div class="tab-col-3 col p-0  d-flex justify-content-between">
                    <div class="tab-row-value">
                        <h6 class="mb-0">Amount: {{$curreny}} <span class="price">0.00</span></h6>
                    </div>
                </div>
            </div>
            <hr class="row-divider">
            <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                <div class="tab-col-1 min-width-220 d-flex align-self-start">
                    <div class="tab-row-title">
                        <h5 class="font-weight-bold">Billing Information</h5>
                    </div>
                </div>

                <div class="tab-col-2 min-width-260">
                    <div class="tab-row-label">
                        <label class="Same-Information" style="line-height: 1;">Use same information<br>as for the user name</label>
                    </div>
                </div>

                <div class="tab-col-3 col p-0  d-flex justify-content-between">
                    <div class="tab-row-value">
                        <label class="chkcn">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <!-- <div class="float-right">
                        <a href="javascript:void(0);" class="Edit">Edit</a>
                    </div> -->
                </div>
            </div>
            <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                <div class="tab-col-1 min-width-220 d-flex align-self-start">
                </div>

                <div class="tab-col-2 min-width-260">
                    <div class="tab-row-label">
                        <label class="Currency">Currency</label>
                    </div>
                </div>

                <div class="tab-col-3 col p-0  d-flex justify-content-between">
                    <div class="tab-row-value">
                        <h6 class="mb-0"><span class="currency">{{optional($company->currency)->code}}</span></h6>
                    </div>
                </div>
            </div>
            <hr class="row-divider">
            <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                <div class="tab-col-1 min-width-220 d-flex align-self-start">
                    <div class="tab-row-title">
                        <h5 class="font-weight-bold">Payment Information</h5>
                    </div>
                </div>
                <div class="tab-col-2 min-width-260 d-flex align-self-start">
                    <div class="tab-row-label">
                        <label class="Full-name">Full name</label>
                        <!-- <label class="Card-Type mt-2 mb-2">Type</label> -->
                        <label class="Card-Number">Card Detail</label>
                    </div>
                </div>
                <div class="tab-col-3 col p-0  d-flex justify-content-between">
                    <div class="tab-row-value col-md-9 p-0">
                        <p class="pb-0">{{$user->name}}</p>
                        <!-- <select class="mt-2 mb-2" data-size="5" data-width="fit" tabindex="-98">
                            <option>VISA</option>
                            <option>MASTER CARD</option>
                        </select> -->
                        <div id="payment-intent"></div>
                        
                        <div class="form-group">
                            <label for="card-holder-name">Card holder name</label>
                            <input id="card-holder-name" class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            
                            <label for="card-element">Credit or debit card</label>
                            <input type= 'text' id="card-element" class="form-control" style='height: 2.4em; padding-top: .7em;'>
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                    </div>
                    <!-- <div class="float-right d-flex justify-content-between text-right flex-column">
                        <a href="javascript:void(0);" class="Edit" data-toggle="modal" data-target="#Payment-Information">Edit</a>
                        <a href="javascript:void(0);" class="Change-Card mt-4" data-toggle="modal" data-target="#Payment">Change card</a>
                    </div> -->
                </div>
            </div>
            <hr class="row-divider">
            <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                <div class="tab-col-1 min-width-220 d-flex align-self-start">
                    <div class="tab-row-title">
                        <h5 class="font-weight-bold">Automation</h5>
                    </div>
                </div>

                <div class="tab-col-2 min-width-260">
                    <div class="tab-row-label">
                        <label class="Automatic">Automatic top up </label>
                    </div>
                </div>
                <div class="tab-col-3 col p-0  d-flex justify-content-between">
                    <div class="tab-row-value">
                        <label class="chkcn">
                            <input class="autotopup" type="checkbox" checked>
                            <span class="checkmark"></span>
                        </label>

                    </div>

                </div>
            </div>
            <hr class="row-divider">
            <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                <div class="tab-col-1 min-width-220 d-flex align-self-start">
                    <div class="tab-row-title">
                        <h5 class="font-weight-bold">Cancel account</h5>
                    </div>
                </div>
                <div class="tab-col-2 min-width-260">
                    <div class="tab-row-label">
                        <label class="Delete-Account">Delete account</label>
                    </div>
                </div>
                <div class="tab-col-3 col p-0  d-flex justify-content-between">
                    <div class="tab-row-value">
                        <label class="chkcn">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <!-- <div class="float-right">
                        <a href="javascript:void(0);" class="Cancel">Cancel</a>
                    </div> -->
                </div>
            </div>
            <div>
                <input type="hidden" name="subscriptionPlanId" id="subscriptionPlanId" value="">
            </div>
            <div class="col-md-12 text-left">
                <a href="javascript:void(0)" id="card-button" class="btn_chk_ac" data-secret="{{ $intent->client_secret }}">Make Payment</a>
            </div>
        </form>
    </div>
</div>