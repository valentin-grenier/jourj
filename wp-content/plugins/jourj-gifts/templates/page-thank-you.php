<?php
# Gift data
$gift_id = isset($_GET['gift_id'])   ? intval($_GET['gift_id']) : 0;
$transaction_id = isset($_GET['tx'])        ? sanitize_text_field($_GET['tx']) : '';
$payment_status = isset($_GET['st'])        ? sanitize_text_field($_GET['st']) : '';
$amount = isset($_GET['amt'])       ? sanitize_text_field($_GET['amt']) : '';
$currency_code  = isset($_GET['cc'])        ? sanitize_text_field($_GET['cc']) : '';
$payer_id = isset($_GET['PayerID'])   ? sanitize_text_field($_GET['PayerID']) : '';

?>

<div class="jo-page-thank-you">
    <div class="jo-page-thank-you__text">
        <h1><?php _e('Merci pour votre participation !', 'jourj-gifts'); ?></h1>
        <p><?php _e('Votre participation a bien été enregistrée. Nous vous remercions pour votre soutien.', 'jourj-gifts'); ?></p>
    </div>

    <div class="wp-block-buttons">
        <div class="wp-block-button">
            <a class="wp-block-button__link" href="<?php echo esc_url(home_url('/')); ?>">
                <?php _e("Retour à l'accueil", 'jourj-gifts'); ?>
            </a>
        </div>

        <div class="wp-block-button is-style-button-secondary is-style-button-secondary--1">
            <a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(home_url('/infos-pratiques')); ?>#jourj-gifts-list">
                <?php _e("Les infos du jour J", 'jourj-gifts'); ?>
            </a>
        </div>
    </div>
</div>