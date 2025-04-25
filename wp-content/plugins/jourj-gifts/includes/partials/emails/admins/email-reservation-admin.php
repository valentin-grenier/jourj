<?php
$gift_id = strval($gift_id);
$gift_title = get_the_title($gift_id);
$guest_name = get_post_meta($gift_id, '_jourj_reserved_by_name', true);
$cancellation_link = get_post_meta($gift_id, '_jourj_cancellation_link', true);
?>

<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #F4F8F7; padding: 24px">
    <div style="max-width: 600px; margin: 0 auto; padding: 24px; border-radius: 12px; background: #ffffff">
        <h2 style="margin-top: 0;">Nouvelle réservation de cadeau 🎁</h2>
        <p>Bonjour les amoureux,</p>
        <p>Le cadeau "<strong style="color: #8DB1AB; font-weight: 700;"><?php echo esc_html($gift_title); ?></strong>" vient d'être réservé par <?php echo esc_html($guest_name); ?> 🎉</p>

        <?php if ($guest_message): ?>
            <p><?php echo esc_html($guest_name); ?> a voulu vous laisser un message avec sa réservation :</p>
            <blockquote style="background: #F4F8F7; padding: 16px; border-radius: 8px; margin: 16px 0;">
                <p style="margin: 0;"><?php echo esc_html($guest_message); ?></p>
            </blockquote>
        <?php endif; ?>

        <p>Si vous souhaitez annuler la réservation, vous pouvez le faire en cliquant sur le bouton ci-dessous :</p>
        <div style="background-color: #37515F; border-radius: 8px; border-width: 0; font-family: inherit; font-size: inherit; font-weight: 600; line-height: normal; width: fit-content;">
            <a href="<?php echo esc_url($cancellation_link); ?>" style="display: flex; padding: 12px 16px; color: #ffffff; text-decoration: none;">Annuler la réservation</a>
        </div>

        <p>Si le bouton ne fonctionne pas, <a href="<?php echo esc_url($cancellation_link); ?>" style="color: #8DB1AB; font-weight: 700;">cliquez sur ce lien.</a></p>

        <p>Bisous, <br>La crème de la crème des devs toulousain</p>
    </div>
</div>