<?php

namespace GiveCloudflareTurnstile\Addon;

/**
 * Helper class responsible for showing add-on notices.
 */
class Notices
{

    /**
     * GiveWP min required version notice.
     *
     * @since 1.0.0
     */
    public static function giveVersionError(): void
    {
        Give()->notices->register_notice(
            [
                'id' => 'give-cloudflare-turnstile-activation-error',
                'type' => 'error',
                'description' => View::load('admin/notices/give-version-error'),
                'show' => true,
            ]
        );
    }

    /**
     * GiveWP inactive notice.
     *
     * @since 1.0.0
     */
    public static function giveInactive(): void
    {
        echo esc_html(View::load('admin/notices/give-inactive'));
    }
}
