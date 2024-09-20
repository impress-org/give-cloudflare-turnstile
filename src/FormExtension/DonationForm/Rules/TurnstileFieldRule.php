<?php

namespace GiveCloudflareTurnstile\FormExtension\DonationForm\Rules;

use Closure;
use Give\Log\Log;
use Give\Vendors\StellarWP\Validation\Contracts\ValidatesOnFrontEnd;
use Give\Vendors\StellarWP\Validation\Contracts\ValidationRule;

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
        $siteKey = defined('GIVE_TURNSTILE_SITE_KEY') ? GIVE_TURNSTILE_SITE_KEY : '';
        $secretKey = defined('GIVE_TURNSTILE_SECRET_KEY') ? GIVE_TURNSTILE_SECRET_KEY : '';

        if (empty($siteKey) || empty($secretKey)) {
            Log::error(__('Turnstile missing credentials.', 'give'), [
                'formId' => $values['formId'] ?? null,
            ]);

            $fail(__('Permission denied.', 'give'));
        }

        $verify = wp_remote_post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'body' => [
                'secret' => $secretKey,
                'response' => $value
            ]
        ]);

        $verify = wp_remote_retrieve_body($verify);
        $response = json_decode($verify, false);

        if (!$response->success) {
            Log::spam(__('Turnstile verification failed.', 'give'), [
                'response' => $response,
                'formId' => $values['formId'] ?? null,
            ]);

            $fail(__('Permission denied.', 'give'));
        }
    }

    /**
     * @since 3.0.0
     */
    public function serializeOption()
    {
        return true;
    }
}
