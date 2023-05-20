<?php
session_start();
if (isset($_SESSION['courriel'])) {
    $courriel = $_SESSION['courriel'];
    $id_utilisateur = $_SESSION['id_utilisateur'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $pseudo = $_SESSION['pseudo'];
}