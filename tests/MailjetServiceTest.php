<?php

use Ciareis\Bypass\Bypass;
use Ciareis\Bypass\Route;
use YieldStudio\LaravelMailjetNotifier\MailjetEmailMessage;
use YieldStudio\LaravelMailjetNotifier\MailjetException;
use YieldStudio\LaravelMailjetNotifier\MailjetService;
use Mailjet\Response;
use YieldStudio\LaravelMailjetNotifier\MailjetSmsMessage;
use function PHPUnit\Framework\assertInstanceOf;

it('returns a Response instance when the email is sent correctly', function () {
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

    $message = (new MailjetEmailMessage())->templateId(1);
    $result = $mailjetService->sendEmail($message);

    $bypass->assertRoutes();
    assertInstanceOf(Response::class, $result);
});

it('returns a MailjetException when sending email fails', function () {
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

    $message = (new MailjetEmailMessage())->templateId(1);

    $mailjetService->sendEmail($message);
})->throws(MailjetException::class);

it('returns a Response instance when the sms is sent correctly', function () {
    $bypass = Bypass::serve(
        Route::post('/v4/sms-send', ['success' => true]),
    );

    $mailjetService = new MailjetService('key', 'secret', false, [
        'smsFrom' => 'SENDER',
        'secured' => false,
        'url' => str_replace('http://', '', $bypass->getBaseUrl()),
    ]);

    $mailjetService->setSmsToken('testing');

    $message = (new MailjetSmsMessage())->to('0601020304')->text('Hello');
    $result = $mailjetService->sendSms($message);

    $bypass->assertRoutes();
    assertInstanceOf(Response::class, $result);
});

it('returns a MailjetException when sending sms fails', function () {
    $bypass = Bypass::serve(
        Route::post('/v4/sms-send', ['success' => false], 400),
    );

    $mailjetService = new MailjetService('key', 'secret', false, [
        'smsFrom' => 'SENDER',
        'secured' => false,
        'url' => str_replace('http://', '', $bypass->getBaseUrl()),
    ]);

    $mailjetService->setSmsToken('testing');

    $message = (new MailjetSmsMessage())->to('0601020304')->text('Hello');
    $mailjetService->sendSms($message);
})->throws(MailjetException::class);
