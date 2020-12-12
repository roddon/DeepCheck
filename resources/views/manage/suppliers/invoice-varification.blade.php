<div class="inrcontsec h-100 px-0" id="invoice-varification-area">
    <div class="row h-100">
        @php
        $checkDoc = false;
        @endphp
        @foreach($invoices as $invoice)
        @if(count($invoice->present()->invoiceDoc) > 0)
        @php
        $checkDoc = true;
        @endphp
        @endif
        @endforeach
        @if($checkDoc)
        <div class="col-lg-8">
            <div class="dcmntbxarea" id="gridViewArea">

                @php
                $flag = true;
                @endphp
                @foreach($invoices as $invoice)



                @if(count($invoice->present()->invoiceDoc) > 0)
                @php
                $flag = false;
                @endphp

                @foreach($invoice->present()->invoiceDoc as $doc)

                @php
                $class ="";
                $status = isset(\App\Models\Invoice::MEDIA_SCAN_STATUS[$doc->doc_status]) ? \App\Models\Invoice::MEDIA_SCAN_STATUS[$doc->doc_status] : '';

                if($doc->new_DRS){
                $status = __('common.new_drs');

                }else if($doc->containsscripts){
                $status = __('common.malware');

                }else if($doc->duplicate){
                $status = __('common.duplicate');
                }

                $class = isset(\App\Models\Invoice::MEDIA_SCAN_STATUS_BG_CLASS[$status]) ? \App\Models\Invoice::MEDIA_SCAN_STATUS_BG_CLASS[$status] : '';
                @endphp

                <a title="{{ $status }}" href="javascript:void(0);" class="dcmntbx {{$class}}" invoice_id="{{$invoice->id}}" name="a_invoices[]">
                    @php
                        $fileNameArr = explode('.', $doc->file_name);
                        $ext = end($fileNameArr);
                    @endphp
                    <img src="{{ asset('assets/images/'.$ext.'.svg') }}" alt="" class="fileExt">

                    <h6>{{ $doc->file_name }}</h6>
                    <h5 class="document-status-verified">{{ $status }}</h5>
                </a>

                @endforeach
                @endif
                @endforeach
            </div>

            <div class="dcmntbxarea p-0" id="listViewArea" style="display: none;">
                <div class="row title-row m-0">
                    <span class="col-md-4">File name</span>
                    <span class="col-md-4">Date upload</span>
                    <span class="col-md-4">Status</span>
                </div>

                @php
                $flag = true;
                @endphp
                @foreach($invoices as $invoice)



                @if(count($invoice->present()->invoiceDoc) > 0)
                @php
                $flag = false;
                @endphp

                @foreach($invoice->present()->invoiceDoc as $doc)

                @php
                $class ="";
                $status = isset(\App\Models\Invoice::MEDIA_SCAN_STATUS[$doc->doc_status]) ? \App\Models\Invoice::MEDIA_SCAN_STATUS[$doc->doc_status] : '';

                if($doc->new_DRS){
                $status = __('common.new_drs');

                }else if($doc->containsscripts){
                $status = __('common.malware');

                }else if($doc->duplicate){
                $status = __('common.duplicate');
                }

                $class = isset(\App\Models\Invoice::MEDIA_SCAN_STATUS_BG_CLASS[$status]) ? \App\Models\Invoice::MEDIA_SCAN_STATUS_BG_CLASS[$status] : '';

                $fontClass = isset(\App\Models\Invoice::MEDIA_SCAN_STATUS_FONT_CLASS[$status]) ? \App\Models\Invoice::MEDIA_SCAN_STATUS_FONT_CLASS[$status] : '';

                @endphp

                <div class="row data-row m-0">
                    <span class="col-md-4 data-file">
                        <a title="{{ $status }}" href="javascript:void(0);" class="" invoice_id="{{$invoice->id}}" name="a_invoices[]">
                            @php
                                $fileNameArr = explode('.', $doc->file_name);
                                $ext = end($fileNameArr);
                            @endphp
                            <img src="{{ asset('assets/images/'.$ext.'.svg') }}" alt="" class="fileExt">
                            {{ $doc->file_name }}
                        </a>
                    </span>
                    <span class="col-md-4 data-date">
                        {{$doc->created_at->format('d/m/Y')}}
                    </span>
                    <span class="col-md-4 data-status {{$fontClass}}">
                        {{ $status }}
                    </span>
                </div>

                @endforeach
                @endif
                @endforeach
            </div>
        </div>
        <div class="col-lg-4 mt-mbl" id="invoice_area">
            <ul class="flasi row no-status justify-content-center align-items-center main-ul-button">
                <li class="falabtn col-md-12 pl-md-0 not-active"><a href="javascript:void(0);">Not Active</a></li>
            </ul>
            <ul class="flasi row no-status justify-content-center align-items-center">
                <li class="falabtn col-md-6 pl-md-0 not-active"><a href="javascript:void(0);">Not Active <br /> <span>Malware Check</span></a></li>
                <li class="falabtn col-md-6 pr-md-0 not-active"><a href="javascript:void(0);">Not Active <br /> <span>Falsification</span></a></li>
            </ul>
            <div class="imgbx no-invoice">
                <span>No invoice selected</span>
            </div>
            <ul class="vat">
                <li><span>Supplier name</span><span></span></li>
                <li><span>Address 1</span><span></span></li>
                <li><span>Address 2</span><span></span></li>
                <li><span>Post code/Zip</span><span></span></li>
                <li><span>City</span><span></span></li>
                <li><span>Country</span><span></span></li>
                <!-- <li><span>Items</span><span></span></li> -->
                <li><span>Total price</span><span></span></li>
                <li><span>VAT</span><span></span></li>
                <li><span>Bank account</span><span></span></li>
                <li><span>Email</span><span></span></li>
                <li><span>VAT number</span><span></span></li>
            </ul>
        </div>
        @else
        <span class="previewSpan mt-5">No files are uploaded</span>
        @endif
    </div>
</div>
