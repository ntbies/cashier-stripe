<?php

namespace Ntbies\CashierStripe\Exceptions;

use Exception;

class AccountAlreadyExists extends Exception
{
    /**
     * Create a new AccountAlreadyExists instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $partner
     * @return static
     */
    public static function exists($partner)
    {
        return new static(class_basename($partner)." has already a Stripe account with ID {$partner->stripe_account_id}.");
    }
}