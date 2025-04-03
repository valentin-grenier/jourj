<?php
# Icons
$icon_calendar = file_get_contents(get_template_directory() . '/assets/img/icon-calendar.svg');
$icon_pin = file_get_contents(get_template_directory() . '/assets/img/icon-pin.svg');

# Block fields
$title = get_field('jo_event_title') ?: "";
$event_date = get_field('jo_event_date') ?: "";
$event_location = get_field('jo_event_location') ?: null;
$color = get_field('jo_event_color') ?: "";
$direction = get_field('jo_event_direction') ?: "";

# Class names
$classes = "";
$classes .= $color ? "color-{$color}" : "";
$classes .= $direction ? " direction-{$direction}" : "";

?>

<div class="jo-block-card-event <?php echo esc_attr($classes); ?>">
    <div class="jo-block-card-event__container">
        <h3><?php echo esc_html($title); ?></h3>

        <div class="jo-block-card-event__item">
            <?php echo $icon_calendar; ?>
            <span><?php echo esc_html($event_date); ?></span>
        </div>

        <?php if ($event_location['location_name']): ?>
            <div class="jo-block-card-event__item">
                <?php echo $icon_pin; ?>

                <a href="<?php echo esc_attr($event_location['location_link']); ?>" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html($event_location['location_name']); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>