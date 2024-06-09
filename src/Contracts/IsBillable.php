<?php

namespace Ntbies\CashierStripe\Contracts;

interface IsBillable
{

    public function createAsStripeCustomer(array $options = []);

    public function createOrUpdateTaxId(): void;

    public function updateStripeCustomer(array $options = []);

    public function stripeAddress();
}
