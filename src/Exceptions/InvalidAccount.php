<?php

namespace Ntbies\CashierStripe\Exceptions;

use Exception;

class InvalidAccount extends Exception
{
    /**
     * Create a new InvalidAccount instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $partner
     * @return static
     */
    public static function notYetCreated($partner)
    {
        return new static(class_basename($partner)." has not a Stripe account yet.");
    }
}