<?php

# Register ACF blocks
function jourj_acf_register_blocks()
{
    $block_json_files = glob(get_template_directory() . '/blocks/*/block.json');

    foreach ($block_json_files as $block_json_file) {
        register_block_type($block_json_file);
    };
}
add_action('init', 'jourj_acf_register_blocks');

# Set featured image for "lodging" post type on save with lodging link
add_action('save_post_lodging', 'jourj_set_featured_image_from_booking', 20, 3);

function jourj_set_featured_image_from_booking($post_id, $post, $update)
{
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }

    # Don't overwrite if featured image already exists
    if (has_post_thumbnail($post_id)) {
        return;
    }

    # Get the booking.com URL from an ACF field (change field name as needed)
    $booking_url = get_field('jo_lodging_link', $post_id);
    if (!$booking_url) return;

    # Fetch the HTML of the Booking.com page
    $response = wp_remote_get($booking_url);
    if (is_wp_error($response)) return;

    $body = wp_remote_retrieve_body($response);

    $regex = preg_match('/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\']/', $body, $matches) ||
        preg_match('/<meta[^>]+name=["\']og:image["\'][^>]+content=["\']([^"\']+)["\']/', $body, $matches);


    # Extract the image from <meta name="twitter:image" content="...">
    if ($regex) {
        $image_url = $matches[1];

        # Download and attach image
        $attachment_id = jourj_attach_external_image($image_url, $post_id);
        if ($attachment_id) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }
}
