# Give - Cloudflare Turnstile

## Description
Reduce donation spam with Cloudflare turnstile, a user-friendly, privacy-preserving alternative to CAPTCHA

## Installation
1. Run composer install
2. Run npm install && npm run build
3. Activate the plugin

Add the following:
```php
add_filter('give_cloudflare_turnstile_enabled', '__return_true');
```

Replace the following with your Cloudflare Turnstile Site Key and Secret Key:
The current values are for testing purposes only.

```php
define('GIVE_TURNSTILE_SITE_KEY', '0x4AAAAAAAkKVAClSfWgKKSy');
define('GIVE_TURNSTILE_SECRET_KEY', '0x4AAAAAAAkKVKxbDHB4JJNJy-Laa1brdLM');
```

