<?php

namespace Ntbies\CashierStripe\Events;

use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Stripe\Checkout\Session;

class CheckoutSessionCompleted implements ShouldHandleEventsAfterCommit
{
    use Dispatchable, SerializesModels;
    
    public Session $checkoutSession;
    
    public function __construct(Session $checkoutSession)
    {
        $this->checkoutSession = $checkoutSession;
    }
}
