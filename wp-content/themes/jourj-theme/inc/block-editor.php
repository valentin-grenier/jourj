<?php

# Block editor assets
function jourj_block_editor_assets()
{
    # CSS
    wp_enqueue_style('jourj-block-editor-main', get_template_directory_uri() . '/assets/css/editor-styles.css', array(), '1.0.0', 'all');

    # JS
    wp_enqueue_script(
        "jourj-scripts-unregister-style-variations",
        get_template_directory_uri() . "/assets/js/block-editor/unregister-style-variations.js",
        ["wp-blocks", "wp-dom-ready", "wp-edit-post"],
        "1.0",
        true
    );
}
add_action('enqueue_block_assets', 'jourj_block_editor_assets');


# BLock editor configuration
function jourj_block_editor_config()
{
    # Remove pattern directory et blocks suggestions
    remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');
    remove_theme_support("core-block-patterns");

    # Disable CSS for some blocks
    wp_dequeue_style("wp-block-navigation");
}
add_action('after_setup_theme', 'jourj_block_editor_config');
