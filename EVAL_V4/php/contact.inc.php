<?php
require_once 'php/myFct.php';
require_once 'inc/db_user.inc.php';
require_once 'inc/config.inc.php';

use User\MyUser;

class Contact
{
    private $message;
    private $user = null;

    public function __construct()
    {
        if (isset($_GET['form__contact__mail']) && filter_var($_GET['form__contact__mail'], FILTER_VALIDATE_EMAIL) || isset($_POST['form__contact__mail'])) {
            $this->user = new MyUser();
            $this->user->courriel = (isset($_GET['form__contact__mail'])) ? $_GET['form__contact__mail'] : $_POST['form__contact__mail'];
        }
    }

    public function contacter()
    {
        $user = new MyUser();
        $user->courriel = strip_tags(trim($_POST['form__contact__mail']));
        if (empty($user->courriel)) {
            $this->message = "<h1>Courriel manquant !</h1>";
        } else {
            if (filter_var($user->courriel, FILTER_VALIDATE_EMAIL)) {
                if (trim($_POST['form__contact__intitule']) == "" || trim($_POST['form__contact__message']) == "") {
                    $this->message = "<h1>Intitulé et/ou message manquant(s) !</h1>";
                } else {
                    $intitule = "eWins : " . strip_tags($_POST['form__contact__intitule']);
                    $intituleCopie = "eWins copie : " . strip_tags($_POST['form__contact__intitule']);
                    $body = strip_tags($_POST['form__contact__message']);
                    $bodyCopie = "Voici un copie de votre mail envoyé : <br>" . strip_tags($_POST['form__contact__message']);
                    sendMail($user->courriel, MYMAIL, $intitule, $body, $this->message);
                    sendMail("no-reply@ewins.com", $user->courriel, $intituleCopie, $bodyCopie, $this->message);
                    if ($this->message == "") {
                        $this->message = "Le mail a été envoyé";
                    }
                }
            } else {
                $this->message = "Le courriel est invalide";
            }
        }
    }

    public function get_message()
    {
        return $this->message;
    }

    public function get_utilisateur()
    {
        return $this->user;
    }
}
