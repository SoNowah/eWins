<?php
require_once "inc/db_user.inc.php";
require 'myFct.php';

use User\UserRepository;
use User\MyUser;

class Connexion
{
    private $message;

    public function __construct()
    {
        if (isset($_POST['form__button__submit'])) {
            $userRepository = new UserRepository();
            $user = new MyUser();
            $user->courriel = strip_tags(trim($_POST['form__connexion__mail']));
            if (empty($user->courriel)) {
                $this->message = "<h1>Aucun courriel n'a été spécifié</h1>";
            } else {

                if (empty($_POST['form__connexion__mdp'])) {
                    $this->message = "<h1>Aucun mot de passe n'a été spécifié</h1>";
                } else {
                    if (filter_var($user->courriel, FILTER_VALIDATE_EMAIL)) {
                        $user->motDePasse = trim($_POST['form__connexion__mdp']);
                        $desactive = $userRepository->courrielExistsInDB($user->courriel, 0, $this->message);
                        if ($desactive != "") {
                            $intitule = "eWins : Réactivation de votre compte";
                            $body = "Votre compte est désactivé.\n
                                    Pour réactiver votre compte, merci de cliquer sur le lien suivant :\n
                                    http://192.168.128.13/~q210112/EVAL_V4/reactiverCompte.php";
                            sendMail("no-reply@ewins.com", $user->courriel, $intitule, $body, $this->message);
                            if ($this->message == "Mail expédié") {
                                $this->message = "<h1>Votre compte est désactivé. Veuillez vérifier vos mails.</h1>";
                            }
                        } else {
                            $user->id_utilisateur = $userRepository->courrielExistsInDB($user->courriel, 1, $this->message);
                            if ($user->id_utilisateur == "") {
                                $this->message = "<h1>Courriel inexistant !</h1>";
                            } else {
                                $mdp = $userRepository->getMotDePasse($user->courriel, $this->message);
                                $password = hash("sha512", $user->motDePasse);
                                if ($password === $mdp) {
                                    $_SESSION['courriel'] = $user->courriel;
                                    $_SESSION['id_utilisateur'] = $user->id_utilisateur;
                                    $_SESSION['nom'] = $userRepository->getNom($user->courriel, $message);
                                    $_SESSION['prenom'] = $userRepository->getPrenom($user->courriel, $message);
                                    $_SESSION['pseudo'] = $userRepository->getPseudo($user->courriel, $message);
                                    $_SESSION['urlPhoto'] = $userRepository->getUrlPhoto($user->courriel, $message);
                                    $this->message = "<h1>Connexion réussie.</h1>";
                                    header('location: mesTournois.php');
                                } else {
                                    $this->message = "<h1>Mot de passe incorrecte !</h1>";
                                }
                            }
                        }
                    } else {
                        $this->message = "<h1>Le courriel est invalide</h1>";
                    }
                }
            }
        }
    }

    public function get_message()
    {
        return $this->message;
    }
}