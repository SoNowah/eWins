<?php
  require 'php/session.inc.php';
  require_once 'php/suppression.inc.php';

  $supprimerProfil = new SupprimerProfil();
  $supprimerProfil->suppressionProfil();

  $title = "Suppresion de profil";
  include('inc/headerThree.inc.php');
  ?>  

        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="listeTournois.php">Liste tournois</a></li>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="suppression.php">Supprimer</a> </li>
                </ul>
            </div>
            <h1 class="h2 h2__main">Vous voulez nous quitter ?</h1>
            <h1 class="h2 h2__under">Veuillez encoder votre mot de passe</h1>
            <div class="main__bloc">
                <img class="img__fond" src="images/fond.png" alt="Rond Jaune"/>
                <section class="main main__section__deleteProfil">
                    <?php echo $supprimerProfil->get_message(); ?>
                    <img class="img__profil" src="<?php echo $_SESSION['urlPhoto'] ?>" alt="Image de profil"/>
                    <p class="p__bold"><?php echo $_SESSION['nom'] ?> <?php echo $_SESSION['prenom'] ?></p>
                    <p><?php echo $_SESSION['pseudo'] ?></p>
                    <?php
                    if ($supprimerProfil->get_participe()) {
                        ?>
                        <p> Suppression du profil impossible ! Vous êtes encore enregistré dans des tournois actifs. </p>
                    <?php
                    } else {
                        ?>
                        <form class="main__section__deleteProfil__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                            <label for="form__suppression__mdp">Mot de passe*</label> <input type="password" name="form__suppression__mdp" id="form__suppression__mdp" autofocus required/>

                            <input type="submit" name="form__button__delete" value="Supprimer">
                        </form>
                    <?php
                    }
                        ?>
                    <a class="fake__button__back" href="profil.php">Annuler</a>
                </section>
            </div>
        </main>

<?php 
    require 'inc/footer.inc.php';
?>