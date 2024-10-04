<?php

namespace GiveCloudflareTurnstile\Addon;

use Give_Addon_Activation_Banner;

use GiveCloudflareTurnstile\Settings\Repositories\GlobalSettings;

use const GIVE_CLOUDFLARE_TURNSTILE_VERSION;

/**
 * Helper class responsible for showing add-on Activation Banner.
 * @since 1.0.0
 */
class ActivationBanner
{

    /**
     * Show activation banner
     *
     * @since 1.0.0
     */
    public function show(): void
    {
        // Check for Activation banner class.
        if (!class_exists('Give_Addon_Activation_Banner') && file_exists(
                GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php'
            )) {
                include GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php';
            }

        // Only runs on admin.
        $args = [
            'file' => GIVE_CLOUDFLARE_TURNSTILE_FILE,
            'name' => GIVE_CLOUDFLARE_TURNSTILE_NAME,
            'version' => GIVE_CLOUDFLARE_TURNSTILE_VERSION,
            'settings_url' => give(GlobalSettings::class)->getSettingsUrl(),
            'documentation_url' => 'https://givewp.com/documentation/add-ons/boilerplate/',
            'support_url' => 'https://givewp.com/support/',
            'testing' => false, // Never leave true.
        ];

        ray($args);

        new Give_Addon_Activation_Banner($args);
    }
}
