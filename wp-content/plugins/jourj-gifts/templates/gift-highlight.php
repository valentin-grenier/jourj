<?php

# Get the featured gift from the "jourj_gift" post type
$gift = new WP_Query(array(
    'post_type'      => 'jourj_gift',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'meta_query'     => array(
        array(
            'key'     => '_jourj_is_highlighted',
            'value'   => '1',
            'compare' => '='
        )
    )
));

# Gift data
$gift_id = $gift->posts[0]->ID;
$title = get_the_title($gift_id);
$description = get_post_meta($gift_id, '_jourj_gift_description', true);
$image = get_the_post_thumbnail($gift_id, 'full');
$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($gift_id), 'full');
$image_url = $image_url[0]; // Get the URL of the image
$image_alt = get_post_meta(get_post_thumbnail_id($gift_id), '_wp_attachment_image_alt', true);
$price = number_format(intval(get_post_meta($gift_id, '_jourj_total_amount', true)), 0, '.', ' ');
$funded = intval(get_post_meta($gift_id, '_jourj_funded', true));
$funded_percentage = $funded === 0 ? 0 : ($funded / $price) * 100;
$funded_percentage = min($funded_percentage, 100); // Ensure it doesn't exceed 100%
$funded_percentage = number_format($funded_percentage, 0, '.', ''); // Format to 0 decimal places

# Icons
$icon_plane = plugins_url('assets/img/icon-airplane.png', __DIR__);
$icon_island = plugins_url('assets/img/icon-island.png', __DIR__);
?>

<div class="jo-block-gift-highlight">
    <div class="jo-block-gift-highlight__main">
        <div class="jo-block-gift-highlight__content">
            <h3><?php echo esc_html($title); ?></h3>

            <p class="jo-block-gift-highlight__content--description">
                <?php echo esc_html($description); ?>
            </p>

            <div class="jo-block-gift-highlight__content--price">
                <?php echo __('Nous estimons le montant du voyage à', 'jourj-gifts') . ' ' . esc_html($price) . '€.'; ?>
            </div>

            <button class="wp-block-button__link"><?php _e('Participer à notre voyage de noces', 'jourj-gifts'); ?></button>
        </div>

        <div class="jo-block-gift-highlight__overlay"></div>

        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="jo-block-gift-highlight__image" />
    </div>

    <div class="jo-block-gift-highlight__bottom">
        <div class="jo-block-gift-highlight__funded">
            <span>
                <?php echo "<strong>$funded_percentage% </strong>" . __("de l'objectif atteint", 'jourj-gifts') . ' 🎉'; ?>
            </span>
        </div>

        <div class="jo-block-gift-highlight__progress-bar">
            <div class="jo-block-gift-highlight__progress-bar--filled" style="width: <?php echo esc_html($funded_percentage); ?>%;">
                <div class="jo-block-gift-highlight__progress-bar--filled-icon">
                    <img src="<?php echo esc_url($icon_plane); ?>" alt="Plane Icon" />
                </div>
            </div>

            <div class="jo-block-gift-highlight__progress-bar--icon">
                <img src="<?php echo esc_url($icon_island); ?>" alt="Island Icon" />
            </div>
        </div>
    </div>
</div>