<?php

/**
 * MyApp
 *
 * @package   MyApp
 * @author    MooToon <support@mootoons.com>
 * @license   GPL v2 or later
 * @link      https://github.com/mootoons/wp-react-typescript-plugin-standard
 */

namespace MyApp;

if (!defined('ABSPATH')) {
    exit;
}

class Activation
{
    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function onHooks(): void
    {
        add_action('admin_init', [$this, 'upgradeProcedure']);
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public static function activate(): void
    {
        self::upgradeProcedure();

        flush_rewrite_rules();
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public static function deactivate(): void
    {
        flush_rewrite_rules();
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public static function upgradeProcedure(): void
    {
        if (!is_admin()) {
            return;
        }

        $version = strval(get_option('my-app_version'));
        if (!version_compare(MY_APP_VERSION, $version, '>')) {
            return;
        }

        update_option('my-app_version', MY_APP_VERSION);
    }
}
