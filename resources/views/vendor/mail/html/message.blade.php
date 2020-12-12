@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}

<h3>Customer verification </h3>
<div class="ln"></div>
<div class="thankuarea">
    {{-- Subcopy --}}
    @isset($subcopy)
    @slot('subcopy')
    @component('mail::subcopy', ['customer' => $customer])
    {{ $subcopy }}
    @endcomponent
    @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
    @component('mail::footer')
    © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
    @endcomponent
</div>
@endslot
@endcomponent