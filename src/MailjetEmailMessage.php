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

    public ?array $from = null;

    public bool $templateLanguage = true;

    public array $variables = [];

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

    public function from($name, $email = null): static
    {
        if (is_array($name)) {
            $this->from = $name;
        } else {
            $this->from[] = [
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

    public function toArray(): array
    {
        return [
            'Messages' => [
                [
                    'To' => $this->to,
                    'From' => $this->from,
                    'TemplateID' => $this->templateId,
                    'TemplateLanguage' => $this->templateLanguage,
                    'Subject' => $this->subject,
                    'Variables' => $this->variables,
                ],
            ],
        ];
    }
}
