<?php

namespace GiveCloudflareTurnstile\Addon;

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
        $newActions = array(
            'settings' => sprintf(
                '<a href="%s">%s</a>',
                esc_url(admin_url('edit.php?post_type=give_forms&page=give-settings&tab=advanced&section=cloudflare_turnstile')),
                __('Settings', 'givewp-cloudflare-turnstile')
            ),
        );

        return array_merge($newActions, $actions);
    }
}
