<?php

namespace App\Notifications;

use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Company $company, Request $request)
    {
        $this->company = $company;
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {


        if ($this->request->mailTemplate == 'SYNCINVOICE_VERIFICATION') {

            $name = $this->company->name;

            $invoices = Invoice::whereIn('id', $this->request->invoices)->get();

            return (new MailMessage)
                ->subject('Syncinvoce Verification')
                ->markdown('manage.mailer.syncinvoice-verification', [
                    'name' => $name,
                    'invoices' => $invoices
                ])
                ->action('Notification Action', url('/'));
        }



        $tmpltVars = [
            '&lt;First Name&gt;' => $this->request->firstName,
            '&lt;Last Name&gt;' => $this->request->lastName,
            '&lt;person email&gt;' => $this->request->personEmail,
            '&lt;phone number&gt;' => $this->request->phoneNumber,
        ];

        $name = $this->request->name;
        $companyInfo = $this->company;

        switch ($this->request->mailTemplate) {
            case 'ONBOARDING_MESSAGE':
                $tmpltVars['<a>&lt;click here&gt;</a>'] =
                    '<a href="' . route('customer-verification', ['verification_code' => $this->request->hasLink]) . '">click Here</a>';
                $template = $companyInfo->onboarding_message;
                $subject = $companyInfo->onboarding_mail_subject;
                break;
            case 'INVOICE_RESULT_MESSAGE':
                $template = $companyInfo->invoice_result_message;
                $subject = $companyInfo->invoice_result_message_subject;
                break;
            case 'SUPPLIER_VERIFICATION_MESSAGE':
                $tmpltVars['<a>&lt;click here&gt;</a>'] =
                    '<a href="' . route('verification.supplier.start', ['verification_code' => $this->request->hasLink]) . '">click Here</a>';
                $template = $companyInfo->supplier_verification_message;
                $subject = $companyInfo->supplier_verification_mail_subject;
                break;
            case 'EXISTING_SUPPLIER_MESSAGE':
                $tmpltVars['<a>&lt;click here&gt;</a>'] =
                    '<a href="' . route('verification.supplier.start', ['verification_code' => $this->request->hasLink]) . '">click Here</a>';
                $template = $companyInfo->existing_supplier_message;
                $subject = $companyInfo->existing_supplier_mail_verification;
                break;
            default:
                $template = $companyInfo->onboarding_message;
                $subject = $companyInfo->onboarding_mail_subject;
        }
        $mailTemplate = strtr($template, $tmpltVars);


        return (new MailMessage)
            ->subject($subject)
            ->markdown('manage.mailer.setting-notification-mail', ['mailTemplate' => $mailTemplate, 'name' => $name])
            ->action('Notification Action', url('/'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
