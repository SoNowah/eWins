<?php
  require 'php/session.inc.php';
  require_once 'php/contact.inc.php';
  $contact = new Contact();
  if (isset($_POST['butConValide'])) {
      $contact->contacter();
  }
  $user = $contact->get_utilisateur();
  $title = "Contact";
    if (empty($_SESSION['id_utilisateur']) || $_SESSION['id_utilisateur'] == "") {
        require 'inc/headerTwo.inc.php';
    } else {
        require 'inc/headerThree.inc.php';
    }
  ?>  
        
        <main>
            <h1 class="h2 h2__main">Vous souhaitez nous en parler ?</h1>
            <h1 class="h2 h2__under">Ça tombe bien, nous sommes là pour vous</h1>
            <div class="main__bloc">
                <img class="img__fond" src="images/fond.png" alt="Rond Jaune"/>
                <section class="main main__section">
                    <?php echo $contact->get_message(); ?>
                    <form class="main__section__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <label for="form__contact__mail">Adresse Mail*</label> <input type="email" name="form__contact__mail" id="form__contact__mail" autofocus required value="<?php if (isset($_SESSION['id_utilisateur'])) {
                            echo $_SESSION['courriel'];
                        } else { ?> <?php } ?>"/>
                        
                        <label for="form__contact__intitule">Intitulé*</label> <input type="text" name="form__contact__intitule" id="form__contact__intitule" maxlength="100" required />
                        
                        <label for="form__contact__message">Message*</label> <textarea name="form__contact__message" id="form__contact__message" rows="5" cols="50" required ></textarea>
                        
                        <input type="submit" name="butConValide" value="Envoyer"/>
                    </form>
                </section>
            </div>
        </main>

<?php 
    require 'inc/footer.inc.php';
?>