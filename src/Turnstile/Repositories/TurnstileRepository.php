<?php
namespace GiveCloudflareTurnstile\Turnstile\Repositories;

 use GiveCloudflareTurnstile\Turnstile\ValueObjects\TurnstileVerifyResponse;

 /**
 * @since 1.0.0
 */
class TurnstileRepository {
    /**
     * Verify the Turnstile response.
     * @see https://developers.cloudflare.com/turnstile/get-started/server-side-validation/
     * @param string $secretKey The widget’s secret key. The secret key can be found under widget settings in the Cloudflare dashboard under Turnstile.
     * @param string $responseValue The response provided by the Turnstile client-side render on your site.
     *
     * @since 1.0.0
     */
    public function verify(string $secretKey, string $responseValue): TurnstileVerifyResponse
    {
        $response = wp_remote_post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'body' => [
                'secret' => $secretKey,
                'response' => $responseValue
            ]
        ]);

        $response = wp_remote_retrieve_body($response);

        return new TurnstileVerifyResponse(json_decode($response, false));
    }
}
