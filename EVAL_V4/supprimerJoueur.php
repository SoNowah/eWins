<?php
  require 'php/session.inc.php';
  require_once 'inc/db_tournoi.inc.php';
  require_once 'inc/db_user.inc.php';
  require_once 'inc/db_participer.inc.php';
  require_once 'php/supprimerJoueur.inc.php';
  require_once 'php/myFct.php';

  $supprimerJoueur = new SupprimerJoueur();
  $tournament = $supprimerJoueur->get_tournament();
  $user = $supprimerJoueur->get_user();
  if (isset($_POST['form__button__delete__Tournament'])) {
      $supprimerJoueur->supprimerJoueur();;
      $intitule = "eWins : Utilisateur supprimé";
      $body = "L'utilisateur $user->pseudo a été supprimé du tournoi $tournament->nom.";
      sendMail2("no-reply@ewins.com", $user->courriel, $_SESSION['courriel'], $intitule, $body, $message);
      header("location: detailsTournoi.php?id_tournoi=$tournament->id_tournoi");
  }

  $title = "Supprimer Joueur";
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
            <h1 class="h2 h2__main">Voulez-vous supprimer ce joueur ?</h1>
            <h1 class="h2 h2__under">Il sera supprimé du tournoi : <?php echo $tournament->nom ?></h1>
            <div class="main__bloc">
                <img class="img__fond" src="images/fond.png" alt="Rond Jaune"/>
                <section class="main main__section__deleteTournament">
                    <?php echo $supprimerJoueur->get_message(); ?>
                    <img class="img__profil2" src="<?php echo $user->urlPhoto?>" alt="Image de profil"/>
                    <p class="p__bold"><?php echo $user->nom?> <?php echo $user->prenom?></p>
                    <p><?php echo $user->pseudo?></p>
                    <?php if (!$supprimerJoueur->get_statutGenere()) {?>
                    <form class="main__section__deleteTournament__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <input type="submit" name="form__button__delete__Tournament" value="Supprimer">
                        <input type="hidden" name="id_tournoi" value="<?php echo $tournament->id_tournoi ?>">
                        <input type="hidden" name="id_utilisateur" value="<?php echo $user->id_utilisateur ?>">
                    </form>
                        <?php
                    } else { ?>
                        <p>Les rencontres ont été généré !</p>
                        <?php
                    }
                    ?>
                    <a class="fake__button__back__tournament" href="detailsTournoi.php?id_tournoi=<?php echo $tournament->id_tournoi ?>">Annuler</a>
                </section>
            </div>
        </main>

<?php
  require 'inc/footer.inc.php';
?>