<div class="dash_sidebar">
    <nav>
        <ul>
            @if(!isset($company) || !optional($company)->is_onboarding)
            <li class="{{request()->routeIs('dashboard.create') ? 'active' : ''}}">
                <a class="" href="{{ url('/dashboard') }}"><img src="{{ asset(__('menu.dashboard.icon')) }}" />
                    {{__('menu.dashboard.name')}}
                </a>
            </li>
            @endif

            @if((!isset($company) || !optional($company)->is_onboarding))

            @if(config('config.menu.check-invoice'))
            <li class="{{request()->routeIs('invoice*') || request()->routeIs('sVault.supplier*') ? 'active' : ''}}">
                <a class="" href="{{ route('invoice.index') }}"><img src="{{ asset(__('menu.s-vault.invoice.icon')) }}" />
                    {{__('menu.s-vault.invoice.name')}} <sup class="set setfst">FREE</sup>
                </a>
            </li>
            @endif
            @if(config('config.menu.detector'))
            <li class="{{request()->routeIs('detector*') ? 'active' : ''}}">
                <a name="subscription[]" href="{{route('detector.accountingCheck')}}"><img src="{{ asset(__('menu.detector.icon')) }}" />
                    {{__('menu.detector.name')}}
                </a>
            </li>
            @endif

            @if(config('config.menu.safepay'))
            <li class="{{request()->routeIs('liveProtect*') ? 'active' : ''}}">
                <a name="subscription[]" href="{{route('liveProtect.index')}}"><img src="{{ asset(__('menu.live-protect.icon')) }}" />
                    {{ __('menu.live-protect.name') }}
                </a>
            </li>
            @endif
            @endif

            @if(config('config.menu.onboarding'))
            <li class="{{request()->routeIs('onboarding*') ? 'active' : ''}}">
                <a name="subscription[]" class="" href="{{ route('onboarding.index') }}"><img src="{{ asset(__('menu.onboard.icon')) }}" />
                    {{ __('menu.onboard.name') }}
                </a>
            </li>
            @endif
            @if(config('config.menu.enterprise') && (!isset($company) || !optional($company)->is_onboarding))
            <li class="{{request()->routeIs('enterprise*') ? 'active' : ''}}">
                <a class="" href="{{ route('enterprise.index') }}"><img src="{{ asset(__('menu.enterprise.icon')) }}" />
                    {{__('menu.enterprise.name')}}
                </a>
            </li>
            @endif

            <li class="{{request()->routeIs('settings*') ? 'active' : ''}}">
                <a href="{{ route('settings.edit') }}"><img src="{{ asset(__('menu.settings.icon')) }}" />
                    {{ __('menu.settings.name') }}
                </a>
            </li>
        </ul>
    </nav>
</div>
