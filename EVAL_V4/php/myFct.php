<?php
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($expediteur, $destinataire, $subject, $body, &$message){
    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($expediteur);
        $mail->addAddress($destinataire);
        $mail->addReplyTo($expediteur);
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
        $message = "Mail expédié";
    } catch (Exception $e) {
        $message = 'Erreur survenue lors de l\'envoi de l\'email de confirmation. Veuillez vérifier que les données encodées sont correcte et réessayer plus tard ' . $mail->ErrorInfo;
        return false;
    }
    return true;
}

function sendMail2($expediteur, $destinataire, $destinataire2, $subject, $body, &$message){
    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($expediteur);
        $mail->addAddress($destinataire);
        $mail->addCC($destinataire2);
        $mail->addReplyTo($expediteur);
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
        $message = "Mail expédié";
    } catch (Exception $e) {
        $message = 'Erreur survenue lors de l\'envoi de l\'email de confirmation. Veuillez vérifier que les données encodées sont correcte et réessayer plus tard ' . $mail->ErrorInfo;
        return false;
    }
    return true;
}

function isValidMail($mail)
{
    return (!filter_var($mail, FILTER_VALIDATE_EMAIL)) ? false : true;
}


function nettoyerDonnee($data) {
    return htmlentities(trim($data));
}
?>