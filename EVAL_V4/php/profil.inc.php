<?php
require_once 'inc/db_user.inc.php';
use User\MyUser;

class Profil
{
    private $message;
    private $user;

    public function __construct() {
        $this->user = new MyUser();
        $this->user->nom = $_SESSION['nom'];
        $this->user->prenom = $_SESSION['prenom'];
        $this->user->pseudo = $_SESSION['pseudo'];
        $this->user->courriel = $_SESSION['courriel'];
        $this->user->urlPhoto = $_SESSION['urlPhoto'];
    }

    public function get_message()
    {
        return $this->message;
    }

    public function get_user() {
        return $this->user;
    }
}