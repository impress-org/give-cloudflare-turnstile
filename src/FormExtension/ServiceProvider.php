<?php

namespace GiveCloudflareTurnstile\FormExtension;

use Give\Helpers\Hooks;
use GiveCloudflareTurnstile\FormExtension\DonationForm\Actions\AddFieldToFormSchema;
use GiveCloudflareTurnstile\FormExtension\DonationForm\Actions\EnqueueScripts;

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
        Hooks::addAction('givewp_donation_form_enqueue_scripts', EnqueueScripts::class);
        Hooks::addAction('givewp_donation_form_schema', AddFieldToFormSchema::class, '__invoke', 10, 2);
    }
}
