<?php

use Illuminate\Notifications\Notification;
use YieldStudio\LaravelMailjetNotifier\MailjetEmailChannel;
use YieldStudio\LaravelMailjetNotifier\MailjetEmailMessage;
use YieldStudio\LaravelMailjetNotifier\MailjetService;
use YieldStudio\LaravelMailjetNotifier\Tests\User;

it('send notification via MailjetEmailChannel should call MailjetService sendEmail method', function () {
    $mock = $this->mock(MailjetService::class)->shouldReceive('sendEmail')->once();
    $channel = new MailjetEmailChannel($mock->getMock());

    $channel->send(new User(), new class extends Notification {
        public function via()
        {
            return [MailjetEmailChannel::class];
        }

        public function toMailjetEmail(User $notifiable): MailjetEmailMessage
        {
            return new MailjetEmailMessage();
        }
    });
});
