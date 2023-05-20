<?php
require_once 'inc/db_user.inc.php';
require_once 'inc/db_tournoi.inc.php';

use Tournoi\TournamentRepository;
use Tournoi\MyTournament;

class EditionTournoi
{
    private $message;
    private $tournament;
    private $exist;

    public function __construct() {
        $tournamentRepository = new TournamentRepository();
        $this->tournament = new MyTournament();
        $this->exist = false;

        if (isset($_GET['id_tournoi']) && is_numeric($_GET['id_tournoi']) || isset($_POST['id_tournoi'])) {
            $this->tournament->id_tournoi = (isset($_GET['id_tournoi'])) ? $_GET['id_tournoi'] : $_POST['id_tournoi'];
            $this->exist = $tournamentRepository->tournamentExistInDB($this->tournament->id_tournoi, $this->message);
        }
        if ($this->exist) {
            $this->tournament->nom = $tournamentRepository->getNom($this->tournament->id_tournoi, $this->message);
            $this->tournament->id_sport = $tournamentRepository->getIdSport($this->tournament->id_tournoi, $this->message);
            $this->tournament->placesDispo = $tournamentRepository->getPlacesDispo($this->tournament->id_tournoi, $this->message);
            $this->tournament->dateTournoi = $tournamentRepository->getDateTournoi($this->tournament->id_tournoi, $this->message);
            $this->tournament->dateFinInscription = $tournamentRepository->getDateFinInscription($this->tournament->id_tournoi, $this->message);
        }
    }

    public function editerTournoi() {
        if ($this->exist) {
            if (isset($_POST['form__editionTour__name']) && !empty(trim($_POST['form__editionTour__name']))) {
                if ($_POST['form__editionTour__name'] != $this->tournament->nom || $_POST['form__editionTour__sport'] != $this->tournament->id_sport || $_POST['form__editionTour__nbplaceDispo'] != $this->tournament->placesDispo || $_POST['form__editionTour__dateFinTour'] != $this->tournament->dateTournoi || $_POST['form__editionTour__dateFinIscription'] != $this->tournament->dateFinInscription ) {
                    $tournamentRepository = new TournamentRepository();
                    $nomTournoi = strip_tags($_POST['form__editionTour__name']);
                    $exit = $tournamentRepository->nameExistInDB($nomTournoi, 1, $this->message);
                    if ($exit != "" && $nomTournoi != $this->tournament->nom) {
                        $this->message = "<h1>Un tournoi portant ce nom existe déjà !</h1>";
                    } else {
                        $this->tournament->nom = $nomTournoi;
                        if (is_numeric($_POST['form__editionTour__sport'])) {
                            $this->tournament->id_sport = $_POST['form__editionTour__sport'];
                            if (is_numeric($_POST['form__editionTour__nbplaceDispo'])) {
                                $this->tournament->placesDispo = $_POST['form__editionTour__nbplaceDispo'];
                                if (DateTime::createFromFormat("Y-m-d", $_POST['form__editionTour__dateFinTour'])) {
                                    $this->tournament->dateTournoi = $_POST['form__editionTour__dateFinTour'];
                                    if (DateTime::createFromFormat("Y-m-d", $_POST['form__editionTour__dateFinIscription'])) {
                                        $this->tournament->dateFinInscription = $_POST['form__editionTour__dateFinIscription'];
                                        $this->tournament->id_organisateur = $_SESSION['id_utilisateur'];
                                    } else {
                                        $this->message = "<h1>Valeur inconnue pour la date de fin des inscriptions</h1>";
                                    }
                                } else {
                                    $this->message = "<h1>Valeur inconnue pour la date du tournoi.</h1>";
                                }
                            } else {
                                $this->message = "<h1>Valeur inconnue pour le nombre de places disponnibles.</h1>";
                            }
                        } else {
                            $this->message = "<h1>Valeur inconnue pour le sport.</h1>";
                        }
                        $tournamentRepository->updateTournament($this->tournament->nom, $this->tournament->id_sport, $this->tournament->placesDispo, $this->tournament->dateTournoi, $this->tournament->dateFinInscription, $this->tournament->id_organisateur, $this->tournament->id_tournoi, $this->message);
                    }
                } else {
                    $this->message = "<h1>Aucune modification apportée !</h1>";
                }
            } else {
                $this->message = "<h1>Nom du tournoi manquant</h1>";
            }
        }
    }

    public function get_message() {
        return $this->message;
    }

    public function get_tournament() {
        return $this->tournament;
    }
}