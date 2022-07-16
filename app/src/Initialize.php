<?php

/**
 * MooToonStarter
 *
 * @package   MooToonStarter
 * @author    MooToon <support@mootoons.com>
 * @license   GPL v2 or later
 * @link      https://github.com/mootoons/wp-react-typescript-plugin-standard
 */

namespace MyApp;

if (!defined('ABSPATH')) {
    exit;
}

final class Initialize
{
    /**
     * List of class to initialize.
     *
     * @var array
     */
    public $classes = [];

    /**
     * Composer autoload file list.
     *
     * @var \Composer\Autoload\ClassLoader
     */
    private $composer;

    /**
     * The Constructor that load the entry classes
     *
     * @param \Composer\Autoload\ClassLoader $composer Composer autoload output.
     * @since 1.0.0
     */
    public function __construct(\Composer\Autoload\ClassLoader $composer)
    {
        $this->composer = $composer;

        $this->getClasses();
        $this->loadClasses();
    }

    /**
     * Initialize all the classes.
     *
     * @since 1.0.0
     * @SuppressWarnings("MissingImport")
     * @return void
     */
    private function loadClasses(): void
    {
        $this->classes = apply_filters('my-app_classes_to_execute', $this->classes);

        foreach ($this->classes as $class) {
            try {
                $temp = new $class;

                if (method_exists($temp, 'onHooks')) {
                    $temp->onHooks();
                }
            } catch (\Throwable $err) {
                do_action('my-app_on_hooks_failed', $err);

                if (WP_DEBUG) {
                    throw new \Exception($err->getMessage());
                }
            }
        }
    }

    private function getClasses(): void
    {
        $classmap  = $this->composer->getClassMap();
        $namespace = 'MyApp\\';

        $exclude = $namespace . 'Initialize';

        // In case composer has autoload optimized
        if (isset($classmap[$exclude])) {
            $classes = array_keys($classmap);

            foreach ($classes as $class) {
                if ($class === $exclude) {
                    continue;
                }

                if (0 !== strncmp((string) $class, $namespace, strlen($namespace))) {
                    continue;
                }

                $this->classes[] = $class;
            }
        } else {
            wp_die(
                \sprintf(esc_html__('class `%s` not found.', 'my-app'), $exclude)
            );
        }
    }
}
