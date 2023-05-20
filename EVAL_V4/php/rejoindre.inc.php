<?php
require_once 'inc/db_tournoi.inc.php';
require_once 'inc/db_user.inc.php';
require_once 'inc/db_participer.inc.php';

use Tournoi\TournamentRepository;
use Tournoi\MyTournament;
use User\MyUser;
use Participer\ParticipationRepository;

class Rejoindre
{
    private $message;
    private $tournament;
    private $user;
    private $exist;

    public function __construct() {
        $this->tournament = new MyTournament();
        $tournamentRepository = new TournamentRepository();
        $this->user = new MyUser();
        $this->exist = false;

        if (isset($_POST['id_tournoi']) && is_numeric($_POST['id_tournoi'])) {
            $this->tournament->id_tournoi = $_POST['id_tournoi'];
            $this->exist = $tournamentRepository->tournamentExistInDB($this->tournament->id_tournoi, $this->message);
        } elseif (isset($_GET['id_tournoi']) && is_numeric($_GET['id_tournoi'])) {
            $this->tournament->id_tournoi = $_GET['id_tournoi'];
            $this->exist = $tournamentRepository->tournamentExistInDB($this->tournament->id_tournoi, $this->message);
        }
        if (!$this->exist) {
            $this->message = "<h1>Tournoi inexistant</h1>";
        } else {
            $this->tournament->nom = $tournamentRepository->getNom($this->tournament->id_tournoi, $this->message);
            $this->user->id_utilisateur = $_SESSION['id_utilisateur'];
        }

    }

    public function joinTournament($tournament) {
        $participeRepository = new ParticipationRepository();
        if ($this->exist) {
            $result = $participeRepository->addParticipation($this->user->id_utilisateur, $this->tournament->id_tournoi, $this->message);
            if ($result) {
                $this->message = "Tournoi rejoin !";
                header("location: detailsTournoi.php?id_tournoi=$tournament->id_tournoi");
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
