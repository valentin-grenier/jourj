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
        # Get raw POST data from PayPal
        $raw_post = file_get_contents('php://input');

        if (empty($raw_post)) {
            error_log('[JourJ Gifts] Empty IPN received');
            return new WP_REST_Response('Empty IPN', 400);
        }

        # Prepend cmd=_notify-validate to the raw POST data
        $payload = 'cmd=_notify-validate&' . $raw_post;

        # Validate IPN with PayPal
        $response = wp_remote_post('https://ipnpb.paypal.com/cgi-bin/webscr', [
            'body'    => $payload,
            'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
        ]);

        if (is_wp_error($response)) {
            error_log('[JourJ Gifts] IPN validation error: ' . $response->get_error_message());
            return new WP_REST_Response('IPN HTTP error', 500);
        }

        $body = wp_remote_retrieve_body($response);

        # Development bypass: localhost or Postman
        if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || (strpos($_SERVER['HTTP_USER_AGENT'], 'PostmanRuntime') !== false)) {
            $body = 'VERIFIED';
        }

        # Check if the response is 'VERIFIED'
        if (trim($body) !== 'VERIFIED') {
            error_log('[JourJ Gifts] IPN not verified: ' . $body);
            return new WP_REST_Response('IPN no verified', 400);
        } else {
            error_log('[JourJ Gifts] IPN verified: ' . $body);
        }

        error_log('ici 1');

        # Parse data after validation
        $post_data = [];
        parse_str($raw_post, $post_data);

        if ($post_data['payment_status'] !== 'Completed') {
            error_log('[JourJ Gifts] Payment not completed');
            return new WP_REST_Response('Payment not completed', 400);
        }

        $gift_id = intval($post_data['item_number'] ?? 0);
        $amount  = floatval($post_data['mc_gross'] ?? 0);

        if (!$gift_id || $amount <= 0) {
            error_log('[JourJ Gifts] Missing or invalid gift data');
            return new WP_REST_Response('Missing gift data', 400);
        }

        $gift_title = get_the_title($gift_id);

        $this->update_gift_amount($gift_id, $amount);
        error_log("[JourJ Gifts] Payment received for $gift_title – Amount: $amount EUR");

        # Save guest message if present

        $custom_raw = $post_data['custom'] ?? '';
        $custom_data = json_decode($custom_raw, true);

        error_log("[JourJ Gifts] Custom data (raw): " . $custom_raw);
        error_log("[JourJ Gifts] Custom message: " . print_r($custom_data['guest_message'], true));

        if (!empty($custom_data['guest_message'])) {
            $messages = get_post_meta($gift_id, '_jourj_guest_messages', true) ?: [];

            error_log("[JourJ Gifts] Existing messages: " . print_r($messages, true));

            $current_datetime = current_datetime()->getTimestamp();
            $current_datetime = date('Y-m-d H:i:s', $current_datetime);

            $messages[] = [
                'name'    => sanitize_text_field($custom_data['guest_name'] ?? ''),
                'message' => sanitize_textarea_field($custom_data['guest_message']),
                'date'    => $current_datetime,
            ];

            update_post_meta($gift_id, '_jourj_guest_messages', $messages);
            error_log("[JourJ Gifts] Guest message saved for $gift_title from {$custom_data['guest_name']}");
        }


        return new WP_REST_Response('IPN processed', 200);
    }

    protected function update_gift_amount($gift_id, $amount)
    {
        # Get existing funded amount
        $funded = get_post_meta($gift_id, '_jourj_funded', true) ?: 0;

        # Convert gift ID to string
        $gift_id = strval($gift_id);

        # Update the funded amount
        $new_funded = $funded + $amount;
        update_post_meta($gift_id, '_jourj_funded', $new_funded);
    }
}
