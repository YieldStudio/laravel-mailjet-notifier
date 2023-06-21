# laravel-mailjet-notifier

Easily send Mailjet transactional email and sms with Laravel notifier.

[![Latest Version](https://img.shields.io/github/release/yieldstudio/laravel-mailjet-notifier?style=flat-square)](https://github.com/yieldstudio/laravel-mailjet-notifier/releases)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/yieldstudio/laravel-mailjet-notifier/tests.yml?branch=main)](https://github.com/yieldstudio/laravel-mailjet-notifier/actions/workflows/tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/yieldstudio/laravel-mailjet-notifier?style=flat-square)](https://packagist.org/packages/yieldstudio/laravel-mailjet-notifier)

If you're just looking for a mailjet mail transport, check out [mailjet/laravel-mailjet](https://github.com/mailjet/laravel-mailjet)

> Major version zero (0.y.z) is for initial development. Anything MAY change at any time. The public API SHOULD NOT be considered stable.

## Installation

	composer require yieldstudio/laravel-mailjet-notifier

## Configure

Just define these environment variables:

```dotenv
MAILJET_APIKEY=
MAILJET_APISECRET=
MAILJET_SMSTOKEN=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
MAILJET_SMS_SENDER=
MAILJET_DRY=true|false
```

Make sure that MAIL_FROM_ADDRESS is an authenticated email on Mailjet, otherwise your emails will not be sent by the Mailjet API.

MAILJET_SMS_SENDER should be between 3 and 11 characters in length, only alphanumeric characters are allowed.

When the dry mode is enabled, Mailjet API isn't called.

You can publish the configuration file with:

```shell
php artisan vendor:publish --provider="YieldStudio\LaravelMailjetNotifier\MailjetNotifierServiceProvider" --tag="config"
```

## Usage

### Send email

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use YieldStudio\LaravelMailjetNotifier\MailjetEmailChannel;

class OrderConfirmation extends Notification
{
    public function via(): array
    {
        return [MailjetEmailChannel::class];
    }

    public function toMailjetEmail($notifiable): MailjetEmailMessage
    {
        return (new MailjetEmailMessage())
            ->templateId(999999) // Replace with your template ID
            ->to($notifiable->firstname, $notifiable->email)
            ->variable('firstname', $notifiable->firstname)
            ->variable('order_ref', 'N°0000001');
    }
}
```

### Send sms

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification
;use YieldStudio\LaravelMailjetNotifier\MailjetSmsChannel;
use YieldStudio\LaravelMailjetNotifier\MailjetSmsMessage;

class ResetPassword extends Notification
{
    public function __construct(protected string $code)
    {
    }

    public function via()
    {
        return [MailjetSmsChannel::class];
    }

    public function toMailjetSms($notifiable): MailjetSmsMessage
    {
        return (new MailjetSmsMessage())
            ->to($notifiable->phone)
            ->text(__('This is your reset code :code', ['code' => $this->code]));
    }
}
```

## Unit tests

To run the tests, just run `composer install` and `composer test`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you've found a bug regarding security please mail [contact@yieldstudio.fr](mailto:contact@yieldstudio.fr) instead of using the issue tracker.

## Credits

- [James Hemery](https://github.com/jameshemery)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

