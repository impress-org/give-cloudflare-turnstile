<?php

use Give\Tests\Framework\Addons\Bootstrap;

require __DIR__ . '/../../give/vendor/autoload.php';

(new Bootstrap(__DIR__ . '/../give-cloudflare-turnstile.php'))->load();
