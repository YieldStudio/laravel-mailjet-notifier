<?php

declare(strict_types=1);

use Illuminate\Notifications\Notification;
use YieldStudio\LaravelMailjetNotifier\Channels\MailjetEmailChannel;
use YieldStudio\LaravelMailjetNotifier\MailjetService;
use YieldStudio\LaravelMailjetNotifier\Messages\MailjetEmailMessage;
use YieldStudio\LaravelMailjetNotifier\Tests\Models\User;

it('send notification via MailjetEmailChannel should call MailjetService sendEmail method', function (): void {
    $mock = $this->mock(MailjetService::class)->shouldReceive('sendEmail')->once();
    $channel = new MailjetEmailChannel($mock->getMock());

    $channel->send(new User, new class extends Notification
    {
        public function via(): array
        {
            return [MailjetEmailChannel::class];
        }

        public function toMailjetEmail(User $notifiable): MailjetEmailMessage
        {
            return new MailjetEmailMessage;
        }
    });
});
