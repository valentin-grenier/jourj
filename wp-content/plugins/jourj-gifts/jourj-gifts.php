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

# Initialize the plugin classes
require_once(JOURJ_GIFTS_DIR . 'includes/class-init.php');
require_once(JOURJ_GIFTS_DIR . 'includes/class-post-types.php');
require_once(JOURJ_GIFTS_DIR . 'includes/class-custom-fields.php');
require_once(JOURJ_GIFTS_DIR . 'includes/class-shortcodes.php');
require_once(JOURJ_GIFTS_DIR . 'includes/class-ajax.php');

# Initialize the plugin
function jourj_gifts_init()
{
    new JourJ_Init();
    new JourJ_Post_Types();
    new JourJ_Custom_Fields();
    new JourJ_Shortcodes();
    new Jourj_Gift_Ajax();
}

add_action('plugins_loaded', 'jourj_gifts_init');
