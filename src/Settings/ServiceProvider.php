<?php

namespace GiveCloudflareTurnstile\Settings;

use Give\Helpers\Hooks;
use GiveCloudflareTurnstile\Settings\Actions\RegisterGlobalSettings;
use GiveCloudflareTurnstile\Settings\Repositories\GlobalSettings;

/**
 * @since 1.0.0
 */
class ServiceProvider implements \Give\ServiceProviders\ServiceProvider
{

    /**
     * @since 1.0.0
     */
    public function register()
    {
        give()->singleton(GlobalSettings::class);
    }

    /**
     * @since 1.0.0
     */
    public function boot()
    {
        add_filter('give_get_sections_security', function($sections) {
            $sections['cloudflare_turnstile'] = __('Cloudflare Turnstile', 'givewp-cloudflare-turnstile');

            return $sections;
        });

        Hooks::addFilter('give_get_settings_security', RegisterGlobalSettings::class);
    }
}
