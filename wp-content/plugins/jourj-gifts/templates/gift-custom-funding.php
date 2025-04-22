<?php
# Get "custom-funding" gift ID by the slug
$custom_gift_id = get_page_by_path('custom-funding', OBJECT, 'jourj_gift')->ID;
?>

<div class="jo-block-gift-custom-funding">
    <p><strong>
            <?php _e('Vous ne trouvez pas votre bonheur dans la liste ?', 'jourj-gifts'); ?>
        </strong>
    </p>

    <p>
        <?php _e('Vous pouvez aussi contribuer librement à notre cagnotte, avec le montant de votre choix. Chaque participation, petite ou grande, est précieuse.', 'jourj-gifts'); ?>
    </p>

    <button class="jo-block-gift-custom-funding__button">
        <?php _e('Faire un don', 'jourj-gifts'); ?>
    </button>

    <form class="jo-block-gift-custom-funding__form hidden">

        <div class="jo-block-gift-custom-funding__form--inputs">
            <div class="jo-block-gift-custom-funding__form--input">
                <label for="guest-name"><?php _e('Votre prénom et nom', 'jourj-gifts'); ?> :</label>
                <input type="text" name="guest-name" id="guest-name" placeholder="<?php _e('ex : John Doe', 'jourj-gifts'); ?>" required>
            </div>

            <div class="jo-block-gift-custom-funding__form--input number">
                <label for="funding-amount"><?php _e('Montant', 'jourj-gifts'); ?> :</label>
                <input type="number" name="funding-amount" id="funding-amount" min="0" step="0.01" placeholder="0" required>
            </div>

            <div class="jo-block-gift-custom-funding__form--input">
                <label for="guest-message"><?php _e('Laissez un message avec votre don (facultatif)', 'jourj-gifts'); ?> :</label>
                <textarea name="guest-message" id="guest-message" rows="4" placeholder="<?php _e('Glissez ici votre petit mot ...', 'jourj-gifts'); ?>"></textarea>
            </div>
        </div>

        <input type="hidden" name="gift-id" id="gift-id" value="<?php echo esc_attr($custom_gift_id); ?>">

        <input type="submit" value="<?php _e('Participer', 'jourj-gifts'); ?>">
    </form>
</div>