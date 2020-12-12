@extends('layouts.admin.app-2')
@section('content')
@foreach($invoice->present()->invoiceDoc as $doc)
    @php
        $imageSrc = $doc->getUrl();        

        if($doc->doc_status == __('common.fraud_document')){
            $imageSrc = str_replace($doc->file_name, $doc->comment, $imageSrc);
        }
        if($doc->containsscripts){            
            $imageSrc = asset('assets/images/bug.svg');
        }
        $mediaTraining = $invoice->present()->invoiceMediaTraining($doc->id);
        $mediaId = $doc->id;
        $vatNumber = $mediaTraining ? $mediaTraining->corrected_VAT_number : $doc->VAT_Number;
        $vatChanged = $mediaTraining && $mediaTraining->corrected_VAT_number != $doc->VAT_Number ? 'changedText' : '';
        $sortCode = $doc->sortcode;
        $accountNumber = $doc->account_number;
        $email = $mediaTraining ? $mediaTraining->corrected_email : $doc->Email;
        $emailChanged = $mediaTraining && $mediaTraining->corrected_email != $doc->Email ? 'changedText' : '';
        $address1 = $mediaTraining ? $mediaTraining->corrected_address1 : $doc->address1;
        $address1Changed = $mediaTraining && $mediaTraining->corrected_address1 != $doc->address1 ? 'changedText' : '';
        $address2 = $mediaTraining ? $mediaTraining->corrected_address2 : $doc->address2;
        $address2Changed = $mediaTraining && $mediaTraining->corrected_address2 != $doc->address2 ? 'changedText' : '';
        $city = $mediaTraining ? $mediaTraining->corrected_city : $doc->city;
        $cityChanged = $mediaTraining && $mediaTraining->corrected_city != $doc->city ? 'changedText' : '';
        $country = $mediaTraining ? $mediaTraining->corrected_country : $doc->Country;
        $countryChanged = $mediaTraining && $mediaTraining->corrected_country != $doc->Country ? 'changedText' : '';
        $issueDate = $doc->issuedate;
        $invoiceNumber = $doc->invoicenumber;
        $subTotal = $doc->subtotal;
        $total = $mediaTraining ? $mediaTraining->corrected_total_price : $doc->Total_price;
        $totalChanged = $mediaTraining && $mediaTraining->corrected_total_price != $doc->Total_price ? 'changedText' : '';
        $currencyIso = $doc->currency_iso;
        $phone = $mediaTraining ? $mediaTraining->corrected_phone : $doc->phone;
        $phoneChanged = $mediaTraining && $mediaTraining->corrected_phone != $doc->phone ? 'changedText' : '';
        $web = $mediaTraining ? $mediaTraining->corrected_web : $doc->web;
        $webChanged = $mediaTraining && $mediaTraining->corrected_web != $doc->web ? 'changedText' : '';
        $tax = $mediaTraining ? $mediaTraining->corrected_tax : $doc->tax;
        $taxChanged = $mediaTraining && $mediaTraining->corrected_tax != $doc->tax ? 'changedText' : '';
        $isAdminReview = $doc->review_status;
        $invoiceMediaItems = $mediaTraining = $invoice->present()->invoiceMediaItems($doc->id);
        $listCount = $invoiceMediaItems->count();
    @endphp

 @endforeach

