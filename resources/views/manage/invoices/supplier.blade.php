@extends('layouts.app-2')

@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="dash_main_container sm-hgt">
            <div class="top_title title-small mb-3">Invoices</div>
            <div class="dash_section_3">
                <div class="table-responsive">
                    <table class="table table-borderless invc-tbl">
                        <thead>
                            <tr>
                                <th>Click to select</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplierInvoices as $invoice)
                            @php
                            $mediaName = '';
                            foreach($invoice->present()->invoiceDoc as $doc){
                            $mediaName = $doc->name;
                            }

                            @endphp
                            <tr>
                                <td class="micro psar dcmntbx newdcmntbx {{ request('id') == $invoice->id ? 'active' : ''}}">
                                    <a href="{{route('invoice.detail', ['id' => $invoice->id])}}">
                                        <figure>
                                            <img src="{{asset('assets/images/doc.png')}}" alt="">
                                            <h6> {{ $mediaName }} </h6>
                                        </figure>
                                        <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="dataTables_paginate newdata">
                    {{ $supplierInvoices->links('vendor.pagination.default') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 mt-mbl">
        <div class="dash_main_container sm-hgt">
            <ul class="upperul">
                <li class="active"><a href="javascript:void(0);">Manual Invoice confirmation</a></li>
            </ul>
            <div class="inrcontsec">
                <p>This invoice has been detected. Please confirm the information is correctly read from the invoice.
                    It is only needed the first time you receive an invoice from the supplier. The system is after this time trained.</p>
                <p>If you want to do less manual confirmation, sync your accounting system so your customers are
                    transferred to our system automatically.</p>
                <div class="row mt-5">
                    <div class="col-lg-6">
                        <form action="{{route('varifyInvoice')}}" method="POST" class="mnlform">
                            @CSRF
                            <div class="frmbx">
                                <label>Supplier name</label>
                                <input type="text" name="supplierName" value="{{optional($supplier)->name}}">
                            </div>
                            <div class="frmbx">
                                <label>Address 1</label>
                                <input type="text" name="address1" value="{{optional($supplier)->address_1}}">
                            </div>
                            <div class="frmbx">
                                <label>Address 2</label>
                                <input type="text" name="address2" value="{{optional($supplier)->address_2}}">
                            </div>
                            <div class="frmbx">
                                <label>City</label>
                                <input type="text" name="city" value="{{optional(optional($supplier)->city)->name}}">
                            </div>
                            <div class="frmbx">
                                <label>Country</label>
                                <input type="text" name="country" value="{{optional(optional($supplier)->country)->name}}">
                            </div>
                            <div class="frmbx">
                                <label>Items</label>
                                <input type="text">
                            </div>
                            <div class="frmbx">
                                <label>Total price</label>
                                <input type="text" name="total" value="{{optional($invoiceDetail)->total}}">
                            </div>
                            <div class="frmbx">
                                <label>VAT</label>
                                <input type="text" placeholder="1,250">
                            </div>
                            <div class="frmbx">
                                <label>Bank account</label>
                                <input type="text" name="accountNumber" value="{{optional($supplier)->account_number}}">
                            </div>
                            <div class="frmbx">
                                <label>Email</label>
                                <input type="text" value="{{optional($supplier)->email}}">
                            </div>
                            <div class="frmbx">
                                <label>VAT number</label>
                                <input type="text" name="vatNumber" value="{{optional($supplier)->vat_number}}">
                            </div>
                            <input type="hidden" name="supplierId" value="{{ optional($supplier)->id }}">
                            <input type="hidden" name="invoiceId" value="{{ optional($invoiceDetail)->id }}">
                            <div class="text-center mt-162">
                                <input type="submit" value="Save verified invoice" class="invite">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6 mt-mbl">
                        <div class="imgbx mt-0 h-100">
                            @php
                            $image = 'assets/images/mnlimg.png';
                            foreach($invoiceDetail->present()->invoiceDoc as $doc){

                            $image = $doc->getUrl();
                            }

                            @endphp


                            <embed src="{{asset($image)}}" class="h-100 w-100" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection