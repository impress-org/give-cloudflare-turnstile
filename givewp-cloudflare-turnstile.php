<?php

/**
 * Plugin Name:         Give - Cloudflare Turnstile
 * Requires Plugins:    give
 * Plugin URI:          https://github.com/impress-org/givewp
 * Description:         Reduce donation spam with Cloudflare turnstile, a user-friendly, privacy-preserving alternative to CAPTCHA
 * Version:             1.0.0
 * Requires at least:   6.3
 * Requires PHP:        7.2
 * Author:              GiveWP
 * Author URI:          https://givewp.com/
 * Text Domain:         give
 * Domain Path:         /languages
 */

use Give\Framework\FieldsAPI\DonationForm;
use GiveCloudflareTurnstile\FormExtension\DonationForm\Fields\TurnstileField;
use GiveCloudflareTurnstile\FormExtension\DonationForm\Rules\TurnstileFieldRule;

defined('ABSPATH') or exit;

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

// Register the add-on service provider with GiveWP core.
add_action('givewp_donation_form_enqueue_scripts', function () {
    $turnstileFieldScriptAsset = Give\Framework\Support\Facades\Scripts\ScriptAsset::get(
        plugin_dir_path(__FILE__) . 'build/turnstileField.asset.php'
    );

    wp_enqueue_script(
        'give-turnstile-field',
        plugin_dir_url(__FILE__) . 'build/turnstileField.js',
        $turnstileFieldScriptAsset['dependencies'],
        false,
        true
    );

    wp_add_inline_script(
        'give-turnstile-field',
        'window.giveTurnstileFieldSettings = ' . wp_json_encode([
            'siteKey' => defined('GIVE_TURNSTILE_SITE_KEY') ? GIVE_TURNSTILE_SITE_KEY : '',
        ]) . ';',
        'before'
    );
});

// Register the add-on service provider with GiveWP core.
 add_action('givewp_donation_form_schema', function (DonationForm $form, int $formId) {
     if (!apply_filters('give_cloudflare_turnstile_enabled', false, $formId)) {
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
}, 10, 2);