<?php

/**
 * Class: Shortcodes
 * 
 * This class registers the shortcodes for displaying the gift list and form on the front end.
 */

class JourJ_Shortcodes
{
    public function __construct()
    {
        add_shortcode('jourj_gifts_list', [$this, 'render_gift_list']);
        add_shortcode('jourj_gifts_featured', [$this, 'render_gift_featured']);
    }

    # Render the gift list shortcode and the modal
    public function render_gift_list($atts)
    {
        ob_start();
        include(JOURJ_GIFTS_DIR . 'templates/gifts-list.php');
        include(JOURJ_GIFTS_DIR . 'templates/gift-modal.php');
        return ob_get_clean();
    }

    # Render the featured gift shortcode
    public function render_gift_featured($atts)
    {
        ob_start();
        include(JOURJ_GIFTS_DIR . 'templates/gifts-featured.php');
        return ob_get_clean();
    }
}
