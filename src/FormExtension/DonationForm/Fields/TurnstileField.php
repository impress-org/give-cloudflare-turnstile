<?php

namespace GiveCloudflareTurnstile\FormExtension\DonationForm\Fields;

use Give\Framework\FieldsAPI\Concerns\HasLabel;
use Give\Framework\FieldsAPI\Field;

/**
 * Cloudflare Turnstile field.
 * @see https://developers.cloudflare.com/turnstile/get-started/
 *
 * @unreleased
 */
class TurnstileField extends Field {
    use HasLabel;

    const TYPE = 'turnstile';
}