<?php
namespace User;
use DBLink;
use Exception;
use PDO;

require_once 'db_link.inc.php';

class MyUser {
    public $id_utilisateur;
    public $courriel;
    public $pseudo;
    public $nom;
    public $prenom;
    public $motDePasse;
    public $estActif;
    public $estOrganisateur;
    public $urlPhoto;
}

class UserRepository {

    public function courrielExistsInDB($courriel, $estActif, &$message){
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT id_utilisateur FROM Utilisateur WHERE courriel = :courriel AND estActif = :estActif");
            $stmt->bindParam(':courriel', $courriel);
            $stmt->bindParam(':estActif', $estActif);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_utilisateur\id_utilisateur");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_utilisateur"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function userExistInDB($id_utilisateur, &$message) {
        $result = false;
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Utilisateur WHERE id_utilisateur = :id_utilisateur");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "nom\nom");
            if ($stmt->execute()){
                if($stmt->fetch() !== NULL){
                    $result = true;
                }
            } else {
                $message .= "Utilisateur inexistant";
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }
    function getUser($mail) {
        $obj = null;
        $bdd = null;
        try {
            $message = "";
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Utilisateur WHERE courriel = :mail");
            $stmt->bindValue(':mail', $mail);
            if ($stmt->execute()) {
                $obj = $stmt->fetchObject("User\\MyUser");
            } else {
                $message .= "Erreur !";
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
        return $obj;
    }

    function getNom($mail, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT nom FROM Utilisateur WHERE courriel = :mail");
            $stmt->bindParam(':mail', $mail);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'nom\nom');
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

    function getNomId($id_utilisateur, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT nom FROM Utilisateur WHERE id_utilisateur = :id_utilisateur");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'nom\nom');
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

    function getCourrielId($id_utilisateur, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT courriel FROM Utilisateur WHERE id_utilisateur = :id_utilisateur");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'courriel\courriel');
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["courriel"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    function getPrenom($mail, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT prenom FROM Utilisateur WHERE courriel = :mail");
            $stmt->bindParam(':mail', $mail);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'prenom\prenom');
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["prenom"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    function getUrlPhoto($mail, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT urlPhoto FROM Utilisateur WHERE courriel = :mail");
            $stmt->bindParam(':mail', $mail);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'urlPhoto\urlPhoto');
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["urlPhoto"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    function getUrlPhotoId($id_utilisateur, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT urlPhoto FROM Utilisateur WHERE id_utilisateur = :id_utilisateur");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'urlPhoto\urlPhoto');
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["urlPhoto"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    function getPrenomId($id_utilisateur, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT prenom FROM Utilisateur WHERE id_utilisateur = :id_utilisateur");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'prenom\prenom');
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["prenom"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function getPseudoId($id_utilisateur, &$message){
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT pseudo FROM Utilisateur WHERE id_utilisateur = :id_utilisateur");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'pseudo\pseudo');
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["pseudo"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    function addUser($mail, $name, $firstname, $nickname, $password, $urlPhoto, &$message) {
        $result = false;
        $bdd = null;
        try {
            $bdd = DBLink::connect2db(MYDB,$message);
            $stmt = $bdd->prepare("INSERT INTO Utilisateur (courriel, pseudo, nom, prenom, motDePasse, urlPhoto, estActif, estOrganisateur) VALUES (:mail, :nickname, :name, :firstname, :password, :urlPhoto, '1', '0')");
            $stmt->bindValue(':mail', $mail);
            $stmt->bindValue(':nickname', $nickname);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':firstname', $firstname);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':urlPhoto', $urlPhoto);
            if($stmt->execute() && $stmt->rowCount() == 1) {
                $result = true;
                $message = "<h1>Votre compte a été créé avec succès !</h1>";
            } else {
                $message = "<h1>Erreur !</h1>";
            }
        }catch (Exception $e) {
            $message .=$e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function addUrl($urlPhoto, $id_utilisateur, &$message){
        $noError = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("UPDATE Utilisateur SET urlPhoto = :urlPhoto WHERE id_utilisateur = :id_utilisateur");
            $stmt->bindValue(':urlPhoto', $urlPhoto);
            $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() == 1){
                $message .= "L\'url a bien été ajouté." ;
                $noError = true;
            } else {
                $message = "<h1>Erreur !</h1>";
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $noError;
    }

    public function getId($mail, &$message){
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT id_utilisateur FROM Utilisateur WHERE courriel = :mail");
            $stmt->bindParam(':mail', $mail);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "id_utilisateur\id_utilisateur");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["id_utilisateur"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    function modifyPasswordByEmail($password, $mail, &$message) {
        $bdd = null;
        try {
            $passwordHash = hash("sha512", $password);
            $bdd = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("UPDATE Utilisateur SET motDePasse = :passwordHash WHERE courriel = :mail");
            $stmt->bindValue(':passwordHash', $passwordHash);
            $stmt->bindValue(':mail', $mail);
            if ($stmt->execute()) {
                $message .= "<h1>Votre mot de passe a été modifié avec succès !</h1>";
            } else {
                $message .= "<h1>Erreur !</h1>";
            }
        } catch (Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLink::disconnect($bdd);
    }

    public function updateUser($id_utilisateur, $mail, $nom, $prenom, $pseudo, $urlPhoto, &$message){
        $result = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare( "UPDATE Utilisateur SET courriel = :mail, nom = :nom, prenom = :prenom, pseudo = :pseudo, urlPhoto = :urlPhoto WHERE id_utilisateur = :id_utilisateur ");
            $stmt->bindValue(':mail', $mail);
            $stmt->bindValue(':nom', $nom);
            $stmt->bindValue(':prenom', $prenom);
            $stmt->bindValue(':pseudo', $pseudo);
            $stmt->bindValue(':urlPhoto', $urlPhoto);
            $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() == 1){
                $message .= "<h1>Votre compte a bien été mis à jour.</h1>" ;
                $result = true;
            } else {
                $message .= "<h1>Erreur !</h1>";
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    public function updatePassword($id_utilisateur, $mail, $nom, $prenom, $pseudo, $motDePasse, &$message){
        $noError = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare( "UPDATE Utilisateur SET courriel = :mail, nom = :nom, prenom = :prenom, pseudo = :pseudo,  motDePasse = :motDePasse  WHERE id_utilisateur = :id_utilisateur ");
            $stmt->bindValue(':mail', $mail);
            $stmt->bindValue(':nom', $nom);
            $stmt->bindValue(':prenom', $prenom);
            $stmt->bindValue(':pseudo', $pseudo);
            $stmt->bindValue(':motDePasse', $motDePasse);
            $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() == 1){
                $message .= "<h1>Votre compte a bien été mis à jour.</h1>" ;
                $noError = true;
            } else {
                $message .= "<h1>Erreur !</h1>";
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $noError;
    }


    function getPseudo($mail, &$message) {
        $result = "";
        $bdd    = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT pseudo FROM Utilisateur WHERE courriel = :mail");
            $stmt->bindParam(':mail', $mail);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'pseudo\pseudo');
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["pseudo"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    function removeUser($id_utilisateur, $estActif, &$message) {
        $result = false;
        $bdd   = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare( "UPDATE Utilisateur SET estActif = :estActif  WHERE id_utilisateur = :id_utilisateur ");
            $stmt->bindValue(':estActif',  $estActif, PDO::PARAM_INT);
            $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() == 1){
                $message .= "Compte supprimé avec succès !" ;
                $result = true;
            } else {
                $message .= 'Erreur !';
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }

    function getMotDePasse($mail, &$message) {
        $result = "";
        $bdd = null;
        try {
            $bdd  = DBLink::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT motDePasse FROM Utilisateur WHERE courriel = :mail");
            $stmt->bindParam(':mail', $mail);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "motDePasse\motDePasse");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $result = $row["motDePasse"];
            }
            $stmt = null;
        } catch (Exception $e) {
            $message .= $e->getMessage().'<br>';
        }
        DBLink::disconnect($bdd);
        return $result;
    }
}