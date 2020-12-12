<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\SubscriptionExpiryMail as SubExpMailModel;

class SubscriptionExpiryMail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $userSub = $this->user->userSubscription()->first();
        if ($userSub) {
            $endDate = Carbon::parse($userSub->end_date);
            $todayDate = Carbon::now();
            $diffInDays = $endDate->diffInDays($todayDate);
            $subTemplate = SubExpMailModel::find(1);
            $tmpltVars = [
                '&lt;Name&gt;' => $this->user->name
            ];

            $template = $subject = '';
            $mailFlag = 0;

            if ($endDate->lt($todayDate) && $diffInDays == 7) {
                $tmpltVars['&lt;no of days&gt;'] = 7;
                $tmpltVars['<a>&lt;press here&gt;</a>'] = '<a href="' . route('subscribe-plan', ['userId' => $this->user->id]) . '">press here</a>';;
                $template = $subTemplate->seven_days_before_exp;
                $subject = 'Time is running';
                $mailFlag = 1;
            }

            if ($endDate->lt($todayDate) && $diffInDays == 3) {
                $tmpltVars['&lt;no of days&gt;'] = 3;
                $tmpltVars['<a>&lt;press here&gt;</a>'] = '<a href="' . route('subscribe-plan', ['userId' => $this->user->id]) . '">press here</a>';;
                $template = $subTemplate->three_days_before_exp;
                $subject = '3 days left only';
                $mailFlag = 1;
            }

            if ($endDate->lt($todayDate) && $diffInDays == 1) {
                $tmpltVars['&lt;no of days&gt;'] = 1;
                $tmpltVars['<a>&lt;press here&gt;</a>'] = '<a href="' . route('subscribe-plan', ['userId' => $this->user->id]) . '">press here</a>';;
                $template = $subTemplate->one_days_before_exp;
                $subject = '1 day left only';
                $mailFlag = 1;
            }

            if ($endDate->gt($todayDate) && $diffInDays == 1) {
                $tmpltVars['&lt;no of days&gt;'] = 1;
                $tmpltVars['&lt;discount&gt;'] = 10;
                $tmpltVars['<a>&lt;press here&gt;</a>'] = '<a href="' . route('subscribe-plan', ['userId' => $this->user->id]) . '">press here</a>';;
                $template = $subTemplate->one_days_after_exp;
                $subject = 'Oops, perhaps a mistake';
                $mailFlag = 1;
            }

            if ($endDate->gt($todayDate) && $diffInDays == 3) {
                $tmpltVars['&lt;no of days&gt;'] = 3;
                $tmpltVars['&lt;discount&gt;'] = 15;
                $tmpltVars['<a>&lt;press here&gt;</a>'] = '<a href="' . route('subscribe-plan', ['userId' => $this->user->id]) . '">press here</a>';;
                $template = $subTemplate->three_days_after_exp;
                $subject = 'We miss you!';
                $mailFlag = 1;
            }

            if ($endDate->gt($todayDate) && $diffInDays == 7) {
                $tmpltVars['&lt;no of days&gt;'] = 7;
                $tmpltVars['&lt;discount&gt;'] = 20;
                $tmpltVars['<a>&lt;press here&gt;</a>'] = '<a href="' . route('subscribe-plan', ['userId' => $this->user->id]) . '">press here</a>';;
                $template = $subTemplate->seven_days_after_exp;
                $subject = 'Free additions perhaps?';
                $mailFlag = 1;
            }

            $mailTemplate = strtr($template, $tmpltVars);

            if ($mailFlag) {
                return (new MailMessage)
                    ->subject($subject)
                    ->markdown('manage.mailer.setting-notification-mail', ['mailTemplate' => $mailTemplate, 'name' => $this->user->name])
                    ->action('Notification Action', url('/'));
            }
        }
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
