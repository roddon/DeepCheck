<?php

namespace App\Notifications;

use App\Models\Supplier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteSuppliers extends Notification
{
    use Queueable;
    protected $supplier;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Supplier $supplier, $flag = false)
    {
        $this->supplier = $supplier;
        $this->flag = $flag;
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

        $supplier = $this->supplier;

        $user = $this->supplier->user;
        $personalEmail = $user->email;
        $phoneNumber = $user->contact_number;
        $name = explode(' ', $user->name);
        $supplierName = $supplier->name ?: $supplier->company_name;

        if (!$this->flag) {
            $template = $user->company->supplier_verification_message;
            $subject = $user->company->supplier_verification_mail_subject;
        } else {
            $template = $user->company->existing_supplier_message;
            $subject = $user->company->existing_supplier_mail_verification;
        }


        $tmpltVars = [
            '<a>&lt;click here&gt;</a>' => '<a href="' . route('verification.supplier.start', ['verification_code' => $supplier->verification_token]) . '">click here</a>',
            '&lt;First Name&gt;' => isset($name[0]) ? $name[0] : '',
            '&lt;Last Name&gt;' => isset($name[1]) ? $name[1] : '',
            '&lt;person email&gt;' => $personalEmail,
            '&lt;phone number&gt;' => $phoneNumber,
        ];

        $mailTemplate = strtr($template, $tmpltVars);

        return (new MailMessage)
            ->subject($subject)
            ->markdown('manage.mailer.setting-notification-mail', ['mailTemplate' => $mailTemplate, 'name' => $supplierName])
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
