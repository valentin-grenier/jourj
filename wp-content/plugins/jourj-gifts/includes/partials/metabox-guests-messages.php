<?php if (!empty($guest_messages)) : ?>
    <ul>
        <?php foreach (array_reverse($guest_messages) as $entry) : ?>
            <?php $date = new DateTime($entry['date']);
            $date->setTimezone(wp_timezone());  ?>

            <li>
                <strong>
                    <?php echo esc_html($entry['name'] ?? 'Anonyme'); ?>
                    <?php if (!empty($entry['email'])) : ?>
                        (<span><?php echo esc_html($entry['email']); ?></span>)
                    <?php endif; ?>
                </strong>
                <br>
                <?php echo esc_html($entry['message']);
                ?>
                <br><small><?php echo esc_html($date->format('d F Y à H:i')); ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p><?php _e('Pas encore de messages pour ce cadeau.', 'jourj-gifts'); ?></p>
<?php endif; ?>