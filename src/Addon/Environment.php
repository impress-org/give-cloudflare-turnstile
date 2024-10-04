<?php

namespace GiveCloudflareTurnstile\Addon;

use const GIVE_CLOUDFLARE_TURNSTILE_MIN_GIVE_VERSION;

/**
 * Helper class responsible for checking the add-on environment.
 *
 * @since 1.0.0
 */
class Environment
{

    /**
     * Check environment.
     *
     * @since 1.0.0
     */
    public static function checkEnvironment(): void
    {
        // Check is GiveWP active
        if (!static::isGiveActive()) {
            add_action('admin_notices', [Notices::class, 'giveInactive']);

            return;
        }
        // Check min required version
        if (!static::giveMinRequiredVersionCheck()) {
            add_action('admin_notices', [Notices::class, 'giveVersionError']);
        }
    }

    /**
     * Check min required version of GiveWP.
     *
     * @since 1.0.0
     */
    public static function giveMinRequiredVersionCheck(): bool
    {
        return defined('GIVE_VERSION') && version_compare(GIVE_VERSION, GIVE_CLOUDFLARE_TURNSTILE_MIN_GIVE_VERSION, '>=');
    }

    /**
     * Check if GiveWP is active.
     *
     * @since 1.0.0
     */
    public static function isGiveActive(): bool
    {
        return defined('GIVE_VERSION');
    }
}
