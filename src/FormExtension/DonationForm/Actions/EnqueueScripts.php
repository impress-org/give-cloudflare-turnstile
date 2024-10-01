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

        $turnstileFieldScriptHandle = 'give-turnstile-field';

        wp_enqueue_script(
            $turnstileFieldScriptHandle,
            GIVE_CLOUDFLARE_TURNSTILE_URL . 'build/turnstileField.js',
            $turnstileFieldScriptAsset['dependencies'],
            false,
            true
        );

        wp_add_inline_script(
            $turnstileFieldScriptHandle,
            'window.giveTurnstileFieldSettings = ' . wp_json_encode([
                'siteKey' => defined('GIVE_TURNSTILE_SITE_KEY') ? GIVE_TURNSTILE_SITE_KEY : '',
            ]) . ';',
            'before'
        );

        wp_set_script_translations($turnstileFieldScriptHandle, 'givewp-cloudflare-turnstile', GIVE_CLOUDFLARE_TURNSTILE_DIR . "languages");
    }
}
