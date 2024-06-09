<?php

namespace Ntbies\CashierStripe\Listeners;

use App\Models\Company;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;
use Ntbies\CashierStripe\CashierStripe;

class WebhookProcessor
{

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        $method = 'handle'.Str::studly(str_replace('.', '_', $event->payload['type']));
        if (method_exists($this, $method)) {
            $this->{$method}($event->payload['data']['object']);
        }
    }

    /**
     * Handle the account update event
     * In the future this should eventually emit an
     * event such as PartnerUpdated
     * @param array $payload
     * @return void
     */
    public function handleAccountUpdated( array $data):void {
        $partner = CashierStripe::findPartner($data['id']);
        if(!$partner) {
            return;
        }
        $partner->stripe_details_submitted = empty($data['requirements']['pending_verification']);
        $partner->saveQuietly();
    }

    /**
     * Handle the payment intend in case of connected account
     * In the future this should eventually emit an
     * event such as ConnectedPaymentSuceeded
     * @param array $data
     * @return void
     */
    public function handlePaymentIntentSucceeded(array $data):void {
    }


}
