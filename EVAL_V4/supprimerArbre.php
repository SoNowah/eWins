<?php
require 'php/session.inc.php';
require_once 'inc/db_user.inc.php';
require_once 'inc/db_rencontre.inc.php';
require_once 'inc/db_participer.inc.php';
require_once 'inc/db_statut.inc.php';
require_once 'inc/db_sport.inc.php';
require_once 'php/supprimerArbre.inc.php';

$supprimerArbre = new SupprimerArbre();
$tournament = $supprimerArbre->get_tournament();

if (isset($_POST['form__button__delete__Tournament'])) {
    $supprimerArbre->supprimerArbre();
    echo $supprimerArbre->get_message();
    header("location: detailsTournoi.php?id_tournoi=$tournament->id_tournoi");
    exit;
}

$title = "Supprimer Arbre";
require 'inc/headerThree.inc.php';
?>

    <main>
        <div class="filAriane">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="listeTournois.php">Liste tournois</a></li>
                <li><a href="supprimerJoueur.php">Supprimer joueur</a> </li>
            </ul>
        </div>
        <h1 class="h2 h2__main">Voulez-vous supprimer l'arbre ?</h1>
        <h1 class="h2 h2__under">Il concerne le tournoi : <?php echo $tournament->nom ?></h1>
        <div class="main__bloc">
            <img class="img__fond" src="images/fond.png" alt="Rond Jaune"/>
            <section class="main main__section__deleteTournament">
                <?php echo $supprimerArbre->get_message(); ?>
                    <form class="main__section__deleteTournament__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <input type="submit" name="form__button__delete__Tournament" value="Supprimer">
                        <input type="hidden" name="id_tournoi" value="<?php echo $tournament->id_tournoi ?>">
                    </form>
                <a class="fake__button__back__tournament" href="detailsTournoi.php?id_tournoi=<?php echo $tournament->id_tournoi ?>">Annuler</a>
            </section>
        </div>
    </main>

<?php
require 'inc/footer.inc.php';
?>