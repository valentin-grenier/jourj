<?php

/**
 * Class: Custom Fields
 * 
 * This class registers the custom fields for the "gift" post type using ACF (Advanced Custom Fields).
 */

class JourJ_Custom_Fields
{
    public function __construct()
    {
        # Register the meta box
        add_action('add_meta_boxes', [$this, 'add_custom_fields_box']);

        # Save meta box data
        add_action('save_post_jourj_gift', [$this, 'save_custom_fields']);
    }

    # Create the meta box
    public function add_custom_fields_box()
    {
        add_meta_box(
            'jourj_gift_details',                           # Unique ID for the meta box
            __('Gift Details', 'jourj-gifts'),              # Box title 
            array($this, 'render_custom_fields_box'),       # Content callback
            'jourj_gift',                                   # Post type
            'normal',                                       # Context (normal, side, advanced)
            'high'                                          # Priority (high, default, low)
        );
    }

    # Render the meta box fields
    public function render_custom_fields_box($post)
    {
        # Security nonce
        wp_nonce_field('jourj_gift_nonce', 'jourj_gift_nonce_field');

        # Get current meta values
        $total_amount   = get_post_meta($post->ID, '_jourj_total_amount', true);
        $custom_message = get_post_meta($post->ID, '_jourj_custom_message', true);
        $reserved       = get_post_meta($post->ID, '_jourj_reserved', true);
        $funded         = get_post_meta($post->ID, '_jourj_funded', true);
        $reserved_by    = get_post_meta($post->ID, '_jourj_reserved_by', true);
        $is_featured    = get_post_meta($post->ID, '_jourj_is_featured', true);
        $cancellation_link = get_post_meta($post->ID, '_jourj_cancellation_link', true);

        # Default or cast
        $total_amount   = $total_amount ?: '';
        $custom_message = $custom_message ?: '';
        $reserved       = (int) $reserved;
        $funded         = (float) $funded;
        $reserved_by    = $reserved_by ?: '';
        $is_featured    = (int) $is_featured;
        $cancellation_link = $cancellation_link ?: '';

        require plugin_dir_path(__FILE__) . 'partials/metabox-gift-fields.php';
    }

    # Save the meta box data
    public function save_custom_fields($post_id)
    {
        # Check for nonce
        if (
            !isset($_POST['jourj_gift_nonce_field']) ||
            !wp_verify_nonce($_POST['jourj_gift_nonce_field'], 'jourj_gift_nonce')
        ) {
            return $post_id;
        }

        # Check for autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        # Check user capabilities
        if (isset($_POST['post_type']) && 'jourj_gift' === $_POST['post_type']) {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }

        # Sanitize and save the fields
        $fields = [
            '_jourj_total_amount' => filter_input(INPUT_POST, 'jourj_total_amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            '_jourj_custom_message' => sanitize_textarea_field($_POST['jourj_custom_message'] ?? ''),
            '_jourj_reserved' => !empty($_POST['jourj_reserved']) ? 1 : 0,
            '_jourj_funded' => filter_input(INPUT_POST, 'jourj_funded', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            '_jourj_reserved_by' => sanitize_email($_POST['jourj_reserved_by'] ?? ''),
            '_jourj_is_featured' => !empty($_POST['jourj_is_featured']) ? 1 : 0,
            '_jourj_cancellation_link' => sanitize_url($_POST['jourj_cancellation_link'] ?? ''),
        ];

        foreach ($fields as $meta_key => $value) {
            update_post_meta($post_id, $meta_key, $value);
        }
    }
}
