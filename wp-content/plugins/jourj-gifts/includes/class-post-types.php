<?php

/**
 * Class: Post Types
 * 
 * This class registers the custom post type "gift" and its associated meta fields.
 */

class JourJ_Post_Types
{
    public function __construct()
    {
        add_action('init', [$this, 'register_cpt']);
        add_filter('use_block_editor_for_post_type', [$this, 'disable_block_editor'], 10, 2);
    }

    # Define the custom post type "gift"
    public function register_cpt()
    {
        $labels = [
            'name'               => __('Gifts', 'jourj'),
            'singular_name'      => __('Gift', 'jourj'),
            'add_new'            => __('Add New Gift', 'jourj'),
            'add_new_item'       => __('Add New Gift', 'jourj'),
            'edit_item'          => __('Edit Gift', 'jourj'),
            'new_item'           => __('New Gift', 'jourj'),
            'all_items'          => __('All Gifts', 'jourj'),
            'view_item'          => __('View Gift', 'jourj'),
            'search_items'       => __('Search Gifts', 'jourj'),
            'not_found'          => __('No gifts found', 'jourj'),
            'not_found_in_trash' => __('No gifts found in Trash', 'jourj'),
            'menu_name'          => __('Gifts', 'jourj'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'rewrite'            => ['slug' => 'gifts'],
            'supports'           => ['title', 'thumbnail'],        # Title, Description, Featured Image
            'menu_icon'          => 'dashicons-editor-ul',      # Optional dashicon
            'show_in_rest'       => true,                       # Enable block editor support
            'menu_position'     => 10,                          # Position in the admin menu
        ];

        register_post_type('jourj_gift', $args);
    }

    # Disable block editor for this post type
    public function disable_block_editor($use_block_editor, $post_type)
    {
        if ($post_type === 'jourj_gift') {
            return false;
        }
        return $use_block_editor;
    }
}
