<?php

namespace GiveCloudflareTurnstile\FormExtension\DonationForm\Actions;

use Give\Framework\FieldsAPI\DonationForm;
use Give\Framework\FieldsAPI\Exceptions\EmptyNameException;
use GiveCloudflareTurnstile\FormExtension\DonationForm\Fields\TurnstileField;
use GiveCloudflareTurnstile\FormExtension\DonationForm\Rules\TurnstileFieldRule;

/**
 * @since 1.0.0
 */
class AddFieldToFormSchema
{
    /**
     * @since 1.0.0
     * @throws EmptyNameException
     */
    public function __invoke(DonationForm $form, int $formId)
    {
        if (!apply_filters(
            'give_cloudflare_turnstile_enabled',
            give_is_setting_enabled(give_get_option('givewp_donation_forms_cloudflare_turnstile_enabled', false)),
            $formId
        )) {
            return;
        }

        /** @var TurnstileField $field */
        $field = TurnstileField::make('turnstile')
            ->label(__('Please verify you are human', 'give'))
            ->defaultValue('')
            ->rules('required', new TurnstileFieldRule());

        $formNodes = $form->all();
        $lastSection = $form->count() ? $formNodes[$form->count() - 1] : null;

        $siteKey = defined('GIVE_TURNSTILE_SITE_KEY') ? GIVE_TURNSTILE_SITE_KEY : '';
        $secretKey = defined('GIVE_TURNSTILE_SECRET_KEY') ? GIVE_TURNSTILE_SECRET_KEY : '';


        if ($lastSection && !empty($siteKey) && !empty($secretKey)) {
            $lastSection->append($field);
        }
    }
}
