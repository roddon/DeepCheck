@extends('manage.mailer.mail-deepcheck')

@section('content')

<h3>Dear {{ $user->name }}, </h3>
<div class="ln"></div>
<div class="thankuarea" id="emailView">
    <p class="invitations-note mb-4">

        <span>Thank you for uploading the invoice for analysis. We are now in full swing with looking into the invoice.</span>
        <span>Sometimes the analysis will take up to 10 minutes due to a thorough process. To see the results you must login to our server and review.</span>

        <span>Please use your email: {{ $user->email }} Login with the password: {{ $password }}</span>
        <br>
        <br>
        <span>Regards</span>
        <span>deepcheck</span>
    </p>
</div>
@endsection
