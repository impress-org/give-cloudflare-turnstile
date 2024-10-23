<?php

namespace GiveCloudflareTurnstile\Tests\Unit\Turnstile\ValueObjects;

use Give\Tests\TestCase;
use GiveCloudflareTurnstile\Turnstile\ValueObjects\TurnstileVerifyResponse;

/**
 * @since 1.0.0
 */
class TestTurnstileVerifyResponse extends TestCase
{

    /**
     * @since 1.0.0
     */
    public function testShouldReturnSelf(): void
    {
        $response = wp_json_encode([
            'success' => true,
            'challenge_ts' => '2021-09-01T00:00:00Z',
            'hostname' => 'example.com',
            'error_codes' => [],
            'action' => 'action',
            'cdata' => 'cdata'
        ]);

        $turnstileVerifyResponse = new TurnstileVerifyResponse(json_decode($response, false));
        $this->assertTrue($turnstileVerifyResponse->success);
    }

     /**
     * @since 1.0.0
      * @dataProvider errorMessagesProvider
     */
    public function testShouldGetErrorMessage(string $code, string $message): void
    {
        $turnstileVerifyResponse = new TurnstileVerifyResponse((object)[
            'success' => false,
            'error_codes' => [$code],
        ]);

        $this->assertEquals($message, $turnstileVerifyResponse->getErrorMessage($code));
    }

    /**
     * @since 1.0.0
     */
    public function testShouldGetErrorMessages(): void
    {
        $turnstileVerifyResponse = new TurnstileVerifyResponse((object)[
            'success' => false,
            'error_codes' => ['missing-input-secret', 'invalid-input-secret'],
        ]);

        $this->assertEquals([
            __("The secret parameter was not passed.", 'give-cloudflare-turnstile'),
            __("The secret parameter was invalid or did not exist.", 'give-cloudflare-turnstile'),
        ], $turnstileVerifyResponse->getErrorMessages());
    }

    /**
     * @since 1.0.0
     */
    public function errorMessagesProvider(): array
    {
        return [
            ['missing-input-secret', __("The secret parameter was not passed.", 'give-cloudflare-turnstile')],
            ['invalid-input-secret', __("The secret parameter was invalid or did not exist.", 'give-cloudflare-turnstile')],
            ['missing-input-response', __("The response parameter (token) was not passed.", 'give-cloudflare-turnstile')],
            ['invalid-input-response', __("The response parameter (token) is invalid or has expired. Most of the time, this means a fake token has been used. If the error persists, contact customer support.", 'give-cloudflare-turnstile')],
            ['bad-request', __("The request was rejected because it was malformed.", 'give-cloudflare-turnstile')],
            ['timeout-or-duplicate', __("The response parameter (token) has already been validated before. This means that the token was issued five minutes ago and is no longer valid, or it was already redeemed.", 'give-cloudflare-turnstile')],
            ['internal-error', __("An internal error happened while validating the response. The request can be retried.", 'give-cloudflare-turnstile')],
            ['', __("Invalid response", 'give-cloudflare-turnstile')],
        ];
    }

}
