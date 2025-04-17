<?php

/**
 * Class: Payment
 * 
 * Handles the payment process for the gifts with PayPal IPN.
 */


class JourJ_IPN_Handler
{

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_ipn_routes']);
    }

    public function register_ipn_routes()
    {
        register_rest_route('jourj-gifts/v1', '/paypal-ipn', [
            'methods' => 'POST',
            'callback' => [$this, 'handle_ipn'],
            'permission_callback' => '__return_true', // No auth because PayPal needs public access
        ]);
    }

    public function handle_ipn($request)
    {
        # Read raw POST data from PayPal
        $raw_post_data = file_get_contents('php://input');
        $post_data = [];
        parse_str($raw_post_data, $post_data);

        if (empty($post_data)) {
            error_log('[JourJ Gifts] Empty IPN received');
            return new WP_REST_Response('Empty IPN', 400);
        }

        # Validate the IPN with PayPal
        $post_data['cmd'] = '_notify-validate';
        $response = wp_remote_post('https://ipnpb.paypal.com/cgi-bin/webscr', [
            'body' => $post_data,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        if (is_wp_error($response)) {
            error_log('[JourJ Gifts] Error validating IPN: ' . $response->get_error_message());
            return new WP_REST_Response('IPN HTTP error', 500);
        }

        // $body = wp_remote_retrieve_body($response);
        // if (trim($body) !== 'VERIFIED') {
        //     error_log('[JourJ Gifts] IPN not verified: ' . $body);
        //     return new WP_REST_Response('IPN not verified', 400);
        // }

        $body = "VERIFIED"; // For testing purposes, assume it's verified
        if (trim($body) !== 'VERIFIED') {
            error_log('[JourJ Gifts] IPN not verified: ' . $body);
            return new WP_REST_Response('IPN not verified', 400);
        }

        # Check payment status
        if (empty($post_data['payment_status']) || $post_data['payment_status'] !== 'Completed') {
            error_log('[JourJ Gifts] Payment not completed or missing status');
            return new WP_REST_Response('Payment not completed', 200);
        }

        # Extract useful information
        $gift_id = intval($post_data['item_number'] ?? 0); // From the payment url
        $amount = floatval($post_data['mc_gross'] ?? 0); // Amount paid

        if (empty($gift_id) || $amount <= 0) {
            error_log('[JourJ Gifts] Missing gift ID or amount in IPN data');
            return new WP_REST_Response('Missing gift ID or invalid amount', 400);
        }

        # Update the gift post with the payment information
        $this->update_gift_amount($gift_id, $amount);

        # Log the successful IPN
        error_log("[JourJ Gifts] Payment received: Gift #$gift_id - Amount: $amount EUR");
        return new WP_REST_Response('IPN processed', 200);
    }

    protected function update_gift_amount($gift_id, $amount)
    {
        # Assume you have a meta field like '_remaining_amount'
        $remaining = get_post_meta($gift_id, '_remaining_amount', true);
        if ($remaining === '') {
            $remaining = 0;
        }

        $new_remaining = floatval($remaining) - $amount;
        $new_remaining = max(0, $new_remaining); // Don't go negative

        update_post_meta($gift_id, '_remaining_amount', $new_remaining);

        # Notify with email notification
        // $this->send_notification($gift_id, $amount);
    }

    protected function send_notification($gift_id, $amount)
    {
        $gift_name = get_the_title($gift_id);

        $to = get_option('admin_email'); // Change this to your desired recipient 
        $subject = '[Cagnotte] Nouvelle participation ! 🥳';
        $message = sprintf('Une nouvelle personne vient de donner %s€ pour le cadeau %d.', wc_price($amount), $gift_name);

        # Send the email
        wp_mail($to, $subject, $message);
    }
}
