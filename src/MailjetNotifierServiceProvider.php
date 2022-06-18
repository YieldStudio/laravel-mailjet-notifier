<?php

declare(strict_types=1);

namespace YieldStudio\LaravelMailjetNotifier;

use Illuminate\Support\ServiceProvider;

class MailjetNotifierServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config' => config_path(),
            ], 'config');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/mailjet.php', 'mailjet');

        $this->app->bind(MailjetService::class, function () {
            $key = config('mailjet.key');
            $secret = config('mailjet.secret');
            $smsToken = config('mailjet.smsToken');
            $emailFrom = config('mailjet.emailFrom');
            $smsFrom = config('mailjet.smsFrom');
            $options = config('mailjet.options', []);

            $instance = new MailjetService($key, $secret, $options);
            $instance->setEmailFrom($emailFrom);
            $instance->setSmsFrom($smsFrom);
            $instance->setSmsToken($smsToken);

            return $instance;
        });

        $this->app->alias('mailjet', MailjetService::class);
    }

    public function provides(): array
    {
        return ['mailjet'];
    }
}
