<?php
$icon_cross = JOURJ_GIFTS_URL . 'assets/img/icon-cross.svg';
?>

<div class="jo-block-gift-modal payment">
    <div class="jo-block-gift-modal__container">
        <img class="jo-block-gift-modal__image gift-image" src="" alt="" />

        <div class="jo-block-gift-modal__details">
            <h2 class="jo-block-gift-modal__details--title">
                <?php _e('Participer au cadeau : ', 'jourj-gifts'); ?>
                <span class="gift-name"></span>
            </h2>

            <div class="jo-block-gift-modal__details--price">
                <?php _e('Montant : ', 'jourj-gifts'); ?>
                <span class="gift-price"></span>
            </div>

            <div class="jo-block-gift-modal__details--amounts">
                <button class="wp-block-button__link defined-amount">€</button>
                <button class="wp-block-button__link defined-amount">€</button>
                <button class="wp-block-button__link defined-amount">€</button>
                <button class="wp-block-button__link defined-amount">€</button>
                <button class="wp-block-button__link custom-amount"><?php _e('Montant libre', 'jourj-gifts'); ?></button>
            </div>

            <div class="jo-block-gift-modal__details--custom-amount">
                <label for="custom-amount"><?php _e('Montant libre', 'jourj-gifts'); ?> :</label>
                <input type="number" name="custom-amount" id="custom-amount" placeholder="<?php _e('ex : 100€', 'jourj-gifts'); ?>" min="1" step="1" required />
            </div>
        </div>

        <div class="jo-block-gift-modal__payment-infos">
            <span class="jo-block-gift-modal__payment-infos--title">
                <?php _e('Paiement 100% sécurisé <strong>via PayPal</strong>', 'jourj-gifts'); ?>
            </span>
            <p class="jo-block-gift-modal__payment-infos--subtitle">
                <?php _e("Toutes les transactions sont traitées directement sur la plateforme PayPal, reconnue pour sa fiabilité. Aucune information bancaire n'est enregistrée ou visible sur notre site.", "jourj-gifts"); ?>
            </p>
        </div>

        <form class="jo-block-gift-modal__form">
            <label for="user-name"><?php _e('Votre prénom et nom', 'jourj-gifts'); ?> :</label>
            <input type="text" name="user-name" id="user-name" placeholder="<?php _e('ex : John Doe', 'jourj-gifts'); ?>" required />

            <label for="user-message"><?php _e('Vous pouvez laisser un petit message avec votre participation (facultatif)', 'jourj-gifts'); ?> :</label>
            <textarea name="user-message" id="user-message" placeholder="<?php _e('ex : Écrivez ici votre message ...', 'jourj-gifts'); ?>" rows="4"></textarea>

            <input type="hidden" name="gift-id" id="gift-id" value="" />
            <input type="hidden" name="user-funding" id="user-funding" value="" />

            <input type="submit" value="<?php _e('Confirmer ma participation', 'jourj-gifts'); ?>" class="wp-block-button__link" />
        </form>

        <button class="jo-block-gift-modal__close" aria-label="<?php _e('Fermer', 'jourj-gifts'); ?>">
            <img src="<?php echo $icon_cross; ?>" alt="<?php _e('Fermer', 'jourj-gifts'); ?>" />
        </button>
    </div>
</div>