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
 * @since 1.0.0
 */
class TurnstileFieldRule implements ValidationRule, ValidatesOnFrontEnd
{

    /**
     * @since 1.0.0
     */
    public static function id(): string
    {
        return 'turnstile';
    }

    /**
     * @since 1.0.0
     */
    public static function fromString(string $options = null): ValidationRule
    {
        return new self();
    }

    /**
     * @since 1.0.0
     */
    public function __invoke($value, Closure $fail, string $key, array $values)
    {
        /** @var GlobalSettings $settings */
        $settings = give(GlobalSettings::class);

        $siteKey = $settings->getSiteKey();
        $secretKey = $settings->getSecretKey();

        if (empty($siteKey) || empty($secretKey)) {
            Log::error(__('Turnstile missing credentials.', 'give-cloudflare-turnstile'), [
                'formId' => $values['formId'] ?? null,
            ]);

            $fail(__('Permission denied.', 'give-cloudflare-turnstile'));
        }

        $response = $this->verifyToken($secretKey, $value);

        if (!$response->isSuccess()) {
            Log::spam(__('Turnstile verification failed.', 'give-cloudflare-turnstile'), [
                'response' => $response,
                'errorMessages' => $response->getErrorMessages() ?? [],
                'formId' => $values['formId'] ?? null,
            ]);

            $fail(__('Permission denied.', 'give-cloudflare-turnstile'));
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
