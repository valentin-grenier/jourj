<?php

# Download external image
function jourj_attach_external_image($image_url, $post_id)
{
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $tmp = download_url($image_url);
    if (is_wp_error($tmp)) return false;

    $file_array = [
        'name'     => basename(parse_url($image_url, PHP_URL_PATH)),
        'tmp_name' => $tmp
    ];

    $attachment_id = media_handle_sideload($file_array, $post_id);
    return is_wp_error($attachment_id) ? false : $attachment_id;
}
