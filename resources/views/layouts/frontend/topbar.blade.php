<!-- <!--Preloader -->
<div class="preloader" style="display: none;">
    <div class="spinner">
        <img src="{{asset('frontend/images/deepcheck-loader.png')}}" />
    </div>
</div>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PLVQ5JN" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- Mainmenu-Area -->
<nav class="navbar mainmenu-area" data-spy="affix" data-offset-top="197">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div id="search-box" class="collapse">
                    <form action="#">
                        <input type="search" class="form-control" placeholder="What do you want to know?">
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="navbar-header smoth">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainmenu">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="{{asset('frontend/images/home.png')}}" alt="Deepcheck Logo" width="196"></a>
                </div>
                <div class="collapse navbar-collapse navbar-right" id="mainmenu">
                    <ul class="nav navbar-nav navbar-right help-menu">
                        <li><a href=""><i class="icofont icofont-user-alt-4"></i></a></li>
                        <li><a href="#search-box" data-toggle="collapse"><i class="icofont icofont-search-alt-2"></i></a></li>
                        <li class="select-cuntry">
                            <select name="counter" id="counter">
                                <option value="ENG">ENG</option>
                                <option value="BEN">BEN</option>
                                <option value="ARA">ARA</option>
                                <option value="ARG">ARG</option>
                                <option value="CHV">CHV</option>
                            </select>
                        </li>
                    </ul>
                    @php
                        $maintenance = config('config.maintenance');
                        $loginLink = '#loginmodal';
                        if($maintenance) {
                            $loginLink = '#maintenanceModal';
                        }
                    @endphp
                    <ul class="nav navbar-nav primary-menu">
                        <!--<li class="active"><a href="#home-area">Home</a></li> -->
                        <li><a href="{{route('about-us')}}">About Us</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('safe-pay')}}">SafePay</a></li>
                                <li><a href="{{route('document-check')}}">Check Invoice </a></li>
                                <li><a href="{{route('account-check')}}">Internal Fraud Check</a></li>
                                <li><a href="{{route('identity-check')}}">Onboarding/AML/KYC</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('document-check')}}">Check invoice</a></li>
                        <li><a href="{{route('technology')}}">Technology</a></li>
                        <li><a href="https://deepcheck.one/news" target="blank">News</a></li>
                        <li><a class="login-link" data-target="{{$loginLink}}" data-toggle="modal">Login/Signup</a></li>
                        <li><a href="#"><img src="{{asset('frontend/images/360.png')}}" width="37" /></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>