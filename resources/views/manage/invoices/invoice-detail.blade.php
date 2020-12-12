 @php
 $statusClassLeft = "not-active";
 $statusClassRight = "not-active";
 $statusClass = "not-active";
 $statusText = "Not Active";
 $statusTextLeft = "Not Active";
 $statusTextRight = "Not Active";
 $noStatus = 'no-status';
 $imageSrc = "";
 $validInvoice = 0;
 $isAdminReview = 0;
 $enlargeButton = "";
 @endphp

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
    $enlargeButton = "Not Processed";
 }elseif($doc->containsscripts){
    $statusClassLeft = "malware-doc";
    $statusClassRight = "duplicate-doc";
    $statusClass = "malware-doc";
    $statusText = "Not Approved";
    $statusTextLeft = "Warning";
    $statusTextRight = "Stopped";
 $imageSrc = asset('assets/images/bug.svg');
    $enlargeButton = "Malware";
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
    $enlargeButton = isset(\App\Models\Invoice::MEDIA_SCAN_STATUS[$doc->doc_status])
    ? \App\Models\Invoice::MEDIA_SCAN_STATUS[$doc->doc_status] : '';
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

 @php
 if(!$invoice->supplier){
    $enlargeButton = "Awaiting Analysis";
 }
 @endphp

 <div>
     @if ($validInvoice && is_null($isAdminReview))
     <a href="{{route('sVault.supplier.edit-invoice-media', ['mediaId' => $mediaId, 'invoiceId' => $invoice->id])}}" class="invite mt-md-5 mt-3 review col-md-12 text-center">Review/Edit enlarged</a>
     @else
     <a href="javascript:void(0);" class="invite mt-md-5 mt-3 inactive-review col-md-12 text-center">{{ $enlargeButton }}</a>
     @endif
 </div>
