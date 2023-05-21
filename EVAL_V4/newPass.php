<?php
  require_once 'php/newPass.inc.php';

  $nouveauMDP = new NouveauMDP();
  $nouveauMDP->recuperationMDP();
  $title = "Nouveau mot de passe";
  require 'inc/headerTwo.inc.php';
  ?>  
  
        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="connexion.php">Connexion</a></li>
                    <li><a href="newPass.php">Nouveau mot de passe</a></li>
                </ul>
            </div>
            <h1 class="h2 h2__main">Vous avez oublié votre mot de passe ?</h1>
            <h1 class="h2 h2__under">Demandez-en un nouveau</h1>
            <div class="main__bloc">
                <img class="img__fond" src="images/fond.png" alt="Rond Jaune"/>
                <section class="main main__section__one">
                    <?php echo $nouveauMDP->get_message(); ?>
                    <form class="main__section__one__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <label for="form__newPass__mail">Adresse Mail*</label> <input type="email" name="form__newPass__mail" id="form__newPass__mail" autofocus required />
                        
                        <input type="submit" name="butNewPass" value="Valider">
                    </form>
                </section>
            </div>
        </main>

<?php 
    require 'inc/footer.inc.php';
?>