<?php

namespace GiveCloudflareTurnstile\Addon;

use GiveCloudflareTurnstile\Settings\Repositories\GlobalSettings;

/**
 * @since 1.0.0
 */
class Links
{
    /**
     * Add settings link to the add-on action links.
     *
     * @since 1.0.0
     */
    public function __invoke($actions): array
    {
        /** @var GlobalSettings $settings */
        $settings = give(GlobalSettings::class);
        $newActions = array(
            'settings' => sprintf(
                '<a href="%s">%s</a>',
                esc_url($settings->getSettingsUrl()),
                __('Settings', 'give-cloudflare-turnstile')
            ),
        );

        return array_merge($newActions, $actions);
    }
}
