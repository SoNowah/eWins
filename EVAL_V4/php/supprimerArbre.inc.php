<?php
require_once 'inc/db_user.inc.php';
require_once 'inc/db_tournoi.inc.php';
require_once 'inc/db_participer.inc.php';
require_once 'inc/db_sport.inc.php';
require_once 'inc/db_statut.inc.php';
require_once 'inc/db_rencontre.inc.php';

use Rencontre\MyRencontre;
use Tournoi\TournamentRepository;
use Tournoi\MyTournament;
use User\UserRepository;
use Participer\ParticipationRepository;
use Sport\SportRepository;
use Statut\StatutRepository;
use Rencontre\RencontreRepository;

class SupprimerArbre
{
    private $message;
    private $tournament;
    private $tournamentRepository;
    private $rencontre;
    private $userRepository;
    private $participationRepository;
    private $statutRepository;
    private $sportRepository;
    private $rencontreRepository;

    public function __construct()
    {
        $this->message = "";
        $this->tournamentRepository = new TournamentRepository();
        $this->tournament = new MyTournament();
        $this->rencontre = new MyRencontre();
        $this->userRepository = new UserRepository();
        $this->participationRepository = new ParticipationRepository();
        $this->statutRepository = new StatutRepository();
        $this->sportRepository = new SportRepository();
        $this->rencontreRepository = new RencontreRepository();
        $exists = false;

        if (isset($_GET['id_tournoi']) && is_numeric($_GET['id_tournoi']) || isset($_POST['id_tournoi'])) {
            $this->tournament->id_tournoi = (isset($_GET['id_tournoi'])) ? $_GET['id_tournoi'] : $_POST['id_tournoi'];
            $exists = $this->tournamentRepository->tournamentExistInDB($this->tournament->id_tournoi, $this->message);
        }
        if ($exists) {
            $this->rencontre = $this->rencontreRepository->getRencontreTournament($this->tournament->id_tournoi, $this->message);
            $this->tournament->nom = $this->tournamentRepository->getNom($this->tournament->id_tournoi, $this->message);
            $this->tournament->dateTournoi = $this->tournamentRepository->getDateTournoi($this->tournament->id_tournoi, $this->message);
            $this->tournament->dateFinInscription = $this->tournamentRepository->getDateFinInscription($this->tournament->id_tournoi, $this->message);
            $this->tournament->placesDispo = $this->tournamentRepository->getPlacesDispo($this->tournament->id_tournoi, $this->message);
            $this->tournament->statut = $this->tournamentRepository->getIdStatut($this->tournament->id_tournoi, $this->message);
            $this->tournament->id_organisateur = $this->tournamentRepository->getOrganisateur($this->tournament->id_tournoi, $this->message);
        } else {
            $this->message = "<h1>Ce tournoi n'existe pas !</h1>";
        }
    }

    public function supprimerArbre() {
        $this->rencontreRepository->deleteTree($this->tournament->id_tournoi, $this->message);
        $this->tournamentRepository->updateStatutTournament(3, $this->tournament->id_tournoi, $this->message);
    }

    public function get_message() {
        return $this->message ;
    }

    public function get_tournament() {
        return $this->tournament ;
    }

    public function get_rencontre() {
        return $this->rencontre ;
    }

    public function get_userRepository() {
        return $this->userRepository;
    }

    public function get_participationRepository() {
        return $this->participationRepository;
    }

    public function get_statutRepository() {
        return $this->statutRepository;
    }

    public function get_sportRepository() {
        return $this->sportRepository;
    }

    public function get_rencontreRepository() {
        return $this->rencontreRepository;
    }
}
