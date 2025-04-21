<?php
# Convert gift_id to string
$gift_id = strval($gift_id);

$gift_title = get_the_title($gift_id);
$guest_name = get_post_meta($gift_id, '_jourj_reserved_by_name', true);
?>

<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #F4F8F7; padding: 24px">
    <div style="max-width: 600px; margin: 0 auto; padding: 24px; border-radius: 12px; background: #ffffff">
        <h2 style="margin-top: 0;">Nouvelle réservation de cadeau</h2>
        <p>Bonjour les amoureux,</p>
        <p>Le cadeau "<strong style="color: #8DB1AB; font-weight: 700;"><?php echo esc_html($gift_title); ?></strong>". vient d'être réservé par <?php echo esc_html($guest_name); ?>.</p>
        <p>Bisous, <br>La crème de la crème des devs toulousain</p>
    </div>
</div>