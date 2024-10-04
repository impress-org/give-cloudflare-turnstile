<?php defined( 'ABSPATH' ) or exit; ?>

<strong><?php _e( 'Activation Error:', 'givewp-cloudflare-turnstile' ); ?></strong>
<?php _e( 'You must have', 'givewp-cloudflare-turnstile' ); ?> <a href="https://givewp.com" target="_blank">Give</a>
<?php _e( 'version', 'givewp-cloudflare-turnstile' ); ?> <?php echo GIVE_CLOUDFLARE_TURNSTILE_MIN_GIVE_VERSION; ?>+
<?php printf( esc_html__( 'for the %1$s add-on to activate', 'givewp-cloudflare-turnstile' ), GIVE_CLOUDFLARE_TURNSTILE_NAME ); ?>
.

