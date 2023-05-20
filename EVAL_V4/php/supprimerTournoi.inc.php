<?php
require_once 'php/myFct.php';
require_once 'inc/db_tournoi.inc.php';
require_once 'inc/db_rencontre.inc.php';
require_once 'inc/db_participer.inc.php';
require_once 'inc/db_user.inc.php';

use User\UserRepository;
use Tournoi\TournamentRepository;
use Tournoi\MyTournament;

class SupprimerTournoi
{
    private $message;
    private $tournamentRepository;
    private $tournament;
    private $userRepository;
    private $statutTermine;
    private $exist;

    public function __construct() {
        $this->tournamentRepository = new TournamentRepository();
        $this->userRepository = new UserRepository();
        $this->exist = false;
        $this->tournament = new MyTournament();
        $this->statutTermine = false;

        if (isset($_POST['id_tournoi']) && is_numeric($_POST['id_tournoi'])) {
            $this->tournament->id_tournoi = $_POST['id_tournoi'];
            $this->exist = $this->tournamentRepository->tournamentExistInDB($this->tournament->id_tournoi, $this->message);
        } elseif (isset($_GET['id_tournoi']) && is_numeric($_GET['id_tournoi'])) {
            $this->tournament->id_tournoi = $_GET['id_tournoi'];
            $this->exist = $this->tournamentRepository->tournamentExistInDB($this->tournament->id_tournoi, $this->message);
        }
        $this->tournament->nom = $this->tournamentRepository->getNom($this->tournament->id_tournoi, $this->message);
        $this->tournament->id_organisateur = $this->tournamentRepository->getOrganisateur($this->tournament->id_tournoi, $this->message);

        if ($this->exist) {
            $statut = $this->tournamentRepository->getIdStatut($this->tournament->id_tournoi, $this->message);
            if ($statut == 6) {
                $this->statutTermine = true;
            }
        } else {
            $this->message = "<h1>Tournoi inexistant !</h1>";

        }
    }

    public function supprimerTournoi() {
        if ($this->exist && $this->statutTermine) {
            $this->tournamentRepository->deleteTournament($this->tournament->id_tournoi, $this->message);
            $this->message = "<h1>Le tournoi a été supprimé avec succès !</h1>";
            $mail = $this->userRepository->getCourrielId($this->tournament->id_organisateur, $this->message);
            $intitule = "eWins : Suppression de tournoi";
            $body = "Nous avons l'honneur de vous annoncer que le tournoi " . $this->tournament->nom . " a bien été supprimé.";
            sendMail("no-reply@ewins.com", $mail, $intitule, $body, $this->message);
            header('location: listeTournois.php');
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

    public function get_statutTermine() {
        return $this->statutTermine;
    }
}
