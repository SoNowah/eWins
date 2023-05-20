<?php
  require 'php/connexion.inc.php';
  if (isset($_GET['deconnexion'])) {
      session_start();
      $_SESSION = array();
      setcookie("PHPSESSID", "", time() - 3600, "/");
      session_destroy();
  }
  session_start();
  $connexion = new Connexion();
  $title = "Connexion";
  require 'inc/header.inc.php';
  ?>  

        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="connexion.php">Connexion</a></li>
                </ul>
            </div>
            <h1 class="h2 h2__main">Bienvenue sur eWins,</h1>
            <h1 class="h2 h2__under">votre site de tournois préféré</h1>
            <div class="main__bloc">
                <img class="img__fond" src="images/fond.png" alt="Rond Jaune"/>
                <section class="main main__section">
                    <?php echo $connexion->get_message(); ?>
                    <form class="main__section__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <label for="form__connexion__mail">Adresse Mail*</label> <input type="email" name="form__connexion__mail" id="form__connexion__mail" autofocus required >
                        
                        <label for="form__connexion__mdp">Mot de passe*</label> <input type="password" name="form__connexion__mdp" id="form__connexion__mdp" required>
                        <div class="reset__password"><a class="a__form" href="newPass.php">Mot de passe oublié ?</a></div>

                        <input type="submit" name="form__button__submit" value="Connexion">
                    </form>
                    
                    <p class="p__connexion">Pas encore de compte ?</p>
                    <a class="fake__button__link" href="inscription.php">Inscription</a>
                </section>
            </div>
        </main>
    </body>
</html>