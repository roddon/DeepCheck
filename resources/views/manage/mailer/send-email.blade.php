@extends('manage.mailer.mail')

@section('content')

<h3>Customer verification </h3>
<div class="ln"></div>
<div class="thankuarea" id="emailView">
    {!! $mailTemplate !!}
</div>
@endsection