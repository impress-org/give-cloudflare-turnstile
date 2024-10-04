<?php

namespace GiveCloudflareTurnstile\Addon;

use Give\Helpers\Hooks;

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
            // Load add-on links.
            Hooks::addFilter('plugin_action_links_' . GIVE_CLOUDFLARE_TURNSTILE_BASENAME, Links::class);

            if (is_admin()){
                Hooks::addAction('admin_init', ActivationBanner::class, 'show', 20);
            }
        }
}
