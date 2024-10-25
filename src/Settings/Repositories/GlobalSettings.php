<?php

namespace GiveCloudflareTurnstile\Settings\Repositories;

/**
 * @since 1.0.0
 */
class GlobalSettings {
    /**
     * @since 1.0.0
     */
    public function getSiteKey(): string
    {
        return (string)defined('GIVE_TURNSTILE_SITE_KEY') ? constant('GIVE_TURNSTILE_SITE_KEY') : give_get_option('givewp_cloudflare_turnstile_site_key', '');
    }

    /**
     * @since 1.0.0
     */
    public function getSecretKey(): string
    {
        return (string)defined('GIVE_TURNSTILE_SECRET_KEY') ? constant('GIVE_TURNSTILE_SECRET_KEY') : give_get_option('givewp_cloudflare_turnstile_secret_key', '');
    }

    /**
     * @since 1.0.0
     */
    public function isEnabled(): bool
    {
        return give_is_setting_enabled(give_get_option('givewp_donation_forms_cloudflare_turnstile_enabled', 'disabled'));
    }

    /**
     * @since 1.0.0
     */
    public function getSettingsUrl(): ?string
    {
        return admin_url('edit.php?post_type=give_forms&page=give-settings&tab=security&section=cloudflare_turnstile');
    }
}
