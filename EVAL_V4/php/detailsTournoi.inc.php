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

class DetailsTournoi
{
    private $message;
    private $tournament;
    private $rencontre;
    private $userRepository;
    private $participationRepository;
    private $statutRepository;
    private $sportRepository;
    private $rencontreRepository;

    public function __construct() {
        $this->message = "";
        $tournamentRepository = new TournamentRepository();
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
            $exists = $tournamentRepository->tournamentExistInDB($this->tournament->id_tournoi, $this->message);
        }
        if ($exists) {
            $this->rencontre = $this->rencontreRepository->getRencontreTournament($this->tournament->id_tournoi, $this->message);
            $this->tournament->nom = $tournamentRepository->getNom($this->tournament->id_tournoi, $this->message);
            $this->tournament->dateTournoi = $tournamentRepository->getDateTournoi($this->tournament->id_tournoi, $this->message);
            $this->tournament->dateFinInscription = $tournamentRepository->getDateFinInscription($this->tournament->id_tournoi, $this->message);
            $this->tournament->placesDispo = $tournamentRepository->getPlacesDispo($this->tournament->id_tournoi, $this->message);
            $this->tournament->statut = $tournamentRepository->getIdStatut($this->tournament->id_tournoi, $this->message);
            $this->tournament->id_organisateur = $tournamentRepository->getOrganisateur($this->tournament->id_tournoi, $this->message);
        } else {
            $this->message = "<h1>Ce tournoi n'existe pas !</h1>";
        }
    }

    public function genererRencontres(){
        $participationRepository = new ParticipationRepository();

        //1. Calculer le nombre de participants à un tournoi
        $nombreParticipations = $participationRepository->getNumberParticipationByTournamentId($this->tournament->id_tournoi, $this->message);

        //2. Calculer ensuite l’indice « y » : y = arrondi_supérieur(log2(x)),
        // a. y = nombre de tours dans le tournoi
        $nombreTours = ceil(log($nombreParticipations, 2));

        //b. 2y-1 = nombre de rencontres du tournoi. On attribuera aux rencontres un id évoluant de 1 à 2y-1
        $nombreRencontres = pow(2, $nombreTours) - 1;

        //c. 2^(y-1)/2^n = le nombre de rencontres dans le tour correspondant à n (n évoluant de 1 à y)
        $rencontresParTour = array();
        for ($n = 1; $n <= $nombreTours; $n++) {
            $rencontresParTour[] = pow(2, ($nombreTours - $n));
        }

        //3. Pour le premier tour (n=1), attribuer un joueur pour toutes les rencontres (au choix : ordre alphabétique, ordre d’inscription...)
        $participations = $participationRepository->getParticipationByTournamentId($this->tournament->id_tournoi, $this->message);
        if (!isset($participations) || count($participations) < 2) {
            $this->message = "<h1>>Nombre de participants trop faible !</h1>";
        } else {
            $maxIdRencontre = $this->rencontreRepository->getMaxIdRencontre($this->message);
            shuffle($participations); // mélanger les participants
            for ($i = $maxIdRencontre + 1; $i < $rencontresParTour[0] + $maxIdRencontre + 1; $i++) {
                $j = 0;
                //Créer une rencontre
                $this->rencontreRepository->addRencontre($i, $this->tournament->id_tournoi, $this->message);
                //Update JoueurUn
                $idJoueurUn = $participations[$j]->id_utilisateur;
                $this->rencontreRepository->updatePlayerOne($i, $this->tournament->id_tournoi, $idJoueurUn, $this->message);
                $j++;
            }
            //On supprime les noms de joueurs utilisés.
            array_splice($participations, 0, $rencontresParTour[0]);

            //Affecter joueur deux
            for ($i = $maxIdRencontre + 1; $i < $rencontresParTour[0] + $maxIdRencontre + 1; $i++) {
                $j = 0;
                //Update JoueurDeux
                $idJoueurDeux = isset($participations[$j]->id_utilisateur) ? $participations[$j]->id_utilisateur : null;
                $this->rencontreRepository->updatePlayerTwo($i, $this->tournament->id_tournoi, $idJoueurDeux, $this->message);
                $j++;
            }

            //4. Prévoir les rencontres suivantes pour le vainqueur de chaque rencontre actuelle
            for ($i = $maxIdRencontre + 1; $i < $rencontresParTour[0] + $maxIdRencontre + 1; $i++) {
                //Update score
                if ($this->rencontreRepository->getPlayerTwo($i, $this->tournament->id_tournoi, $this->message) == null) {
                    $this->rencontreRepository->updateVainqueur($this->rencontreRepository->getPlayerOne($i, $this->tournament->id_tournoi, $this->message), $i, $this->message);
                } elseif ($this->rencontreRepository->getScorePlayerOne($i, $this->tournament->id_tournoi, $this->message) != null && $this->rencontreRepository->getScorePlayerTwo($i, $this->tournament->id_tournoi, $this->message) != null) {
                    $this->rencontreRepository->getScorePlayerOne($i, $this->tournament->id_tournoi, $this->message) > $this->rencontreRepository->getScorePlayerTwo($i, $this->tournament->id_tournoi, $this->message) ?
                        $this->rencontreRepository->updateVainqueur($this->rencontreRepository->getPlayerOne($i, $this->tournament->id_tournoi, $this->message), $i, $this->message) :
                        $this->rencontreRepository->updateVainqueur($this->rencontreRepository->getPlayerTwo($i, $this->tournament->id_tournoi, $this->message), $i, $this->message);
                }
                if ($nombreRencontres == 1) {

                } else {
                    $id_rencontreSuivante = ceil(($i / 2) + pow(2, $nombreTours - 1));
                    $this->rencontreRepository->addRencontre($id_rencontreSuivante, $this->tournament->id_tournoi, $this->message);
                    $this->rencontreRepository->updateRencontresuivante($i, $this->tournament->id_tournoi, $id_rencontreSuivante, $this->message);
                }
            }
            $tournamentRepository = new TournamentRepository();
            $tournamentRepository->updateStatutTournament(4, $this->tournament->id_tournoi, $this->message);
        }
    }

    public function cloturerTournoi() {
        $tournamentRepository = new TournamentRepository();
        $tournamentRepository->updateStatutTournament(3, $this->tournament->id_tournoi, $this->message);
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
