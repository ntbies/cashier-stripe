<?php

namespace Ntbies\CashierStripe\Listeners;

use App\Models\Company;
use Illuminate\Support\Str;
use Laravel\Cashier\Events\WebhookReceived;
use Ntbies\CashierStripe\CashierStripe;
use Ntbies\CashierStripe\Events\CheckoutSessionCompleted;
use Ntbies\CashierStripe\Events\ConnectPaymentSucceeded;
use Ntbies\CashierStripe\Events\PaymentSucceeded;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

class WebhookProcessor
{
    
    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        $method = 'handle' . Str::studly(str_replace('.', '_', $event->payload['type']));
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
    public function handleAccountUpdated(array $data): void
    {
        $partner = CashierStripe::findPartner($data['id']);
        if (!$partner) {
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
    public function handlePaymentIntentSucceeded(array $data): void
    {
        $paymentIntent = PaymentIntent::constructFrom($data);
        $isConnect = !empty(
            $paymentIntent->application
            || $paymentIntent->application_fee_amount
            || $paymentIntent->on_behalf_of
            || $paymentIntent->transfer_data
        );
        ConnectPaymentSucceeded::dispatchIf($isConnect, $paymentIntent);
        PaymentSucceeded::dispatchIf(!$isConnect, $paymentIntent);
    }
    
    public function handleCheckoutSessionCompleted(array $data): void
    {
        $checkoutSession = Session::constructFrom($data);
        CheckoutSessionCompleted::dispatch($checkoutSession);
    }
}
