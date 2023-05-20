<?php
require_once 'inc/db_user.inc.php';
require 'inc/db_tournoi.inc.php';
require_once 'inc/db_participer.inc.php';

use User\UserRepository;
use Tournoi\TournamentRepository;
use Tournoi\MyTournament;
use Participer\ParticipationRepository;

class CreerTournoi
{
    private $message;

    public function creationTournoi()
    {
        if (isset($_POST['form__button__submit'])) {
            $tournamentRepository = new TournamentRepository();
            $participationRepository = new ParticipationRepository();
            if (isset($_POST['form__creationTour__name']) && !empty(trim($_POST['form__creationTour__name']))) {
                if (isset($_POST['form__creationTour__sport']) && !empty(trim($_POST['form__creationTour__sport']))) {
                    if (isset($_POST['form__creationTour__dateTour']) && !empty(trim($_POST['form__creationTour__dateTour']))) {
                        if (isset($_POST['form__creationTour__dateTourFin']) && !empty(trim($_POST['form__creationTour__dateTourFin']))) {
                            $tournament = new MyTournament();
                            $tournament->nom = strip_tags(trim($_POST['form__creationTour__name']));
                            $exist = $tournamentRepository->nameExistInDB($tournament->nom, 1, $this->message);
                            if ($exist != "") {
                                $this->message = "<h1>Un tournoi portant ce nom existe déjà !</h1>";
                            } else {
                                if (is_numeric($_POST['form__creationTour__sport'])) {
                                    $tournament->id_sport = $_POST['form__creationTour__sport'];
                                    if (is_numeric($_POST['form__creationTour__nbPlaceDispo'])) {
                                        $tournament->placesDispo = $_POST['form__creationTour__nbPlaceDispo'];
                                        if (DateTime::createFromFormat("Y-m-d", $_POST['form__creationTour__dateTour'])) {
                                            $tournament->dateTournoi = $_POST['form__creationTour__dateTour'];
                                            if (DateTime::createFromFormat("Y-m-d", $_POST['form__creationTour__dateTourFin'])) {
                                                $tournament->dateFinInscription = $_POST['form__creationTour__dateTourFin'];
                                                $tournament->id_organisateur = $_SESSION['id_utilisateur'];
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
                                if ($tournament->placesDispo < 2) {
                                    $this->message = "<h1>Le nombre de places ne peut pas être inférieur à 2 !</h1>";
                                } elseif ($tournament->dateTournoi < $tournament->dateFinInscription) {
                                    $this->message = "<h1>La date du tournoi ne peut pas être inférieur à la date de fin des inscriptions !</h1>";
                                } elseif ($tournament->dateFinInscription < date("Y-m-d")) {
                                    $this->message = "<h1>La date de fin des inscriptions ne peut pas être inférieur à la date du jour!</h1>";
                                } else {
                                    $result = $tournamentRepository->createTournament($tournament->nom, $tournament->id_sport, $tournament->placesDispo, 1, $tournament->dateTournoi, $tournament->dateFinInscription, 1, $tournament->id_organisateur, $this->message);
                                    if ($result) {
                                        $this->message = "<h1>Tournoi créé avec succès !</h1>";
                                        $tournament->id_tournoi = $tournamentRepository->getId($tournament->nom, $tournament->id_sport, $tournament->id_organisateur, $this->message);
                                        $participationRepository->addParticipation($tournament->id_organisateur, $tournament->id_tournoi, $this->message);
                                    }
                                }
                            }
                        } else {
                            $this->message = "<h1>Aucune date de fin d'inscription spécifiée !</h1>";
                        }
                    } else {
                        $this->message = "<h1>Aucune date de tournoi spécifiée !</h1>";
                    }
                } else {
                    $this->message = "<h1>Aucun sport spécifié !</h1>";
                    }
                } else {
                    $this->message = "<h1>Aucun nom de tournoi spécifié</h1>";
            }
        }
    }

    public function get_message() {
    return $this->message;
    }
}

       