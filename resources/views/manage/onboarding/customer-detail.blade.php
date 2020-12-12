@extends('layouts.app-2')

@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="dash_main_container sm-hgt">
            <div class="top_title title-small mb-3">Onboarding List</div>

            <div class="dash_section_3">
                <div class="table-responsive">
                    <table class="table table-borderless onbrdtble">
                        <thead>
                            <tr>
                                <th>Authenticated Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $data)
                            <tr>
                                @php
                                $active = $data->id == $id ? 'active' : '';
                                @endphp
                                <td class="micro psar {{$active}}">
                                    <a class="micro d-flex align-items-center" href="{{ route('onboarding.customer-detail', ['id' => $data->id]) . '?page=' . request()->get('page') ?? 1 }}">
                                        <img src="{{ $data->present()->getCapturePhoto }}" alt="" width="45"> {{ $data->present()->name }}
                                        <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                    </a>
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="dataTables_paginate newdata">
                    {{ $customers->links('vendor.pagination.default') }}

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 mt-mbl">
        <div class="dash_main_container sm-hgt">
            <ul class="upperul">
                <li class="active" id="customer-authetication"><a href="javascript:void(0);">ID Authentication</a></li>
                <li id="document-verification"><a href="javascript:void(0);">Document verification</a></li>
                <li id="bank-account-verification"><a href="javascript:void(0);">Bank account verification </a></li>
                <div class="right-actions float-right" style="display: none;">
                    <a href="javascript:void(0);" id="listView"><img src="{{asset('assets/images/list.png')}}" title="list" width="20" /></a>
                    <a href="javascript:void(0);" id="gridView"><img src="{{asset('assets/images/grid.png')}}" title="grid" width="20" /></a>
                </div>
            </ul>
            @include('manage.onboarding.id-authentication')
            @include('manage.onboarding.document-identify')
            @include('manage.onboarding.bank-account-verification')
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('a[name^=a_document]').click(function() {


        $('.dcmntbx').removeClass('bdrClr');
        $('.imgbx').removeClass('no-invoice');
        $(this).addClass('bdrClr');

        status = $(this).attr('status');
        imgSrc = $(this).attr('imgSrc');
        mimeType = $(this).attr('mimeType');
        areadetected = $(this).attr('areadetected');
        $('#liDocStatus').removeClass('invalid-doc');
        $('#liDocStatus').removeClass('valid-doc');
        $('#liDocStatus').removeClass('duplicate-doc');
        $('#liDocStatus').removeClass('malware-doc');
        $('#liDocStatus').removeClass('not-active');

        $('#liDocAreaDetected').removeClass('invalid-doc');
        $('#liDocAreaDetected').removeClass('valid-doc');
        $('#liDocAreaDetected').removeClass('duplicate-doc');
        $('#liDocAreaDetected').removeClass('malware-doc');
        $('#liDocAreaDetected').removeClass('not-active');

        $('#liDocMainStatus').removeClass('invalid-doc');
        $('#liDocMainStatus').removeClass('valid-doc');
        $('#liDocMainStatus').removeClass('duplicate-doc');
        $('#liDocMainStatus').removeClass('malware-doc');
        $('#liDocMainStatus').removeClass('not-active');

        $('#docMainStatus').html('');
        $('#docStatus').html('');
        $('#docAreaDetected').html('');
        // $('#documentArea').find('ul').removeClass('no-status');
        $('#docAreaDetected').html('');

        $('.imgbx span').hide();

        statusClass = $(this).attr('statusClass');
        statusText = $(this).attr('statusText');

        statusClassLeft = $(this).attr('statusClassLeft');
        statusTextLeft = $(this).attr('statusTextLeft');

        statusClassRight = $(this).attr('statusClassRight');
        statusTextRight = $(this).attr('statusTextRight');

        if (statusText) {
            $('#docMainStatus').html(statusText);
            $('#liDocMainStatus').addClass(statusClass);
        }

        if (statusTextLeft) {
            $('#docStatus').html(statusTextLeft + '<br/><span>Malware Check</span>');
            $('#liDocStatus').addClass(statusClassLeft);
        }

        if (statusTextRight) {
            $('#docAreaDetected').html(statusTextRight + '<br/><span>Malware Check</span>');
            $('#liDocAreaDetected').addClass(statusClassRight);
        }

        var parent = $('embed#docImgSrc').parent();
        var newElement = "<embed src='" + imgSrc + "' type='" + mimeType + "' id='docImgSrc'>";

        $('embed#docImgSrc').remove();
        parent.append(newElement);

    });


    $('#customer-authetication').click(function() {
        $('.right-actions').hide();
        $('#document-verification').removeClass('active');
        $('#bank-account-verification').removeClass('active');
        $('#customer-authetication').addClass('active');

        $('#customer-authetication-area').show();
        $('#bank-account-verification-area').hide();
        $('#document-verification-area').hide();
    })

    $('#document-verification').click(function() {
        $('.right-actions').show();
        $('#gridViewArea').show();
        $('#listViewArea').hide();
        $('#document-verification').addClass('active');
        $('#bank-account-verification').removeClass('active');
        $('#customer-authetication').removeClass('active');

        $('#customer-authetication-area').hide();
        $('#bank-account-verification-area').hide();
        $('#document-verification-area').show();
    })

    $('#gridView').click(function() {
        $('#listViewArea').hide();
        $('#gridViewArea').show();
    })

    $('#listView').click(function() {
        $('#gridViewArea').hide();
        $('#listViewArea').show();
    })

    $('#bank-account-verification').click(function() {
        $('.right-actions').hide();
        $('#document-verification').removeClass('active');
        $('#bank-account-verification').addClass('active');
        $('#customer-authetication').removeClass('active');

        $('#customer-authetication-area').hide();
        $('#bank-account-verification-area').show();
        $('#document-verification-area').hide();
    })
</script>
@endsection