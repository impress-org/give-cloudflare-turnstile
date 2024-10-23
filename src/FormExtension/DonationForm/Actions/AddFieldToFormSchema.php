<?php

namespace GiveCloudflareTurnstile\FormExtension\DonationForm\Actions;

use Give\Framework\FieldsAPI\DonationForm;
use Give\Framework\FieldsAPI\Exceptions\EmptyNameException;
use Give\Log\Log;
use GiveCloudflareTurnstile\FormExtension\DonationForm\Fields\TurnstileField;
use GiveCloudflareTurnstile\FormExtension\DonationForm\Rules\TurnstileFieldRule;
use GiveCloudflareTurnstile\Settings\Repositories\GlobalSettings;

/**
 * @since 1.0.0
 */
class AddFieldToFormSchema
{
    /**
     * @var GlobalSettings $settings
     */
    public $settings;

    /**
     * @since 1.0.0
     */
    public function __construct(GlobalSettings $settings) {
        $this->settings = $settings;
    }

    /**
     * @since 1.0.0
     * @throws EmptyNameException
     */
    public function __invoke(DonationForm $form, int $formId)
    {
        if (!apply_filters(
            'give_cloudflare_turnstile_enabled',
            $this->settings->isEnabled(),
            $formId
        )) {
            return;
        }

        /** @var TurnstileField $field */
        $field = TurnstileField::make('turnstile')
            ->label(__('Please verify you are human', 'give-cloudflare-turnstile'))
            ->defaultValue('')
            ->rules('required', new TurnstileFieldRule());

        $formNodes = $form->all();
        $lastSection = $form->count() ? $formNodes[$form->count() - 1] : null;

        if (empty($this->settings->getSiteKey())) {
            Log::error('Cloudflare Turnstile Site Key Missing');

            return;
        }

        if (empty($this->settings->getSecretKey())) {
            Log::error('Cloudflare Turnstile Secret Key Missing');

            return;
        }


        if ($lastSection && is_null($form->getNodeByName('turnstile'))) {
            $lastSection->append($field);
        }
    }
}
