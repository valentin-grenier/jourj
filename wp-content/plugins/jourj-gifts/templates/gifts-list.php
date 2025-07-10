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

$gift_payment_url_paypal = isset($_ENV['PAYPAL_URL']) ? $_ENV['PAYPAL_URL'] : null;

?>

<div class="jo-block-gifts-list">
    <?php if ($gifts->have_posts()): ?>
        <?php while ($gifts->have_posts()): $gifts->the_post(); ?>
            <div class="jo-block-gifts-list__item" data-gift-id="<?php echo get_the_ID(); ?>">
                <div class="jo-block-gifts-list__item--image">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium'); ?>
                    <?php endif; ?>
                </div>

                <div class="jo-block-gifts-list__item--details">
                    <span class="price"><strong><?php echo get_post_meta(get_the_ID(), '_jourj_total_amount', true); ?>€</strong></span>
                    <span class="title"><?php echo get_the_title(); ?></span>
                </div>

                <?php if (!empty($gift_payment_url_paypal)): ?>
                    <div class="jo-block-gifts-list__item--buttons">
                        <a
                            class="wp-block-button__link"
                            href="<?php echo esc_url($gift_payment_url_paypal); ?>"
                            target="_blank" rel="noopener noreferrer">
                            <?php _e('Participer', 'jourj-gifts'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p><?php _e('Les cadeaux ne sont pas encore disponibles. Patience ...', 'jourj-gifts'); ?></p>
    <?php endif; ?>
</div>