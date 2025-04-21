<?php

/**
 * Partial: Metabox Fields for the "Gift Details"
 * Variables provided by the parent file (render_custom_fields_box()):
 *  - $total_amount
 *  - $custom_message
 *  - $reserved
 *  - $funded
 *  - $reserved_by
 *  - $is_featured
 */
?>

<div class="jourj-gifts-fields">
    <!-- Total Amount -->
    <p>
        <label for="jourj_total_amount"><?php esc_html_e('Total Amount:', 'jourj'); ?></label><br>
        <input
            type="number"
            step="0.01"
            name="jourj_total_amount"
            id="jourj_total_amount"
            value="<?php echo esc_attr($total_amount); ?>"
            style="width: 100%; max-width: 300px;"
            required>
    </p>

    <!-- Custom Message -->
    <p>
        <label for="jourj_custom_message"><?php esc_html_e('Custom Message:', 'jourj'); ?></label><br>
        <textarea
            name="jourj_custom_message"
            id="jourj_custom_message"
            rows="3"
            style="width: 100%; max-width: 500px;"><?php echo esc_textarea($custom_message); ?></textarea>
    </p>

    <!-- is_featured (checkbox) -->
    <p>
        <input
            type="checkbox"
            name="jourj_is_featured"
            id="jourj_is_featured"
            value="1"
            <?php checked($is_featured, 1); ?>>
        <label for="jourj_is_featured">
            <?php esc_html_e('Highlight this gift?', 'jourj'); ?>
        </label>
    </p>

    <!-- Separator -->
    <hr>

    <!-- Reserved (checkbox) -->
    <p>
        <input
            type="checkbox"
            name="jourj_reserved"
            id="jourj_reserved"
            value="1"
            <?php checked($reserved, 1); ?>>
        <label for="jourj_reserved"><?php esc_html_e('Reserved?', 'jourj'); ?></label>
    </p>

    <!-- Already Funded -->
    <p>
        <label for="jourj_funded"><?php esc_html_e('Already Funded Amount:', 'jourj'); ?></label><br>
        <input
            type="number"
            step="0.01"
            name="jourj_funded"
            id="jourj_funded"
            disabled
            value="<?php echo esc_attr($funded); ?>"
            style="width: 100%; max-width: 300px;">
    </p>

    <!-- Reserved By Email -->
    <p>
        <label for="jourj_reserved_by"><?php esc_html_e('Reserved By (Email):', 'jourj'); ?></label><br>
        <input
            type="email"
            name="jourj_reserved_by"
            id="jourj_reserved_by"
            value="<?php echo esc_attr($reserved_by); ?>"
            style="width: 100%; max-width: 300px;"
            disabled>
    </p>

    <!-- Cancellation Link -->
    <p>
        <label for="jourj_cancellation_link"><?php esc_html_e('Cancellation Link:', 'jourj'); ?></label><br>
        <input
            type="text"
            name="jourj_cancellation_link"
            id="jourj_cancellation_link"
            value="<?php echo esc_attr(get_post_meta($post->ID, '_jourj_cancellation_link', true)); ?>"
            style="width: 100%; max-width: 300px;"
            disabled>
    </p>

</div>