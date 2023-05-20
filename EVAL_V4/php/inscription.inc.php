<?php
require_once "php/myFct.php";
require_once "inc/db_user.inc.php";

use User\MyUser;
use User\UserRepository;

class Inscription
{
    private $message;

    public function creation_profil() {
        $userRepository = new UserRepository();
        session_start();
        $resultNom = false;
        $resultPrenom = false;
        $resultPseudo = false;

        if (isset($_POST['form__button__submit'])) {
            $user = new MyUser();
            if (!empty(trim($_POST['form__inscription__name']))) {
                $user->nom = strip_tags(trim($_POST['form__inscription__name']));
                $resultNom = true;
            }
            if ($resultNom) {
                if (!empty(trim($_POST['form__inscription__firstname']))) {
                    $user->prenom = strip_tags(trim($_POST['form__inscription__firstname']));
                    $resultPrenom = true;
                }

                if ($resultPrenom) {
                    if (!empty(trim($_POST['form__inscription__nickname']))) {
                        $user->pseudo = strip_tags(trim($_POST['form__inscription__nickname']));
                        $resultPseudo = true;
                    }

                    if ($resultPseudo) {
                        $user->courriel = strip_tags(trim($_POST['form__inscription__mail']));
                        if (empty($user->courriel)) {
                            $this->message = "<h1>Aucun courriel n'a été spécifié !</h1>";
                        } else {
                            if (filter_var($user->courriel, FILTER_VALIDATE_EMAIL)) {
                                $exist = $userRepository->courrielExistsInDB($user->courriel, 1, $this->message);
                                $desactive = $userRepository->courrielExistsInDB($user->courriel, 0, $this->message);
                                if ($exist != "") {
                                    $this->message = "<h1>Un utilisateur est déjà inscrit avec cet email !</h1>";
                                } elseif($desactive != "") {
                                    $this->message = "<h1>Email d'un compte désactivé !</h1>";
                                    $intitule = "eWins : Réactivation de votre compte";
                                    $body = "Votre compte est désactivé.\n
                                    Pour réactiver votre compte, merci de cliquer sur le lien suivant :\n
                                    http://192.168.128.13/~q210112/EVAL_V4/reactiverCompte.php";
                                    sendMail("no-reply@ewins.com", $user->courriel, $intitule, $body, $message);
                                    $this->message = $this->message . "<br>" . $message;
                                    } else {
                                    if (empty($_FILES['form__inscription__photo'])) {
                                        $this->message = "<h1>Aucune photo de profil n'a été spécifiée</h1>";
                                    } else {
                                        if ($_FILES['form__inscription__photo']['error'] === UPLOAD_ERR_OK) {
                                            $photoTmpPath = $_FILES['form__inscription__photo']['tmp_name'];
                                            $photoName = $_FILES['form__inscription__photo']['name'];
                                            $photoExtension = pathinfo($photoName, PATHINFO_EXTENSION);
                                            $newPhotoName = uniqid() . '.' . $photoExtension;
                                            $targetPath = PATH . $newPhotoName;
                                            if (!is_dir(PATH)) {
                                                mkdir(PATH, 0777, true);
                                            }
                                            if (move_uploaded_file($photoTmpPath, $targetPath)) {
                                                $url = $targetPath;
                                                $user->urlPhoto = pack('a*', $url);
                                                if (empty($_POST['form__inscription__mdp'])) {
                                                    $this->message = "<h1>Aucun mot de passe n'a été spécifié !</h1>";
                                                } else {
                                                    if (empty($_POST['form__inscription__repMdp'])) {
                                                        $this->message = "<h1>Aucune répétition de mot de passe n'a été spécifié !</h1>";
                                                    } else {
                                                        $egale = strcmp(trim($_POST['form__inscription__repMdp']), trim($_POST['form__inscription__mdp']));
                                                        if ($egale == 0) {
                                                            $user->motDePasse = hash("sha512", trim($_POST['form__inscription__mdp']));
                                                            $result = $userRepository->addUser($user->courriel, $user->nom, $user->prenom, $user->pseudo, $user->motDePasse, $user->urlPhoto, $this->message);
                                                            if ($result) {
                                                                $_SESSION['courriel'] = $user->courriel;
                                                                $_SESSION['id_utilisateur'] = $user->id_utilisateur;
                                                                $_SESSION['nom'] = $user->nom;
                                                                $_SESSION['prenom'] = $user->prenom;
                                                                $_SESSION['pseudo'] = $user->pseudo;
                                                                $_SESSION['urlPhoto'] = $user->urlPhoto;
                                                                $intitule = "eWins : Création de profil";
                                                                $body = "Nous avons l'honneur de vous annoncer que votre profil a bien été créé. <br> Merci pour votre confiance !";
                                                                sendMail("no-reply@ewins.com", $user->courriel, $intitule, $body, $this->message);
                                                                $this->message = "<h1>Création du compte effectuée, redirection vers la page de connexion...</h1>";
                                                                header('location: connexion.php');
                                                            }
                                                        } else {
                                                            $this->message = "<h1>Les mots de passe ne correspondent pas !</h1>";
                                                        }
                                                    }
                                                }
                                            } else {
                                                $this->message = "<h1>Image invalide !</h1>";
                                            }
                                        } else {
                                            $this->message = "<h1>Image invalide !</h1>";
                                        }
                                    }
                                }
                            } else {
                                $this->message = "<h1>L'email fournit est invalide !</h1>";
                            }
                        }
                    } else {
                        $this->message = "<h1>Pseudo invalide !</h1>";
                    }
                } else {
                    $this->message = "<h1>Prénom invalide !</h1>";
                }
            } else {
                $this->message = "<h1>Nom invalide !</h1>";
            }
        }
    }

    public function get_message() {
        return $this->message;
    }
}