<?php

namespace GiveCloudflareTurnstile\Settings;

use Give\Helpers\Hooks;
use GiveCloudflareTurnstile\Settings\Actions\RegisterGlobalSettings;

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
    }

    /**
     * @since 1.0.0
     */
    public function boot()
    {
        add_filter('give_get_sections_advanced', function($sections) {
            $sections['cloudflare_turnstile'] = __('Cloudflare Turnstile', 'give');

            return $sections;
        });

        Hooks::addFilter('give_get_settings_advanced', RegisterGlobalSettings::class);
    }
}
