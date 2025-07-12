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
        add_shortcode('jourj_gifts_thank_you', [$this, 'render_thank_you_page']);
        add_shortcode('jourj_gifts_cancel', [$this, 'render_cancel_page']);
    }

    # Render the gift list shortcode and the modal
    public function render_gift_list()
    {
        ob_start();
        include(JOURJ_GIFTS_DIR . 'templates/gift-highlight.php');
        include(JOURJ_GIFTS_DIR . 'templates/gifts-list.php');
        include(JOURJ_GIFTS_DIR . 'templates/gift-custom-funding.php');
        return ob_get_clean();
    }
}