<div class="row">
    <div class="col-lg-3">	
        <div class="dash_main_container sm-hgt">
            <div class="top_title">Suppliers</div>
                    
            <div class="dash_section_3">
                <div class="table-responsive">
                    <table class="table table-borderless invc-tbl">
                        <thead>
                            <tr>
                                <th>Supplier name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="micro psar active">
                                    <a class="micro d-flex align-items-center" href="##">
                                        <img src="{{ asset('assets/images/photo.png') }}" alt=""> {{ optional($invoice->supplier)->name }}
                                        <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="dataTables_paginate newdata" >
                    <ul class="pagination">
                        <li class="paginate_button previous"><a href="#">Previous</a></li>
                        <li class="paginate_button active"><a href="#">1</a></li>
                        <li class="paginate_button "><a href="#">2</a></li>
                        <li class="paginate_button "><a href="#">3</a></li>
                        <li class="paginate_button "><a href="#">4</a></li>
                        <li class="paginate_button next" ><a href="#">Next</a></li>
                    </ul>
                </div> -->
            </div>
        </div>
	</div>
    <div class="col-lg-9">
        <div class="dash_main_container sm-hgt mt-mbl invoice-editing-wrapper p-0 h-100 pb-3">
            <div class="row h-100">
                <div class="col-md-8 pr-md-0" id="pdf-embed-wrapper">
                    <embed id="edit-invoice-doc" src="{{$imageSrc}}" width="100%" height="100%">
                </div>
                <div class="col-md-4 pl-md-0">
                    <div class="edit-detail-wrapper affix">
                        <h6>Detailed information <span class="d-block">Click to edit</span></h6>
                        <form class="invoice-edit-form pl-md-4">
                            <label class="non-edit-label">
                                <span>Supplier name</span>
                                <span>{{ optional($invoice->supplier)->name }}</span>
                            </label>
                            <!-- <label class="form-group border-lable-flt">
                                <select class="form-control custom-select">
                                    <option selected>Peter Skafte APS</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                </select>
                                <span>Supplier</span>
                            </label> -->
                            <label class="non-edit-label">
                                <span>Receiver</span>
                                <span>{{ optional(optional($invoice->user)->company)->name }}</span>
                            </label>
                            <!-- <label class="form-group border-lable-flt">
                                <select class="form-control custom-select">
                                    <option selected>Peter Skafte APS</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                </select>
                                <span>Receiver</span>
                            </label> -->

                            <label class="non-edit-label">
                                <span>Company number</span>
                                <span>{{ optional(optional($invoice->user)->company)->company_number }}</span>
                            </label>
                            
                            <label class="non-edit-label" id="vatNumber">
                                <span>VAT number</span>
                                <span class="vatText {{$vatChanged}}">{{$vatNumber}}</span>
                            </label>

                            <div class="form-group input-group vatNumber" style="display: none;">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" name="VAT_Number" value="{{$vatNumber}}">
                                    <label for="label-name">VAT number</label>
                                </span>
                                <a href="javascript:void(0);" class="edited-text edit-vat">Edited</a>
                            </div>

                            <label class="non-edit-label">
                                <span>IBAN Number</span>
                                <span>{{ optional(optional($invoice->user)->company)->i_ban_number }}</span>
                            </label>

                            <!-- <div class="form-group input-group">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" placeholder="IBAN Number" value="{{ optional(optional($invoice->user)->company)->i_ban_number }}">
                                    <label for="label-name">IBAN</label>
                                </span>
                            </div> -->


                            <label class="non-edit-label">
                                <span>Sort Code</span>
                                <span>{{$sortCode}}</span>
                            </label>
                            <label class="non-edit-label">
                                <span>Account number</span>
                                <span>{{$accountNumber}}</span>
                            </label>
                            <label class="non-edit-label" id="email">
                                <span>Email</span>
                                <span class="emailText {{$emailChanged}}">{{$email}}</span>
                            </label>
                            <div class="form-group input-group email" style="display: none;">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" name="Email" value="{{$email}}">
                                    <label for="label-name">Email</label>
                                </span>
                                <a href="javascript:void(0);" class="edited-text edit-email">Edited</a>
                            </div>

                            <label class="non-edit-label" id="phone">
                                <span>Phone</span>
                                <span class="phoneText {{$phoneChanged}}">{{$phone}}</span>
                            </label>
                            <div class="form-group input-group phone" style="display: none;">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" name="phone" value="{{$phone}}">
                                    <label for="label-name">Phone</label>
                                </span>
                                <a href="javascript:void(0);" class="edited-text edit-phone">Edited</a>
                            </div>

                            <label class="non-edit-label" id="web">
                                <span>Web</span>
                                <span class="webText {{$webChanged}}">{{$web}}</span>
                            </label>
                            <div class="form-group input-group web" style="display: none;">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" name="web" value="{{$web}}">
                                    <label for="label-name">Web</label>
                                </span>
                                <a href="javascript:void(0);" class="edited-text edit-web">Edited</a>
                            </div>

                            <label class="non-edit-label" id="address1">
                                <span>Address 1</span>
                                <span class="address1Text {{$address1Changed}}">{{$address1}}</span>
                            </label>
                            <div class="form-group input-group address1" style="display: none;">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" name="address1" value="{{$address1}}">
                                    <label for="label-name">Address 1</label>
                                </span>
                                <a href="javascript:void(0);" class="edited-text edit-address1">Edited</a>
                            </div>

                            <label class="non-edit-label" id="address2">
                                <span>Address 2</span>
                                <span class="address2Text {{$address2Changed}}">{{$address2}}</span>
                            </label>
                            <div class="form-group input-group address2" style="display: none;">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" name="address2" value="{{$address2}}">
                                    <label for="label-name">Address 2</label>
                                </span>
                                <a href="javascript:void(0);" class="edited-text edit-address2">Edited</a>
                            </div>

                            <label class="non-edit-label" id="city">
                                <span>City</span>
                                <span class="cityText {{$cityChanged}}">{{$city}}</span>
                            </label>
                            <div class="form-group input-group city" style="display: none;">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" name="city" value="{{$city}}">
                                    <label for="label-name">City</label>
                                </span>
                                <a href="javascript:void(0);" class="edited-text edit-city">Edited</a>
                            </div>

                            <label class="non-edit-label" id="country">
                                <span>Country</span>
                                <span class="countryText {{$countryChanged}}">{{$country}}</span>
                            </label>

                            <div class="form-group input-group country" style="display: none;">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" name="Country" value="{{$country}}">
                                    <label for="label-name">Country</label>
                                </span>
                                <a href="javascript:void(0);" class="edited-text edit-country">Edited</a>
                            </div>

                            <label class="non-edit-label" id="listItem">
                                <span>Line Items ({{$listCount}})</span>
                                <span></span>
                            </label>

                            <div class="row listItem" style="display: none;">
                                @foreach($invoiceMediaItems as $item)
                                @php
                                    $latestMediaTrainingItem = $item->mediaTrainingItems()->latest()->first();
                                    $quantity = $latestMediaTrainingItem ? $latestMediaTrainingItem->quantity : $item->quantity;
                                    $description = $latestMediaTrainingItem ? $latestMediaTrainingItem->description : $item->description;
                                    $totalPrice = $latestMediaTrainingItem ? $latestMediaTrainingItem->total_price : $item->total_price;
                                @endphp

                                <div class="form-group input-group col-md-12 pr-0">
                                    <span class="border-lable-flt">
                                        <input type="text" class="form-control description" name="item[{{$item->id}}][quantity]" id="label-name" value="{{$quantity}}">
                                        <label for="label-name">quantity</label>
                                    </span>
                                </div>
                                <div class="form-group input-group col-md-12 pr-0">
                                    <span class="border-lable-flt">
                                        <input type="text" class="form-control description" name="item[{{$item->id}}][description]" id="label-name" value="{{$description}}">
                                        <label for="label-name">Description</label>
                                    </span>
                                </div>
                                <div class="form-group input-group col-md-12 pr-0">
                                    <span class="border-lable-flt">
                                        <input type="text" class="form-control total_price" name="item[{{$item->id}}][total_price]" id="label-name" value="{{$totalPrice}}">
                                        <label for="label-name">Sub total (excl tax)</label>
                                    </span>
                                </div>
                                <input type="hidden"name="item[{{$item->id}}][media_id]" value="{{$mediaId}}">
                                @endforeach
                                <a href="javascript:void(0);" class="edit-line-item col-md-12 form-group">Edited</a>
                            </div>

                            <label class="non-edit-label" id="tax">
                                <span>Tax</span>
                                <span class="taxText {{$taxChanged}}">{{$tax}}</span>
                            </label>
                            <div class="form-group input-group tax" style="display: none;">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" name="tax" value="{{$tax}}">
                                    <label for="label-name">Tax</label>
                                </span>
                                <a href="javascript:void(0);" class="edited-text edit-tax">Edited</a>
                            </div>


                            <label class="non-edit-label" id="total">
                                <span>Total (incl tax)</span>
                                <span class="totalText {{$totalChanged}}">{{$total}}</span>
                            </label>

                            <div class="form-group input-group total" style="display: none;">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" name="Total_price" value="{{$total}}">
                                    <label for="label-name">Total (incl tax)</label>
                                </span>
                                <a href="javascript:void(0);" class="edited-text edit-total">Edited</a>
                            </div>

                            <!-- <div class="form-group input-group">
                                <span class="border-lable-flt">
                                    <input type="text" class="form-control" id="label-name" placeholder="IBAN Number">
                                    <label for="label-name">Total (incl tax)</label>
                                </span>
                                <p class="edited-text">Edited</p>
                            </div> -->

                            <label class="non-edit-label">
                                <span>Currency</span>
                                <span>{{$currencyIso}}</span>
                            </label>

                            <!-- <div class="col-md-6 pl-0">
                                <label class="form-group border-lable-flt">
                                    <select class="form-control custom-select">
                                        <option selected>Peter Skafte APS</option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                    </select>
                                    <span>Currency</span>
                                </label>
                            </div>-->
                            <input type="hidden" name="mediaId" value="{{$mediaId}}">
                            <a href="javascript:void(0);" class="invite mt-2 w-100 review approvedChanges text-center">Approved Changes</a>
                            <a href="javascript:void(0);" class="invite mt-2 w-100 rejectedChanges text-center">Rejected Changes</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @include('manage.admin.change-request.edit-invoice-script')
@endsection