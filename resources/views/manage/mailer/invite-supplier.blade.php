@extends('manage.mailer.mail')

@section('content')
<h3>Supplier verification </h3>
<div class="ln"></div>
<div class="thankuarea" id="emailView">
    <p>Thank you for allowing us to verify you on behalf of ({{ $supplier->user->name }}).
        When you click on the link below you will be brought to your bank's login screen and
        you will then need to use your own credentials to login.</p>


    <p>Our system is verifying that your bank account number belongs to you so
        your buyer is paying the money to the correct account.</p>


    <p>Your customer is happy to help you on phone number
        or via email.</p>
    <p class="mb-2">Please add your information below to verify your company information</p>
    <ul>
        @if($supplier->company_number)
        <li><span>Company number </span><span>{{ $supplier->company_number }}</span></li>
        @endif
        @if($supplier->vat_number)
        <li><span>VAT number</span> <span>{{ $supplier->vat_number }}</span></li>
        @endif
        <li><span>Email</span> <span>{{ $supplier->email }}</span></li>
        @if($supplier->website_url)
        <li>
            <span>Web address</span>
            <span>
                <a href="{{ $supplier->website_url }}" style="text-decoration:underline; color:#0094FF;">
                    {{ $supplier->website_url }}
                </a>
            </span>
        </li>
        @endif
    </ul>
    <div class="text-center">
        <a href="{{ route('verification.supplier.start', ['verification_code' => $supplier->verification_token])  }}" class="invite mb-3"> Start verification</a>
    </div>

</div>
@endsection