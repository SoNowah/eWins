<?php
require_once 'inc/db_user.inc.php';

use User\UserRepository;
use User\MyUser;

class ModifierProfil
{
    private $message;
    private $userRepository;

    public function modifier_Profil() {
        if (isset($_POST['form__button__submit'])) {
            $this->userRepository = new UserRepository();
            $user = new MyUser();
            $user->nom = (isset($_POST['form__modification__name']) && trim($_POST['form__modification__name']) != "") ? strip_tags(trim($_POST['form__modification__name'])) : $_SESSION['nom'];
            $user->prenom = (isset($_POST['form__modification__firstname']) && trim($_POST['form__modification__firstname']) != "") ? strip_tags(trim($_POST['form__modification__firstname'])) : $_SESSION['prenom'];
            $user->pseudo = strip_tags(trim($_POST['form__modification__nickname']));
            $user->courriel = strip_tags(trim($_POST["form__modification__mail"]));
            if (empty($user->courriel) && empty($user->pseudo)) {
                $this->message = "<h1>Aucun courriel et/ou pseudo n'a été spécifié !</h1>";
            } else {
                $exit = $this->userRepository->courrielExistsInDB($user->courriel, 1, $this->message);
                $user->id_utilisateur = (integer)$this->userRepository->getId($user->courriel, $this->message);
                if ($exit != "" && $exit != $user->id_utilisateur) {
                    $this->message = "<h1>Cette adresse email est déjà attribuée !</h1>";
                } else {
                    if ($_FILES['form__modification__photo']['error'] === UPLOAD_ERR_OK) {
                        $photoTmpPath = $_FILES['form__modification__photo']['tmp_name'];
                        $photoName = $_FILES['form__modification__photo']['name'];
                        $photoExtension = pathinfo($photoName, PATHINFO_EXTENSION);
                        $newPhotoName = uniqid() . '.' . $photoExtension;
                        $targetPath = PATH . $newPhotoName;
                        if (!is_dir(PATH)) {
                            mkdir(PATH, 0777, true);
                        }
                        if (move_uploaded_file($photoTmpPath, $targetPath)) {
                            $url = $targetPath;
                            $user->urlPhoto = pack('a*', $url);

                        } else {
                            $this->message = "<h1>Image invalide !</h1>";
                        }
                    } else {
                        $this->message = "<h1>Image invalide !</h1>";
                    }
                    if (isset($_POST['form__modification__mdp']) && $_POST['form__modification__mdp'] != "") {
                        if (empty($_POST['form__modification__mdpRep'])) {
                            $this->message = "<h1>Répétition du mot de passe invalide !</h1>";
                        } else {
                            $egale = strcmp(trim($_POST['form__modification__mdp']), trim($_POST['form__modification__mdpRep']));
                            if ($egale == 0) {
                                $user->motDePasse = hash("sha512", trim($_POST['form__modification__mdp']));
                                $result = $this->userRepository->updatePassword($user->id_utilisateur, $user->courriel, $user->nom, $user->prenom, $user->pseudo, $user->motDePasse, $this->message);
                                if ($result) {
                                    $_SESSION['courriel'] = $user->courriel;
                                    $_SESSION['nom'] = $user->nom;
                                    $_SESSION['prenom'] = $user->prenom;
                                    $_SESSION['pseudo'] = $user->pseudo;
                                    $this->message = "<h1>Modification du compte effectuée !</h1>";
                                }
                            } else {
                                $this->message = "<h1>Les mots de passe ne sont pas identiques !</h1>";
                            }
                        }
                    } else {
                        $result = $this->userRepository->updateUser($user->id_utilisateur, $user->courriel, $user->nom, $user->prenom, $user->pseudo, $user->urlPhoto, $this->message);
                        if ($result) {
                            $_SESSION['courriel'] = $user->courriel;
                            $_SESSION['nom'] = $user->nom;
                            $_SESSION['prenom'] = $user->prenom;
                            $_SESSION['pseudo'] = $user->pseudo;
                            $_SESSION['urlPhoto'] = $user->urlPhoto;
                            $this->message = "<h1>Modification du compte effectuée !</h1>";
                        } else {
                            $this->message = "<h1>Erreur lors de la modification !</h1>";
                        }
                    }
                }
            }
        }
    }

    public function get_message() {
        return $this->message;
    }
}
