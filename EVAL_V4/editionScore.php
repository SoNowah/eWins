<?php
    require 'php/session.inc.php';
    require_once 'php/editionScore.inc.php';

    $editionScore = new EditionScore();
    if (isset($_POST['butValScore'])) {
        $editionScore->editerScore();
    }

    $rencontre = $editionScore->get_rencontre();
    $pseudoJ1 = $editionScore->get_userRepository()->getPseudoId($rencontre->id_joueurUn, $message);
    $pseudoJ2 = $editionScore->get_userRepository()->getPseudoId($rencontre->id_joueurDeux, $message);
    $id_statut = $editionScore->get_tournamentRepository()->getIdStatut($rencontre->id_tournoi, $message);

    if (isset($_POST['validerVainqueurJ1']))  {
    $editionScore->validerVainqueur($rencontre->id_joueurUn);
    }

    if (isset($_POST['validerVainqueurJ2'])) {
    $editionScore->validerVainqueur($rencontre->id_joueurDeux);
    }

    $title = "Edition du score";
    require 'inc/headerThree.inc.php';
  ?>  

        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="listeTournois.php">Liste tournois</a></li>
                    <li><a href="detailsTournoi.php?id_tournoi=<?php echo $rencontre->id_tournoi?>">Détails tournoi</a> </li>
                    <li><a href="editionScore.php?id_tournoi=<?php echo $rencontre->id_tournoi?>&id_rencontre=<?php echo $rencontre->id_rencontre?>">Modifier score</a> </li>
                </ul>
            </div>
            <h1 class="h2 h2__main">Vous souhaitez modifier le score de cette rencontre ?</h1>
            <div class="main__bloc">
                <img class="img__fond" src="images/fond.png" alt="Rond Jaune"/>
                <section class="main main__section__editScore">
                    <p class="p__bold"><?php echo $pseudoJ1 ?> VS <?php echo $pseudoJ2?></p>
                    <?php echo $editionScore->get_message(); ?>
                    <form class="main__section__editScore__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <label for="form__editionScoreJ1">Score <?php echo $pseudoJ1?></label> <input type="number" name="form__editionScoreJ1" id="form__editionScoreJ1" value="<?php echo $rencontre->score_joueurUn ?>" min="0" required/>
                        <?php if ($rencontre->id_vainqueur == null) {?>
                        <input type="submit" name="validerVainqueurJ1" value="Valider vainqueur">
                        <?php }?>

                        <label for="form__editionScoreJ2">Score <?php echo $pseudoJ2?></label> <input type="number" name="form__editionScoreJ2" id="form__editionScoreJ2" value="<?php echo $rencontre->score_joueurDeux ?>" min="0" required/>
                        <?php if ($rencontre->id_vainqueur == null) {?>
                            <input type="submit" name="validerVainqueurJ2" value="Valider vainqueur">
                        <?php }?>

                        <?php if($id_statut == 1) {
                            echo 'Le tournoi est toujours ouvert !';
                        } else {?>
                        <input type="submit" name="butValScore" value="Modifier">
                        <?php } ?>
                        <input type="hidden" name="id_rencontre" value="<?php if ($rencontre->id_rencontre != null) {
                            echo $rencontre->id_rencontre;
                        }?>">
                        <input type="hidden" name="id_tournoi" value="<?php if ($rencontre->id_tournoi != null) {
                            echo $rencontre->id_tournoi;
                        }?>">
                        <a class="fake__button__empty" href="detailsTournoi.php?id_tournoi=<?php echo $rencontre->id_tournoi?>">Annuler</a>
                    </form>
                </section>
            </div>
        </main>

<?php 
    include('inc/footer.inc.php'); 
?>