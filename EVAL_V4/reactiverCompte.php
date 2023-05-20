<?php
require_once 'php/reactiverCompte.inc.php';

$reactiverCompte = new ReactiverCompte();
$reactiverCompte->reactiverCompte();
$title = "Réactiver compte";
require 'inc/header.inc.php';
?>

<main>
    <h1 class="h2 h2__main">Réactivation de votre compte,</h1>
    <h1 class="h2 h2__under">veuillez entrer votre adresse mail</h1>
    <div class="main__bloc">
        <img class="img__fond" src="images/fond.png" alt="Rond Jaune"/>
        <section class="main main__section">
            <?php echo $reactiverCompte->get_message(); ?>
            <form class="main__section__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <label for="form__reactiver__mail">Adresse Mail*</label> <input type="email" name="form__reactiver__mail" id="form__reactiver__mail" autofocus required >
                <input type="submit" name="form__button__submit" value="Réactiver">
            </form>
        </section>
    </div>
</main>
</body>
</html>