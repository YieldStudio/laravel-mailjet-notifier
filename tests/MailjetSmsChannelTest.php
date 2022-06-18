<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use YieldStudio\LaravelMailjetNotifier\MailjetSmsChannel;
use YieldStudio\LaravelMailjetNotifier\MailjetSmsMessage;
use YieldStudio\LaravelMailjetNotifier\MailjetService;
use YieldStudio\LaravelMailjetNotifier\Tests\User;

it('send notification via MailjetSmsChannel should call MailjetService sendSms method', function () {
    $mock = $this->mock(MailjetService::class)->shouldReceive('sendSms')->once();
    $channel = new MailjetSmsChannel($mock->getMock());
    $channel->send(new User(), new class extends Notification {
        public function via()
        {
            return [MailjetSmsChannel::class];
        }

        public function toMailjetSms(Model $notifiable): MailjetSmsMessage
        {
            return new MailjetSmsMessage();
        }
    });
});
