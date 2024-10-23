<?php

namespace GiveCloudflareTurnstile\FormExtension\DonationForm\Rules;

use Closure;
use Give\Log\Log;
use Give\Vendors\StellarWP\Validation\Contracts\ValidatesOnFrontEnd;
use Give\Vendors\StellarWP\Validation\Contracts\ValidationRule;
use GiveCloudflareTurnstile\Settings\Repositories\GlobalSettings;
use GiveCloudflareTurnstile\Turnstile\Repositories\TurnstileRepository;
use GiveCloudflareTurnstile\Turnstile\ValueObjects\TurnstileVerifyResponse;

/**
 * @unreleased
 */
class TurnstileFieldRule implements ValidationRule, ValidatesOnFrontEnd
{

    /**
     * @unreleased
     */
    public static function id(): string
    {
        return 'turnstile';
    }

    /**
     * @unreleased
     */
    public static function fromString(string $options = null): ValidationRule
    {
        return new self();
    }

    /**
     * @unreleased
     */
    public function __invoke($value, Closure $fail, string $key, array $values)
    {
        /** @var GlobalSettings $settings */
        $settings = give(GlobalSettings::class);

        $siteKey = $settings->getSiteKey();
        $secretKey = $settings->getSecretKey();

        if (empty($siteKey) || empty($secretKey)) {
            Log::error(__('Turnstile missing credentials.', 'givewp-cloudflare-turnstile'), [
                'formId' => $values['formId'] ?? null,
            ]);

            $fail(__('Permission denied.', 'givewp-cloudflare-turnstile'));
        }

        $response = $this->verifyToken($secretKey, $value);

        if (!$response->isSuccess()) {
            Log::spam(__('Turnstile verification failed.', 'givewp-cloudflare-turnstile'), [
                'response' => $response,
                'errorMessages' => $response->getErrorMessages() ?? [],
                'formId' => $values['formId'] ?? null,
            ]);

            $fail(__('Permission denied.', 'givewp-cloudflare-turnstile'));
        }
    }

    /**
     * @since 3.0.0
     */
    public function serializeOption()
    {
        return true;
    }

    /**
     * @since 1.0.0
     */
    protected function verifyToken(string $secretKey, $value): TurnstileVerifyResponse
    {
            /** @var TurnstileRepository $turnstileRepository */
        $turnstileRepository = give(TurnstileRepository::class);

        return $turnstileRepository->verify($secretKey, $value);
    }
}
