<?php

namespace GiveCloudflareTurnstile\Addon;

use InvalidArgumentException;

use const GIVE_CLOUDFLARE_TURNSTILE_DIR;

/**
 * Helper class responsible for loading add-on views.
 * @since 1.0.0
 */
class View
{
    /**
     * Default add-on domain
     */
    const DEFAULT_DOMAIN = 'Addon';

    /**
     * @since 1.0.0
     *
     * @param array  $templateParams Arguments for template.
     * @param bool   $echo
     *
     * @param string $view Template name
     * When using multiple domains within this add-on, the domain directory can be set by using "." in the template name.
     * String before the "." character is domain directory, and everything after is the template file path
     * Example usage: View::render( 'DomainName.templateName' );
     * This will try to load src/DomainName/resources/view/templateName.php file
     *
     * @return string|void
     * @throws InvalidArgumentException if template file not exist
     *
     */
    public static function load(string $view, array $templateParams = [], bool $echo = false)
    {
        // Get domain and file path
        list ($domain, $file) = static::getPaths($view);
        $template = GIVE_CLOUDFLARE_TURNSTILE_DIR . "src/{$domain}/resources/views/{$file}.php";

        if ( ! file_exists($template)) {
            throw new InvalidArgumentException("View template file {$template} does not exist");
        }

        ob_start();
        extract($templateParams);
        include $template;
        $content = ob_get_clean();

        if ( ! $echo) {
            return $content;
        }

        echo $content;
    }

    /**
     * @since 1.0.0
     *
     * @param array  $vars
     *
     * @param string $view
     */
    public static function render(string $view, array $vars = []): void
    {
        static::load($view, $vars, true);
    }

    /**
     * Get domain and template file path
     *
     * @since 1.0.0
     *
     * @param string $path
     *
     * @return array
     */
    private static function getPaths(string $path): array
    {
        // Check for . delimiter
        if (false === strpos($path, '.')) {
            return [
                self::DEFAULT_DOMAIN,
                $path,
            ];
        }

        return explode('.', $path, 2);
    }
}
