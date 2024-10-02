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
        $response = json_encode([
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

}
