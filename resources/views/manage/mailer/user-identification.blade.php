@extends('manage.mailer.mail-deepcheck')

@section('content')

<h3>Dear {{ $user->name }}, </h3>
<div class="ln"></div>
<div class="thankuarea" id="emailView">
    <p class="invitations-note mb-4">

        <span>It’s time to confirm your email address.</span>

		<span>Have we got the right email address to reach you on? To confirm that you can get our emails, just click the link below.</span>

		<span class="mb-2 mt-2"><a href="{{ route('verification.user.start', ['verification_code' => $user->verification_token]) }}">Confirm my email address</a></span>

		<span>If you don’t know why you got this email, please get in touch with us so we can fix this for you.</span>

		<span>Thanks,</span>

		<span>The deepcheck team</span>
    </p>
</div>
@endsection