<?php

declare(strict_types=1);

namespace YieldStudio\LaravelMailjetNotifier;

use Illuminate\Support\Traits\Conditionable;

final class MailjetSmsMessage
{
    use Conditionable;

    public string $to;

    public string $text;

    public ?string $from = null;

    public function to(string $to): static
    {
        $this->to = $to;

        return $this;
    }

    public function from(string $from): static
    {
        $this->from = $from;

        return $this;
    }

    public function text(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'To' => $this->to,
            'From' => $this->from,
            'Text' => $this->text,
        ];
    }
}
