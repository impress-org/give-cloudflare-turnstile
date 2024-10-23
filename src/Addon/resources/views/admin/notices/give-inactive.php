<?php defined( 'ABSPATH' ) or exit; ?>

<strong><?php esc_attr_e( 'Activation Error:', 'give-cloudflare-turnstile' ); ?></strong>
<?php esc_attr_e( 'You must have', 'give-cloudflare-turnstile' ); ?> <a href="https://givewp.com" target="_blank">Give</a>
<?php printf(/* translators: %s: GiveWP Add-on name. */ esc_html__( 'plugin installed and activated for the %s add-on to activate', 'give-cloudflare-turnstile' ), esc_attr(GIVE_CLOUDFLARE_TURNSTILE_NAME) ); ?>
