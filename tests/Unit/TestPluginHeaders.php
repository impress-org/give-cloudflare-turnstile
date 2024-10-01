<?php

namespace GiveCloudflareTurnstile\Tests\Unit;


use Give\Tests\TestCase;

/**
 * @since 1.0.0
 */
class TestPluginHeaders extends TestCase {
     /**
     * @since 1.0.0
     */
    public function testReadMeVersionMatchesPluginVersion(): void
    {
        $readme = get_file_data(
            trailingslashit(GIVE_CLOUDFLARE_TURNSTILE_DIR) . "readme.txt",
            [
                "Version" => "Stable tag"
            ]
        );

        $plugin = get_plugin_data(GIVE_CLOUDFLARE_TURNSTILE_FILE);

        $this->assertEquals(GIVE_CLOUDFLARE_TURNSTILE_VERSION, $readme['Version']);
        $this->assertEquals(GIVE_CLOUDFLARE_TURNSTILE_VERSION, $plugin['Version']);
        $this->assertEquals($readme['Version'], $plugin['Version']);
    }

    /**
     * @since 1.0.0
     */
    public function testReadMeRequiresPHPVersionMatchesPluginVersion(): void
    {
        $readme = get_file_data(
            trailingslashit(GIVE_CLOUDFLARE_TURNSTILE_DIR) . "readme.txt",
            [
                "RequiresPHP" => "Requires PHP"
            ]
        );

        $plugin = get_plugin_data(GIVE_CLOUDFLARE_TURNSTILE_FILE);

        $this->assertEquals($plugin['RequiresPHP'], $readme['RequiresPHP']);
    }

    /**
     * @since 1.0.0
     */
    public function testReadMeRequiresWPVersionMatchesPluginHeaderVersion(): void
    {
        $readme = get_file_data(
            trailingslashit(GIVE_CLOUDFLARE_TURNSTILE_DIR) . "readme.txt",
            [
                "RequiresWP" => "Requires at least"
            ]
        );

        $plugin = get_plugin_data(GIVE_CLOUDFLARE_TURNSTILE_FILE);

        $this->assertEquals($plugin['RequiresWP'], $readme['RequiresWP']);
    }

     /**
     * @since 1.0.0
     */
    public function testIsCompatibleWithGiveWP(): void
    {
        $this->assertTrue(version_compare(GIVE_VERSION, GIVE_CLOUDFLARE_TURNSTILE_MIN_GIVE_VERSION, '>='));
    }
}
