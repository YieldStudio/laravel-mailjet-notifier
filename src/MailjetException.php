<?php

declare(strict_types=1);

namespace YieldStudio\LaravelMailjetNotifier;

use Exception;
use Mailjet\Response;
use Throwable;

class MailjetException extends Exception
{
    private ?string $errorInfo;

    private ?string $errorMessage;

    private ?string $errorIdentifier;

    /**
     * @see https://dev.mailjet.com/guides/#about-the-mailjet-restful-api.
     */
    public function __construct(int $statusCode = 0, ?string $message = null, ?Response $response = null, ?Throwable $previous = null)
    {
        if ($response) {
            $statusCode = $response->getStatus();
            $message = "{$message}: {$response->getReasonPhrase()}";

            $body = $response->getBody();

            if (isset($body['ErrorInfo'])) {
                $this->errorInfo = $body['ErrorInfo'];
            }
            if (isset($body['ErrorMessage'])) {
                $this->errorMessage = $body['ErrorMessage'];
            }
            if (isset($body['ErrorIdentifier'])) {
                $this->errorIdentifier = $body['ErrorIdentifier'];
            }
        }

        parent::__construct($message, $statusCode, $previous);
    }

    public function getErrorInfo(): string
    {
        return $this->errorInfo;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getErrorIdentifier(): string
    {
        return $this->errorIdentifier;
    }
}
