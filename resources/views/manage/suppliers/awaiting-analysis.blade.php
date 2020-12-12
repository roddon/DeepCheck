@extends('layouts.app-2')
@section('content')
<div class="row h-100">
    <div class="col-lg-12">
        <div class="dash_main_container sm-hgt mt-mbl h-100">
            <ul class="upperul">
                <li id="invoice-varification" class='active'><a href="javascript:void(0);">Check Invoice</a></li>
                <li id="supplier-varification"><a href="javascript:void(0);">Supplier check</a></li>
            </ul>

            <div class="inrcontsec h-100 px-0" id="invoice-varification-area">
                <div class="row h-100">

                    @php
                    $mediaName = '';
                    $imageSrc = asset('assets/images/mnlimg.png');
                    $class ="";
                    $status = "";
                    $noStatus = 'no-status';
                    $statusClassLeft = "not-active";
                    $statusClassRight = "not-active";
                    $statusClass = "not-active";
                    $statusText = "Not Active";
                    $statusTextLeft = "Not Active";
                    $statusTextRight = "Not Active";
                    foreach($invoiceData->present()->invoiceDoc as $doc){
                        $mediaName = $doc->file_name;
                        $imageSrc = $doc->getUrl();

                        $status = isset(\App\Models\Invoice::MEDIA_SCAN_STATUS[$doc->doc_status])
                        ? \App\Models\Invoice::MEDIA_SCAN_STATUS[$doc->doc_status] : '';

                        if($doc->new_DRS){
                            $status = __('common.new_drs');
                        }elseif($doc->doc_status == __('common.fraud_document')){
                            $imageSrc = str_replace($doc->file_name, $doc->comment, $imageSrc);
                        }else if($doc->containsscripts){
                            $status = __('common.malware');
                            $imageSrc = asset('assets/images/bug.svg');
                        }else if($doc->duplicate){
                            $status = __('common.duplicate');
                        }

                        $class = isset(\App\Models\Invoice::MEDIA_SCAN_STATUS_BG_CLASS[$status])
                        ? \App\Models\Invoice::MEDIA_SCAN_STATUS_BG_CLASS[$status] : '';

                        $fraudDocumentCount = '';
                        $noStatus = 'no-status';

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
                        }elseif($doc->doc_status > 1){
                            $statusClass = "malware-doc";
                            $statusClassLeft = "malware-doc";
                            $statusClassRight = "malware-doc";
                            $statusText = "Not Approved";
                            $statusTextLeft = "Warning";
                            $statusTextRight = "Warning";
                        }
                    }

                    @endphp

                    <div class="col-lg-8">
                        <div class="dcmntbxarea">
                            <a href="javascript:void(0);" class="dcmntbx {{$class}} bdrClr" invoice_id="{{$invoiceData->id}}" name="a_invoices[]">
                                <img src="{{asset('assets/images/doc.png')}}" alt="">

                                <h6>{{$mediaName}}</h6>
                                <h5 class="document-status-verified">{{ $status }}</h5>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-mbl">
                        <ul class="flasi row {{ $noStatus }} justify-content-center align-items-center main-ul-button">
                            <li class="falabtn col-md-12 pl-md-0 {{ $statusClass }}">
                                <a href="javascript:void(0);" id="docStatus">{{$statusText}}</a>
                            </li>
                        </ul>
                        <ul class="flasi row {{ $noStatus }} justify-content-center align-items-center">
                            <li class="falabtn col-md-6 pl-md-0 {{ $statusClassLeft }}">
                                <a href="javascript:void(0);" id="docStatus">
                                    {{$statusTextLeft}}
                                    @if($statusTextLeft)
                                    <br> <span>Malware Check</span>
                                    @endif
                                </a>
                            </li>
                            <li class="falabtn col-md-6 pr-md-0 {{ $statusClassRight }}">
                                <a href="javascript:void(0);" id="docAreaDetected">
                                    {{ $statusTextRight }}
                                    @if($statusTextRight)
                                    <br>
                                    <span class="d-block">Falsification</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                        <div class="imgbx">
                            <embed src="{{$imageSrc}}" class="h-100 w-100" alt="">
                        </div>
                    </div>

                </div>
            </div>

            <div class="inrcontsec" id="supplier-varification-area" style="display: none;">
                <div class="row h-100">
                    <span class="previewSpan mt-5">Supplier is not present</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection


@section('scripts')


<script>
    $('#inviteSupplierForVerification').click(function() {
        $('#invite-supplier').modal('show');
    });

    $('#invoice-varification').click(function() {
        $('#supplier-varification').removeClass('active');
        $('#invoice-varification').addClass('active');

        $('#invoice-varification-area').show();
        $('#supplier-varification-area').hide();
    })

    $('#supplier-varification').click(function() {
        $('#supplier-varification').addClass('active');
        $('#invoice-varification').removeClass('active');

        $('#invoice-varification-area').hide();
        $('#supplier-varification-area').show();
    })
</script>
@endsection
