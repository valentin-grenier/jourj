<?php if (!empty($guest_messages)) : ?>
    <ul>
        <?php foreach (array_reverse($guest_messages) as $entry) : ?>
            <li>
                <strong>
                    <?php echo esc_html($entry['name'] ?? 'Anonyme'); ?>
                    <?php if (!empty($entry['email'])) : ?>
                        (<span><?php echo esc_html($entry['email']); ?></span>)
                    <?php endif; ?>
                </strong>
                <br>
                <?php echo esc_html($entry['message']); ?>
                <br><small><?php echo esc_html(date_i18n('j F Y à H:i', strtotime($entry['date']))); ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p><?php _e('No messages for this gift yet.', 'jourj-gifts'); ?></p>
<?php endif; ?>