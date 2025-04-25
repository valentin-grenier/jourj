<?php

$cancellation_handler = new JourJ_Shortcodes();
$token = $_GET['token'] ?? null;
$gift_id = $_GET['gift_id'] ?? null;
$cancellation_state = $cancellation_handler->handle_reservation_cancellation($token, $gift_id);

?>

<div class="jo-page-cancel-reservation">
    <div class="jo-page-cancel-reservation__text">
        <?php if ($cancellation_state): ?>
            <h1><?php _e('Annulation de la réservation', 'jourj-gifts'); ?></h1>
            <p><?php _e('Votre réservation a été annulée avec succès.', 'jourj-gifts'); ?></p>
        <?php else: ?>
            <h1><?php _e('Réservation inconnue', 'jourj-gifts'); ?></h1>
            <p><?php _e("La réservation que vous essayez d'annuler n'existe pas ou a déjà été annulée.", 'jourj-gifts'); ?></p>
        <?php endif; ?>
    </div>

    <div class="wp-block-buttons">
        <div class="wp-block-button">
            <a class="wp-block-button__link" href="<?php echo esc_url(home_url('/')); ?>">
                <?php _e("Retour à l'accueil", 'jourj-gifts'); ?>
            </a>
        </div>

        <div class="wp-block-button is-style-button-secondary is-style-button-secondary--1">
            <a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(home_url('/infos-pratiques')); ?>">
                <?php _e("Les infos du jour J", 'jourj-gifts'); ?>
            </a>
        </div>
    </div>
</div>