<?php

/**
 * MyApp
 *
 * @package   MyApp
 * @author    MooToon <support@mootoons.com>
 * @license   GPL v2 or later
 * @link      https://github.com/mootoons/wp-react-typescript-plugin-standard
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('my_app_get_settings')) {
    function my_app_get_settings(): array
    {
        return get_option('my-app_get_settings', []);
    }
}
