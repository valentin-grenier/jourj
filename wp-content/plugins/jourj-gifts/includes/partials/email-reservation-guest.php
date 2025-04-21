<?php
# Convert gift_id to string
$gift_id = strval($gift_id);

$gift_title = get_the_title($gift_id);
$cancellation_link = get_post_meta($gift_id, '_jourj_cancellation_link', true);
?>

<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #F4F8F7; padding: 24px">
    <div style="max-width: 600px; margin: 0 auto; padding: 24px; border-radius: 12px; background: #ffffff">
        <h2 style="margin-top: 0;">Confirmation de votre réservation de cadeau</h2>
        <p>Bonjour,</p>
        <p>Merci d'avoir réservé le cadeau "<strong style="color: #8DB1AB; font-weight: 700;"><?php echo esc_html($gift_title); ?></strong>". Nous sommes ravis de vous compter parmi nos invités pour ce jour si spécial.</p>
        <p>Si vous souhaitez annuler votre réservation, vous pouvez le faire en cliquant sur le bouton ci-dessous :</p>
        <div style="background-color: #37515F; border-radius: 8px; border-width: 0; font-family: inherit; font-size: inherit; font-weight: 600; line-height: normal; width: fit-content;">
            <a href="<?php echo esc_url($cancellation_link); ?>" style="display: flex; padding: 12px 16px; color: #ffffff; text-decoration: none;">Annuler ma réservation</a>
        </div>
        <p>Merci à vous, et à vite,</p>
        <p>Rébecca et Aurélien</p>
    </div>
</div>