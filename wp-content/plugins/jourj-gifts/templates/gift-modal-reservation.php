<?php
$icon_cross = JOURJ_GIFTS_URL . 'assets/img/icon-cross.svg';
?>

<div class="jo-block-gift-modal reservation">
    <div class="jo-block-gift-modal__container">
        <img class="jo-block-gift-modal__image gift-image" src="" alt="" />

        <div class="jo-block-gift-modal__details">
            <h2 class="jo-block-gift-modal__details--title">
                <?php _e('Réserver le cadeau : ', 'jourj-gifts'); ?>
                <span class="gift-name"></span>
            </h2>

            <div class="jo-block-gift-modal__details--price">
                <?php _e('Montant : ', 'jourj-gifts'); ?>
                <span class="gift-price"></span>
            </div>

            <div class="jo-block-gift-modal__payment-infos">
                <p class="jo-block-gift-modal__payment-infos--subtitle">
                    <?php _e('Vous pourrez annuler la réservation à tout moment via le lien reçu par email. La réservation bloque le cadeau pour les autres invités.', 'jourj-gifts'); ?>
                </p>
            </div>
        </div>

        <form class="jo-block-gift-modal__form">
            <label for="user-name"><?php _e('Votre prénom et nom', 'jourj-gifts'); ?> :</label>
            <input type="text" name="user-name" id="user-name" placeholder="<?php _e('ex : John Doe', 'jourj-gifts'); ?>" required />

            <label for="user-email"><?php _e('Votre adresse email', 'jourj-gifts'); ?> :</label>
            <input type="email" name="user-email" id="user-email" placeholder="<?php _e('ex : john@doe.com', 'jourj-gifts'); ?>" required />

            <label for="guest_message"><?php _e('Vous pouvez laisser un petit message avec votre réservation (facultatif)', 'jourj-gifts'); ?> :</label>
            <textarea name="guest_message" id="guest_message" placeholder="<?php _e('ex : Écrivez ici votre message ...', 'jourj-gifts'); ?>" rows="4"></textarea>

            <input type="hidden" name="gift-id" id="gift-id" value="" />

            <input type="submit" value="<?php _e('Confirmer ma réservation', 'jourj-gifts'); ?>" class="wp-block-button__link" />
        </form>

        <button class="jo-block-gift-modal__close" aria-label="<?php _e('Fermer', 'jourj-gifts'); ?>">
            <img src="<?php echo $icon_cross; ?>" alt="<?php _e('Fermer', 'jourj-gifts'); ?>" />
        </button>
    </div>
</div>