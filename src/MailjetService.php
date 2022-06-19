<?php

declare(strict_types=1);

namespace YieldStudio\LaravelMailjetNotifier;

use Mailjet\Client;
use Mailjet\Resources;
use Mailjet\Response;

class MailjetService
{
    protected Client $client;

    protected ?array $emailFrom = null;

    protected ?string $smsFrom = null;

    protected ?string $smsToken = null;

    protected array $options;

    public function __construct(string $key, string $secret, bool $dry = false, array $options = [])
    {
        if (array_key_exists('emailFrom', $options)) {
            $this->emailFrom = $options['emailFrom'];
            unset($options['emailFrom']);
        }

        if (array_key_exists('smsFrom', $options)) {
            $this->smsFrom = $options['smsFrom'];
            unset($options['smsFrom']);
        }

        $this->client = new Client($key, $secret, ! $dry, $options);
        $this->options = $options;
    }

    /**
     * Send mailjet email.
     *
     * @param MailjetEmailMessage $message
     * @param array $args Request arguments
     * @param array $options
     *
     * @return Response
     *
     * @throws MailjetException
     */
    public function sendEmail(MailjetEmailMessage $message, array $args = [], array $options = []): Response
    {
        if (! $message->from) {
            $message->from($this->emailFrom);
        }

        $response = $this->client->post(Resources::$Email, array_merge_recursive(['body' => $message->toArray()], $args), $options);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:sendEmail() failed', $response);
        }

        return $response;
    }

    /**
     * Send mailjet SMS.
     *
     * @param MailjetSmsMessage $message
     * @param array $args Request arguments
     * @param array $options
     *
     * @return Response
     *
     * @throws MailjetException
     */
    public function sendSms(MailjetSmsMessage $message, array $args = [], array $options = []): Response
    {
        $options = array_merge_recursive($options, $this->options);
        $options['version'] = 'v4';

        if (! $message->from) {
            $message->from($this->smsFrom);
        }

        $client = new Client($this->smsToken, null, true, $options); // @phpstan-ignore-line

        $response = $client->post(Resources::$SmsSend, array_merge_recursive(['body' => $message->toArray()], $args), $options);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:sendSms() failed', $response);
        }

        return $response;
    }

    /**
     * Trigger a POST request.
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args Request arguments
     * @param array $options
     *
     * @return Response
     *
     * @throws MailjetException
     */
    public function post(array $resource, array $args = [], array $options = []): Response
    {
        $response = $this->client->post($resource, $args, $options);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:post() failed', $response);
        }

        return $response;
    }

    /**
     * Trigger a GET request.
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args Request arguments
     * @param array $options
     *
     * @return Response
     *
     * @throws MailjetException
     */
    public function get(array $resource, array $args = [], array $options = []): Response
    {
        $response = $this->client->get($resource, $args, $options);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:get() failed', $response);
        }

        return $response;
    }

    /**
     * Trigger a PUT request.
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args Request arguments
     * @param array $options
     *
     * @return Response
     *
     * @throws MailjetException
     */
    public function put(array $resource, array $args = [], array $options = []): Response
    {
        $response = $this->client->put($resource, $args, $options);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:put() failed', $response);
        }

        return $response;
    }

    /**
     * Trigger a DELETE request.
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args Request arguments
     * @param array $options
     *
     * @return Response
     *
     * @throws MailjetException
     */
    public function delete(array $resource, array $args = [], array $options = []): Response
    {
        $response = $this->client->delete($resource, $args, $options);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:delete() failed', $response);
        }

        return $response;
    }

    public function setEmailFrom(array $emailFrom): void
    {
        $this->emailFrom = $emailFrom;
    }

    public function setSmsFrom(string $smsFrom): void
    {
        $this->smsFrom = $smsFrom;
    }

    public function setSmsToken(string $smsToken): void
    {
        $this->smsToken = $smsToken;
    }
}
