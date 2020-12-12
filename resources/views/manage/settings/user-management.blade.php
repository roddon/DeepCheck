<div class="tab tab-active" data-id="user-management-tab">

    <div class="inrcontsec">
        <form enctype="multipart/form-data" id="user-management-form">
            <div class="row pl-4 pr-4 mt-3" style="{{!optional($company)->id ? 'display:none' : '' }}" id="company-profile">
                <div class="tab-col-1 min-width-220">
                    <div class="d-inline-block">
                        <div class="user-management-img mb-2">
                            @php
                            $image = $company ? $company->getMedia('company_image') : null;
                            $imageUrl = isset($image[0]) ? $image[0]->getUrl() : asset('assets/images/no-image.jpg');
                            @endphp
                            <img src="{{ $imageUrl }}" id="companyLogo" />
                            <input type="file" id="companyLogoImage" style="display: none;" />
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="javascript:void(0);" id="changeImage">Change</a>
                            <a href="javascript:void(0);" id="deleteImage">Delete</a>
                        </div>
                    </div>
                </div>
                <div class="tab-col-2 min-width-220">
                    <div class="d-inline-block">
                        <div class="">
                            <h4 class="font-weight-bold mb-1" id="company-name"> {{ optional($company)->name }}</h4>
                            <p class="account-number  pb-0 mb-0">Account no
                                <span id="account-number">{{ optional($company)->account_number }}</span></p>
                            <div class="d-sm-flex tab-row-label ">
                                <label class="language min-width-220 align-self-center">Language</label>
                                <select class="new-slct mt-2 mt-sm-0" data-size="5" data-width="fit" name="languageId" id="languageId">
                                    <option value=""> -- Select --</option>
                                    @foreach (getLanguages() as $key => $value)
                                    @php
                                    $selected = "";
                                    if( $key == optional($company)->language_id ){
                                    $selected = "selected";
                                    }
                                    @endphp
                                    <option {{$selected}} value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-sm-flex tab-row-label mt-2">
                                <label class="language min-width-220 align-self-center">Currency</label>
                                <select class="new-slct mt-2 mt-sm-0 w-100" data-size="5" data-width="fit" name="currencyId" id="currencyId">
                                    <option value=""> -- Select --</option>
                                    @foreach (getCurrency() as $key => $value)
                                    @php
                                    $selected = "";
                                    if( $key == optional($company)->currency_id ){
                                    $selected = "selected";
                                    }
                                    @endphp
                                    <option {{$selected}} value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="row-divider" />
            <!-- Edit Company Number -->
            <div id="company_number" style="display: {{$company && $company->is_company_verified? 'block' : 'none'}};">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-center">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Companies house
                            </h5>
                        </div>
                    </div>
                    <div class="tab-col-2 min-width-220">
                        <div class="tab-row-label">
                            <label class="Registered-Number">Registered Number</label>
                        </div>
                    </div>
                    <div class="tab-col-3 col p-0 align-self-center">
                        <div class="tab-row-value d-flex justify-content-between">
                            <p class="p-0" id="company-number">{{ optional($company)->company_number }}</p>
                            <a href="javascript:void(0);" class="Verify" id="editCompanyNumber">Edit</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="edit_company_number" style="display: {{$company && $company->is_company_verified? 'none' : 'block'}};">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Companies house
                            </h5>
                        </div>
                    </div>
                    <div class="tab-col-2 min-width-220 align-self-start">
                        <div class="tab-row-label d-none-mbl">
                            <label class="Registered-Number">Registered Number</label>
                        </div>
                    </div>
                    <div class="tab-col-3 col p-0  d-flex justify-content-between ">
                        <div class="tab-row-value">
                            <p id="edit-company-number"><input type="text" class="form-control" name="companyNumber" value="{{ optional($company)->company_number }}" /></p>

                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="verifyCompanyNumber">Verify</a>
                            <a href="javascript:void(0);" class="Edit" id="cancelVerifyCompanyNumber" style="display:none">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Edit Company Number -->

            <hr class="row-divider" />
            <!-- Edit Vat Number -->
            <div id="vat_number" style="display: {{$company && $company->is_vat_number_verified? 'block' : 'none'}};">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-center">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Tax information</h5>
                        </div>
                    </div>

                    <div class="tab-col-2 min-width-220">
                        <div class="tab-row-label">
                            <label class="VAT-Number">VAT number</label>
                        </div>
                    </div>
                    <div class="tab-col-3 col p-0  d-flex justify-content-between align-self-center">
                        <div class="tab-row-value">
                            <p class="p-0" id="vat-number">{{ optional($company)->vat_number }}</p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Verify" id="editVatNumber">Edit</a>
                        </div>

                    </div>
                </div>
            </div>

            <div id="edit_vat_number" style="display: {{$company && $company->is_vat_number_verified? 'none' : 'block'}};">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-center">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Tax information</h5>
                        </div>
                    </div>

                    <div class="tab-col-2 min-width-220">
                        <div class="tab-row-label">
                            <label class="VAT-Number">VAT number</label>
                        </div>
                    </div>
                    <div class="tab-col-3 col p-0  d-flex justify-content-between align-self-center">
                        <div class="tab-row-value">
                            <p class="p-0" id="vat-number"><input type="text" class="form-control" name="vatNumber" value="{{ optional($company)->vat_number }}" /></p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="verifyVatNumber">Verify</a>
                            <a href="javascript:void(0);" class="Edit" id="cancelVerifyVatNumber" style="display:none">Cancel</a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END Edit Vat Number -->

            <hr class="row-divider" />

            <!-- Edit Address Detail -->
            <div id="company_address_detail">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Address</h5>
                        </div>
                    </div>

                    <div class="tab-col-3 col p-0  d-flex justify-content-between ">
                        <div class="tab-row-value">
                            <div>
                                <label class="Address-1 d-inline-block min-width-220">Address 1</label>
                                <p class="d-inline-block" id="companyAddress1">{{ optional($company)->address_1 }}&nbsp;</p>
                            </div>

                            <div>
                                <label class="Address-2 d-inline-block min-width-220">Address 2</label>
                                <p class="d-inline-block" id="companyAddress2">{{ optional($company)->address_2 }}&nbsp;</p>
                            </div>

                            <div>
                                <label class="Post-Code d-inline-block min-width-220">Post code/Zip</label>
                                <p class="d-inline-block" id="companyPostCode">{{ optional($company)->post_code }}&nbsp;</p>
                            </div>

                            <div>
                                <label class="City d-inline-block min-width-220">City</label>
                                <p class="d-inline-block" id="companyCity">{{ optional($company)->city }}&nbsp;</p>
                            </div>

                            <div>
                                <label class="Country d-inline-block min-width-220">Country</label>
                                <p class="d-inline-block" id="companyCountry">{{ optional($company)->country }}&nbsp;</p>
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="edit_company_address_detail">Edit</a>
                        </div>

                    </div>
                </div>
            </div>
            <div id="company_address_detail_edit" style="display: none;">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Address</h5>
                        </div>
                    </div>

                    <div class="tab-col-3 col p-0  d-flex justify-content-between ">
                        <div class="tab-row-value ">
                            <div>
                                <label class="Address-1 d-inline-block min-width-220">Address 1</label>
                                <p class="d-inline-block"><input type="text" class="form-control" name="address_1" value="{{ optional($company)->address_1 }}" /></p>
                            </div>

                            <div>
                                <label class="Address-2 d-inline-block min-width-220">Address 2</label>
                                <p class="d-inline-block"><input type="text" class="form-control" name="address_2" value="{{ optional($company)->address_2}}" /></p>
                            </div>

                            <div>
                                <label class="Post-Code d-inline-block min-width-220">Post code/Zip</label>
                                <p class="d-inline-block"><input type="text" class="form-control" name="post_code" value="{{ optional($company)->post_code }}" /></p>
                            </div>

                            <div>
                                <label class="City d-inline-block min-width-220">City</label>
                                <p class="d-inline-block"><input type="text" class="form-control" name="city" value="{{ optional($company)->city }}" /></p>
                            </div>

                            <div>
                                <label class="Country d-inline-block min-width-220">Country</label>
                                <p class="d-inline-block"><input type="text" class="form-control" name="country" value="{{ optional($company)->country }}" /></p>
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="save_company_address_detail">Save</a>
                            <a href="javascript:void(0);" class="Edit" id="cancel_company_address_detail">Cancel</a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END Edit Address Detail -->

            <hr class="row-divider" />

            <!-- Edit IBan Number -->
            <div id="bank_number" style="display:{{ $company && $company->is_ban_number_verified? 'block' : 'none' }};">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Bank Information </h5>
                        </div>
                    </div>
                    <div class="tab-col-2 min-width-220">
                        <div class="tab-row-label">
                            <label class="IBAN">IBAN</label>
                        </div>
                    </div>
                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value">
                            <p class="" id="iban_number">{{ optional($company)->i_ban_number }}</p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Verify" id="editIbanNumber">Edit</a>

                        </div>
                    </div>
                </div>
            </div>
            <div id="edit_bank_number" style="display:{{ $company && $company->is_ban_number_verified? 'none' : 'block' }};">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Bank Information </h5>
                        </div>
                    </div>
                    <div class="tab-col-2 min-width-220">
                        <div class="tab-row-label">
                            <label class="IBAN">IBAN</label>
                        </div>
                    </div>
                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value">
                            <p class=""><input type="text" class="form-control" name="iBanNumber" value="{{ optional($company)->i_ban_number }}" /></p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="varify_iban_number">Verify</a>
                            <a href="javascript:void(0);" class="Edit" id="cancel_iban_number">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Edit IBan Number -->

            <hr class="row-divider" />

            <!-- Edit Office Phone Number -->
            <div id="office_phone_number">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Office</h5>
                        </div>
                    </div>
                    <div class="tab-col-2 min-width-220">
                        <div class="tab-row-label">
                            <label class="Phone-Number">Phone number</label>
                        </div>
                    </div>
                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value">
                            <p class="" id="office-phone-number">{{ optional($company)->phone_number }}</p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="edit_office_phone_number">Edit</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="office_phone_number_edit" style="display: none;">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Office</h5>
                        </div>
                    </div>
                    <div class="tab-col-2 min-width-220">
                        <div class="tab-row-label">
                            <label class="Phone-Number">Phone number</label>
                        </div>
                    </div>
                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value">
                            <p class=""><input type="text" class="form-control" name="companyPhoneNumber" value="{{ optional($company)->phone_number }}" /></p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="save_office_phone_number">Save</a>
                            <a href="javascript:void(0);" class="Edit" id="cancel_office_phone_number">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Edit Office Phone Number -->

            <hr class="row-divider" />
            <!-- Edit Website URL -->
            <div id="website_url">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Web address</h5>
                        </div>
                    </div>
                    <div class="tab-col-2 min-width-220">
                        <div class="tab-row-label">
                            <label class="URL">URL</label>
                        </div>
                    </div>
                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value">
                            <p class=""><a href="{{ optional($company)->website_url }}" style="text-decoration:underline;" id="companyWebsiteUrl"></a>
                            </p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="edit_website_url">Edit</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="website_url_edit" style="display: none;">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Web address</h5>
                        </div>
                    </div>
                    <div class="tab-col-2 min-width-220">
                        <div class="tab-row-label">
                            <label class="URL">URL</label>
                        </div>
                    </div>
                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value">
                            <p class="">
                                <input type="text" class="form-control" name="companyWebsiteUrl" value="{{ optional($company)->website_url }}" />
                            </p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="save_website_url"> Save </a>
                            <a href="javascript:void(0);" class="Edit" id="cancel_website_url"> Cancel </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Edit Website URL -->

            <hr class="row-divider" />
            <!-- Edit User Information -->
            <div id="user_info">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">User</h5>
                        </div>
                    </div>

                    <div class="tab-col-3 col p-0  d-flex justify-content-between align-self-start">
                        <div class="tab-row-value newtab-rw">
                            <div>
                                <label class="Your-Name d-inline-block min-width-220">Your name</label>
                                <p class="d-inline-block" id="user-name">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="Sign-In-Email d-inline-block min-width-220">Sign-In Email</label>
                                <p class="d-inline-block">{{ $user->email }}</p>
                            </div>

                            <div>
                                <label class="Direct-Phone-number d-inline-block min-width-220">Your Direct Phone number</label>
                                <p class="d-inline-block" id="user-contact-number">{{ $user->contact_number }} &nbsp;</p>
                            </div>
                            <div>
                                <label class="Password d-inline-block min-width-220">Password</label>
                                <p class="d-inline-block">*******************</p>
                            </div>
                            <div>
                                <label class="Confirm-Password d-inline-block min-width-220">Confirm-Password</label>
                                <p class="d-inline-block">*******************</p>
                            </div>
                        </div>
                        <div class="float-right">

                            <a href="javascript:void(0);" class="Edit mb-5 d-block" id="edit_user_info">Edit</a>
                            <!-- <a href="javascript:void(0);" class="Edit d-block" id="edit_user_info">Edit</a> -->
                        </div>
                    </div>
                </div>
            </div>

            <div id="user_info_edit" style="display: none;">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">User</h5>
                        </div>
                    </div>

                    <div class="tab-col-3 col p-0  d-flex justify-content-between align-self-start">
                        <div class="tab-row-value newtab-rw">
                            <div>
                                <label class="Your-Name d-inline-block min-width-220">Your name</label>
                                <p class="d-inline-block" id="user-name"><input type="text" class="form-control" name="name" value="{{ $user->name }}" /></p>
                            </div>

                            <div>
                                <label class="Sign-In-Email d-inline-block min-width-220">Sign-In Email</label>
                                <p class="d-inline-block">
                                    <input type="text" class="form-control" name="email" value="{{ $user->email }}" />
                                </p>
                            </div>
                            <div>
                                <label class="Direct-Phone-number d-inline-block min-width-220">Your Direct Phone number</label>
                                <p class="d-inline-block" id="user-contact-number"><input type="text" class="form-control" name="contact_number" value="{{ $user->contact_number }}" /></p>
                            </div>
                            <div>
                                <label class="Password d-inline-block min-width-220">Password</label>
                                <p class="d-inline-block"><input type="password" class="form-control" name="password" value="" /></p>
                            </div>
                            <div>
                                <label class="Confirm-Password d-inline-block min-width-220">Confirm-Password</label>
                                <p class="d-inline-block"><input type="password" class="form-control" name="password_confirmation" value="" /></p>
                            </div>
                        </div>
                        <div class="float-right">

                            <a href="javascript:void(0);" class="Edit" id="save_user_info">Save</a>
                            <a href="javascript:void(0);" class="Edit" id="cancel_user_info">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit User Information -->

            <hr class="row-divider" />

            <div id="onboarding_text">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Invitations</h5>
                        </div>
                    </div>

                    <div class="tab-col-2 min-width-220 d-flex align-self-start">
                        <div class="tab-row-label">
                            <label class="Invitations-Onboarding">Onboarding</label>
                        </div>
                    </div>

                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value col-md-9 pl-0">

                            <p class=" invitations-note mb-4">
                                <span id="show_onboarding_mail_subject">{{ optional($company)->onboarding_mail_subject }}</span>
                                <span class="mb-2" id="onboarding-message">
                                    {!! nl2br(optional($company)->onboarding_mail) !!}
                                </span>

                                {!! optional($settingsMail)->onboarding_content !!}
                            </p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="edit_onboarding_message">Edit</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="onboarding_text_edit" style="display: none;">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold">Invitations</h5>
                        </div>
                    </div>

                    <div class="tab-col-2 min-width-220 d-flex align-self-start">
                        <div class="tab-row-label">
                            <label class="Invitations-Onboarding">Onboarding</label>
                        </div>
                    </div>

                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value col-md-9 pl-0">
                            <p class="invitations-note mb-4">
                                <span>
                                    <input class="form-control" type="text" value="{{ optional($company)->onboarding_mail_subject }}" id="onboarding_mail_subject" />
                                </span>
                                <span class="mb-2" id="onboarding_mail_content">
                                    <textarea class="form-control" id="onboarding_message">{{ optional($company)->onboarding_mail }}</textarea>

                                    {!! optional($settingsMail)->onboarding_content !!}
                                </span>
                            </p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="save_onboarding_message">Save</a>
                            <a href="javascript:void(0);" class="Edit" id="cancel_onboarding_message">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="invoice_result_text">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold"></h5>
                        </div>
                    </div>

                    <div class="tab-col-2 min-width-220 d-flex align-self-start">
                        <div class="tab-row-label">
                            <label class="Invitations-Invoice-Result">Check the invoice results</label>
                        </div>
                    </div>

                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value col-md-9 pl-0">
                            <p class="invitations-note mb-4">
                                <span id="show_invoice_result_mail_subject">
                                    {{ optional($company)->invoice_result_mail_subject }}
                                </span>
                                <span class="mb-2" id="invoice-result-message">
                                    {!! nl2br(optional($company)->check_the_invoice_mail) !!}
                                </span>

                                {!! optional($settingsMail)->check_the_invoice_content !!}
                            </p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="edit_invoice_result_message">Edit</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="invoice_result_text_edit" style="display: none;">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold"></h5>
                        </div>
                    </div>

                    <div class="tab-col-2 min-width-220 d-flex align-self-start">
                        <div class="tab-row-label">
                            <label class="Invitations-Invoice-Result">Check the invoice results</label>
                        </div>
                    </div>

                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value col-md-9 pl-0">
                            <p class="invitations-note mb-4">
                                <span>
                                    <input class="form-control" type="text" value="{{ optional($company)->invoice_result_mail_subject }}" id="invoice_result_mail_subject" />
                                </span>
                                <span class="mb-2" id="check_the_invoice_mail">
                                    <textarea class="form-control" id="invoice_result_message">{{ optional($company)->check_the_invoice_mail }}</textarea>
                                    {!! optional($settingsMail)->check_the_invoice_content !!}
                                </span>
                            </p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="save_invoice_result_message">Save</a>
                            <a href="javascript:void(0);" class="Edit" id="cancel_invoice_result_message">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="supplier_verification_text">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold"></h5>
                        </div>
                    </div>

                    <div class="tab-col-2 min-width-220 d-flex align-self-start">
                        <div class="tab-row-label">
                            <label class="Invitations-Supplier-Verification">Supplier Verification</label>
                        </div>
                    </div>

                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value col-md-9 pl-0">
                            <p class="invitations-note mb-4">
                                <span id="show_supplier_verification_mail_subject">
                                    {{ optional($company)->supplier_verification_mail_subject }}
                                </span>
                                <span class="mb-2" id="supplier-verification-message">
                                    {!! nl2br(optional($company)->supplier_verification_mail) !!}
                                </span>

                                {!! optional($settingsMail)->supplier_verification_content !!}
                            </p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="edit_supplier_verification_message">Edit</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="supplier_verification_text_edit" style="display: none;">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                        <div class="tab-row-title">
                            <h5 class="font-weight-bold"></h5>
                        </div>
                    </div>

                    <div class="tab-col-2 min-width-220 d-flex align-self-start">
                        <div class="tab-row-label">
                            <label class="Invitations-Supplier-Verification">Supplier Verification</label>
                        </div>
                    </div>

                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value col-md-9 pl-0">
                            <p class="invitations-note mb-4">
                                <span>
                                    <input class="form-control" type="text" value="{{ optional($company)->supplier_verification_mail_subject }}" id="supplier_verification_mail_subject" />
                                </span>
                                <span id="supplier_verification_mail">
                                    <textarea class="form-control" id="supplier_verification_message">{{ optional($company)->supplier_verification_mail }}</textarea>

                                    {!! optional($settingsMail)->supplier_verification_content !!}
                                </span>
                            </p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="save_supplier_verification_message">Save</a>
                            <a href="javascript:void(0);" class="Edit" id="cancel_supplier_verification_message">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>


            <div id="existing_supplier_text">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                    </div>

                    <div class="tab-col-2 min-width-220 d-flex align-self-start">
                        <div class="tab-row-label">
                            <label class="Existing-Suppliers">Existing Suppliers</label>
                        </div>
                    </div>



                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value col-md-9 pl-0">
                            <p class="invitations-note mb-4">
                                <span id="show_existing_supplier_mail_verification">
                                    {{ optional($company)->existing_supplier_mail_verification }}
                                </span>
                                <span class="mb-2" id="existing-supplier-message">
                                    {!! nl2br(optional($company)->existing_supplier_mail) !!}
                                </span>
                                {!! optional($settingsMail)->existing_supplier_content !!}
                            </p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="edit_existing_supplier">Edit</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="existing_supplier_text_edit" style="display: none;">
                <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                    <div class="tab-col-1 min-width-220 d-flex align-self-start">
                    </div>

                    <div class="tab-col-2 min-width-220 d-flex align-self-start">
                        <div class="tab-row-label">
                            <label class="Existing-Suppliers">Existing Suppliers</label>
                        </div>
                    </div>



                    <div class="tab-col-3 col p-0  d-flex justify-content-between">
                        <div class="tab-row-value col-md-9 pl-0">
                            <p class="invitations-note mb-4">
                                <span>
                                    <input class="form-control" type="text" value="{{ optional($company)->existing_supplier_mail_verification }}" id="existing_supplier_mail_verification" />
                                </span>
                                <span id="existing_supplier_mail">
                                    <textarea class="form-control" id="existing_supplier">{{ optional($company)->existing_supplier_mail }}</textarea>
                                    {!! optional($settingsMail)->existing_supplier_content !!}
                                </span>
                            </p>
                        </div>
                        <div class="float-right">
                            <a href="javascript:void(0);" class="Edit" id="save_existing_supplier">Save</a>
                            <a href="javascript:void(0);" class="Edit" id="cancel_existing_supplier">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>


            <hr class="row-divider" />

            <div class="row d-flex align-items-center pl-4 pr-4 mt-3">
                <div class="tab-col-1 min-width-220 d-flex align-self-start">
                    <div class="tab-row-title">
                        <h5 class="font-weight-bold">Onboarding</h5>
                    </div>
                </div>



                <div class="tab-col-3 col p-0  d-flex justify-content-between mt-3">

                    <div class="tab-row-value mt-n3 row">
                        <label class="Onboarding mb-3 col-md-3 float-left min-width-220">Onboarding</label>

                        <div class="form-check nw-frmchk col-md-9  mb-3">
                            <input class="form-check-input cursor-pointer" type="checkbox" value="" id="onboarding-area" required {{ optional($company)->is_onboarding ? 'checked="checked"' : '' }} />
                            <label class="cursor-pointer" for="onboarding-area"> Show only the onboarding area </label>
                        </div>

                        <label class="ID-Document mb-3 col-md-3 float-left min-width-220">ID-Document</label>

                        <div class="form-check nw-frmchk mb-3 col-md-9">
                            <input class="form-check-input cursor-pointer" type="checkbox" checked disabled id="id-verification" required {{ optional($company)->is_id_document ? 'checked="checked"' : '' }} />


                            <label class="cursor-pointer" for="id-verification"> User Id verification in the app. Default and can not be removed</label>
                        </div>

                        <label class="Utility-Bill mb-3 float-left min-width-220 col-md-3">Utility bill upload</label>

                        <div class="form-check nw-frmchk col-md-9">
                            <input class="form-check-input cursor-pointer" type="checkbox" value="" id="utility-document" required {{ optional($company)->is_utility_bill_uploaded ? 'checked="checked"' : '' }} />
                            <label class="cursor-pointer" for="utility-document"> If you want them to upload a utility document to verify their living address</label>
                        </div>

                        <label class="Utility-Bill mb-3 float-left min-width-220 col-md-3">New supplier verification</label>

                        <div class="form-check nw-frmchk col-md-9">
                            <input class="form-check-input cursor-pointer" type="checkbox" value="" id="new-supplier-verification" required {{ optional($company)->new_supplier_verification ? 'checked="checked"' : '' }} />
                            <label class="cursor-pointer" for="utility-document">If you tick this box our system will automatically
                                add new customers and ask them to verify their
                                companies.</label>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>