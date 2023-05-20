<?php
require_once 'inc/db_user.inc.php';
require_once 'php/myFct.php';

use User\UserRepository;
use User\MyUser;

class NouveauMDP
{
    private $message;

    public function recuperationMDP() {
        if (isset($_POST['butNewPass'])) {
            $userRepository = new UserRepository();
            $user = new MyUser();
            $user->courriel = strip_tags(trim($_POST['form__newPass__mail']));
            $result = $userRepository->courrielExistsInDB($user->courriel, 1, $this->message);
            if (empty($user->courriel) || $result == "") {
                $this->message = "<h1>Courriel inexistant ou invalide !</h1>";
            } else {
                $user->motDePasse = bin2hex(openssl_random_pseudo_bytes(4));
                $userRepository->modifyPasswordByEmail($user->motDePasse, $user->courriel, $message);
                if($user->motDePasse == "") {
                    $this->message = "<h1>Courriel inexistant !</h1>";
                } else {
                    $intitule = "eWins : Réinitialisation du mot de passe";
                    $body = "Vous avez oublié votre mot de passe ? Pas de soucis, voici votre nouveau mot de passe généré aléatoirement : " . $user->motDePasse;
                    sendMail("no-reply@ewins.com", $user->courriel, $intitule, $body, $this->message);
                    if ($this->message == "") {
                        $this->message = "<h1>Mail envoyé avec succès !</h1>";
                    }
                }
            }
        }
    }

    public function get_message() {
        return $this->message;
    }
}
