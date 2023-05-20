<?php
  require 'php/session.inc.php';
  require_once 'php/modifProfil.inc.php';

  $modification = new ModifierProfil();
  $modification->modifier_Profil();

  $title = "Modifier profil";
  require 'inc/headerThree.inc.php';
  ?>  
        
        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="listeTournois.php">Liste tournois</a></li>
                    <li><a href="profil.php">Profil</a> </li>
                    <li><a href="modifProfil.php">Modifier Profil</a> </li>
                </ul>
            </div>
            <h1 class="h2 h2__main">Modifiaction de votre profil</h1>
            <div class="main__bloc__center">
                <section class="main main__section__modifProfil">
                    <form class="main__section__modifProfil__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo $modification->get_message(); ?>
                        <div class="form__split form__split__left">
                            <div class="modif__profil__img">
                                <img class="img__profil" src="<?php echo $_SESSION['urlPhoto'] ?>" alt="photo de profil"/>
                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000"><input type="file" name="form__modification__photo" id="form__modification__photo" accept="image/png, image/jpeg"/>
                            </div>
                            <label for="form__modification__name">Nom</label> <input type="text" name="form__modification__name" id="form__modification__name" value="<?php echo isset($_POST['form__modification__name']) ? $_POST['form__modification__name'] : $_SESSION['nom'] ?>"/>
                            <label for="form__modification__firstname">Prénom</label> <input type="text" name="form__modification__firstname" id="form__modification__firstname" value="<?php echo isset($_POST['form__modification__firstname']) ? $_POST['form__modification__firstname'] : $_SESSION['prenom'] ?>"/>
                            <label for="form__modification__nickname">Pseudo*</label> <input type="text" name="form__modification__nickname" id="form__modification__nickname" maxlength="20" required value="<?php echo isset($_POST['form__modification__nickname']) ? $_POST['form__modification__nickname'] : $_SESSION['pseudo'] ?>"/>
                        </div>
                        <div class="form__split form__split__right__modifProfil">
                            <label for="form__modification__mail">Adresse mail*</label> <input type="email" name="form__modification__mail" id="form__modification__mail" required value="<?php echo isset($_POST['form__modification__mail']) ? $_POST['form__modification__mail'] : $_SESSION['courriel'] ?>"/>
                            <label for="form__modification__mdp">Mot de passe</label> <input type="password" name="form__modification__mdp" id="form__modification__mdp" minlength="8" maxlength="20"/>
                            <label for="form__modification__mdpRep">Vérification du mot de passe</label> <input type="password" name="form__modification__mdpRep" id="form__modification__mdpRep" minlength="8" maxlength="20"/>
                        </div>
                        <input type="submit" name="form__button__submit" value="Modifier"/>
                    </form>
                </section>
            </div>
        </main>

<?php 
    require 'inc/footer.inc.php';
?>