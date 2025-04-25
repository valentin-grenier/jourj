<?php

/**
 * Class: Pages
 * 
 * Generate plugin pages on plugin activation.
 */

class JourJ_Pages
{
    public function __construct()
    {
        add_action('init', [$this, 'create_pages']);
    }

    # Create the plugin pages
    public function create_pages()
    {
        $pages = [
            'merci' => [
                'title' => __('Merci pour votre participation', 'jourj-gifts'),
                'content' => '[jourj_gifts_thank_you]',
            ],
            'annulation-reservation' => [
                'title' => __('Annulation de la réservation', 'jourj-gifts'),
                'content' => '[jourj_gifts_cancel]',
            ],
        ];

        foreach ($pages as $slug => $page) {
            if (!get_page_by_path($slug)) {
                wp_insert_post([
                    'post_title'   => $page['title'],
                    'post_content' => $page['content'],
                    'post_status'  => 'publish',
                    'post_type'    => 'page',
                    'post_name'    => $slug,
                ]);
            }
        }
    }
}
