<?php
  require 'php/session.inc.php';
  require_once 'php/profil.inc.php';

  $profil = new Profil();
  $user = $profil->get_user();

  $title = "Profil";
  require 'inc/headerThree.inc.php';
  ?>  
        
        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="listeTournois.php">Liste tournois</a></li>
                    <li><a href="profil.php">Profil</a> </li>
                </ul>
            </div>
            <h1 class="h2 h2__main">Votre profil</h1>
            <div class="main__bloc__center">
                <section class="main main__section__profil">
                    <img class="img__profil" src="<?php echo $user->urlPhoto ?>" alt="Image de profil"/> <?php //TODO Utiliser la photo de l'utilisateur?>
                    <p class="p__bold"> <?php echo $user->nom ?>  <?php echo $user->prenom ?></p>
                    <p> <?php echo $user->pseudo ?></p>
                    <p> <?php echo $user->courriel ?></p>
                    <a class="fake__button__full" href="modifProfil.php">Modifier</a>
                    <a class="fake__button__delete__profil" href="suppression.php">Supprimer</a>
                    <a href="connexion.php?deconnexion=1" id="deconnexion">Déconnexion</a>
                    <?php echo $profil->get_message(); ?>
                </section>
            </div>
        </main>

<?php 
    require 'inc/footer.inc.php';
?>