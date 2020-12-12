 @foreach($invoice->present()->invoiceDoc as $doc)
    @php
        $imageSrc = $doc->getUrl();
        $statusClassLeft = "not-active";
        $statusClassRight = "not-active";
        $statusClass = "not-active";
        $statusText = "Not Active";
        $statusTextLeft = "Not Active";
        $statusTextRight = "Not Active";
        $noStatus = 'no-status';
        $mediaId = $doc->id;
        $validInvoice = 0;
        $isAdminReview = $doc->review_status;

        if($doc->doc_status == __('common.fraud_document')){
            $imageSrc = str_replace($doc->file_name, $doc->comment, $imageSrc);
        }

        if(!$doc->processing && !$doc->processed){
            $statusClassLeft = "not-active";
            $statusClassRight = "not-active";
            $statusClass = "not-active";
            $statusText = "Not Active";
            $statusTextLeft = "Not Active";
            $statusTextRight = "Not Active";
        }elseif($doc->containsscripts){
            $statusClassLeft = "malware-doc";
            $statusClassRight = "duplicate-doc";
            $statusClass = "malware-doc";
            $statusText = "Not Approved";
            $statusTextLeft = "Warning";
            $statusTextRight = "Stopped";
            $imageSrc = asset('assets/images/bug.svg');
        }elseif($doc->doc_status == 1){
            $statusClass = "valid-doc";
            $statusClassLeft = "valid-doc";
            $statusClassRight = "valid-doc";
            $statusText = "Approved";
            $statusTextLeft = "Clear";
            $statusTextRight = "Clear";
            $validInvoice = 1;
        }elseif($doc->doc_status > 1){
            $statusClass = "malware-doc";
            $statusClassLeft = "malware-doc";
            $statusClassRight = "malware-doc";
            $statusText = "Not Approved";
            $statusTextLeft = "Warning";
            $statusTextRight = "Warning";            
        }


    @endphp


 @endforeach
 <ul class="flasi row {{ $noStatus }} justify-content-center align-items-center main-ul-button">
     <li class="falabtn col-md-12 pl-md-0 {{ $statusClass }}">
         <a href="javascript:void(0);">{{ $statusText }}</a>
     </li>
 </ul>
 <ul class="flasi row {{ $noStatus }}  justify-content-center align-items-center">

     <li class="falabtn col-md-6 pl-md-0 {{ $statusClassLeft }}">
         <a href="javascript:void(0);">{{ $statusTextLeft }}
            @if($statusTextLeft)
            <br /> <span>Malware Check</span>
            @endif
        </a>
     </li>
     <li class="falabtn col-md-6 pr-md-0 {{ $statusClassRight }}">
         <a href="javascript:void(0);"> {{ $statusTextRight }}
            @if($statusTextRight)
            <br /> <span>Falsification</span>
            @endif
        </a>
     </li>
 </ul>

 <div class="imgbx">
     <embed src="{{$imageSrc}}" class="h-100 w-100" alt="">
 </div>


 <ul class="vat">
     <li><span>Supplier name</span><span>{{$invoice->supplier->name}}</span></li>
     <li><span>Address 1</span><span>{{$invoice->supplier->address_1}}</span></li>
     <li><span>Address 2</span><span>{{$invoice->supplier->address_2}}</span></li>
     <li><span>Post code/Zip</span><span>{{$invoice->supplier->post_code}}</span></li>
     <li><span>City</span><span>{{optional($invoice->supplier->city)->name}}</span></li>
     <li><span>Country</span><span>{{optional($invoice->supplier->country)->name}}</span></li>
     <!-- <li><span>Items</span><span>4</span></li> -->
     <li><span>Total price</span><span>{{optional($invoice)->total}}</span></li>
     <li><span>VAT</span><span></span></li>
     <li><span>Bank account</span><span>{{$invoice->supplier->bank_account_number}}</span></li>
     <li><span>Email</span><span>{{$invoice->supplier->email}}</span></li>
     <li><span>VAT number</span><span class="{{!$invoice->supplier->vat_number ? 'red' : ''}}">{{$invoice->supplier->vat_number ? $invoice->supplier->vat_number : 'NOT CORRECT'}}</span></li>
 </ul>
@if ($validInvoice && is_null($isAdminReview))
    <a href="{{route('sVault.supplier.edit-invoice-media', ['mediaId' => $mediaId, 'invoiceId' => $invoice->id])}}" class="invite mt-md-5 mt-3 review col-md-12 text-center">Review/Edit enlarged</a>
@endif