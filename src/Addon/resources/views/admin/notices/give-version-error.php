<?php defined( 'ABSPATH' ) or exit; ?>

<strong><?php esc_attr_e( 'Activation Error:', 'givewp-cloudflare-turnstile' ); ?></strong>
<?php esc_attr_e( 'You must have', 'givewp-cloudflare-turnstile' ); ?> <a href="https://givewp.com" target="_blank">Give</a>
<?php esc_attr_e( 'version', 'givewp-cloudflare-turnstile' ); ?> <?php echo esc_attr(GIVE_CLOUDFLARE_TURNSTILE_MIN_GIVE_VERSION); ?>
<?php printf(/* translators: %1$s: GiveWP Add-on name. */ esc_html__( 'for the %1$s add-on to activate', 'givewp-cloudflare-turnstile' ), esc_attr(GIVE_CLOUDFLARE_TURNSTILE_NAME) ); ?>
.

