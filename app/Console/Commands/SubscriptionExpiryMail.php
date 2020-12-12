<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SubscriptionExpiryMail as SubExpieryMail;

class SubscriptionExpiryMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription-expiry-mail-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will notify user about subscription plan expiry';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $userSubscription = UserSubscription::where('automatic_top_up', '!=', 1)->where('is_active', 1)->get();
        $users = User::whereHas('userSubscription', function ($query) {
            return $query->where('automatic_top_up', '!=', 1)->where('is_active', 1);
        })->get();

        foreach ($users as $user) {
            $email = $user->email;
            Notification::route('mail', $email)->notify(new SubExpieryMail($user));
        }
    }
}
