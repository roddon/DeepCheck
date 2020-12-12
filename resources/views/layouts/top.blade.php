<header class="header">
    <div class="header_cn">
        <div class="logo">        
            <a href="#"><img src="{{ asset('assets/images/headerlogo.svg') }}" alt=""></a>
        </div>
        <div class="header_right">
            @if(Auth::user())
            
            <div class="hd_notification">
                <div class="noti_num">{{ isset($unreadNotification) ? $unreadNotification : 0 }}</div>
                <a href="{{ route('activityLog.index') }}" name="subscription[]"><img src="{{ asset('assets/images/notification.png') }}" alt=""></a>
            </div>
            <div class="hd_contact">
                <div class="noti_num">{{ isset($unreadEmail) ? $unreadEmail : 0 }}</div>
                <a href="{{ route('email.index') }}" name="subscription[]"><img src="{{ asset('assets/images/contact.png') }}" alt=""></a>
            </div>
            <div class="hd_profile">
                <a href="#" class="acout_drop_down">
                    <div class="profile_cn">
                        <div class="profile_img">
                        @php
                            $image = $company ? $company->getMedia('company_image') : null;
                            $imageUrl = isset($image[0]) ? $image[0]->getUrl() : asset('assets/images/Bitmap.png');
                        @endphp
                            <img src="{{ $imageUrl }}" alt="">
                        </div>
                        <div class="pro_name">{{ Auth::user()->name }}</div>
                        <div class="pro_caret"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                    </div>
                </a>

                <div class="profile_dropdown">
                    <ul>
                        <li><a href="{{ route('dashboard.create') }}"><i class="fas fa-tachometer-alt"></i> {{ __('Dashboard') }}</a></li>
                        <li>
                            <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="cursor: pointer;">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Sign out') }}
                            </a>
                            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
            @endif
        </div>
    </div>
</header>
