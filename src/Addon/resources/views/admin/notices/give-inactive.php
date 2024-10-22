<?php defined( 'ABSPATH' ) or exit; ?>

<strong><?php esc_attr_e( 'Activation Error:', 'givewp-cloudflare-turnstile' ); ?></strong>
<?php esc_attr_e( 'You must have', 'givewp-cloudflare-turnstile' ); ?> <a href="https://givewp.com" target="_blank">Give</a>
<?php printf( __( 'plugin installed and activated for the %s add-on to activate', 'givewp-cloudflare-turnstile' ), GIVE_CLOUDFLARE_TURNSTILE_NAME ); ?>
