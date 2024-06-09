<?php

namespace Ntbies\CashierStripe\Concerns;

use \Laravel\Cashier\Billable as CashierBillable;

trait Billable
{
    use CashierBillable {
        CashierBillable::createAsStripeCustomer as billableCreateStripeCustomer;
        CashierBillable::updateStripeCustomer as billableUpdateStripeCustomer;
    }

    /**
     * @param array $options
     * @return \Stripe\Customer
     * @throws \Laravel\Cashier\Exceptions\CustomerAlreadyCreated
     */
    public function createAsStripeCustomer(array $options = [])
    {
        $customer = $this->billableCreateStripeCustomer($options);
        $this->createOrUpdateTaxId();
        return $customer;
    }
    
    /**
     * Update billable tax id
     * @return void
     */
    public function createOrUpdateTaxId(): void
    {

        $taxIds = $this->taxIds();
        $tax_id = $taxIds->first();
        if (!$this->vat_id) {
            $this->collectTaxIds();
            return;
        }
        if ($tax_id && $tax_id?->value == $this->vat_id) {
            return;
        }
        if ($tax_id) {
            $this->deleteTaxId($tax_id->id);
        }
        $this->createTaxId($this->vat_id_type ?? 'eu_vat', $this->vat_id);
    }

    /**
     * @param array $options
     * @return \Stripe\Customer
     */
    public function updateStripeCustomer(array $options = [])
    {
        $this->createOrUpdateTaxId();
        return $this->billableUpdateStripeCustomer($options);
    }

    public function stripeAddress()
    {
        return [
            'line1' => $this->line1,
            'line2' => $this->line2,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
        ];
    }
    
    

}
