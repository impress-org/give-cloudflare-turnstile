<?php

namespace GiveCloudflareTurnstile\Turnstile;

use GiveCloudflareTurnstile\Turnstile\Repositories\TurnstileRepository;

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
        give()->singleton(TurnstileRepository::class);
    }

    /**
     * @since 1.0.0
     */
    public function boot()
    {

    }
}
