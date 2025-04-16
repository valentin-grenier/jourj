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
        # Initialize AJAX actions
        add_action('wp_ajax_jourj_get_gift_data', [$this, 'handle_get_gift_data']);
        add_action('wp_ajax_nopriv_jourj_get_gift_data', [$this, 'handle_get_gift_data']);
    }

    # Main AJAX callback – validates input, calls get_gift_data(), sends JSON.
    public function handle_get_gift_data()
    {

        # Nonce check
        if (! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'jourj_gift_nonce')) {
            wp_send_json_error(__('Invalid request.', 'jourj-gifts'), 403);
        }

        # Get and sanitize the gift ID
        $gift_id = isset($_POST['gift_id']) ? intval($_POST['gift_id']) : 0;

        if (empty($gift_id) || ! is_numeric($gift_id)) {
            wp_send_json_error(__('Invalid gift ID.', 'jourj-gifts'), 400);
        }

        # Get gift data
        $gift_data = $this->get_gift_data($gift_id);
        if (is_wp_error($gift_data)) {
            wp_send_json_error($gift_data->get_error_message(), 404);
        }

        # Send JSON response
        wp_send_json_success($gift_data);
    }

    # Retrieves gift data based on the provided ID.
    public function get_gift_data($gift_id)
    {

        # Validate ID
        if (empty($gift_id) || ! is_numeric($gift_id)) {
            return new WP_Error('invalid_id', __('Invalid gift ID.', 'jourj-gifts'));
        }

        # Fetch the post
        $gift_post = get_post($gift_id);
        if (! $gift_post || 'jourj_gift' !== $gift_post->post_type) {
            return new WP_Error('not_found', __('Gift not found.', 'jourj-gifts'));
        }

        # Build the response array
        return array(
            'id'          => $gift_post->ID,
            'title'       => get_the_title($gift_post->ID),
            'image'       => get_the_post_thumbnail_url($gift_post->ID, 'medium'),
            'price'       => (float) get_post_meta($gift_post->ID, '_jourj_total_amount', true),
        );
    }
}
