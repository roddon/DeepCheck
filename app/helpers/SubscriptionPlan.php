<?php

namespace App\Helpers;

use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\StripeClient;

class SubscriptionPlan
{
    public function __construct()
    {
        $this->stripeKey = env('STRIPE_KEY');
        $this->stripeSecret = env('STRIPE_SECRET');
    }

    public function autoPayment($user, $price)
    {
        Stripe::setApiKey($this->stripeSecret);
        $stripeClient = new StripeClient($this->stripeSecret);

        $paymentMethod = $stripeClient->paymentMethods->all([
            'customer' => $user->stripe_id,
            'type' => 'card',
        ]);

        $paymentMethodId = $paymentMethod->data[0]->id;
        return $user->charge($price, $paymentMethodId, [
            'customer' => $user->stripe_id
        ]);
    }

    public function chargePayment($user, $price, $paymentMethodId)
    {
        $stripeCustomer = $user->createAsStripeCustomer(
            [
                'payment_method' => $paymentMethodId
            ]
        );

        return $user->charge($price, $paymentMethodId, [
            'customer' => $stripeCustomer->id
        ]);
    }
}