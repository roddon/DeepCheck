<div class="inrcontsec" id="supplier-varification-area" style="display: none;">
    <div class="overfldv">
        <ul class="splrnm">
            <li>
                <span class="dv"><b>Supplier Name</b></span>
                <span class="dv">Account holder <span class="brk">Company number</span> <span class="brk">VAT number</span></span>
                <span class="dv light">{{ $supplier->name }}&nbsp; <span class="brk"> {{ $supplier->company_number }} &nbsp;</span> <span class="brk red">{{ $supplier->vat_number }}&nbsp;</span> </span>
                <span class="dv mr-0">
                    <span class="{{ $supplier->name ?  $supplier->present()->bankAccountStatusColorPage : 'awiting' }}">{{ $supplier->name ? $supplier->present()->bankAccountPageStatus : 'awaiting' }} </span>
                    <span class="{{ $supplier->company_number ? $supplier->present()->companyNumberStatusPageColor : 'awiting' }}">{{ $supplier->company_number ? $supplier->present()->companyNumberStatus : 'awaiting' }} </span>
                    <span class="{{ $supplier->vat_number ? $supplier->present()->vatNumberStatusPageColor : 'awiting' }}">{{ $supplier->vat_number ? $supplier->present()->vatNumberStatus : 'awaiting' }} </span>
                </span>
            </li>
            <li>
                <span class="dv"><b>Address</b></span>
                <span class="dv">Address 1 <span class="brk">Address 2</span> <span class="brk">Post code/Zip</span> <span class="brk">City</span> <span class="brk">Country</span></span>
                <span class="dv light">{{ $supplier->address_1 }}&nbsp;<span class="brk"> {{ $supplier->address_2 }}&nbsp;</span> <span class="brk">{{ $supplier->post_code }}&nbsp;</span> <span class="brk">{{ optional($supplier->city)->name }}&nbsp;</span> <span class="brk">{{ optional($supplier->country)->name }}&nbsp;</span> </span>
                <span class="dv mr-0">
                    <span class="{{ $supplier->address_1 ? $supplier->present()->addressStatusPageColor : 'awiting' }}">{{ $supplier->address_1 ? $supplier->present()->addressStatus : 'awaiting' }} </span>
                    <span class="{{ $supplier->address_2 ? $supplier->present()->addressStatusPageColor : 'awiting' }}">{{ $supplier->address_2 ? $supplier->present()->addressStatus : 'awaiting'}} </span>
                    <span class="{{ $supplier->post_code ? $supplier->present()->addressStatusPageColor : 'awiting' }}">{{ $supplier->post_code ? $supplier->present()->addressStatus : 'awaiting'}} </span>
                    <span class="{{ optional($supplier->city)->name ? $supplier->present()->addressStatusPageColor : 'awiting' }}">{{ optional($supplier->city)->name ? $supplier->present()->addressStatus : 'awaiting'}} </span>
                    <span class="{{ optional($supplier->country)->name ? $supplier->present()->addressStatusPageColor : 'awiting' }}">{{ optional($supplier->country)->name ? $supplier->present()->addressStatus : 'awaiting' }} </span>
                </span>
            </li>
            <li>
                <span class="dv"><b>Contact</b></span>
                <span class="dv">Email <span class="brk">Phone number</span> </span>
                <span class="dv light"> {{ $supplier->email }}&nbsp; <span class="brk"> {{ $supplier->contact_number }} &nbsp;</span> </span>
                <span class="dv mr-0">
                    <span class="{{ $supplier->email ? $supplier->present()->emailStatusPageColor : 'awiting' }}"> {{ $supplier->email ? $supplier->present()->emailStatus : 'awaiting' }} </span>
                    <span class="{{ $supplier->contact_number ? $supplier->present()->contactNumberStatusPageColor: 'awiting' }}">{{ $supplier->contact_number ? $supplier->present()->contactNumberStatus : 'awaiting' }} </span>
                </span>
            </li>
            <li>
                <span class="dv"><b>Bank</b></span>
                <span class="dv">Bank name <span class="brk">IBAN</span> <span class="brk">Sort Code</span> <span class="brk">Account number</span> </span>
                <span class="dv light">{{ $supplier->bank_name }} &nbsp;<span class="brk"> {{ $supplier->i_ban_number }} &nbsp;</span> <span class="brk">{{ $supplier->sort_code }}&nbsp;</span> <span class="brk">{{ $supplier->bank_account_number }}</span> </span>
                <span class="dv mr-0">
                    <span class="{{ $supplier->bank_name ? $supplier->present()->bankAccountStatusColorPage: 'awiting' }}">{{ $supplier->bank_name ? $supplier->present()->bankAccountPageStatus : 'awaiting' }} </span>
                    <span class="{{ $supplier->i_ban_number ? $supplier->present()->bankAccountStatusColorPage : 'awiting' }}">{{ $supplier->i_ban_number ? $supplier->present()->bankAccountPageStatus : 'awaiting' }} </span>
                    <span class="{{ $supplier->sort_code ? $supplier->present()->bankAccountStatusColorPage : 'awiting'}}">{{ $supplier->sort_code ? $supplier->present()->bankAccountPageStatus : 'awaiting' }} </span>
                    <span class="{{ $supplier->bank_account_number ? $supplier->present()->bankAccountStatusColorPage : 'awiting' }}">{{ $supplier->bank_account_number ? $supplier->present()->bankAccountPageStatus : 'awaiting'}} </span>
                </span>
            </li>
        </ul>
    </div>
    <div class="text-center mt-5">
        <p>Verification failed in one or more areas. Please call your supplier to make sure it was added correctly.</p>
        <a href="javascript:void(0);" class="invite mt-md-5 mt-3" id="inviteSupplierForVerification">Invite company for verification</a>
    </div>
</div>