<?php

/**
 * Class: Jourj_Gift_Ajax
 * 
 * Handles AJAX requests for the Jourj Gifts plugin.
 */

class Jourj_Gift_Ajax
{
    public function __construct()
    {
        add_action('wp_ajax_jourj_get_gift_data', [$this, 'handle_get_gift_data']);
        add_action('wp_ajax_nopriv_jourj_get_gift_data', [$this, 'handle_get_gift_data']);

        add_action('wp_ajax_jourj_reserve_gift', [$this, 'handle_reserve_gift']);
        add_action('wp_ajax_nopriv_jourj_reserve_gift', [$this, 'handle_reserve_gift']);
    }

    # Handle AJAX request to get gift data
    public function handle_get_gift_data()
    {
        if (! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'jourj_gift_nonce')) {
            wp_send_json_error(__('Invalid request.', 'jourj-gifts'), 403);
        }

        $gift_id = isset($_POST['gift_id']) ? intval($_POST['gift_id']) : 0;
        $mode    = sanitize_text_field($_POST['mode'] ?? 'payment');

        if (empty($gift_id) || ! is_numeric($gift_id)) {
            wp_send_json_error(__('Invalid gift ID.', 'jourj-gifts'), 400);
        }

        $gift_data = $this->get_gift_data($gift_id, $mode);
        if (is_wp_error($gift_data)) {
            wp_send_json_error($gift_data->get_error_message(), 404);
        }

        wp_send_json_success($gift_data);
    }


    # Get gift data by ID
    public function get_gift_data($gift_id, $mode = 'payment')
    {
        # Check if the gift ID is valid and if the post type is correct
        if (empty($gift_id) || ! is_numeric($gift_id)) {
            return new WP_Error('invalid_id', __('Invalid gift ID.', 'jourj-gifts'));
        }

        # Check if the post type is correct
        $gift_post = get_post($gift_id);
        if (! $gift_post || 'jourj_gift' !== $gift_post->post_type) {
            return new WP_Error('not_found', __('Gift not found.', 'jourj-gifts'));
        }

        # Initialize the data array
        $data = [
            'id'     => $gift_post->ID,
            'title'  => get_the_title($gift_post->ID),
            'image'  => get_the_post_thumbnail_url($gift_post->ID, 'medium'),
        ];

        # Fill the data array with the necessary information based on the mode
        if ($mode === 'payment') {
            $data['price']  = (float) get_post_meta($gift_post->ID, '_jourj_total_amount', true);
            $data['funded'] = (float) get_post_meta($gift_post->ID, '_jourj_funded', true);
        } elseif ($mode === 'reservation') {
            $data['price']     = (float) get_post_meta($gift_post->ID, '_jourj_total_amount', true);
            $data['reserved']    = (bool) get_post_meta($gift_post->ID, '_jourj_reserved', true);
            $data['reserved_by'] = sanitize_text_field(get_post_meta($gift_post->ID, '_jourj_reserved_by', true));
        }

        return $data;
    }

    # AJAX handler for reserving a gift
    public function handle_reserve_gift()
    {
        # Check if the request is valid
        if (! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'jourj_gift_nonce')) {
            wp_send_json_error(__('Invalid request.', 'jourj-gifts'), 403);
        }

        # Check the provided gift id
        $gift_id = isset($_POST['gift_id']) ? strval($_POST['gift_id']) : 0;
        $reserved_by = sanitize_text_field($_POST['reserved_by'] ?? '');

        if (! $gift_id || get_post_type($gift_id) !== 'jourj_gift') {
            wp_send_json_error(__('Invalid gift ID.', 'jourj-gifts'), 400);
        }

        # Check if the gift is already reserved
        if (get_post_meta($gift_id, '_jourj_reserved', true)) {
            wp_send_json_error(__('Ce cadeau est déjà réservé.', 'jourj-gifts'), 409);
        }

        # Else, update the gift post meta to reserve it and send a success response
        update_post_meta($gift_id, '_jourj_reserved', 1);
        update_post_meta($gift_id, '_jourj_reserved_by', $reserved_by);

        # Generate a token for cancellation link and store it in the post meta
        $token = bin2hex(random_bytes(16));
        $cancellation_link = add_query_arg(
            [
                'action' => 'jourj_cancel_gift',
                'token'  => $token,
                'gift_id' => $gift_id,
            ],
            home_url('/')
        );

        update_post_meta($gift_id, '_jourj_cancellation_link', $cancellation_link);

        # Send the cancellation email to the user
        $user_email = sanitize_email($_POST['reserved_by']) ?? '';

        if (!empty($user_email)) {
            $this->send_cancellation_email($gift_id, $user_email);
        }

        # Send the success response
        wp_send_json_success(['message' => 'Cadeau réservé avec succès']);
    }

    # Send an email to the user with the cancellation link
    public function send_cancellation_email($gift_id, $user_email)
    {
        # Create the email content
        $subject = __('Confirmation de réservation - Mariage Rébecca et Aurélien', 'jourj-gifts');

        ob_start();
        include plugin_dir_path(__FILE__) . './partials/email-template.php';
        $message = ob_get_clean();

        # Set the email headers to send HTML email
        $headers = ['Content-Type: text/html; charset=UTF-8'];

        wp_mail($user_email, $subject, $message, $headers);
    }
}
