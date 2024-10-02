<?php

namespace GiveCloudflareTurnstile\Tests\Unit\FormExtension\Rules;

use Exception;
use Give\Tests\TestCase;
use Give\Tests\TestTraits\RefreshDatabase;
use Give\Tests\Unit\DonationForms\TestTraits\HasValidationRules;
use GiveCloudflareTurnstile\FormExtension\DonationForm\Rules\TurnstileFieldRule;
use GiveCloudflareTurnstile\Tests\Unit\TestTraits\HasCloudFlareTurnstileSettings;
use GiveCloudflareTurnstile\Turnstile\Repositories\TurnstileRepository;
use GiveCloudflareTurnstile\Turnstile\ValueObjects\TurnstileVerifyResponse;
use PHPUnit_Framework_MockObject_MockBuilder;

/**
 * @since 1.0.0
 */
class TestTurnstileFieldRule extends TestCase
{
    use RefreshDatabase;
    use HasValidationRules;
    use HasCloudFlareTurnstileSettings;

    /**
     * @since 1.0.0
     * @throws Exception
     */
    public function testShouldFailIfMissingSiteKey(): void
    {
        $this->mockTurnstileRepository();
        $this->setupCloudflareTurnstileSettings();
        give_update_option('givewp_donation_forms_cloudflare_turnstile_enabled', 'enabled');
        give_update_option('givewp_cloudflare_turnstile_site_key', '');


        $rule = new TurnstileFieldRule();

        self::assertValidationRuleFailed($rule, 'cloudflare-turnstile-response-token');
    }

    /**
     * @since 1.0.0
     * @throws Exception
     */
    public function testShouldFailIfMissingSecretKey(): void
    {
        $this->mockTurnstileRepository();
        $this->setupCloudflareTurnstileSettings();
        give_update_option('givewp_donation_forms_cloudflare_turnstile_enabled', 'enabled');
        give_update_option('givewp_cloudflare_turnstile_secret_key', '');


        $rule = new TurnstileFieldRule();

        self::assertValidationRuleFailed($rule, 'cloudflare-turnstile-response-token');
    }

    /**
     * @since 1.0.0
     * @throws Exception
     */
    public function testShouldFailIfResponseIsNotSuccessful(): void
    {
        $mockRule = $this->getMockRule();

        $mockRule->expects($this->once())
            ->method('verifyToken')
            ->willReturn(
                new TurnstileVerifyResponse(
                    (object)[
                        'success' => false,
                        'error_codes' => ['invalid-input-response'],
                    ]
                )
            );

        $this->setupCloudflareTurnstileSettings();
        give_update_option('givewp_donation_forms_cloudflare_turnstile_enabled', 'enabled');

        self::assertValidationRuleFailed($mockRule, 'cloudflare-turnstile-response-token');
    }

    /**
     * @since 1.0.0
     * @throws Exception
     */
    public function testShouldPassIfResponseIsSuccessful(): void
    {
        $mockRule = $this->getMockRule();

        $mockRule->expects($this->once())
            ->method('verifyToken')
            ->willReturn(
                new TurnstileVerifyResponse(
                    (object)[
                        'success' => true,
                        'error_codes' => [],
                        'hostname' => 'example.com',
                        'challenge_ts' => '2021-01-01T00:00:00Z',
                    ]
                )
            );

        $this->setupCloudflareTurnstileSettings();
        give_update_option('givewp_donation_forms_cloudflare_turnstile_enabled', 'enabled');

        self::assertValidationRulePassed($mockRule, 'cloudflare-turnstile-response-token');
    }

    /**
     * @since 1.0.0
     */
    public function mockTurnstileRepository(): void
    {
        $this->mock(
            TurnstileRepository::class,
            function (PHPUnit_Framework_MockObject_MockBuilder $mockBuilder) {
                $mockBuilder->setMethods(['verify']);

                return $mockBuilder->getMock();
            }
        );
    }

    /**
     * @since 1.0.0
     */
    public function getMockRule()
    {
        return $this->createMock(
            TurnstileFieldRule::class,
            function (PHPUnit_Framework_MockObject_MockBuilder $mockBuilder) {
                $mockBuilder->setMethods(['verifyToken']);

                return $mockBuilder->getMock();
            }
        );
    }
}
