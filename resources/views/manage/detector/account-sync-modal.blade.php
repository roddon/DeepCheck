<div class="modal fade checkaccounting" id="checkaccounting1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <img src="{{asset('assets/images/close.svg')}}" alt="">
            </button>
            <div class="modal-body">
                <h2>Account Sync</h2>
                <p>You can check your accounts by either synchronising the accounts or uploading a journal. The below accounting system can be synchronized only</p>
                <div class="choose_box">
                    <div class="upload_jou" style="display: none;"><a href="#">Upload journal(s)</a></div>
                    <h3>Choose System to Sync Account</h3>
                    <div class="choose_box_img_holder">
                        <div class="choose_box_img_box">
                            <a href="javascript:void(0)" onclick="modelPopupOpen('{{ env('CONNECTORS_URL') .
                                '/connect?customer_id=' . Auth::user()->id .
                                '&cust_no=' . Auth::user()->company->account_number .
                                '&accounting_system=kashflow' }}')">
                                <img src="{{asset('assets/images/ch_img_1.png')}}" alt="">
                            </a>
                        </div>
                        <div class="choose_box_img_box">
                            <a href="javascript:void(0)" onclick="modelPopupOpen('{{ env('CONNECTORS_URL') .
                                '/connect?customer_id=' . Auth::user()->id .
                                '&cust_no=' . Auth::user()->company->account_number .
                                '&accounting_system=freshbook' }}')">
                                <img src="{{asset('assets/images/ch_img_2.png')}}" alt="">
                            </a>
                        </div>
                        <div class="choose_box_img_box">
                            <a href="javascript:void(0)" onclick="modelPopupOpen('{{ env('CONNECTORS_URL') .
                                '/connect?customer_id=' . Auth::user()->id .
                                '&cust_no=' . Auth::user()->company->account_number .
                                '&accounting_system=clearbooks' }}' )">
                                <img src="{{asset('assets/images/ch_img_3.png')}}" alt="">
                            </a>
                        </div>
                        <div class="choose_box_img_box">
                            <a href="javascript:void(0)" onclick="modelPopupOpen('{{ env('CONNECTORS_URL') .
                                '/connect?customer_id=' . Auth::user()->id .
                                '&cust_no=' . Auth::user()->company->account_number .
                                '&accounting_system=sageone' }}')">
                                <img src="{{asset('assets/images/ch_img_4.png')}}" alt="">
                            </a>
                        </div>
                        {{-- <div class="choose_box_img_box">
                            <img src="{{asset('assets/images/ch_img_5.png')}}" alt="">
                    </div> --}}
                    <div class="choose_box_img_box">
                        <a href="javascript:void(0)" onclick="modelPopupOpen('{{ env('CONNECTORS_URL') .
                            '/api/quickbooks/button_html?customer_id=' . Auth::user()->id .
                            '&cust_no=' . Auth::user()->company->account_number }}')">
                            <img src="{{asset('assets/images/ch_img_6.png')}}" alt="">
                        </a>
                    </div>
                    <div class="choose_box_img_box">
                        <a href="javascript:void(0)" onclick="modelPopupOpen('{{ env('CONNECTORS_URL') .
                            '/connect?customer_id=' . Auth::user()->id .
                            '&cust_no=' . Auth::user()->company->account_number .
                            '&accounting_system=freeagent' }}')">
                            <img src="{{asset('assets/images/ch_img_7.png')}}" alt="">
                        </a>
                    </div>
                    {{-- <div class="choose_box_img_box">
                            <img src="{{asset('assets/images/ch_img_8.png')}}" alt="">
                </div> --}}
                <div class="choose_box_img_box">
                    <a href="javascript:void(0)" onclick="modelPopupOpen('{{ env('CONNECTORS_URL') .
                        '/connect?customer_id=' . Auth::user()->id .
                        '&cust_no=' . Auth::user()->company->account_number .
                        '&accounting_system=xero' }}')">
                        <img src="{{asset('assets/images/ch_img_9.png')}}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>