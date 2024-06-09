<?php

namespace Ntbies\CashierStripe\Contracts;

use Stripe\Account;
interface IsPartner
{
    
    /**
     * Create the stripe account
     * @param array $options
     * @return Account
     */
    public function createStripeAccount(array $options = []): Account;
    
    /**
     * Determine either the partner has already an Account
     * @return bool
     */
    public function hasStripeAccount(): bool;
    
    /**
     * Get the account Id
     * @return string|null will return null if the model has no account id.
     */
    public function stripeAccountId(): string|null;
    
    /**
     * Get the account link to allow user access Connect platform
     * via the onboarding
     * @return string The url to access the onboarding
     */
    public function stripeAccountLink(?string $refresh_url = null, ?string $return_url = null): string;
    
    /**
     * Return the stripe login link for express connected account using the express dashboard.
     * As describe at this link: https://docs.stripe.com/api/accounts/login_link
     *
     * @return string
     */
    public function stripeLoginLink(): string;
    
    /**
     * Provides the account email address
     * @return string
     */
    public function stripeAccountEmail(): string;
    
    /**
     * Provides the account country iso code
     * @return string
     */
    public function stripeAccountCountry(): string;
    
    
    
}