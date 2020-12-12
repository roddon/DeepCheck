<?php

namespace App\Listeners;

use App\Models\EmailLog;
use Carbon\Carbon;
use Illuminate\Mail\Events\MessageSent;;

class LogEmail
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        $message = $event->message;
        $userId = null;
        if (\Auth::check()) {
            $userId = \Auth::user()->id;
        }

        EmailLog::insert([
            'to' => implode(',', array_keys($message->getTo())),
            'from' => implode(',', array_keys($message->getFrom())),
            'cc' => null,
            'bcc' => null,
            'subject' => $message->getSubject(),
            'body' => $message->getBody(),
            'user_id' => $userId,
            'created_at' => Carbon::now()
        ]);
    }
}
