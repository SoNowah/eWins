<?php
namespace Participer;
require_once 'db_link.inc.php';

use DBLink;
use PDO;
class MyParticipation {
    public $id_utilisateur;
    public $id_tournoi;
    public $dateInscription;

    public static function DBPartciper($row) {
        $participation = new MyParticipation();
        $participation->id_utilisateur = $row['id_utilisateur'];
        $participation->id_tournoi = $row['id_tournoi'];
        $participation->dateInscription = $row['dateInscription'];
        return $participation;
    }

}

class ParticipationRepository {

    function getNumberParticipationByTournamentId($id_tournoi, &$message) {
        $result = null;
        $bdd = null;
        try {
            $message = "";
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT COUNT(*) FROM Participer WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(":id_tournoi", $id_tournoi);
            if ($stmt->execute()) {
                $result = $stmt->fetchColumn();
            } else {
                $message = 'Erreur !';
            }

        } catch (Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    function getParticipationByUserId($id_utilisateur, &$message) {
        $participations = [];
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Participer p JOIN Tournoi t ON p.id_tournoi = t.id_tournoi WHERE p.id_utilisateur = :id_utilisateur ORDER BY t.dateTournoi ASC");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "participe\participe");
            $stmt->execute();
            while($row = $stmt->fetch()){
                array_push($participations, MyParticipation::DBPartciper($row));
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '';
        }
        DBLink::disconnect($bdd);
        return $participations;
    }

    function getParticipationByTournamentId($id_tournoi, &$message) {
        $participations = [];
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Participer WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "participe\participe");
            $stmt->execute();
            while($row = $stmt->fetch()){
                array_push($participations, MyParticipation::DBPartciper($row));
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '';
        }
        DBLink::disconnect($bdd);
        return $participations;
    }

    function getParticipationByUserIdAndSportId($id_utilisateur, $id_sport ,&$message) {
        $participations = [];
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Participer p JOIN Tournoi t ON p.id_tournoi = t.id_tournoi WHERE p.id_utilisateur = :id_utilisateur AND t.id_sport = :id_sport ORDER BY t.dateTournoi ASC");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->bindParam(':id_sport', $id_sport);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "participe\participe");
            $stmt->execute();
            while($row = $stmt->fetch()){
                array_push($participations, MyParticipation::DBPartciper($row));
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '';
        }
        DBLink::disconnect($bdd);
        return $participations;
    }

    function getParticipationByUserIdAndStatutId($id_utilisateur, $id_statut ,&$message) {
        $participations = [];
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Participer p JOIN Tournoi t ON p.id_tournoi = t.id_tournoi WHERE p.id_utilisateur = :id_utilisateur AND t.statut = :id_statut ORDER BY t.dateTournoi ASC");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->bindParam(':id_statut', $id_statut);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "participe\participe");
            $stmt->execute();
            while($row = $stmt->fetch()){
                array_push($participations, MyParticipation::DBPartciper($row));
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '';
        }
        DBLink::disconnect($bdd);
        return $participations;
    }

    function getParticipationByUserIdAndStatutIdAndBySportId($id_utilisateur, $id_statut, $id_sport,&$message) {
        $participations = [];
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Participer p JOIN Tournoi t ON p.id_tournoi = t.id_tournoi WHERE p.id_utilisateur = :id_utilisateur AND t.statut = :id_statut AND t.id_sport = :id_sport ORDER BY t.dateTournoi ASC");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->bindParam(':id_statut', $id_statut);
            $stmt->bindParam(':id_sport', $id_sport);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "participe\participe");
            $stmt->execute();
            while($row = $stmt->fetch()){
                array_push($participations, MyParticipation::DBPartciper($row));
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '';
        }
        DBLink::disconnect($bdd);
        return $participations;
    }

    function addParticipation($id_utilisateur, $id_tournoi, &$message) {
        $result = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("INSERT INTO Participer (id_utilisateur, id_tournoi, dateInscription) VALUES (:id_utilisateur, :id_tournoi, :dateInscription)");
            $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            $stmt->bindValue(':id_tournoi', $id_tournoi, PDO::PARAM_INT);
            $date = date('Y-m-d');
            $stmt->bindValue(':dateInscription', $date);
            if ($stmt->execute() && $stmt->rowCount() == 1){
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

    function getParticipationTrueFalse($id_utilisateur, $id_tournoi, &$message) {
        $result = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Participer WHERE id_utilisateur = :id_utilisateur AND id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            if ($stmt->execute() && $stmt->rowCount() > 0){
                $result = true;
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    function deleteUser($id_utilisateur, $id_tournoi, &$message) {
        $result = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("DELETE FROM Participer WHERE id_utilisateur = :id_utilisateur AND id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            if ($stmt->execute()){
                $result = true;
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }
}