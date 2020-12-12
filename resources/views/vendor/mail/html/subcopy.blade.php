<p>Thank you for allowing us to verify you on behalf of ({{ $customer->user->name }}).
    When you click on the link below you will be brought to your bank's login screen and
    you will then need to use your own credentials to login.
</p>

<p>Our system is verifying that your bank account number belongs to you and we will also get you
    home address automatically without any need for additional verification.
</p>

<p>Your customer is happy to help you on phone number
    or via email.</p>
<p>Please add your information below to verify your information</p>
<ul>
    <!-- <li><span>Phone number</span><span>3433434343434343</span></li> -->
    <li><span>Email</span> <span>{{$customer->email}}</span></li>
</ul>
<div class="text-center">
    <a href="{{ route('customer-verification', ['verification_code' => $customer->verification_token])  }}" class="btn btn-primary invite mb-2"> Start verification</a>
</div>