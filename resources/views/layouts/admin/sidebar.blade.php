<div class="dash_sidebar">
    <nav>
        <ul>
            <li class="{{request()->routeIs('admin.users.*') ? 'active' : ''}}">
                <a class="" href="{{ route('admin.users.index') }}"><img src="{{ asset(__('menu.admin.users.icon')) }}" />
                    <span>{{__('menu.admin.users.name')}}</span>
                </a>
            </li>
            <li class="{{request()->routeIs('admin.members.*') ? 'active' : ''}}">
                <a class="" href="{{ route('admin.members.index') }}"><img src="{{ asset(__('menu.admin.members.icon')) }}" />
                    <span>{{__('menu.admin.members.name')}}</span>
                </a>
            </li>
            <li class="{{request()->routeIs('admin.subscription_plans.*') ? 'active' : ''}}">
                <a class="" href="{{ route('admin.subscription_plans.index') }}"><img src="{{ asset(__('menu.admin.subscription_plans.icon')) }}" />
                    <span>{{__('menu.admin.subscription_plans.name')}}</span>
                </a>
            </li>
            <li class="{{request()->routeIs('admin.activityLog.index') ? 'active' : ''}}">
                <a class="" href="{{ route('admin.activityLog.index') }}"><img src="{{ asset(__('menu.admin.activity_log.icon')) }}" />
                    <span>{{__('menu.admin.activity_log.name')}}</span>
                </a>
            </li>

            <li class="{{request()->routeIs('admin.tinkLog.index') ? 'active' : ''}}">
                <a class="" href="{{ route('admin.tinkLog.index') }}"><img src="{{ asset(__('menu.admin.activity_log.icon')) }}" />
                    <span>{{__('menu.admin.tink_log.name')}}</span>
                </a>
            </li>

            <li class="{{request()->routeIs('admin.trueLayerLog.index') ? 'active' : ''}}">
                <a class="" href="{{ route('admin.trueLayerLog.index') }}"><img src="{{ asset(__('menu.admin.activity_log.icon')) }}" />
                    <span>{{__('menu.admin.true_layer_log.name')}}</span>
                </a>
            </li>

            <li class="{{request()->routeIs('admin.stripeLog.index') ? 'active' : ''}}">
                <a class="" href="{{ route('admin.stripeLog.index') }}"><img src="{{ asset(__('menu.admin.stripe_log.icon')) }}" />
                    <span>{{__('menu.admin.stripe_log.name')}}</span>
                </a>
            </li>

            <li class="{{request()->routeIs('admin.customerLog.index') ? 'active' : ''}}">
                <a class="" href="{{ route('admin.customerLog.index') }}"><img src="{{ asset(__('menu.admin.customer_log.icon')) }}" />
                    <span>{{__('menu.admin.customer_log.name')}}</span>
                </a>
            </li>

            <li class="{{request()->routeIs('admin.counterLog.index') ? 'active' : ''}}">
                <a class="" href="{{ route('admin.counterLog.index') }}"><img src="{{ asset(__('menu.admin.counter_log.icon')) }}" />
                    <span>{{__('menu.admin.counter_log.name')}}</span>
                </a>
            </li>

            <li class="{{request()->routeIs('admin.change-request.index') ? 'active' : ''}}">
                <a class="" href="{{ route('admin.change-request.index') }}"><img src="{{ asset(__('menu.admin.change_request.icon')) }}" />
                    <span>{{__('menu.admin.change_request.name')}}</span>
                </a>
            </li>

        </ul>
    </nav>
</div>
