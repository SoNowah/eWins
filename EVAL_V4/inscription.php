<?php
  require 'php/inscription.inc.php';
  $creationProfil = new Inscription();
  $creationProfil->creation_profil();
  $title = "Inscription";
  require 'inc/header.inc.php';
  ?>

        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="inscription.php">Inscription</a></li>
                </ul>
            </div>
            <h1 class="h2 h2__main">Merci de nous rejoindre !</h1>
            <div class="main__bloc">
                <img class="img__fond" src="images/fond.png" alt="Rond Jaune"/>
                <section class="main main__section__split">
                    <?php echo $creationProfil->get_message(); ?>
                    <form class="main__section__split__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form__split">
                            <label for="form__inscription__name">Nom*</label> <input type="text" name="form__inscription__name" id="form__inscription__name" autofocus required value="<?php echo isset($_POST['form__inscription__name']) ? $_POST['form__inscription__name'] : "" ?>"/>
                            
                            <label for="form__inscription__firstname">Prénom*</label> <input type="text" name="form__inscription__firstname" id="form__inscription__firstname" required value="<?php echo isset($_POST['form__inscription__firstname']) ? $_POST['form__inscription__firstname'] : "" ?>" />
                            
                            <label for="form__inscription__nickname">Pseudo*</label> <input type="text" name="form__inscription__nickname" id="form__inscription__nickname" maxlength="20" required value="<?php echo isset($_POST['form__inscription__nickname']) ? $_POST['form__inscription__nickname'] : "" ?>" />

                            <label for="form__inscription__photo">Photo</label> <input type="hidden" name="MAX_FILE_SIZE" value="1000000"> <input type="file" name="form__inscription__photo" id="form__inscription__photo" accept="image/*, .png, .jpg" required/>
                        </div>
                        <div class="form__split">
                            <label for="form__inscription__mail">Adresse Mail*</label> <input type="email" name="form__inscription__mail" id="form__inscription__mail" required value="<?php echo isset($_POST['form__inscription__mail']) ? $_POST['form__inscription__mail'] : "" ?>"/>
                            
                            <label for="form__inscription__mdp">Mot de passe*</label> <input type="password" name="form__inscription__mdp" id="form__inscription__mdp" minlength="8" maxlength="20" required/>

                            <label for="form__inscription__repMdp">Vérification du mot de passe*</label> <input type="password" name="form__inscription__repMdp" id="form__inscription__repMdp" minlength="8" maxlength="20" required/>
                        </div>
                        <input type="submit" name="form__button__submit" value="S'inscrire">
                    </form>
                </section>
            </div>
        </main>
    </body>
</html>