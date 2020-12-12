<div class="inrcontsec h-100" id="document-verification-area" style="display: none;">
    <div class="row h-100">
        @if(count($customer->present()->getMedia) > 0)
        <div class="col-lg-8">
            <div class="dcmntbxarea" id="gridViewArea">

                @foreach($customer->present()->getMedia as $media)

                    @php
                        $class ="";
                        $status = isset(\App\Models\Customer::MEDIA_SCAN_STATUS[$media->doc_status]) ? \App\Models\Customer::MEDIA_SCAN_STATUS[$media->doc_status] : '';
                        $imageSrc = $media->getUrl();

                        if($media->new_DRS){
                            $status = __('common.new_drs');
                        }elseif($media->doc_status == __('common.fraud_document')){
                            $imageSrc = str_replace($media->file_name, $media->comment, $imageSrc);
                        }else if($media->containsscripts){
                            $status = __('common.malware');
                            $imageSrc = asset('assets/images/bug.svg');
                        }else if($media->duplicate){
                            $status = __('common.duplicate');
                        }

                        $class = isset(\App\Models\Customer::MEDIA_SCAN_STATUS_BG_CLASS[$status]) ? \App\Models\Customer::MEDIA_SCAN_STATUS_BG_CLASS[$status] : '';
                        $statusClass = isset(\App\Models\Customer::MEDIA_SCAN_STATUS_CLASS[$status]) ? \App\Models\Customer::MEDIA_SCAN_STATUS_CLASS[$status] : '';



                        $statusClassLeft = "not-active";
                        $statusClassRight = "not-active";
                        $statusClass = "not-active";
                        $statusText = "Not Active";
                        $statusTextLeft = "Not Active";
                        $statusTextRight = "Not Active";
                        $noStatus = 'no-status';


                        if(!$media->processing && !$media->processed){
                            $statusClassLeft = "not-active";
                            $statusClassRight = "not-active";
                            $statusClass = "not-active";
                            $statusText = "Not Active";
                            $statusTextLeft = "Not Active";
                            $statusTextRight = "Not Active";
                        }elseif($media->containsscripts){
                            $statusClassLeft = "malware-doc";
                            $statusClassRight = "duplicate-doc";
                            $statusClass = "malware-doc";
                            $statusText = "Not Approved";
                            $statusTextLeft = "Warning";
                            $statusTextRight = "Stopped";
                            $imageSrc = asset('assets/images/bug.svg');
                        }elseif($media->doc_status == 1){
                            $statusClass = "valid-doc";
                            $statusClassLeft = "valid-doc";
                            $statusClassRight = "valid-doc";
                            $statusText = "Approved";
                            $statusTextLeft = "Clear";
                            $statusTextRight = "Clear";
                        }elseif($media->doc_status > 1){
                            $statusClass = "malware-doc";
                            $statusClassLeft = "malware-doc";
                            $statusClassRight = "malware-doc";
                            $statusText = "Not Approved";
                            $statusTextLeft = "Warning";
                            $statusTextRight = "Warning";
                        }

                    @endphp

                <a title="{{$status}}" href="javascript:void(0);"
                    class="dcmntbx {{$class}}" document_id="{{ $media->id }}"
                    statusClass="{{ $statusClass }}" name="a_document[]" statusText="{{ $statusText }}"
                    statusClassLeft="{{ $statusClassLeft }}" name="a_document[]" statusTextLeft="{{ $statusTextLeft }}"
                    statusClassRight="{{ $statusClassRight }}" name="a_document[]" statusTextRight="{{ $statusTextRight }}"

                    imgSrc="{{ $imageSrc }}" mimeType="{{ $media->mime_type}}">
                    @php
                        $fileNameArr = explode('.', $media->file_name);
                        $ext = end($fileNameArr);
                    @endphp
                    <img src="{{ asset('assets/images/'.$ext.'.svg') }}" alt="" class="fileExt">
                    <h6>{{ $media->file_name }}</h6>
                    <h5 class="document-status-verified"> {{ $status }}</h5>
                </a>

                @endforeach

            </div>
            
            <div class="dcmntbxarea p-0" id="listViewArea" style="display: none;">
                <div class="row title-row m-0">
                    <span class="col-md-4">File name</span>
                    <span class="col-md-4">Date upload</span>
                    <span class="col-md-4">Status</span>
                </div>
                @foreach($customer->present()->getMedia as $media)

                    @php
                        $class ="";
                        $status = isset(\App\Models\Customer::MEDIA_SCAN_STATUS[$media->doc_status]) ? \App\Models\Customer::MEDIA_SCAN_STATUS[$media->doc_status] : '';
                        $imageSrc = $media->getUrl();

                        if($media->new_DRS){
                            $status = __('common.new_drs');
                        }elseif($media->doc_status == __('common.fraud_document')){
                            $imageSrc = str_replace($media->file_name, $media->comment, $imageSrc);
                        }else if($media->containsscripts){
                            $status = __('common.malware');
                            $imageSrc = asset('assets/images/bug.svg');
                        }else if($media->duplicate){
                            $status = __('common.duplicate');
                        }

                        $class = isset(\App\Models\Customer::MEDIA_SCAN_STATUS_BG_CLASS[$status]) ? \App\Models\Customer::MEDIA_SCAN_STATUS_BG_CLASS[$status] : '';
                        $statusClass = isset(\App\Models\Customer::MEDIA_SCAN_STATUS_CLASS[$status]) ? \App\Models\Customer::MEDIA_SCAN_STATUS_CLASS[$status] : '';

                        $fontClass = isset(\App\Models\Customer::MEDIA_SCAN_STATUS_FONT_CLASS[$status]) ? \App\Models\Customer::MEDIA_SCAN_STATUS_FONT_CLASS[$status] : '';

                        $statusClassLeft = "not-active";
                        $statusClassRight = "not-active";
                        $statusClass = "not-active";
                        $statusText = "Not Active";
                        $statusTextLeft = "Not Active";
                        $statusTextRight = "Not Active";
                        $noStatus = 'no-status';


                        if(!$media->processing && !$media->processed){
                            $statusClassLeft = "not-active";
                            $statusClassRight = "not-active";
                            $statusClass = "not-active";
                            $statusText = "Not Active";
                            $statusTextLeft = "Not Active";
                            $statusTextRight = "Not Active";
                        }elseif($media->containsscripts){
                            $statusClassLeft = "malware-doc";
                            $statusClassRight = "duplicate-doc";
                            $statusClass = "malware-doc";
                            $statusText = "Not Approved";
                            $statusTextLeft = "Warning";
                            $statusTextRight = "Stopped";
                            $imageSrc = asset('assets/images/bug.svg');
                        }elseif($media->doc_status == 1){
                            $statusClass = "valid-doc";
                            $statusClassLeft = "valid-doc";
                            $statusClassRight = "valid-doc";
                            $statusText = "Approved";
                            $statusTextLeft = "Clear";
                            $statusTextRight = "Clear";
                        }elseif($media->doc_status > 1){
                            $statusClass = "malware-doc";
                            $statusClassLeft = "malware-doc";
                            $statusClassRight = "malware-doc";
                            $statusText = "Not Approved";
                            $statusTextLeft = "Warning";
                            $statusTextRight = "Warning";
                        }

                    @endphp
                    <div class="row data-row m-0">
                        <span class="col-md-4 data-file">
                            <a title="{{$status}}" href="javascript:void(0);"
                            class="" document_id="{{ $media->id }}"
                            statusClass="{{ $statusClass }}" name="a_document[]" statusText="{{ $statusText }}"
                            statusClassLeft="{{ $statusClassLeft }}" name="a_document[]" statusTextLeft="{{ $statusTextLeft }}"
                            statusClassRight="{{ $statusClassRight }}" name="a_document[]" statusTextRight="{{ $statusTextRight }}"

                            imgSrc="{{ $imageSrc }}" mimeType="{{ $media->mime_type}}">
                            @php
                                $fileNameArr = explode('.', $media->file_name);
                                $ext = end($fileNameArr);
                            @endphp
                            <img src="{{ asset('assets/images/'.$ext.'.svg') }}" alt="" class="fileExt">
                            {{ $media->file_name }}
                            </a>
                        </span>
                        <span class="col-md-4 data-date">{{ $media->created_at->format('d/m/Y') }}</span>
                        <span class="col-md-4 data-status {{$fontClass}}">{{ $status }}</span>
                    </div>
                @endforeach
            </div>

        </div>
        <div class="col-lg-4 mt-mbl" id="documentArea">
            <ul class="flasi row no-status justify-content-left align-items-center main-ul-button">
                <li class="falabtn col-md-12 pl-md-0 not-active" id="liDocMainStatus">
                    <a href="javascript:void(0);" id="docMainStatus" title="">Not Active </a>
                </li>
            </ul>
            <ul class="flasi row no-status justify-content-left align-items-center">
                <li class="falabtn col-md-6 pl-md-0 not-active" id="liDocStatus">
                    <a href="javascript:void(0);" id="docStatus" title="">Not Active <br> <span>Malware Check</span></a>
                </li>
                <li class="falabtn col-md-6 pr-md-0 not-active" id="liDocAreaDetected">
                    <a href="javascript:void(0);" id="docAreaDetected">Not Active <span class="d-block">Falsification</span></a>
                </li>
            </ul>
            <div class="imgbx no-invoice">
                <span>No document selected</span>
                <embed style="display: none;" src="assets/images/dcmntimg.png" type="" id="docImgSrc">
            </div>
        </div>
        @else
        <span class="previewSpan mt-5">No files are uploaded</span>
        @endif

    </div>
</div>
