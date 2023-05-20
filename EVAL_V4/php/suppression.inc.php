<?php
require_once "php/myFct.php";
require_once 'inc/db_tournoi.inc.php';
require_once 'inc/db_user.inc.php';
require_once 'inc/db_participer.inc.php';

use Tournoi\TournamentRepository;
use User\MyUser;
use User\UserRepository;
use Participer\ParticipationRepository;

class SupprimerProfil
{
    private $message;
    private $participe;

    public function suppressionProfil() {
        $this->participe = false;
        $tournamentRepository = new TournamentRepository();
        $user = new MyUser();
        $userRepository = new UserRepository();

        $user->id_utilisateur = $_SESSION['id_utilisateur'];
        $user->courriel = $_SESSION['courriel'];
        $participeRepository = new ParticipationRepository();

        $participationTournois = $participeRepository->getParticipationByUserId($user->id_utilisateur, $this->message);
        foreach ($participationTournois as $participationTournoi) {
            $tournament = $tournamentRepository->getTournamentByIdActif($participationTournoi->id_tournoi, 1, $this->message);
            if ($tournament != "") {
                $this->participe = true;
            }
        }
        if (isset($_POST['form__button__delete'])) {
            if (empty($_POST['form__suppression__mdp'])) {
                $this->message = "<h1>Aucun mot de passe spécifié !</h1>";
            } else {
                $mdp = $userRepository->getMotDePasse($user->courriel, $this->message);
                $password = hash("sha512", trim($_POST['form__suppression__mdp']));
                if ($mdp === $password) {
                    $intitule = "eWins : Suppresion de votre compte";
                    $body = "Vous avez décidé de nous quitter...<br>Je vous informe que votre compte a bien été supprimé.";
                    sendMail("no-reply@ewins.com", $user->courriel, $intitule, $body, $this->message);
                    $userRepository->removeUser($user->id_utilisateur, 0, $this->message);
                    header('location: connexion.php');
                } else {
                    $this->message = "<h1> Le mot de passe est incorrect</h1>";
                }
            }
        }
    }

    public function get_message() {
        return $this->message;
    }

    public function get_participe() {
        return $this->participe;
    }
}
