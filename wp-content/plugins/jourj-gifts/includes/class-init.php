<?php

/**
 * Class: Init
 * 
 * This class initializes the plugin by loading the necessary classes and registering the custom post type and fields.
 */


class JourJ_Init
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'load_plugin_assets']);
        add_action('admin_enqueue_scripts', [$this, 'load_plugin_admin_assets']);
        add_action('init', [$this, 'check_env_file']);
    }

    # Initialize plugin assets
    public function load_plugin_assets()
    {
        $plugin_root_url  = plugin_dir_url(dirname(__FILE__));

        # CSS
        wp_enqueue_style('jourj-gifts-styles', $plugin_root_url . 'assets/css/front-end.css', array(), '1.0.0', 'all');
    }

    # Load admin scripts
    public function load_plugin_admin_assets()
    {
        $plugin_root_url  = plugin_dir_url(dirname(__FILE__));

        # CSS
        wp_enqueue_style('jourj-gifts-admin-styles', $plugin_root_url . 'assets/css/admin.css', array(), '1.0.0', 'all');
    }

    # Check if .env and PAYPAL_EMAIL are set in root directory, else add an admin notice
    public function check_env_file()
    {
        if (!file_exists(ABSPATH . '.env')) {
            add_action('admin_notices', function () {
                echo '<div class="notice notice-error"><p>' . __('.env file not found in the root directory. Please create one with the required variables.', 'jourj-gifts') . '</p></div>';
            });
        } elseif (!isset($_ENV['PAYPAL_EMAIL'])) {
            add_action('admin_notices', function () {
                echo '<div class="notice notice-error"><p>' . __('PAYPAL_EMAIL is not set in the .env file. Please set it to your PayPal email address.', 'jourj-gifts') . '</p></div>';
            });
        }
    }
}
