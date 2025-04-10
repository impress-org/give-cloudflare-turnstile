<?php

namespace GiveCloudflareTurnstile\Settings\Actions;

use GiveCloudflareTurnstile\Settings\ValueObjects\SettingKeys;

/**
 * @since 1.0.0
 */
class RegisterGlobalSettings
{
    /**
     * @since 1.0.0
     */
    public function __invoke(array $settings): array
    {
        if ('cloudflare_turnstile' !== give_get_current_setting_section()) {
            return $settings;
        }

        return $this->getSettings();
    }

    /**
     * @since 1.0.0
     */
    protected function getSettings(): array
    {
        return [
            [
                'id' => 'give_title_settings_cloudflare_turnstile_1',
                'type' => 'title',
            ],
            $this->getEnableSettings(),
            $this->getApiSiteKeySettings(),
            $this->getApiSecretKeySettings(),
            [
                'id' => 'give_title_settings_cloudflare_turnstile_1',
                'type' => 'sectionend',
            ],
        ];
    }

    /**
     * @since 1.0.0
     */
    public function getEnableSettings(): array
    {
        return [
            'name' => __('Enable Cloudflare Turnstile', 'give-cloudflare-turnstile'),
            'desc' => __(
                'If enabled, this option will add a Cloudflare Turnstile widget to all donation forms',
                'give-cloudflare-turnstile'
            ),
            'id' => SettingKeys::ENABLED,
            'type' => 'radio_inline',
            'default' => 'disabled',
            'options' => [
                'enabled' => __('Enabled', 'give-cloudflare-turnstile'),
                'disabled' => __('Disabled', 'give-cloudflare-turnstile'),
            ],
        ];
    }

    /**
     * @since 1.0.0
     */
    public function getApiSiteKeySettings(): array
    {
        return [
            'id' => SettingKeys::SITE_KEY,
            'name' => __('Cloudflare Turnstile Site Key', 'give-cloudflare-turnstile'),
            'desc' => __(
                'Enter your Cloudflare Site Key here. This key is required to connect to the Cloudflare API.',
                'give-cloudflare-turnstile'
            ),
            'type' => 'api_key',
        ];
    }

    /**
     * @since 1.0.0
     */
    public function getApiSecretKeySettings(): array
    {
        return [
            'id' => SettingKeys::SECRET_KEY,
            'name' => __('Cloudflare Turnstile Secret Key', 'give-cloudflare-turnstile'),
            'desc' => __(
                'Enter your Cloudflare Turnstile Secret key here. This key is required to connect to the Cloudflare API.',
                'give-cloudflare-turnstile'
            ),
            'type' => 'api_key',
        ];
    }
}
