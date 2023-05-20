<?php
require_once 'inc/db_tournoi.inc.php';
require_once 'inc/db_user.inc.php';
require_once 'inc/db_participer.inc.php';
require_once 'inc/db_rencontre.inc.php';

use Tournoi\TournamentRepository;
use Tournoi\MyTournament;
use User\UserRepository;
use User\MyUser;
use Participer\ParticipationRepository;
use Rencontre\RencontreRepository;

class SupprimerJoueur
{
    private $message;
    private $tournamentRepository;
    private $tournament;
    private $userRepository;
    private $user;
    private $participationRepository;
    private $existTournament;
    private $existUser;
    private $statutGenere;

    public function __construct() {
        $this->tournamentRepository = new TournamentRepository();
        $this->tournament = new MyTournament();
        $this->userRepository = new UserRepository();
        $this->participationRepository = new ParticipationRepository();
        $this->user = new MyUser();
        $this->existUser = false;
        $this->existTournament = false;
        $this->statutGenere = false;


        if (isset($_POST['id_utilisateur']) && is_numeric($_POST['id_utilisateur'])) {
            $this->user->id_utilisateur = $_POST['id_utilisateur'];
            $this->existUser = $this->userRepository->userExistInDB($this->user->id_utilisateur, $this->message);
        } elseif (isset($_GET['id_utilisateur']) && is_numeric($_GET['id_utilisateur'])) {
            $this->user->id_utilisateur = $_GET['id_utilisateur'];
            $this->existUser = $this->userRepository->userExistInDB($this->user->id_utilisateur, $this->message);
        }

        if (isset($_POST['id_tournoi']) && is_numeric($_POST['id_tournoi'])) {
            $this->tournament->id_tournoi = $_POST['id_tournoi'];
            $this->existTournament = $this->tournamentRepository->tournamentExistInDB($this->tournament->id_tournoi, $this->message);
        } elseif (isset($_GET['id_tournoi']) && is_numeric($_GET['id_tournoi'])) {
            $this->tournament->id_tournoi = $_GET['id_tournoi'];
            $this->existTournament = $this->tournamentRepository->tournamentExistInDB($this->tournament->id_tournoi, $this->message);
        }
        $this->tournament->nom = $this->tournamentRepository->getNom($this->tournament->id_tournoi, $this->message);
        $this->user->nom = $this->userRepository->getNomId($this->user->id_utilisateur, $this->message);
        $this->user->prenom = $this->userRepository->getPrenomId($this->user->id_utilisateur, $this->message);
        $this->user->pseudo = $this->userRepository->getPseudoId($this->user->id_utilisateur, $this->message);
        $this->user->courriel = $this->userRepository->getCourrielId($this->user->id_utilisateur, $this->message);
        $this->user->urlPhoto = $this->userRepository->getUrlPhotoId($this->user->id_utilisateur, $this->message);

        if ($this->existTournament) {
            if ($this->existUser) {
                $statut =$this->tournamentRepository->getIdStatut($this->tournament->id_tournoi, $this->message);
                if ($statut == 4 || $statut == 5) {
                    $this->statutGenere = true;
                }
            } else {
                $this->message = "<h1>Joueur inexistant !</h1>";
            }
        } else {
            $this->message = "<h1>Tournoi inexistant !</h1>";
        }
    }

    public function supprimerJoueur() {
        if ($this->existUser && $this->existTournament && !$this->statutGenere) {
            $this->participationRepository->deleteUser($this->user->id_utilisateur, $this->tournament->id_tournoi, $this->message);
            $this->message = "<h1>Le joueur a été supprimé avec succès !</h1>";
        }
    }

    public function get_message() {
        return $this->message;
    }

    public function get_tournamentRepository() {
        return $this->tournamentRepository;
    }

    public function get_tournament() {
        return $this->tournament;
    }

    public function get_userRepository() {
        return $this->userRepository;
    }

    public function get_user() {
        return $this->user;
    }

    public function get_statutGenere() {
        return $this->statutGenere;
    }

}