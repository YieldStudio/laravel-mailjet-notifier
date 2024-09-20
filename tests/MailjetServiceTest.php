<?php

declare(strict_types=1);

use Ciareis\Bypass\Bypass;
use Ciareis\Bypass\Route;
use Mailjet\Response;
use YieldStudio\LaravelMailjetNotifier\Exceptions\MailjetException;
use YieldStudio\LaravelMailjetNotifier\MailjetService;
use YieldStudio\LaravelMailjetNotifier\Messages\MailjetEmailMessage;
use YieldStudio\LaravelMailjetNotifier\Messages\MailjetSmsMessage;

it('returns a Response instance when the email is sent correctly', function (): void {
    $bypass = Bypass::serve(
        Route::post('/v3/send', ['success' => true]),
    );

    $mailjetService = new MailjetService('key', 'secret', false, [
        'emailFrom' => [
            'Name' => 'John Doe',
            'Email' => 'john@doe.fr',
        ],
        'secured' => false,
        'url' => str_replace('http://', '', $bypass->getBaseUrl()),
    ]);

    $message = (new MailjetEmailMessage)->templateId(1);
    $result = $mailjetService->sendEmail($message);

    $bypass->assertRoutes();
    expect($result)->toBeInstanceOf(Response::class);
});

it('returns a MailjetException when sending email fails', function (): void {
    $bypass = Bypass::serve(
        Route::post('/v3/send', ['success' => false], 400),
    );

    $mailjetService = new MailjetService('key', 'secret', false, [
        'emailFrom' => [
            'Name' => 'John Doe',
            'Email' => 'john@doe.fr',
        ],
        'secured' => false,
        'url' => str_replace('http://', '', $bypass->getBaseUrl()),
    ]);

    $message = (new MailjetEmailMessage)->templateId(1);

    $mailjetService->sendEmail($message);
})->throws(MailjetException::class);

it('returns a Response instance when the sms is sent correctly', function (): void {
    $bypass = Bypass::serve(
        Route::post('/v4/sms-send', ['success' => true]),
    );

    $mailjetService = new MailjetService('key', 'secret', false, [
        'smsFrom' => 'SENDER',
        'secured' => false,
        'url' => str_replace('http://', '', $bypass->getBaseUrl()),
    ]);

    $mailjetService->setSmsToken('testing');

    $message = (new MailjetSmsMessage)->to('0601020304')->text('Hello');
    $result = $mailjetService->sendSms($message);

    $bypass->assertRoutes();
    expect($result)->toBeInstanceOf(Response::class);
});

it('returns a MailjetException when sending sms fails', function (): void {
    $bypass = Bypass::serve(
        Route::post('/v4/sms-send', ['success' => false], 400),
    );

    $mailjetService = new MailjetService('key', 'secret', false, [
        'smsFrom' => 'SENDER',
        'secured' => false,
        'url' => str_replace('http://', '', $bypass->getBaseUrl()),
    ]);

    $mailjetService->setSmsToken('testing');

    $message = (new MailjetSmsMessage)->to('0601020304')->text('Hello');
    $mailjetService->sendSms($message);
})->throws(MailjetException::class);
