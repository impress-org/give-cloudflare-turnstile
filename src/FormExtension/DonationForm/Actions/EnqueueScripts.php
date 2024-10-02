<?php

namespace GiveCloudflareTurnstile\FormExtension\DonationForm\Actions;

use Give\Framework\Support\Facades\Scripts\ScriptAsset;
use GiveCloudflareTurnstile\Settings\Repositories\GlobalSettings;

use const GIVE_CLOUDFLARE_TURNSTILE_VERSION;

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
            $turnstileFieldScriptAsset['version'],
            true
        );

        wp_add_inline_script(
            $turnstileFieldScriptHandle,
            'window.giveTurnstileFieldSettings = ' . wp_json_encode([
                'siteKey' => give(GlobalSettings::class)->getSiteKey(),
            ]) . ';',
            'before'
        );

        wp_set_script_translations($turnstileFieldScriptHandle, 'givewp-cloudflare-turnstile', GIVE_CLOUDFLARE_TURNSTILE_DIR . "languages");
    }
}
