<?php

# Theme assets
function jourj_theme_assets()
{
    # CSS
    wp_enqueue_style('jourj-styles-stylesheet', get_template_directory_uri() . '/style.css', array(), '1.0.0', 'all');
    wp_enqueue_style('jourj-styles-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0', 'all');

    # JS
    wp_enqueue_script('jourj-scripts-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'jourj_theme_assets');

# Autoload vendor files
function jourj_theme_autoload_vendor_files()
{
    $vendor_dir = get_template_directory() . '/vendor/autoload.php';

    if (file_exists($vendor_dir)) {
        require_once $vendor_dir;
    }
}
add_action('after_setup_theme', 'jourj_theme_autoload_vendor_files');
