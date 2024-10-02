<?php

namespace GiveCloudflareTurnstile\Tests\Unit\TestTraits;

/**
 * @since 1.0.0
 */
trait HasCloudFlareTurnstileSettings
{
    /**
     * Setup Give Cloudflare Turnstile settings.
     *
     * @since 1.0.0
     */
    public function setupCloudflareTurnstileSettings(): void
    {
        give_update_option('givewp_cloudflare_turnstile_site_key', '1x00000000000000000000AA');
        give_update_option('givewp_cloudflare_turnstile_secret_key', '1x0000000000000000000000000000000AA');
    }
}
