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
