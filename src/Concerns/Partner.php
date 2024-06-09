<?php

namespace Ntbies\CashierStripe\Concerns;

use Laravel\Cashier\Cashier;
use Ntbies\CashierStripe\Exceptions\AccountAlreadyExists;
use Ntbies\CashierStripe\Exceptions\InvalidAccount;
use Stripe\Account;
use Stripe\Exception\ApiErrorException;

trait Partner
{
    /**
     * Provides the account email address
     * @return string
     */
    public function stripeAccountEmail(): string
    {
        return $this->stripeEmail();
    }
    
    /**
     * Provides the account country iso code
     * @return string
     */
    public function stripeAccountCountry(): string
    {
        return $this->country;
    }
    
    /**
     * Create the stripe account
     * @param array $options
     * @return Account
     * @throws AccountAlreadyExists|ApiErrorException
     */
    public function createStripeAccount(array $options = []): Account
    {
        if ($this->hasStripeAccount()) {
            throw AccountAlreadyExists::exists($this);
        }
        $parameters = array_merge([
            'country' => $this->country,
            'email' => $this->stripeAccountEmail(),
        ], config('cashier.account.options', [
            'type' => 'express'
        ]), $options ?? [], );
        $account = Cashier::stripe()->accounts
            ->create($parameters);
        $this->stripe_account_id = $account->id;
        $this->save();
        return $account;
    }
    
    /**
     * Determine either the partner has already an Account
     * @return bool
     */
    public function hasStripeAccount(): bool
    {
        return !empty($this->stripe_account_id);
    }
    
    /**
     * Get the account Id
     * @return string|null will return null if the model has no account id.
     */
    public function stripeAccountId(): string|null
    {
        return $this->stripe_account_id;
    }
    
    public function stripeAccountRefreshUrl(): string
    {
        $route_name = config('cashier.account.refresh_route', 'cashier.account.onboarding');
        return route($route_name, ['id' => $this->id]);
    }
    
    public function stripeAccountReturnUrl(): string
    {
        $route_name = config('cashier.account.return_route', 'dashboard');
        return route($route_name, ['id' => $this->id]);
    }
    
    /**
     * Get the account link to allow user access Connect platform
     * via the onboarding
     * @param string|null $refresh_url
     * @param string|null $return_url
     * @return string The url to access the onboarding
     * @throws InvalidAccount
     * @throws ApiErrorException
     */
    public function stripeAccountLink(?string $refresh_url = null, ?string $return_url = null): string
    {
        if (!$this->hasStripeAccount()) {
            throw InvalidAccount::notYetCreated($this);
        }
        
        return Cashier::stripe()->accountLinks->create([
            'account' => $this->stripeAccountId(),
            'refresh_url' => $refresh_url ?? $this->stripeAccountRefreshUrl(),
            'return_url' => $return_url ?? $this->stripeAccountReturnUrl(),
            'type' => "account_onboarding",
        ])['url'];
    }
    
    /**
     * Return the stripe login link for express connected account using the express dashboard.
     * As describe at this link: https://docs.stripe.com/api/accounts/login_link
     * @return string
     * @throws ApiErrorException|InvalidAccount
     */
    
    public function stripeLoginLink(): string
    {
        if (!$this->hasStripeAccount()) {
            throw InvalidAccount::notYetCreated($this);
        }
        return Cashier::stripe()->accounts
            ->createLoginLink($this->stripeAccountId(), [])['url'];
    }
    
    
}