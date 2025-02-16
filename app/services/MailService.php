<?php

namespace App\Services;

use Mailgun\Mailgun;

class MailService
{
    public static function sendResetPasswordEmail($to, $token)
    {
        // Construction du lien de réinitialisation
        $resetLink = BASE_URL . "/auth/resetpassword?token=$token";
        $subject = "Réinitialisation de votre mot de passe";
        $message = "Bonjour, cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink";

        // Configurer le client Mailgun
        $mg = Mailgun::create(MAILGUN_API_KEY);

        // Envoyer l'email
        try {
            $response = $mg->messages()->send('sandbox6d26708620684a72b61142a9b0d15c47.mailgun.org', [
                'from'    => 'Photo Management <mailgun@sandbox6d26708620684a72b61142a9b0d15c47.mailgun.org>',
                'to'      => $to,
                'subject' => $subject,
                'text'    => $message
            ]);
            error_log("Réponse de Mailgun : " . print_r($response, true));
            return true;
        } catch (\Exception $e) {
            error_log("Erreur lors de l'envoi de l'email : " . $e->getMessage());
            throw new \Exception("Erreur lors de l'envoi de l'email : " . $e->getMessage());
        }
    }
}