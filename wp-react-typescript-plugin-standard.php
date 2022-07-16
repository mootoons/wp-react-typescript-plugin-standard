<?php

/**
 * MyApp plugin for WordPress
 *
 * @package   MyApp
 * @link      https://github.com/mootoons/wp-react-typescript-plugin-standard
 * @author    MooToon <support@mootoons.com>
 * @license   GPL v2 or later
 *
 * Plugin Name:  WP React Typescript Plugin Standard
 * Description:  Wordpress plugin react typescript standard
 * Version:      1.0.0
 * Plugin URI:   https://mootoons.com/
 * Author:       MooToon
 * Author URI:   https://mootoons.com/
 * License:      GPL-2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:  my-app
 * Domain Path:  /app/lang/
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}


define('MY_APP_TITLE', 'MyApp');
define('MY_APP_VERSION', '1.0.0');
define('MY_APP_SLUG', 'my-app');
define('MY_APP_ABSOLUTE', __FILE__);
define('MY_APP_PATH', dirname(__FILE__));
define('MY_APP_DIR', basename(MY_APP_PATH));
define('MY_APP_URL', plugins_url() . '/' . MY_APP_DIR);
define('MY_APP_FILE', plugin_basename(__FILE__));

define('MY_APP_MIN_PHP_VERSION', '7.4');
define('MY_APP_WP_VERSION', '5.3');

if (is_ssl()) {
    define('MY_APP_WP_CONTENT_URL', str_replace('http:', 'https:', WP_CONTENT_URL));
    define('MY_APP_WP_PLUGIN_URL', str_replace('http:', 'https:', WP_PLUGIN_URL));
} else {
    define('MY_APP_WP_CONTENT_URL', WP_CONTENT_URL);
    define('MY_APP_WP_PLUGIN_URL', WP_PLUGIN_URL);
}

add_action('init', function () {
    $path = dirname(MY_APP_FILE) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'lang';
    load_plugin_textdomain('my-app', false, $path);
});

if (version_compare(PHP_VERSION, MY_APP_MIN_PHP_VERSION, '<=')) {
    add_action('admin_init', function (): void {
        deactivate_plugins(MY_APP_FILE);
    });

    add_action('admin_notices', function (): void {
        echo wp_kses_post(
            sprintf(
                '<div class="notice notice-error"><p>%s</p></div>',
                sprintf(
                    __('"%1$s" requires PHP %2$s or newer.', 'my-app'),
                    MY_APP_TITLE,
                    MY_APP_MIN_PHP_VERSION
                )
            )
        );
    });

    // Return early to prevent loading the plugin.
    return;
}


$libraries = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, '/app/vendor/autoload.php');
if (!file_exists($libraries)) {
    add_action('admin_init', function (): void {
        deactivate_plugins(MY_APP_FILE);
    });

    add_action('admin_notices', function (): void {
        echo wp_kses_post(
            sprintf(
                '<div class="notice notice-error"><p>%s</p></div>',
                __('Error locating autoloader. Please run <code>composer install</code>.', 'my-app')
            )
        );
    });

    // Return early to prevent loading the plugin.
    return;
}

$libraries = require_once $libraries;
require_once __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'helpers.php';

if (!wp_installing()) {
    register_activation_hook(__FILE__, [new \MyApp\Activation, 'activate']);
    register_deactivation_hook(__FILE__, [new \MyApp\Activation, 'deactivate']);

    add_action('plugins_loaded', function () use ($libraries): void {
        new \MyApp\Initialize($libraries);
    });
}
