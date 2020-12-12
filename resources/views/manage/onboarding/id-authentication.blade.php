<div class="inrcontsec" id="customer-authetication-area">
    <div class="row">
        <div class="col-lg-8">
            <h6 class="idstl">Scanned ID data</h6>
            <div class="inco_box">
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="inco_box_cn">
                            <span class="full-name-box">{{ $customer->name }}</span>

                            <span>Full Name</span>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="inco_box_cn">
                            {{ optional($customer->country)->name }}
                            <span>Country</span>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="inco_box_cn">
                            {{ $customer->present()->dob }}
                            <span>DOB</span>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="inco_box_cn">
                            {{ $customer->present()->gender }}
                            <span>Gender</span>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="inco_box_cn">
                            {{ $customer->passport_number }}
                            <span>Passport Number</span>
                        </div>
                    </div>
                    <br>

                    <div class="col-xl-4 col-md-6">
                        <div class="inco_box_cn">
                            {{ $customer->present()->dateOfExpiry }}
                            <span>Date of Expiry</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="mt-4">
                <h6 class="idstl">Location at scanning time</h6>
                <div class="overfldv">
                    <ul class="splrnm newsplrnm">
                        <li>
                            <span class="dv"><b>Country</b></span>

                            <span class="dv light" style="flex: 0.5;"> {{ optional($customer->country)->name }} </span>

                        </li>
                        <li>
                            <span class="dv"><b>Scan position</b></span>
                            <span class="dv">Longitude<span class="brk">Latitude</span> </span>
                            <span class="dv light">{{ $customer->latitude}} <span class="brk"> {{ $customer->longitude}} </span> </span>


                        </li>
                        <li>
                            <span class="dv"><b>Contact</b></span>
                            <span class="dv">Email <span class="brk">Phone number</span> </span>
                            <span class="dv light" title="{{ $customer->email}}"> {{ $customer->email}} <span class="brk"> {{ $customer->contact_number }} </span> </span>

                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-mbl">

            <div class="passportimg"><img src="{{asset('assets/images/blueimg.png')}}" alt=""></div>
            <div class="row justify-content-center align-items-center">
                <div class="selfie-img-wrapper mt-5 col-md-6">
                    <img src="{{ $customer->present()->getCapturePhoto }}" class="img-fluid" />
                    <p class="pt-2">Selfie</p>
                </div>

                <div class="selfie-img-wrapper mt-5 col-md-6">
                    <img src="{{ $customer->present()->getPassportPhoto }}" class="img-fluid" />
                    <p class="pt-2">Passport</p>
                </div>

            </div>

            @php
            $sanctionText = "Not Present";
            $sancClass = "no-present";
            @endphp
            @if($customer->is_in_sanction_list)
            @php
            $sanctionText = "Risk";
            $sancClass = "present-risk"
            @endphp
            @endif
            <div class="text-center">
                <a href="javascript:void(0);" class="sanc mt-5 {{$sancClass}}"> Sanction List
                    <span>{{$sanctionText}}</span></a>
            </div>

        </div>
    </div>
</div>