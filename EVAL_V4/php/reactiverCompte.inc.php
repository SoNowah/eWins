<?php
require_once 'inc/db_user.inc.php';

use User\MyUser;
use User\UserRepository;

class ReactiverCompte
{
    private $message;

    public function reactiverCompte() {
        if (isset($_POST['form__button__submit'])) {
            $userRepository = new UserRepository();
            $user = new MyUser();
            $user->courriel = strip_tags(trim($_POST['form__reactiver__mail']));
            $user->id_utilisateur = $userRepository->getId($user->courriel, $message);
            if ($user->id_utilisateur == "") {
                $this->message = "<h1>Cette adresse mail ne peut pas être réactivé !</h1>";
            } else {
                $userRepository->removeUser($user->id_utilisateur, 1, $message);
                $this->message = "<h1>Votre compte a bien été réactivé. Vous pouvez vous connecter.</h1>";
                header('location: connexion.php');
            }
        }
    }

    public function get_message() {
        return $this->message;
    }
}