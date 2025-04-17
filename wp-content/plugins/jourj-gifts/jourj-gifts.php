<?php

/**
 * Plugin Name: JourJ Gifts
 * Description: A plugin that registers a "gift" custom post type and associated meta fields for wedding gifts.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

# Plugin Directory
if (!defined('JOURJ_GIFTS_DIR')) {
    define('JOURJ_GIFTS_DIR', plugin_dir_path(__FILE__));
}

# Plugin URL
if (!defined('JOURJ_GIFTS_URL')) {
    define('JOURJ_GIFTS_URL', plugin_dir_url(__FILE__));
}

# Automatically require all PHP files in the includes directory
foreach (glob(JOURJ_GIFTS_DIR . 'includes/*.php') as $file) {
    require_once($file);
}

# Initialize the plugin
function jourj_gifts_init()
{
    new JourJ_Init();
    new JourJ_Post_Types();
    new JourJ_Custom_Fields();
    new JourJ_Shortcodes();
    new Jourj_Gift_Ajax();
    new JourJ_IPN_Handler();
}

add_action('plugins_loaded', 'jourj_gifts_init');
