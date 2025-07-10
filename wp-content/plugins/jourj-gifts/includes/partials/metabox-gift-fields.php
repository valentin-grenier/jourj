<?php

/**
 * Partial: Metabox Fields for the "Gift Details"
 * Variables provided by the parent file (render_custom_fields_box()):
 *  - $total_amount
 *  - $gift_description
 *  - $funded
 *  - $is_featured
 */
?>

<div class="jourj-gifts-fields">
    <!-- Total Amount -->
    <p>
        <label for="jourj_total_amount"><?php esc_html_e('Montant total (€):', 'jourj'); ?></label><br>
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
        <label for="jourj_gift_description"><?php esc_html_e('Description du cadeau :', 'jourj'); ?></label><br>
        <textarea
            name="jourj_gift_description"
            id="jourj_gift_description"
            rows="3"
            style="width: 100%; max-width: 500px;"><?php echo esc_textarea($gift_description); ?></textarea>
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
            <?php esc_html_e('Cadeau mis en avant', 'jourj'); ?>
        </label>
    </p>

    <!-- Separator -->
    <hr>

    <!-- Already Funded -->
    <p>
        <label for="jourj_funded"><?php esc_html_e('Montant collecté :', 'jourj'); ?></label><br>
        <input
            type="number"
            step="0.01"
            name="jourj_funded"
            id="jourj_funded"
            value="<?php echo esc_attr($funded); ?>"
            style="width: 100%; max-width: 300px;">
    </p>
</div>