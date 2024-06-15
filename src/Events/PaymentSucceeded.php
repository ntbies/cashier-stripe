<?php

namespace Ntbies\CashierStripe\Events;

use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Stripe\PaymentIntent;

class PaymentSucceeded implements ShouldHandleEventsAfterCommit
{
    use Dispatchable, SerializesModels;
    
    public PaymentIntent $paymentIntent;
    
    public function __construct(PaymentIntent $paymentIntent)
    {
        $this->paymentIntent = $paymentIntent;
    }
}
