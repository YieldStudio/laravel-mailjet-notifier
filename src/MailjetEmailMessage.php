<?php

declare(strict_types=1);

namespace YieldStudio\LaravelMailjetNotifier;

use Illuminate\Support\Traits\Conditionable;

class MailjetEmailMessage
{
    use Conditionable;

    public int $templateId;

    public ?string $subject = null;

    public array $to = [];

    public array $cc = [];

    public array $bcc = [];

    public ?array $from = null;

    public ?array $replyTo = null;

    public bool $templateLanguage = true;

    public array $variables = [];

    public array $attachments = [];

    public function templateId(int $templateId): static
    {
        $this->templateId = $templateId;

        return $this;
    }

    public function subject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function to($name, $email = null): static
    {
        if (is_array($name)) {
            $this->to = $name;
        } else {
            $this->to[] = [
                'Name' => $name,
                'Email' => $email,
            ];
        }

        return $this;
    }

    public function cc($name, $email = null): static
    {
        if (is_array($name)) {
            $this->cc = $name;
        } else {
            $this->cc[] = [
                'Name' => $name,
                'Email' => $email,
            ];
        }

        return $this;
    }

    public function bcc($name, $email = null): static
    {
        if (is_array($name)) {
            $this->bcc = $name;
        } else {
            $this->bcc[] = [
                'Name' => $name,
                'Email' => $email,
            ];
        }

        return $this;
    }

    public function from($name, $email = null): static
    {
        if (is_array($name)) {
            $this->from = $name;
        } else {
            $this->from = [
                'Name' => $name,
                'Email' => $email,
            ];
        }

        return $this;
    }

    public function replyTo($name, $email = null): static
    {
        if (is_array($name)) {
            $this->replyTo = $name;
        } else {
            $this->replyTo = [
                'Name' => $name,
                'Email' => $email,
            ];
        }

        return $this;
    }

    public function templateLanguage(bool $templateLanguage): static
    {
        $this->templateLanguage = $templateLanguage;

        return $this;
    }

    public function variables(array $variables): static
    {
        $this->variables = $variables;

        return $this;
    }

    public function variable(string $key, $value): static
    {
        $this->variables[$key] = $value;

        return $this;
    }

    public function attachments(array $attachments): static
    {
        $this->attachments = $attachments;

        return $this;
    }

    public function attachment(array $attachment): static
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    public function toArray(): array
    {
        $messagesData = [
            'To' => $this->to,
            'Cc' => $this->cc,
            'Bcc' => $this->bcc,
            'From' => $this->from,
            'TemplateID' => $this->templateId,
            'TemplateLanguage' => $this->templateLanguage,
            'Subject' => $this->subject,
        ];

        if (filled($this->replyTo)) {
            $messagesData['ReplyTo'] = $this->replyTo;
        }

        if (filled($this->variables)) {
            $messagesData['Variables'] = $this->variables;
        }

        if (filled($this->attachments)) {
            $messagesData['Attachments'] = $this->attachments;
        }

        return [
            'Messages' => [
                $messagesData,
            ],
        ];
    }
}
