<?php
require 'php/session.inc.php';
require_once 'php/rejoindre.inc.php';

$rejoindre = new Rejoindre();
$tournament = $rejoindre->get_tournament();
if (isset($_POST['form__button__submit'])) {
    $rejoindre->joinTournament($tournament);
}
$title = "Rejoindre tournoi";
include('inc/headerFour.inc.php');
?>

<main>
    <div class="filAriane">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="listeTournois.php">Liste tournois</a></li>
            <li><a href="detailsTournoi.php?id_tournoi=<?php echo $tournament->id_tournoi?>">Détails tournoi</a></li>
            <li><a href="rejoindre.php">Rejoindre tournoi</a></li>
        </ul>
    </div>
    <h1 class="h2 h2__main">Vous voulez rejoindre <?php echo $tournament->nom ?> ?</h1>
    <div class="main__bloc">
        <img class="img__fond" src="images/fond.png" alt="Rond Jaune"/>
        <section class="main main__section__profil">
            <?php echo $rejoindre->get_message(); ?>
                <form class="main__section__profil__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_tournoi" value="<?php echo $tournament->id_tournoi ?>">
                    <input type="submit" name="form__button__submit" value="Rejoindre">
                </form>
            <a class="fake__button__back" href="detailsTournoi.php?id_tournoi=<?php echo $tournament->id_tournoi?>">Annuler</a>
        </section>
    </div>
</main>

<?php
require 'inc/footer.inc.php';
?>
