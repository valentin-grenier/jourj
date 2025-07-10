<?php
# Get PayPal URL from environment variables
$gift_payment_url_paypal = isset($_ENV['PAYPAL_URL']) ? $_ENV['PAYPAL_URL'] : null;
?>

<div class="jo-block-gift-custom-funding">
    <p><strong>
            <?php _e('Vous ne trouvez pas votre bonheur dans la liste ?', 'jourj-gifts'); ?>
        </strong>
    </p>

    <p>
        <?php _e('Vous pouvez aussi contribuer librement à notre cagnotte, avec le montant de votre choix. Chaque participation, petite ou grande, est précieuse.', 'jourj-gifts'); ?>
    </p>

    <a class="jo-block-gift-custom-funding__button" href="<?php echo esc_url($gift_payment_url_paypal); ?>" target="_blank" rel="noopener noreferrer">
        <?php _e('Faire un don', 'jourj-gifts'); ?>
    </a>
</div>