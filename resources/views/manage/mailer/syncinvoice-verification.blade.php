@extends('manage.mailer.mail-deepcheck')

@section('content')

<h3>{{ $name }}, </h3>
<h3 style="margin-bottom:0;">Dear Sir, </h3>
<div class="ln"></div>
<div class="thankuarea" id="emailView">
    <p class="invitations-note mb-4">
        <span>
            We have analysed the Detector are when you synchronised your data for analysis.
        </span>

        <span>
            We have found a difference between your accounts and the invoice files you have uploaded for file
            content analysis. The invoices are below in the table this email.
        </span>

        <span>
            Please upload the files for those invoices so we can verify them correctly.
        </span>

        <span>
            Kind regards,
        </span>
    </p>
    <p>Support</p>
    <p style="padding-left: 25px;">
        <table style="width:100%; padding-left:40px">
            <tr>
                <th width="100"> Date </th>
                <th width="150"> Invoice Number </th>
                <th width="200"> Supplier Name </th>
            </tr>
            @foreach ($invoices as $invoice)
            <tr>
                <td> <span>{{ $invoice->present()->issueDate }}</span> </td>
                <td> <span>{{ $invoice->invoice_number }}</span> </td>
                <td> <span>{{ optional($invoice->supplier)->name }}</span> </td>
            </tr>
            @endforeach
        </table>
    </p>
</div>
@endsection
