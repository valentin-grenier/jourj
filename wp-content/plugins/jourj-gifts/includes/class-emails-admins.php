<?php

/**
 * Class: Emails Users
 * 
 * This class handles the sending of emails to admins.
 */

class JourJ_Emails_Admins
{
   # Create email template for reservation confirmation
   public function send_email($to, $subject, $content)
   {
      $headers = [
         'Content-Type: text/html; charset=UTF-8',
         'From: Rébecca et Aurélien <no-reply@notremariage-rebec-aure.fr>'
      ];

      wp_mail($to, $subject, $content, $headers);
   }

   # Send a confirmation email to the admins after a reservation
   public function send_reservation_confirmation_email($email, $link, $gift_id, $guest_message)
   {
      # Check if mandatory information are provided
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
      $gift_id = absint($gift_id);
      $gift_title = get_the_title($gift_id);
      $guest_message = wp_unslash($guest_message);
      $guest_name = get_post_meta($gift_id, '_jourj_reserved_by_name', true);
      $cancellation_link = get_post_meta($gift_id, '_jourj_cancellation_link', true);

      $subject = __("[Site web] $gift_title réservé ! 🎉", 'jourj-gifts');

      ob_start();
      include plugin_dir_path(__FILE__) . './partials/emails/admins/email-reservation-admin.php';
      $message = ob_get_clean();

      $this->send_email($email, $subject, $message);
      error_log("[JourJ Gifts - Email] Reservation confirmation email sent to: $email");
   }

   # Send a confirmation email to the user after a reservation cancellation
   public function send_reservation_cancellation_email($email, $link, $gift_id, $guest_name)
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

      # Infos for the email
      $gift_title = get_the_title($gift_id);
      $guest_name = wp_unslash($guest_name);

      # Build the email subject and message
      $subject = __('Annulation de réservation - Cadeau Rébecca et Aurélien', 'jourj-gifts');

      ob_start();
      include plugin_dir_path(__FILE__) . './partials/emails/admins/email-reservation-cancellation-admin.php';
      $message = ob_get_clean();

      $this->send_email($email, $subject, $message);
      error_log("[JourJ Gifts - Email] Reservation cancellation email sent to: $email");
   }
}
