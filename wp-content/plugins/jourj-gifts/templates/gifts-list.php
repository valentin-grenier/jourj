<?php

# Get gifts from "jourj_gift" post type, excluding the one with "custom-funding" slug
$gifts = new WP_Query(array(
    'post_type' => 'jourj_gift',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'post__not_in' => array(
        get_page_by_path('custom-funding', OBJECT, 'jourj_gift')->ID
    ),
    'meta_query' => [
        [
            'key'   => '_jourj_is_highlighted',
            'value' => '0',
            'compare' => '='
        ]
    ]
));

?>

<div class="jo-block-gifts-list">
    <?php if ($gifts->have_posts()): ?>
        <?php while ($gifts->have_posts()): $gifts->the_post(); ?>
            <?php
            # Check if the post is reserved
            $is_reserved = (bool) get_post_meta(get_the_ID(), '_jourj_reserved', true);
            ?>
            <div class="jo-block-gifts-list__item" data-gift-id="<?php echo get_the_ID(); ?>">
                <div class="jo-block-gifts-list__item--image">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium'); ?>

                        <?php if ($is_reserved): ?>
                            <span class="label-reserved"><?php _e('Réservé', 'jourj-gift'); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div class="jo-block-gifts-list__item--details">
                    <span class="price"><strong><?php echo get_post_meta(get_the_ID(), '_jourj_total_amount', true); ?>€</strong></span>
                    <span class="title"><?php echo get_the_title(); ?></span>
                </div>

                <?php if (!$is_reserved): ?>
                    <div class="jo-block-gifts-list__item--buttons">
                        <button class="wp-block-button__link"><?php _e('Participer', 'jourj-gifts'); ?></button>
                        <button class="wp-block-button__link secondary"><?php _e('Réserver', 'jourj-gifts'); ?></button>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p><?php _e('No gifts found.', 'jourj-gifts'); ?></p>
    <?php endif; ?>
</div>