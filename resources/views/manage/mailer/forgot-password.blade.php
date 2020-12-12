@extends('manage.mailer.mail-deepcheck')

@section('content')

<h3>Dear {{ $user->name }}, </h3>
<div class="ln"></div>
<div class="thankuarea" id="emailView">
    <p class="invitations-note mb-4">

        <span>
            Your new password is {{ $password }}
        </span>
    </p>
</div>
@endsection