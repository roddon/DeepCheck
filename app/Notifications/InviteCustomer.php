<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteCustomer extends Notification
{
    use Queueable;
    protected $customer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
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
        $customer = $this->customer;

        $user = $this->customer->user;
        $personalEmail = $user->email;
        $phoneNumber = $user->contact_number;
        $name = explode(' ', $user->name);
        $template = $user->company->onboarding_message;
        $subject = $user->company->onboarding_mail_subject;
        $customerName = $customer->name ?: $customer->company_name;

        $tmpltVars = [
            '<a>&lt;click here&gt;</a>' => '<a href="' . route('customer-verification', ['verification_code' => $customer->verification_token]) . '">click here</a>',
            '&lt;First Name&gt;' => isset($name[0]) ? $name[0] : '',
            '&lt;Last Name&gt;' => isset($name[1]) ? $name[1] : '',
            '&lt;person email&gt;' => $personalEmail,
            '&lt;phone number&gt;' => $phoneNumber,
        ];

        $mailTemplate = strtr($template, $tmpltVars);

        return (new MailMessage)
            ->subject($subject)
            ->markdown('manage.mailer.setting-notification-mail', ['mailTemplate' => $mailTemplate, 'name' => $customerName])
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
