# ntbies/cashier-stripe

## Overview

`ntbies/cashier-stripe` is a Composer package designed to extend and enhance the functionality provided by `laravel/cashier`. This package offers improved handling of customer tax information, redefines Stripe addresses, facilitates migrations, and integrates Connect Accounts for platform-based sales. Additionally, it provides routes to access Stripe's hosted onboarding and dashboard for seamless account management.

## Features

- **Enhanced Billable Trait**: Improved transmission of customer tax information updates to Stripe.
- **Redefined Stripe Address**: Better address handling within the Stripe integration.
- **Migration Support**: Comprehensive tools to support migration processes.
- **Connect Account Integration**: Allows users to sell through your platform with Stripe Connect.
- **Hosted Onboarding**: Easily access Stripe's hosted onboarding page.
- **Hosted Dashboard**: Direct access to the Stripe dashboard for connected accounts.
- **Webhook Support**: Integration with Stripe webhooks for real-time event handling.
- **Event Dispatching**: Events dispatched on `paymentIntent` success for both standard and connect account payments and `checkout.session.completed`.

## Installation

You can install the package via Composer:

```bash
composer require ntbies/cashier-stripe
```

## Configuration

The necessary configurations will be automatically set up upon installation. However, you may need to customize certain settings in the `cashier.php` configuration file.

### Configurations in `cashier.php`

Add the following configurations to the `cashier.php` file to properly use the `Partner` model and other features:

```php
return [
    ...
    'account' => [
        'partner_model' => 'App\\Models\\User',  // Define your partner model here
        'refresh_route' => 'cashier.account.onboarding',  // Route name for refresh URL during onboarding
        'return_route' => 'dashboard',  // Route name for return URL after onboarding
        'options' => [  // Options for creating Stripe accounts (optional)
            'type' => 'express',
            // Add other options here
        ],
    ],
    ...
],
```

## Migrations

This package provides migrations to add necessary columns to your existing tables. Run the migrations with:

```bash
php artisan migrate
```

The migrations include:

- `2024_06_06_040501_add_customer_columns_table.php`: Adds columns to the customer table for storing tax information and Stripe details.
- `2024_06_06_210501_add_partner_columns_to_table.php`: Adds columns to handle partner information for connected accounts.

Ensure that your database is properly configured and backed up before running these migrations.

## Usage

### Implementing Billable and Partner Models

To use the features provided by this package, your models must implement specific interfaces and use the provided traits:

#### Customer Model

The customer model must implement the `IsBillable` interface and use the `Billable` trait:

```php
namespace App\Models;

use Ntbies\CashierStripe\Contracts\IsBillable;
use Ntbies\CashierStripe\Concerns\Billable;

class Customer extends Model implements IsBillable
{
    use Billable;

    // Your model code here
}
```

#### Partner Model

The partner model must implement the `IsPartner` interface and use the `Partner` trait:

```php
namespace App\Models;

use Ntbies\CashierStripe\Contracts\IsPartner;
use Ntbies\CashierStripe\Concerns\Partner as PartnerTrait;

class Partner extends Model implements IsPartner
{
    use PartnerTrait;

    // Your model code here
}
```

### Hosted Onboarding

To access the hosted onboarding route, use the following route name and pass the required parameters:

```php
route('cashier.account.onboarding', ['id' => $partner->id])
```

### Hosted Dashboard

To access the hosted dashboard for a connected account, use this route name with the model ID parameter:

```php
route('cashier.account.dashboard', ['id' => $partner->id])
```

### Webhook Integration

The connected webhook is available at the following route:

- Route Name: `cashier.webhook.connect`
- Default URL: `<siteurl>/stripe/webhook/connect`

Make sure to configure your Stripe account to send connected webhooks to this endpoint. You can set the webhook signing secret in the configuration file to verify incoming requests.

## Event Dispatching

This package dispatches two events on `paymentIntent` success to help you handle different payment scenarios:

- **PaymentSucceeded**: Dispatched when the payment is not related to a connect account.
- **ConnectPaymentSucceeded**: Dispatched when a connect account is involved in the payment.
- **CheckoutSessionCompleted**: Dispatched when a `checkout.session.completed` webhook event is received.
### Listening to Events

To use these events in your Laravel application, you need to set up event listeners. Follow these steps:

#### 1. Define Event Listeners

Create event listener classes for handling the events.

**Example for `PaymentSucceeded`**:

```php
namespace App\Listeners;

use Ntbies\CashierStripe\Events\PaymentSucceeded;

class HandlePaymentSucceeded
{
    public function handle(PaymentSucceeded $event)
    {
        // Handle the event, e.g., update order status, notify user, etc.
        $paymentIntent = $event->paymentIntent;
        // Your logic here
    }
}
```

**Example for `ConnectPaymentSucceeded`**:

```php
namespace App\Listeners;

use Ntbies\CashierStripe\Events\ConnectPaymentSucceeded;

class HandleConnectPaymentSucceeded
{
    public function handle(ConnectPaymentSucceeded $event)
    {
        $paymentIntent = $event->paymentIntent;
        // Handle the logic regarding connected account here
        // Bear in mind the difference between on_behalf_of and transfert_data
    }
}
```

#### 2. Register Event Listeners

Register the event listeners in your `EventServiceProvider`.

**Example `app/Providers/EventServiceProvider.php`**:

```php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Ntbies\CashierStripe\Events\PaymentSucceeded;
use Ntbies\CashierStripe\Events\ConnectPaymentSucceeded;
use App\Listeners\HandlePaymentSucceeded;
use App\Listeners\HandleConnectPaymentSucceeded;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentSucceeded::class => [
            HandlePaymentSucceeded::class,
        ],
        ConnectPaymentSucceeded::class => [
            HandleConnectPaymentSucceeded::class,
        ],
    ];

    // ...
}
```

## Customizations

### Billable Trait

The package rewrites the billable trait to enhance the handling of customer tax information and address updates. You can extend or customize this trait as needed for your application.

### Stripe Address

The package redefines the Stripe address handling to ensure compatibility and proper formatting. This is particularly useful for international addresses and compliance with Stripe's requirements.

## Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details on how to contribute to the project.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).

---

For further details, please refer to the official Stripe documentation or reach out via the issue tracker on GitHub.