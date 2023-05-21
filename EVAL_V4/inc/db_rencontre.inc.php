<?php
namespace Rencontre;
require_once 'db_link.inc.php';

use DBLink;
use PDO;
class MyRencontre {
    public $id_rencontre;
    public $id_tournoi;
    public $id_joueurUn;
    public $id_joueurDeux;
    public $score_joueurUn;
    public $score_joueurDeux;
    public $id_vainqueur;
    public $id_rencontreSuivante;

    public static function DBRencontre($row) {
        $rencontre = new MyRencontre();
        $rencontre->id_rencontre = $row['id_rencontre'];
        $rencontre->id_tournoi = $row['id_tournoi'];
        $rencontre->id_joueurUn = $row['id_joueurUn'];
        $rencontre->id_joueurDeux = $row['id_joueurDeux'];
        $rencontre->score_joueurUn = $row['score_joueurUn'];
        $rencontre->score_joueurDeux = $row['score_joueurDeux'];
        $rencontre->id_vainqueur = $row['id_vainqueur'];
        $rencontre->id_rencontreSuivante = $row['id_rencontreSuivante'];
        return $rencontre;
    }
}

class RencontreRepository {

    public function rencontreExistInDB($id_rencontre, &$message) {
        $result = false;
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Rencontre WHERE id_rencontre = :id_rencontre");
            $stmt->bindParam(':id_rencontre', $id_rencontre);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "nom\nom");
            if ($stmt->execute()){
                if($stmt->fetch() !== NULL){
                    $result = true;
                }
            } else {
                $message .= "Rencontre inexistante";
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public static function getRencontreTournament($id_tournoi, &$message) {
        $result = [];
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Rencontre WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "rencontre\rencontre");
            $stmt->execute();
            while($row = $stmt->fetch()){
                array_push($result, MyRencontre::DBRencontre($row));
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public static function getIdJoueurUn($id_rencontre, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT id_joueurUn FROM Rencontre WHERE id_rencontre = :id_rencontre");
            $stmt->bindParam(':id_rencontre', $id_rencontre);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_joueurUn\id_joueurUn");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_joueurUn"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public static function getIdJoueurDeux($id_rencontre, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT id_joueurDeux FROM Rencontre WHERE id_rencontre = :id_rencontre");
            $stmt->bindParam(':id_rencontre', $id_rencontre);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_joueurDeux\id_joueurDeux");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_joueurDeux"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public static function getScoreJoueurUn($id_rencontre, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT score_joueurUn FROM Rencontre WHERE id_rencontre = :id_rencontre");
            $stmt->bindParam(':id_rencontre', $id_rencontre);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "score_joueurUn\score_joueurUn");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["score_joueurUn"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public static function getScoreJoueurDeux($id_rencontre, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT score_joueurDeux FROM Rencontre WHERE id_rencontre = :id_rencontre");
            $stmt->bindParam(':id_rencontre', $id_rencontre);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "score_joueurDeux\score_joueurDeux");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["score_joueurDeux"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public static function getVainqueur($id_rencontre, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT id_vainqueur FROM Rencontre WHERE id_rencontre = :id_rencontre");
            $stmt->bindParam(':id_rencontre', $id_rencontre);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_vainqueur\id_vainqueur");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_vainqueur"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function updateRencontre($score_joueurUn, $score_joueurDeux, $id_rencontre, &$message) {
        $result = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare( "UPDATE Rencontre SET score_joueurUn = :score_joueurUn, score_joueurDeux = :score_joueurDeux WHERE id_rencontre = :id_rencontre ");
            $stmt->bindValue(':score_joueurUn', $score_joueurUn, PDO::PARAM_INT);
            $stmt->bindValue(':score_joueurDeux', $score_joueurDeux, PDO::PARAM_INT);
            $stmt->bindValue(':id_rencontre', $id_rencontre, PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() == 1){
                $message .= "Le score a  été modifié avec succès !" ;
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

    public function updateVainqueur($id_vainqueur, $id_rencontre, $message) {
        $result = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare( "UPDATE Rencontre SET id_vainqueur = :id_vainqueur WHERE id_rencontre = :id_rencontre");
            $stmt->bindValue(':id_vainqueur', $id_vainqueur, PDO::PARAM_INT);
            $stmt->bindValue(':id_rencontre', $id_rencontre, PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() == 1){
                $message .= "Le vainqueur a été désigné avec succès !" ;
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

    public function addRencontre($id_rencontre, $id_tournoi, &$message) {
        $result = false;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB,$message);
            $stmt = $bdd->prepare("INSERT INTO Rencontre (id_rencontre, id_tournoi) VALUES (:id_rencontre, :id_tournoi)");
            $stmt->bindValue(':id_rencontre', $id_rencontre, PDO::PARAM_INT);
            $stmt->bindValue(':id_tournoi', $id_tournoi, PDO::PARAM_INT);
            if($stmt->execute() && $stmt->rowCount() == 1) {
                $result = true;
                $message = "<h1>Rencontre ajoutée</h1>";
            } else {
                $message = "<h1>Erreur !</h1>";
            }
        }catch (Exception $e) {
            $message .=$e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function updatePlayerOne($id_rencontre, $id_tournoi, $id_joueurUn, $score_joueurUn, &$message) {
        $result = false;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB,$message);
            $stmt = $bdd->prepare("UPDATE Rencontre SET id_joueurUn = :id_joueurUn, score_joueurUn = :score_joueurUn WHERE id_rencontre = :id_rencontre AND id_tournoi = :id_tournoi");
            $stmt->bindValue(':id_joueurUn', $id_joueurUn, PDO::PARAM_INT);
            $stmt->bindValue(':score_joueurUn', $score_joueurUn, PDO::PARAM_INT);
            $stmt->bindValue(':id_rencontre', $id_rencontre, PDO::PARAM_INT);
            $stmt->bindValue(':id_tournoi', $id_tournoi, PDO::PARAM_INT);
            if($stmt->execute() && $stmt->rowCount() == 1) {
                $result = true;
                $message = "<h1>Joueur 1 ajouté</h1>";
            } else {
                $message = "<h1>Erreur !</h1>";
            }
        }catch (Exception $e) {
            $message .=$e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getMaxIdRencontre(&$message) {
        $result = false;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB,$message);
            $stmt = $bdd->prepare("SELECT MAX(id_rencontre) AS id_rencontre FROM Rencontre");
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_rencontre\id_rencontre");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_rencontre"];
            }
            $stmt = null;
        }catch (Exception $e) {
            $message .=$e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function updatePlayerTwo($id_rencontre, $id_tournoi, $id_joueurDeux, $score_joueurDeux, &$message) {
        $result = false;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB,$message);
            $stmt = $bdd->prepare("UPDATE Rencontre SET id_joueurDeux = :id_joueurDeux, score_joueurDeux = :score_joueurDeux WHERE id_rencontre = :id_rencontre AND id_tournoi = :id_tournoi");
            $stmt->bindValue(':id_joueurDeux', $id_joueurDeux, PDO::PARAM_INT);
            $stmt->bindValue(':score_joueurDeux', $score_joueurDeux, PDO::PARAM_INT);
            $stmt->bindValue(':id_rencontre', $id_rencontre, PDO::PARAM_INT);
            $stmt->bindValue(':id_tournoi', $id_tournoi, PDO::PARAM_INT);
            if($stmt->execute() && $stmt->rowCount() == 1) {
                $result = true;
                $message = "<h1>Joueur 1 ajouté</h1>";
            } else {
                $message = "<h1>Erreur !</h1>";
            }
        }catch (Exception $e) {
            $message .=$e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getScorePlayerOne($id_rencontre, $id_tournoi, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT score_joueurUn FROM Rencontre WHERE id_rencontre = :id_rencontre AND id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_rencontre', $id_rencontre);
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "score_joueurUn\score_joueurUn");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["score_joueurUn"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getScorePlayerTwo($id_rencontre, $id_tournoi, &$message)
    {
        $result = "";
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT score_joueurDeux FROM Rencontre WHERE id_rencontre = :id_rencontre AND id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_rencontre', $id_rencontre);
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "score_joueurDeux\score_joueurDeux");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["score_joueurDeux"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getPlayerOne($id_rencontre, $id_tournoi, &$message)
    {
        $result = "";
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT id_joueurUn FROM Rencontre WHERE id_rencontre = :id_rencontre AND id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_rencontre', $id_rencontre);
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_joueurUn\id_joueurUn");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_joueurUn"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }
    public function getPlayerTwo($id_rencontre, $id_tournoi, &$message)
    {
        $result = "";
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT id_joueurDeux FROM Rencontre WHERE id_rencontre = :id_rencontre AND id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_rencontre', $id_rencontre);
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_joueurDeux\id_joueurDeux");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_joueurDeux"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function updateRencontresuivante($id_rencontre, $id_tournoi, $id_rencontreSuivante, &$message) {
        $result = false;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB,$message);
            $stmt = $bdd->prepare("UPDATE Rencontre SET id_rencontreSuivante = :id_rencontreSuivante WHERE id_rencontre = :id_rencontre AND id_tournoi = :id_tournoi");
            $stmt->bindValue(':id_rencontreSuivante', $id_rencontreSuivante, PDO::PARAM_INT);
            $stmt->bindValue(':id_rencontre', $id_rencontre, PDO::PARAM_INT);
            $stmt->bindValue(':id_tournoi', $id_tournoi, PDO::PARAM_INT);
            if($stmt->execute() && $stmt->rowCount() == 1) {
                $result = true;
                $message = "<h1>Rencontre suivante ajoutée</h1>";
            } else {
                $message = "<h1>Erreur !</h1>";
            }
        }catch (Exception $e) {
            $message .=$e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function deleteTree($id_tournoi, &$message)
    {
        $result = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("DELETE FROM Rencontre WHERE id_tournoi = :id_tournoi");
            $stmt->bindParam(':id_tournoi', $id_tournoi);
            if ($stmt->execute()){
                $result = true;
                $message .= "L'arbre a été supprimé avec succès !" ;
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

}