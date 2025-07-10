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
            'name'               => __('Cadeaux', 'jourj'),
            'singular_name'      => __('Cadeau', 'jourj'),
            'add_new'            => __('Ajouter un nouveau cadeau', 'jourj'),
            'add_new_item'       => __('Ajouter un nouveau cadeau', 'jourj'),
            'edit_item'          => __('Modifier le cadeau', 'jourj'),
            'new_item'           => __('Nouveau cadeau', 'jourj'),
            'all_items'          => __('Tous les cadeaux', 'jourj'),
            'view_item'          => __('Voir le cadeau', 'jourj'),
            'search_items'       => __('Rechercher des cadeaux', 'jourj'),
            'not_found'          => __('Aucun cadeau trouvé', 'jourj'),
            'not_found_in_trash' => __('Aucun cadeau trouvé dans la corbeille', 'jourj'),
            'menu_name'          => __('Cadeaux', 'jourj'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'rewrite'            => ['slug' => 'gifts'],
            'supports'           => ['title', 'thumbnail'],     # Title, Description, Featured Image
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
