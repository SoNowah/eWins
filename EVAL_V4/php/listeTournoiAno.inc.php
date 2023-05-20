<?php
require_once 'inc/db_user.inc.php';
require_once 'inc/db_participer.inc.php';
require_once 'inc/db_tournoi.inc.php';
require_once 'inc/db_statut.inc.php';
require_once 'inc/db_sport.inc.php';

use User\UserRepository;
use Participer\ParticipationRepository;
use Tournoi\TournamentRepository;
use Tournoi\MyTournament;
use Statut\StatutRepository;
use Sport\SportRepository;

class ListeTournoisAno
{
    private $message;
    private $participations;

    private $participesRepository;
    private $tournamentRepository;
    private $nePasAfficher;
    private $tournament;
    private $statutRepository;
    private $sportRepository;
    private $userRepository;
    private $compteur;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->participesRepository = new ParticipationRepository();
        $this->tournament = new MyTournament();
        $this->tournamentRepository = new TournamentRepository();
        $this->statutRepository = new StatutRepository();
        $this->sportRepository = new SportRepository();
        $this->compteur = 0;


        if (isset($_POST['form__button__submit'])) {
            if ($_POST['form__listeTournois__statut'] == "all" && $_POST['form__listeTournois__sport'] == "all") {
                $this->participations = $this->tournamentRepository->getAllTournament($this->message);
            } elseif($_POST['form__listeTournois__statut'] == "all") {
                $this->participations = $this->tournamentRepository->getAllTournamentBySportId($_POST['form__listeTournois__sport'], $this->message);
            } elseif ($_POST['form__listeTournois__sport'] == "all") {
                $this->participations = $this->tournamentRepository->getAllTournamentByStatutId($_POST['form__listeTournois__statut'], $this->message);
            } else {
                $this->participations = $this->tournamentRepository->getAllTournamentByStatutIdAndBySportId($_POST['form__listeTournois__statut'], $_POST['form__listeTournois__sport'], $this->message);
            }
        } else {
            $this->participations = $this->tournamentRepository->getAllTournament($this->message);
        }

        if (isset($_GET['message'])) {
            $this->message = $_GET['message'];
        }

        if (count($this->participations) > 0) {
            $this->nePasAfficher = 0;
            foreach ($this->participations as $participation) {
                $this->tournament->id_tournoi = $participation->id_tournoi;
                $this->tournament->nom = $this->tournamentRepository->getNom($this->tournament->id_tournoi, $this->message);
                $this->tournament->id_sport = $this->sportRepository->getSportIdByTournamentId($this->tournament->id_tournoi, $this->message);
                $this->tournament->placesDispo = $this->tournamentRepository->getPlacesDispo($this->tournament->id_tournoi, $this->message);
                $this->tournament->statut = $this->statutRepository->getStatutIdByTournamentId($this->tournament->id_tournoi, $this->message);
                $this->tournament->dateTournoi = $this->tournamentRepository->getDateTournoi($this->tournament->id_tournoi, $this->message);
                $this->tournament->dateFinInscription = $this->tournamentRepository->getDateFinInscription($this->tournament->id_tournoi, $this->message);
                $this->tournament->estActif = $this->tournamentRepository->getEstActif($this->tournament->id_tournoi, $this->message);
                $this->tournament->id_organisateur = $this->tournamentRepository->getOrganisateur($this->tournament->id_tournoi, $this->message);
            }
        } else {
            $this->nePasAfficher = 1;
            $this->message = "<h1>Aucun tournoi ne correspond à votre recherche !</h1>";
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

    public function get_statutRepository() {
        return $this->statutRepository;
    }

    public function get_sportRepository() {
        return $this->sportRepository;
    }

    public function get_participations() {
        return $this->participations;
    }

    public function get_participesRepository() {
        return$this->participesRepository;
    }
}


