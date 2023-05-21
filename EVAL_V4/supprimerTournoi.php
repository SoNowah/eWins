<?php
  require 'php/session.inc.php';
  require_once 'inc/db_tournoi.inc.php';
  require_once 'php/supprimerTournoi.inc.php';
  require_once 'php/myFct.php';

  $supprimerTournoi = new SupprimerTournoi();
  $tournament = $supprimerTournoi->get_tournament();
  if (isset($_POST['form__button__delete__Tournament'])){
      $supprimerTournoi->supprimerTournoi();
  }

  $title = "Supprimer Tournoi";
  require 'inc/headerThree.inc.php';
  ?>

        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="listeTournois.php">Liste tournois</a></li>
                    <li><a href="supprimerTournoi.php">Supprimer tournoi</a> </li>
                </ul>
            </div>
            <h1 class="h2 h2__main">Voulez-vous supprimer ce tournoi ?</h1>
            <h1 class="h2 h2__under">Veuillez confirmer votre demande</h1>
            <div class="main__bloc">
                <img class="img__fond" src="images/fond.png" alt="Rond Jaune"/>
                <section class="main main__section__deleteTournament">
                    <?php echo $supprimerTournoi->get_message(); ?>
                    <p class="p__bold"><?php echo $tournament->nom?></p>
                    <?php if ($supprimerTournoi->get_statutTermine()) {?>
                    <form class="main__section__deleteTournament__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_tournoi" value="<?php echo $tournament->id_tournoi ?>">
                        <input type="submit" name="form__button__delete__Tournament" value="Supprimer">
                    </form>
                    <?php
                    } else { ?>
                        <p>Ce tournoi n'est pas terminé !</p>
                    <?php
                    }
                    ?>
                    <a class="fake__button__back__tournament" href="listeTournois.php">Annuler</a>
                </section>
            </div>
        </main>

<?php
    require 'inc/footer.inc.php';
?>