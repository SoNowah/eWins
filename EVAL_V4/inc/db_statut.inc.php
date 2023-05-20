<?php
namespace Statut;
require_once 'db_link.inc.php';

use DBLink;
use PDO;
class MyStatut {
    public $id_statut;
    public $nom;
}

class StatutRepository {

    public function getStatutByTournamentId($id_tournoi, &$message) {
        $result = "";
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT s.nom FROM Statut s JOIN Tournoi t ON s.id_statut = t.statut WHERE t.id_tournoi = ?");
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

    public function getStatutIdByTournamentId($id_tournoi, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT s.id_statut FROM Statut s JOIN Tournoi t ON s.id_statut = t.statut WHERE t.id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_statut\id_statut");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_statut"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }
}