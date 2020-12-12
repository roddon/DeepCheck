@extends('manage.mailer.mail-deepcheck')

@section('content')

<h3>Dear {{ $name }}, </h3>
<div class="ln"></div>
<div class="thankuarea" id="emailView">
    <p class="invitations-note mb-4">
        {!! $mailTemplate !!}
        <span>PS! Some functionality is only working in Google Chrome browser</span>
    </p>
</div>
@endsection