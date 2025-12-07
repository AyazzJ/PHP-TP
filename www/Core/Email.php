<?php
namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        try {
            // SMTP Configuration for Mailo
            $this->mailer->isSMTP();
            $this->mailer->Host = 'mail.mailo.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'phptest@mailo.com';
            $this->mailer->Password = 'Phptest1234';
            $this->mailer->SMTPSecure = 'ssl';
            $this->mailer->Port = 465;
            $this->mailer->setFrom('phptest@mailo.com', 'PHP Test App');
        } catch (Exception $e) {
            error_log("Mailer Error: {$e->getMessage()}");
        }
    }

    public function sendVerificationEmail($toEmail, $toName, $verificationToken)
    {
        try {
            $verificationLink = "http://web/phptest/verify-email?token=" . $verificationToken;

            $this->mailer->addAddress($toEmail, $toName);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Vérifiez votre adresse email';
            $this->mailer->Body = "
                <h2>Bienvenue!</h2>
                <p>Merci de vous être inscrit. Veuillez vérifier votre adresse email en cliquant sur le lien ci-dessous:</p>
                <p><a href='$verificationLink'>Vérifier mon email</a></p>
                <p>Ou copiez ce lien: $verificationLink</p>
                <p>Ce lien expire dans 24 heures.</p>
            ";
            $this->mailer->AltBody = "Vérifiez votre email: $verificationLink";

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email send failed: {$e->getMessage()}");
            return false;
        }
    }

    public function sendPasswordResetEmail($toEmail, $toName, $resetToken)
    {
        try {
            $resetLink = "http://web/phptest/reset-password?token=" . $resetToken;

            $this->mailer->addAddress($toEmail, $toName);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Réinitialiser votre mot de passe';
            $this->mailer->Body = "
                <h2>Réinitialisation du mot de passe</h2>
                <p>Vous avez demandé une réinitialisation de mot de passe. Cliquez sur le lien ci-dessous:</p>
                <p><a href='$resetLink'>Réinitialiser mon mot de passe</a></p>
                <p>Ou copiez ce lien: $resetLink</p>
                <p>Ce lien expire dans 1 heure.</p>
            ";
            $this->mailer->AltBody = "Réinitialisez votre mot de passe: $resetLink";

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email send failed: {$e->getMessage()}");
            return false;
        }
    }
}
