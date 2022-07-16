<?php

/**
 * MyApp
 *
 * @package   MyApp
 * @author    MooToon <support@mootoons.com>
 * @license   GPL v2 or later
 * @link      https://github.com/mootoons/wp-react-typescript-plugin-standard
 */

namespace MyApp\Admin;

if (!defined('ABSPATH')) {
    exit;
}

class Menu
{
    public function onHooks(): void
    {
        add_action('admin_menu', [$this, 'adminMenu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue']);
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function adminMenu(): void
    {
        global $submenu;

        add_menu_page(
            __(MY_APP_TITLE, 'my-app'),
            __(MY_APP_TITLE, 'my-app'),
            'manage_options',
            MY_APP_SLUG,
            [$this, 'render'],
            'dashicons-buddicons-replies'
        );

        if (current_user_can('manage_options')) {
            $submenu[MY_APP_SLUG][] = [
                esc_attr__('Home', 'my-app'),
                'manage_options',
                'admin.php?page=' . MY_APP_SLUG . '#/'
            ];

            $submenu[MY_APP_SLUG][] = [
                esc_attr__('Hello', 'my-app'),
                'manage_options',
                'admin.php?page=' . MY_APP_SLUG . '#/hello'
            ];
        }
    }

    public function enqueue(string $hook): void
    {
        $page = 'toplevel_page_' . MY_APP_SLUG;
        if ($page != $hook) {
            return;
        }

        $fileAsset = MY_APP_PATH . DIRECTORY_SEPARATOR . 'dist' . DIRECTORY_SEPARATOR . 'scripts.asset.php';
        if (!file_exists($fileAsset)) {
            wp_die(__('file `dist/scripts.asset.php` not found.', 'my-app'));

            return;
        }

        $asset = require $fileAsset;
        if (!is_array($asset)) {
            return;
        }

        /**
         * Enqueue styles.
         */
        wp_enqueue_style(
            'my-app-style',
            MY_APP_URL . '/dist/scripts.css',
            [],
            $asset['version']
        );

        /**
         * Enqueue scripts
         */
        wp_enqueue_script(
            'my-app-script',
            MY_APP_URL . '/dist/scripts.js',
            $asset['dependencies'],
            $asset['version'],
            true
        );

        wp_localize_script(
            'my-app-script',
            'MyAppScript',
            apply_filters('my-app_localize_script', []),
            [
                'admin' => [
                    'url' => esc_url(admin_url())
                ],
                'rest' => [
                    'url' => esc_url(rest_url()),
                    'nonce' => wp_create_nonce('wp_rest')
                ]
            ]
        );
    }

    public function render(): void
    {
        printf(
            '
        <div class="wrap">
            <div id="my-app-app">%s</div>
        </div>',
            __('Loading....', 'my-app')
        );
    }
}
