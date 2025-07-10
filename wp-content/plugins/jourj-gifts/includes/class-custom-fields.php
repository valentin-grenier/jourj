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
        # Register meta boxes
        add_action('add_meta_boxes', [$this, 'gift_details_meta_box']);
        add_action('add_meta_boxes', [$this, 'guests_messages_meta_box']);

        # Save meta box data
        add_action('save_post_jourj_gift', [$this, 'save_gift_custom_fields']);
    }

    # Create details meta box
    public function gift_details_meta_box()
    {
        global $post;

        # Don't add the meta box if the post is "custom-funding"
        if ($post && $post->post_name === 'custom-funding') {
            return;
        }

        # Add the meta box for the "gift" post type
        add_meta_box(
            'jourj_gift_details',                           # Unique ID for the meta box
            __('Détails du cadeau', 'jourj-gifts'),              # Box title 
            array($this, 'render_gift_custom_fields_box'),  # Content callback
            'jourj_gift',                                   # Post type
            'normal',                                       # Context (normal, side, advanced)
            'high'                                          # Priority (high, default, low)
        );
    }

    # Guest messages meta box
    public function guests_messages_meta_box()
    {
        add_meta_box(
            'jourj_guest_messages',                         # Unique ID for the meta box
            __('Mots des invités', 'jourj-gifts'),            # Box title 
            array($this, 'render_guest_messages_box'),      # Content callback
            'jourj_gift',                                   # Post type
            'normal',                                       # Context (normal, side, advanced)
            'default'                                       # Priority (high, default, low)
        );
    }

    # Render the meta box fields
    public function render_gift_custom_fields_box($post)
    {
        # Security nonce
        wp_nonce_field('jourj_gift_nonce', 'jourj_gift_nonce_field');

        # Get current meta values
        $total_amount = get_post_meta($post->ID, '_jourj_total_amount', true);
        $gift_description = get_post_meta($post->ID, '_jourj_gift_description', true);
        $funded = get_post_meta($post->ID, '_jourj_funded', true);
        $is_featured = get_post_meta($post->ID, '_jourj_is_highlighted', true);

        # Default or cast
        $total_amount = $total_amount ?: '';
        $gift_description = $gift_description ?: '';
        $funded = (float) $funded;
        $is_featured = (int) $is_featured;

        require plugin_dir_path(__FILE__) . 'partials/metabox-gift-fields.php';
    }

    # Save the meta box data
    public function save_gift_custom_fields($post_id)
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
            '_jourj_gift_description' => sanitize_textarea_field($_POST['jourj_gift_description'] ?? ''),
            '_jourj_funded' => filter_input(INPUT_POST, 'jourj_funded', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            '_jourj_is_highlighted' => !empty($_POST['jourj_is_featured']) ? 1 : 0,
        ];

        foreach ($fields as $meta_key => $value) {
            update_post_meta($post_id, $meta_key, $value);
        }
    }

    # Render the guest messages box
    public function render_guest_messages_box($post)
    {
        # Security nonce
        wp_nonce_field('jourj_guest_messages_nonce', 'jourj_guest_messages_nonce_field');

        # Get current meta values
        $guest_messages = get_post_meta($post->ID, '_jourj_guest_messages', true);
        $guest_messages = $guest_messages ?: [];

        require plugin_dir_path(__FILE__) . 'partials/metabox-guests-messages.php';
    }
}
