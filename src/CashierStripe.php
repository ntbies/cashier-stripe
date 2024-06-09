<?php

namespace Ntbies\CashierStripe;


use Illuminate\Database\Eloquent\SoftDeletes;
use Stripe\Account as StripeAccount;
use Stripe\Customer;

class CashierStripe
{
    public static $partnerModel = null;

    /**
     * Retrieve the partner object for a given stripe Account ID
     * @param string|StripeAccount|null $stripeAccountId
     * @return void
     */
    public static function findPartner(null|string|StripeAccount $stripeAccountId){
        $accountId = $stripeAccountId instanceof StripeAccount ? $stripeAccountId->id : $stripeAccountId;
        $model = static::getPartnerModel();
        $builder = in_array(SoftDeletes::class, class_uses_recursive($model))
            ? $model::withTrashed()
            : new $model;

        return $accountId ? $builder->where('stripe_account_id', $accountId)->first() : null;
    }

    /**
     * Get the model used to represent the account
     * @return string
     */
    public static function getPartnerModel(): string{
        return static::$partnerModel
            ?? (config('cashier.account.partner_model') ?: 'App\\Models\\User');
    }

    /**
     * Set the model to represent an account
     * @param string $partnerModel
     * @return void
     */
    public static function setPartnerModel(string $partnerModel){
        static::$partnerModel = $partnerModel;
    }

}
