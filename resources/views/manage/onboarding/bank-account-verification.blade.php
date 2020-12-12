<div class="inrcontsec" id="bank-account-verification-area" style="display: none;">
    <div class="overfldv">
        <ul class="splrnm">
            <li>
                <span class="dv"><b>Personal</b></span>
                <span class="dv">Account holder <span class="brk">Date of birth</span> </span>
                <span class="dv light" title="{{ $customer->present()->accountHolderName }}">{{ $customer->present()->accountHolderName }}
                    <span class="brk"> {{ $customer->present()->bankDOB }} </span>
                </span>
                <span class="dv mr-0">
                    <span class="{{ $customer->present()->accountHolderNameStatusColor }}">{{ $customer->name ? $customer->present()->bankAccountPageStatus : 'Awaiting' }}</span>
                    <span class="{{ $customer->present()->bankDOBStatusColor }}">{{ $customer->present()->dob ? $customer->present()->bankAccountPageStatus : 'Awaiting' }} </span>
                </span>
            </li>
            <li>
                <span class="dv"><b>Address</b></span>
                <span class="dv">Address 1 <span class="brk">Address 2</span> <span class="brk">Post code/Zip</span> <span class="brk">City</span> <span class="brk">Country</span></span>
                <span class="dv light"> {{ $customer->address_1 }} <span class="brk"> {{ $customer->address_2 }} </span> <span class="brk">{{ $customer->post_code }}</span> <span class="brk">{{ optional($customer->city)->name }}</span> <span class="brk">{{ optional($customer->country)->name }}</span> </span>
                <span class="dv mr-0">
                    <span class="{{ $customer->address_1 ? $customer->present()->addressStatusPageColor : 'awiting' }}">{{ $customer->address_1 ? $customer->present()->addressStatus : 'Awaiting' }} </span>
                    <span class="{{ $customer->address_2 ? $customer->present()->addressStatusPageColor : 'awiting' }}">{{ $customer->address_2 ? $customer->present()->addressStatus : 'Awaiting'}} </span>
                    <span class="{{ $customer->post_code ? $customer->present()->addressStatusPageColor : 'awiting' }}">{{ $customer->post_code ? $customer->present()->addressStatus : 'Awaiting'}}</span>
                    <span class="{{ optional($customer->city)->name ? $customer->present()->addressStatusPageColor : 'awiting' }}">{{ optional($customer->city)->name ? $customer->present()->addressStatus : 'Awaiting' }}</span>
                    <span class="{{ optional($customer->country)->name ? $customer->present()->addressStatusPageColor : 'awiting' }}">{{ optional($customer->country)->name ? $customer->present()->addressStatus : 'Awaiting' }} </span>
                </span>
            </li>
            <li>
                <span class="dv"><b>Contact</b></span>
                <span class="dv">Email <span class="brk">Phone number</span> </span>
                <span class="dv light" title="{{ $customer->email }}">{{ $customer->email }} <span class="brk"> {{ $customer->contact_number }} </span> </span>
                <span class="dv mr-0">
                    <span class="{{ $customer->email ? $customer->present()->emailStatusPageColor : 'awiting' }}">{{ $customer->email ? $customer->present()->emailStatus : 'Awaiting' }}</span>
                    <span class="{{ $customer->contact_number ? $customer->present()->contactNumberStatusPageColor : 'awiting' }}">{{ $customer->contact_number ? $customer->present()->contactNumberStatus : 'Awaiting' }}</span>
                </span>
            </li>
            <li>
                <span class="dv"><b>Bank</b></span>
                <span class="dv">Bank name <span class="brk">IBAN</span> <span class="brk">Sort Code</span> <span class="brk">Account number</span> </span>
                <span class="dv light"><span class="red">{{ $customer->bank_name }}&nbsp;</span> <span class="brk"> {{ $customer->i_ban_number }} &nbsp;</span> <span class="brk">{{ $customer->sort_code }}&nbsp;</span> <span class="brk">{{ $customer->bank_account_number }}</span> </span>
                <span class="dv mr-0">
                    <span class="{{ $customer->bank_name ? $customer->present()->bankAccountStatusColorPage : 'awiting' }}">{{ $customer->bank_name ? $customer->present()->bankAccountPageStatus : 'Awaiting' }}</span>
                    <span class="{{ $customer->i_ban_number ? $customer->present()->bankAccountStatusColorPage : 'awiting' }}">{{ $customer->i_ban_number ? $customer->present()->bankAccountPageStatus : 'Awaiting' }}</span>
                    <span class="{{ $customer->sort_code ? $customer->present()->bankAccountStatusColorPage : 'awiting' }}">{{ $customer->sort_code ? $customer->present()->bankAccountPageStatus : 'Awaiting' }}</span>
                    <span class="{{ $customer->bank_account_number ? $customer->present()->bankAccountStatusColorPage : 'awiting'}}">{{ $customer->bank_account_number ? $customer->present()->bankAccountPageStatus : 'Awaiting' }} </span>
                </span>
            </li>
        </ul>
    </div>

    <div class="text-center mt-5">
        <p>Verification failed in one or more areas. Please call your supplier to make sure it was added correctly.</p>

    </div>
</div>
