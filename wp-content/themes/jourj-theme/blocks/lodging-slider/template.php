<?php
# Logding posts
$lodgings = get_posts([
    'post_type' => 'lodging',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
]);

# Icons
$icon_location = file_get_contents(get_template_directory() . '/assets/img/icon-pin.svg');
$icon_car = file_get_contents(get_template_directory() . '/assets/img/icon-car.svg');
$icon_chevron = file_get_contents(get_template_directory() . '/assets/img/icon-chevron.svg');

?>

<?php if ($lodgings): ?>
    <div class="jo-block-lodging-slider swiper">
        <div class="swiper-wrapper">
            <?php foreach ($lodgings as $lodging): ?>
                <div class="jo-block-lodging-slider__item swiper-slide">
                    <div class="jo-block-lodging-slider__item--image">
                        <img src="<?php echo get_the_post_thumbnail_url($lodging->ID); ?>" alt="<?php echo get_the_title($lodging->ID); ?>" />
                    </div>

                    <div class="jo-block-lodging-slider__item--content">
                        <h3><?php echo get_the_title($lodging->ID); ?></h3>

                        <div class="jo-block-lodging-slider__item--info">
                            <?php echo $icon_location; ?>
                            <a href="<?php echo get_field('jo_lodging_address_link', $lodging->ID); ?>" target="_blank" rel="noopener noreferrer">
                                <?php echo get_field('jo_lodging_address', $lodging->ID); ?>
                            </a>
                        </div>

                        <div class="jo-block-lodging-slider__item--info">
                            <?php echo $icon_car; ?>
                            <span><?php echo get_field('jo_lodging_distance', $lodging->ID); ?></span>
                        </div>

                        <div class="wp-block-button">
                            <a class="wp-block-button__link" href="<?php echo get_field('jo_lodging_link', $lodging->ID); ?>" target="_blank" rel="noopener noreferrer">
                                <?php _e("Voir sur Booking", "jourj"); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"><?php echo $icon_chevron; ?></div>
        <div class="swiper-button-prev"><?php echo $icon_chevron; ?></div>
    </div>
<?php endif; ?>