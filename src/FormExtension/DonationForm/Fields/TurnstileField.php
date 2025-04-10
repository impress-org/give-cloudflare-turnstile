<?php

namespace GiveCloudflareTurnstile\FormExtension\DonationForm\Fields;

use Give\Framework\FieldsAPI\Concerns\HasLabel;
use Give\Framework\FieldsAPI\SecurityChallenge;

/**
 * Cloudflare Turnstile field.
 * @see https://developers.cloudflare.com/turnstile/get-started/
 *
 * @since 1.1.0 updated to extend SecurityChallenge
 * @since 1.0.0
 */
class TurnstileField extends SecurityChallenge {
    use HasLabel;

    const TYPE = 'turnstile';
}
