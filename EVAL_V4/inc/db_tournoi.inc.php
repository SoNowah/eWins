<?php
namespace Tournoi;
require_once 'db_link.inc.php';

use DBLink;
use PDO;
class MyTournament {
    public $id_tournoi;
    public $nom;
    public $id_sport;
    public $placesDispo;
    public $statut;
    public $dateTournoi;
    public $dateFinInscription;
    public $estActif;
    public $id_organisateur;

    public static function DBTournoi($row) {
        $tournament = new MyTournament();
        $tournament->id_tournoi = $row['id_tournoi'];
        $tournament->nom = $row['nom'];
        $tournament->id_sport = $row['id_sport'];
        $tournament->placesDispo = $row['placesDisponnibles'];
        $tournament->statut = $row['statut'];
        $tournament->dateTournoi = $row['dateTournoi'];
        $tournament->dateFinInscription = $row['dateFinInscription'];
        $tournament->estActif = $row['estActif'];
        $tournament->id_organisateur = $row['id_organisateur'];
        return $tournament;
    }
}

class TournamentRepository {

    public function getNom($id_tournoi, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT nom FROM Tournoi WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "nom\nom");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["nom"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getDateTournoi($id_tournoi, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT dateTournoi FROM Tournoi WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "dateTournoi\dateTournoi");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["dateTournoi"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getDateFinInscription($id_tournoi, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT dateFinInscription FROM Tournoi WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "dateFinInscription\dateFinInscription");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["dateFinInscription"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getPlacesDispo($id_tournoi, &$message) {
        $result = null;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT placesDisponnibles FROM Tournoi WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "placesDisponnibles\placesDisponnibles");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["placesDisponnibles"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getEstActif($id_tournoi, &$message) {
        $result = null;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT estActif FROM Tournoi WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "estActif\estActif");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["estActif"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getOrganisateur($id_tournoi, &$message) {
        $result = null;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT id_organisateur FROM Tournoi WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_organisateur\id_organisateur");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_organisateur"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getId($nom, $id_sport, $id_organisateur, &$message) {
        $result = "";
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT id_tournoi FROM Tournoi WHERE nom = :nom AND id_sport = :id_sport AND id_organisateur = :id_organisateur");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':id_sport', $id_sport);
            $stmt->bindParam(':id_organisateur', $id_organisateur);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_tournoi\id_tournoi");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_tournoi"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getIdSport($id_tournoi, &$message) {
        $result = null;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT id_sport FROM Tournoi WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_sport\id_sport");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_sport"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getIdStatut($id_tournoi, &$message) {
        $result = null;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT statut FROM Tournoi WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "statut\statut");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["statut"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getTournamentByIdActif($id_tournoi, $estActif, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT estActif FROM Tournoi WHERE id_tournoi = :id_tournoi AND estActif = :estActif");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->bindParam(':estActif', $estActif);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "estActif\estActif");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["estActif"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function createTournament($nom, $id_sport, $placesDispo, $statut, $dateTournoi, $dateFinInscription, $estActif, $id_organisateur, &$message) {
        $result = false;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("INSERT INTO Tournoi (nom, id_sport, placesDisponnibles, statut, dateTournoi, dateFinInscription, estActif, id_organisateur) VALUES (:nom, :id_sport, :placesDisponnibles, :statut, :dateTournoi, :dateFinInscription, :estActif, :id_organisateur)");
            $stmt->bindValue(':nom', $nom);
            $stmt->bindValue(':id_sport', $id_sport, PDO::PARAM_INT);
            $stmt->bindValue(':placesDisponnibles', $placesDispo, PDO::PARAM_INT);
            $stmt->bindValue(':statut', $statut, PDO::PARAM_INT);
            $stmt->bindValue(':dateTournoi', $dateTournoi);
            $stmt->bindValue(':dateFinInscription', $dateFinInscription);
            $stmt->bindValue(':estActif', $estActif, PDO::PARAM_INT);
            $stmt->bindValue(':id_organisateur', $id_organisateur, PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() == 1){
                $message .= "Tournoi créé avec succès !" ;
                $result = true;
            } else {
                $message .=  "Erreur !";
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function deleteTournament($id_tournoi, &$message) {
        $result = false;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare( "UPDATE Tournoi SET estActif = 0 WHERE id_tournoi = :id_tournoi ");
            $stmt->bindValue(':id_tournoi', $id_tournoi, PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() == 1){
                $message .= "Le tournoi a  été modifié avec succès !" ;
                $result = true;
            } else {
                $message .= "Erreur !";
            }
            $stmt = null;
        }catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function nameExistInDB($nom, $estActif, &$message){
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT id_tournoi FROM Tournoi WHERE nom = :nom AND estActif = :estActif");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':estActif', $estActif);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_tournoi\id_tournoi");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_tournoi"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function tournamentExistInDB($id_tournoi, &$message) {
        $result = false;
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Tournoi WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "nom\nom");
            if ($stmt->execute()){
                if($stmt->fetch() !== NULL){
                    $result = true;
                }
            } else {
                $message .= "Tournoi inexistant";
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function updateTournament($nom, $id_sport, $placesDispo, $dateTournoi, $dateFinInscription, $id_organisateur, $id_tournoi, &$message) {
        $result = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare( "UPDATE Tournoi SET nom = :nom, id_sport = :id_sport, placesDisponnibles = :placesDispo, dateTournoi = :dateTournoi, dateFinInscription = :dateFinInscription, id_organisateur = :id_organisateur WHERE id_tournoi = :id_tournoi ");
            $stmt->bindValue(':nom', $nom);
            $stmt->bindValue(':id_sport', $id_sport, PDO::PARAM_INT);
            $stmt->bindValue(':placesDispo', $placesDispo, PDO::PARAM_INT);
            $stmt->bindValue(':dateTournoi', $dateTournoi);
            $stmt->bindValue(':dateFinInscription', $dateFinInscription);
            $stmt->bindValue(':id_organisateur', $id_organisateur, PDO::PARAM_INT);
            $stmt->bindValue(':id_tournoi', $id_tournoi, PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() == 1){
                $message .= "Le tournoi a  été modifié avec succès !" ;
                $result = true;
            } else {
                $message .= "Erreur !";
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function updateStatutTournament($statut, $id_tournoi, &$message) {
        $result = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare( "UPDATE Tournoi SET statut = :statut WHERE id_tournoi = :id_tournoi ");
            $stmt->bindValue(':statut', $statut, PDO::PARAM_INT);
            $stmt->bindValue(':id_tournoi', $id_tournoi, PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() == 1){
                $message .= "Le tournoi a  été modifié avec succès !" ;
                $result = true;
            } else {
                $message .= "Erreur !";
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    function getAllTournament(&$message) {
        $participations = [];
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Tournoi WHERE estActif = 1 ORDER BY dateTournoi ASC");
            $stmt->setFetchMode(PDO::FETCH_CLASS, "tournoi\tournoi");
            $stmt->execute();
            while($row = $stmt->fetch()){
                array_push($participations, MyTournament::DBTournoi($row));
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '';
        }
        DBLink::disconnect($bdd);
        return $participations;
    }

    function getAllTournamentBySportId($id_sport, &$message) {
        $participations = [];
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Tournoi  WHERE id_sport = :id_sport AND estActif = 1 ORDER BY dateTournoi ASC");
            $stmt->bindParam(':id_sport', $id_sport);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "tournoi\tournoi");
            $stmt->execute();
            while($row = $stmt->fetch()){
                array_push($participations, MyTournament::DBTournoi($row));
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '';
        }
        DBLink::disconnect($bdd);
        return $participations;
    }

    function getAllTournamentByStatutId($id_statut ,&$message) {
        $participations = [];
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Tournoi WHERE statut = :id_statut AND estActif = 1 ORDER BY dateTournoi ASC");
            $stmt->bindParam(':id_statut', $id_statut);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "tournoi\tournoi");
            $stmt->execute();
            while($row = $stmt->fetch()){
                array_push($participations, MyTournament::DBTournoi($row));
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '';
        }
        DBLink::disconnect($bdd);
        return $participations;
    }

    function getAllTournamentByStatutIdAndBySportId($id_statut, $id_sport,&$message) {
        $participations = [];
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Tournoi WHERE statut = :id_statut AND id_sport = :id_sport AND estActif = 1 ORDER BY dateTournoi ASC");
            $stmt->bindParam(':id_statut', $id_statut);
            $stmt->bindParam(':id_sport', $id_sport);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "tournoi\tournoi");
            $stmt->execute();
            while($row = $stmt->fetch()){
                array_push($participations, MyTournament::DBTournoi($row));
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '';
        }
        DBLink::disconnect($bdd);
        return $participations;
    }
}