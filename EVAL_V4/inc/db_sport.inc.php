<?php
namespace Sport;
require_once 'db_link.inc.php';

use DBLink;
use PDO;
class MySport {
    public $id_sport;
    public $nom;
}

class SportRepository {

    public function getSportByTournamentId($id_tournoi, &$message) {
        $result = "";
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT s.nom FROM Sport s JOIN Tournoi t ON s.id_sport = t.id_sport WHERE t.id_tournoi = ?");
            $stmt->bindParam(1, $id_tournoi, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $result .= $row["nom"] . "\n";
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getSportIdByTournamentId($id_tournoi, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT s.id_sport FROM Sport s JOIN Tournoi t ON s.id_sport = t.id_sport WHERE t.id_tournoi = :id_tournoi");
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
}