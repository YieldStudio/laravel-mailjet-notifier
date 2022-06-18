<?php

namespace YieldStudio\LaravelMailjetNotifier\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use YieldStudio\LaravelMailjetNotifier\MailjetNotifierServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        $serviceProviders = [
            MailjetNotifierServiceProvider::class,
        ];

        return $serviceProviders;
    }
}
