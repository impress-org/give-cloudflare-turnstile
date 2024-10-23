<?php

namespace GiveCloudflareTurnstile\Turnstile\ValueObjects;

/**
 * @since 1.0.0
 * @see https://developers.cloudflare.com/turnstile/get-started/server-side-validation/
 */
class TurnstileVerifyResponse
{
    /**
     * @var bool
     */
    public $success;

    /**
     * @var string
     */
    public $challengeTs;

    /**
     * @var string
     */
    public $hostname;

    /**
     * @var array
     */
    public $errorCodes;

    /**
     * @var string
     */
    public $action;

    /**
     * @var string
     */
    public $cdata;

    /**
     * @since 1.0.0
     */
    public function __construct(object $response)
    {
        $this->success = (bool)$response->success;
        $this->challengeTs = isset($response->challenge_ts) ? (string)$response->challenge_ts : '';
        $this->hostname = isset($response->hostname) ? (string)$response->hostname : '';
        $this->errorCodes = isset($response->error_codes) ? (array)$response->error_codes : [];
        $this->action = isset($response->action) ? (string)$response->action : '';
        $this->cdata = isset($response->cdata) ? (string)$response->cdata : '';
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Get the error message from error code.
     *
     * @since 1.0.0
     */
    public function getErrorMessage(string $code): ?string
    {
        switch ($code) {
            case 'missing-input-secret':
                return __("The secret parameter was not passed.", 'give-cloudflare-turnstile');
            case 'invalid-input-secret':
                return __("The secret parameter was invalid or did not exist.", 'give-cloudflare-turnstile');
            case 'missing-input-response':
                return __("The response parameter (token) was not passed.", 'give-cloudflare-turnstile');
            case 'invalid-input-response':
                return __(
                    "The response parameter (token) is invalid or has expired. Most of the time, this means a fake token has been used. If the error persists, contact customer support.",
                    'give-cloudflare-turnstile'
                );
            case 'bad-request':
                return __("The request was rejected because it was malformed.", 'give-cloudflare-turnstile');
            case 'timeout-or-duplicate':
                return __(
                    "The response parameter (token) has already been validated before. This means that the token was issued five minutes ago and is no longer valid, or it was already redeemed.",
                    'give-cloudflare-turnstile'
                );
            case 'internal-error':
                return __(
                    "An internal error happened while validating the response. The request can be retried.",
                    'give-cloudflare-turnstile'
                );
            default:
                return 'Invalid response';
        }
    }

    /**
     * @return array
     */
    public function getErrorMessages(): array
    {
        return array_map([$this, 'getErrorMessage'], $this->errorCodes);
    }
}
