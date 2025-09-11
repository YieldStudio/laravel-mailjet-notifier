<?php

use YieldStudio\LaravelMailjetNotifier\MailjetEmailMessage;

test('SandboxMode is default false', function (): void {
    $message = (new MailjetEmailMessage())->templateId(123);

    expect($message->toArray()['SandboxMode'])->toBe(false);
});

test('SandboxMode is true when config is set', function (): void {
    // Set sandbox value in config to true
    config(['mailjet.sandbox' => true]);

    $message = (new MailjetEmailMessage())->templateId(123);

    expect($message->toArray()['SandboxMode'])->toBe(true);
});
