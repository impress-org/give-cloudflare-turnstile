<?php

/**
 * Plugin Name:         Give - Cloudflare Turnstile
 * Requires Plugins:    give
 * Plugin URI:          https://github.com/impress-org/givewp
 * Description:         Reduce donation spam with Cloudflare turnstile, a user-friendly, privacy-preserving alternative to CAPTCHA
 * Version:             1.0.0
 * Requires at least:   6.4
 * Requires PHP:        7.2
 * Author:              GiveWP
 * Author URI:          https://givewp.com/
 * Text Domain:         givewp-cloudflare-turnstile
 * Domain Path:         /languages
 * License:             GPLv3
 */

use GiveCloudflareTurnstile\Addon\Environment;

defined('ABSPATH') or exit;

// Add-on name
define('GIVE_CLOUDFLARE_TURNSTILE_NAME', 'Give - Cloudflare Turnstile');

// Versions
define('GIVE_CLOUDFLARE_TURNSTILE_VERSION', '1.0.0');
define('GIVE_CLOUDFLARE_TURNSTILE_MIN_GIVE_VERSION', '3.17.0');

// Add-on paths
define('GIVE_CLOUDFLARE_TURNSTILE_FILE', __FILE__);
define('GIVE_CLOUDFLARE_TURNSTILE_DIR', plugin_dir_path(__FILE__));
define('GIVE_CLOUDFLARE_TURNSTILE_URL', plugin_dir_url(__FILE__));
define('GIVE_CLOUDFLARE_TURNSTILE_BASENAME', plugin_basename(__FILE__));

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

// Check to make sure GiveWP core is installed and compatible with this add-on.
add_action('admin_init', [Environment::class, 'checkEnvironment']);

 // Register the add-on service provider with the GiveWP core.
add_action(
    'before_give_init',
    function () {
        // Check Give min required version.
         if (Environment::giveMinRequiredVersionCheck()) {
            give()->registerServiceProvider(GiveCloudflareTurnstile\Addon\ServiceProvider::class);
            give()->registerServiceProvider(GiveCloudflareTurnstile\Settings\ServiceProvider::class);
            give()->registerServiceProvider(GiveCloudflareTurnstile\FormExtension\ServiceProvider::class);
        }
    }
);
