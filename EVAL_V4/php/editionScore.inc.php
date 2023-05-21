<?php
require_once 'inc/db_user.inc.php';
require_once 'inc/db_tournoi.inc.php';
require_once 'inc/db_rencontre.inc.php';

use User\UserRepository;
use Rencontre\MyRencontre;
use Rencontre\RencontreRepository;
use Tournoi\TournamentRepository;

class EditionScore
{
    private $message;
    private $rencontre;
    private $userRepository;
    private $exist;
    private $tournamentRepository;

    public function __construct() {
        $rencontreRepository = new RencontreRepository();
        $this->userRepository = new UserRepository();
        $this->rencontre = new MyRencontre();
        $this->tournamentRepository = new TournamentRepository();

        if (isset($_GET['id_tournoi']) && is_numeric($_GET['id_tournoi']) || isset($_POST['id_tournoi'])) {
            $this->rencontre->id_tournoi = (isset($_GET['id_tournoi'])) ? $_GET['id_tournoi'] : $_POST['id_tournoi'];
        }

        if (isset($_GET['id_rencontre']) && is_numeric($_GET['id_rencontre']) || isset($_POST['id_rencontre'])) {
            $this->rencontre->id_rencontre = (isset($_GET['id_rencontre'])) ? $_GET['id_rencontre'] : $_POST['id_rencontre'];
            $this->exist = $rencontreRepository->rencontreExistInDB($this->rencontre->id_rencontre, $this->message);
        }

        if ($this->exist) {
            $this->rencontre->id_joueurUn = $rencontreRepository->getIdJoueurUn($this->rencontre->id_rencontre, $this->message);
            $this->rencontre->id_joueurDeux = $rencontreRepository->getIdJoueurDeux($this->rencontre->id_rencontre, $this->message);
            $this->rencontre->score_joueurUn = $rencontreRepository->getScoreJoueurUn($this->rencontre->id_rencontre, $this->message);
            $this->rencontre->score_joueurDeux = $rencontreRepository->getScoreJoueurDeux($this->rencontre->id_rencontre, $this->message);
            $this->rencontre->id_vainqueur = $rencontreRepository->getVainqueur($this->rencontre->id_rencontre, $this->message);
        }
    }

    public function editerScore() {
            if (is_numeric($_POST['form__editionScoreJ1']) && is_numeric($_POST['form__editionScoreJ2'])) {
                if ($_POST['form__editionScoreJ1'] != $this->rencontre->score_joueurUn || $_POST['form__editionScoreJ2'] != $this->rencontre->score_joueurDeux) {
                    $rencontreRepository = new RencontreRepository();
                    $this->rencontre->score_joueurUn = filter_input(INPUT_POST, 'form__editionScoreJ1', FILTER_SANITIZE_NUMBER_INT);
                    $this->rencontre->score_joueurDeux = filter_input(INPUT_POST, 'form__editionScoreJ2', FILTER_SANITIZE_NUMBER_INT);

                    $rencontreRepository->updateRencontre($this->rencontre->score_joueurUn, $this->rencontre->score_joueurDeux,$this->rencontre->id_rencontre, $this->message);
                }
                else {
                    $this->message = "<h1>Aucune modification apportée !</h1>";
                }
            } else {
                $this->message = "<h1>Les données saisies ne sont pas conformes !</h1>";
            }
    }

    public function validerVainqueur($id_joueur) {
        if (($id_joueur == $this->rencontre->id_joueurUn) || ($id_joueur == $this->rencontre->id_joueurDeux)) {
            $rencontreRepository = new RencontreRepository();
            $rencontreRepository->updateVainqueur($id_joueur, $this->rencontre->id_rencontre, $this->message);
            $this->tournamentRepository->updateStatutTournament(5, $this->rencontre->id_tournoi, $this->message);
        } else {
            $this->message = "<h1>Joueur inconnu !</h1>";
        }
    }


    public function get_message() {
        return $this->message;
    }

    public function get_rencontre() {
        return $this->rencontre;
    }

    public function get_userRepository() {
        return $this->userRepository;
    }

    public function get_tournamentRepository() {
        return $this->tournamentRepository;
    }

}
