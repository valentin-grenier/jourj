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

    # Render "Annulation de la réservation" page shortcode
    public function render_cancel_page()
    {
        ob_start();
        include(JOURJ_GIFTS_DIR . 'templates/page-cancel-reservation.php');
        return ob_get_clean();
    }

    public function handle_reservation_cancellation($token, $gift_id)
    {
        if (empty($token) || empty($gift_id)) {
            return false;
        }

        # Check if the token is valid and matches the gift ID
        $cancellation_link = get_post_meta($gift_id, '_jourj_cancellation_link', true);

        if (!$cancellation_link) {
            return false;
        }

        # Gather infos for the email
        $guest_email = get_post_meta($gift_id, '_jourj_reserved_by_email', true);
        $guest_name = get_post_meta($gift_id, '_jourj_reserved_by_name', true);

        # Send cancellation email to the user
        $email_handler_user = new JourJ_Emails_Users();
        $email_handler_user->send_reservation_cancellation_email($guest_email, $gift_id, $guest_name);

        # Send cancellation email to the admins
        $admin_email = isset($_ENV['PAYPAL_EMAIL']) ? $_ENV['PAYPAL_EMAIL'] : get_option('admin_email');
        $email_handler_admin = new JourJ_Emails_Admins();
        $email_handler_admin->send_reservation_cancellation_email($admin_email, $cancellation_link, $gift_id, $guest_name);

        # Delete reservation data
        update_post_meta($gift_id, '_jourj_reserved', 0);
        delete_post_meta($gift_id, '_jourj_reserved_by_name');
        delete_post_meta($gift_id, '_jourj_reserved_by_email');
        delete_post_meta($gift_id, '_jourj_cancellation_link');

        return true;
    }

    # Render overlay in the footer
    public function render_overlay()
    {
        echo '<div class="jo-block-gift-modal__overlay"></div>';
    }
}
