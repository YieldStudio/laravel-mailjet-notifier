<?php

declare(strict_types=1);

namespace YieldStudio\LaravelMailjetNotifier\Channels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use YieldStudio\LaravelMailjetNotifier\Exceptions\MailjetException;
use YieldStudio\LaravelMailjetNotifier\MailjetService;

final class MailjetSmsChannel
{
    public function __construct(protected MailjetService $mailjetService) {}

    /**
     * @throws MailjetException
     */
    public function send(Model|AnonymousNotifiable $notifiable, Notification $notification): void
    {
        $message = $notification->toMailjetSms($notifiable); // @phpstan-ignore-line

        $this->mailjetService->sendSms($message);
    }
}
