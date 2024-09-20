<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use YieldStudio\LaravelMailjetNotifier\Channels\MailjetSmsChannel;
use YieldStudio\LaravelMailjetNotifier\MailjetService;
use YieldStudio\LaravelMailjetNotifier\Messages\MailjetSmsMessage;
use YieldStudio\LaravelMailjetNotifier\Tests\Models\User;

it('send notification via MailjetSmsChannel should call MailjetService sendSms method', function (): void {
    $mock = $this->mock(MailjetService::class)->shouldReceive('sendSms')->once();
    $channel = new MailjetSmsChannel($mock->getMock());

    $channel->send(new User, new class extends Notification
    {
        public function via(): array
        {
            return [MailjetSmsChannel::class];
        }

        public function toMailjetSms(Model $notifiable): MailjetSmsMessage
        {
            return new MailjetSmsMessage;
        }
    });
});
