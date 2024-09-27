<?php

namespace GiveCloudflareTurnstile\Settings\Actions;

/**
 * @unreleased
 */
class RegisterGlobalSettings
{
    /**
     * @unreleased
     */
    public function __invoke(array $settings): array
    {
        if ('cloudflare_turnstile' !== give_get_current_setting_section()) {
            return $settings;
        }

        return $this->getSettings();
    }

    /**
     * @unreleased
     */
    protected function getSettings(): array
    {
        return [
            [
                'id' => 'give_title_settings_cloudflare_turnstile_1',
                'type' => 'title',
            ],
            $this->getEnableSettings(),
            [
                'id' => 'give_title_settings_cloudflare_turnstile_1',
                'type' => 'sectionend',
            ],
        ];
    }

    /**
     * @unreleased
     */
    public function getEnableSettings(): array
    {
        return [
            'name' => __('Enable Cloudflare Turnstile', 'give'),
            'desc' => __(
                'If enabled, this option will add a Cloudflare Turnstile widget to all donation forms',
                'give'
            ),
            'id' => 'givewp_donation_forms_cloudflare_turnstile_enabled',
            'type' => 'radio_inline',
            'default' => 'disabled',
            'options' => [
                'enabled' => __('Enabled', 'give'),
                'disabled' => __('Disabled', 'give'),
            ],
        ];
    }
}
