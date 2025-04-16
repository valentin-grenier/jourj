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
    }

    # Initialize plugin assets
    public function load_plugin_assets()
    {
        $plugin_root_path = plugin_dir_path(dirname(__FILE__));
        $plugin_root_url  = plugin_dir_url(dirname(__FILE__));

        # CSS
        wp_enqueue_style('jourj-gifts-styles', $plugin_root_url . 'assets/css/styles.css', array(), '1.0.0', 'all');

        # JS
        wp_enqueue_script('jourj-gifts-list', $plugin_root_url . 'assets/js/gifts-list.js', array(), '1.0.0', true);
        wp_localize_script('jourj-gifts-list', 'jourj_gift_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('jourj_gift_nonce'),
        ));
    }
}
