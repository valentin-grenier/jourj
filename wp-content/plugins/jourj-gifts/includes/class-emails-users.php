<?php

/**
 * Class: Emails Users
 * 
 * This class handles the sending of emails to users.
 */

class JourJ_Emails_Users
{
   public function __construct() {}

   # Create email template for reservation confirmation
   public function send_email($to, $subject, $content)
   {
      $headers = ['Content-Type: text/html; charset=UTF-8'];

      wp_mail($to, $subject, $content, $headers);
   }

   # Send a confirmation email to the user after a reservation
   public function send_reservation_confirmation_email($email, $link, $gift_id)
   {
      # Check if the user email and link are provided
      if (empty($email)) {
         error_log("[JourJ Gifts - Email] No user email provided for reservation confirmation.");
         return;
      }

      if (empty($link)) {
         error_log("[JourJ Gifts - Email] No reservation link provided for confirmation email.");
         return;
      }

      if (empty($gift_id)) {
         error_log("[JourJ Gifts - Email] No gift ID provided for reservation confirmation email.");
         return;
      }

      # Build the email subject and message
      $subject = __('Confirmation de réservation - Cadeau Rébecca et Aurélien', 'jourj-gifts');

      ob_start();
      include plugin_dir_path(__FILE__) . './partials/emails/users/email-reservation-user.php';
      $message = ob_get_clean();

      $this->send_email($email, $subject, $message);
      error_log("[JourJ Gifts - Email] Reservation confirmation email sent to: $email");
   }

   # Send a confirmation email to the user after a reservation cancellation
   public function send_reservation_cancellation_email($email, $link)
   {
      # Check if the user email and link are provided
      if (empty($email)) {
         error_log("[JourJ Gifts - Email] No user email provided for reservation cancellation.");
         return;
      }

      if (empty($link)) {
         error_log("[JourJ Gifts - Email] No cancellation link provided for confirmation email.");
         return;
      }

      # Build the email subject and message
      $subject = __('Annulation de réservation - Cadeau Rébecca et Aurélien', 'jourj-gifts');

      ob_start();
      include plugin_dir_path(__FILE__) . './partials/emails/users/email-reservation-cancellation-guest.php';
      $message = ob_get_clean();

      $this->send_email($email, $subject, $message);
      error_log("[JourJ Gifts - Email] Reservation cancellation email sent to: $email");
   }
}
