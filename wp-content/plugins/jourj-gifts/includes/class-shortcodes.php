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
        add_action('wp_footer', [$this, 'render_overlay'], 100);
    }

    # Render the gift list shortcode and the modal
    public function render_gift_list()
    {
        ob_start();
        include(JOURJ_GIFTS_DIR . 'templates/gift-highlight.php');
        include(JOURJ_GIFTS_DIR . 'templates/gifts-list.php');
        include(JOURJ_GIFTS_DIR . 'templates/gift-modal-payment.php');
        include(JOURJ_GIFTS_DIR . 'templates/gift-modal-reservation.php');
        include(JOURJ_GIFTS_DIR . 'templates/gift-custom-funding.php');
        return ob_get_clean();
    }

    # Render "Merci" page shortcode
    public function render_thank_you_page()
    {
        ob_start();
        include(JOURJ_GIFTS_DIR . 'templates/page-thank-you.php');
        return ob_get_clean();
    }

    # Render overlay in the footer
    public function render_overlay()
    {
        echo '<div class="jo-block-gift-modal__overlay"></div>';
    }
}
