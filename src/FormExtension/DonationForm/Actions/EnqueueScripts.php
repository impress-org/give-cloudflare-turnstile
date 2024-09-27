<?php

namespace GiveCloudflareTurnstile\FormExtension\DonationForm\Actions;

use Give\Framework\Support\Facades\Scripts\ScriptAsset;

/**
 * @since 1.0.0
 */
class EnqueueScripts
{
    /**
     * @since 1.0.0
     */
    public function __invoke()
    {
        $turnstileFieldScriptAsset = ScriptAsset::get(
            GIVE_CLOUDFLARE_TURNSTILE_DIR . 'build/turnstileField.asset.php'
        );

        wp_enqueue_script(
            'give-turnstile-field',
            GIVE_CLOUDFLARE_TURNSTILE_URL . 'build/turnstileField.js',
            $turnstileFieldScriptAsset['dependencies'],
            false,
            true
        );

        wp_add_inline_script(
            'give-turnstile-field',
            'window.giveTurnstileFieldSettings = ' . wp_json_encode([
                'siteKey' => defined('GIVE_TURNSTILE_SITE_KEY') ? GIVE_TURNSTILE_SITE_KEY : '',
            ]) . ';',
            'before'
        );
    }
}
