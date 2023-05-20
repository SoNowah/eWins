<?php
    require 'php/session.inc.php';
    require_once 'inc/db_user.inc.php';
    require_once 'inc/db_rencontre.inc.php';
    require_once 'inc/db_participer.inc.php';
    require_once 'inc/db_statut.inc.php';
    require_once 'inc/db_sport.inc.php';
    require_once 'php/detailsTournoi.inc.php';

    $detailsTournoi = new DetailsTournoi();
    $tournament = $detailsTournoi->get_tournament();
    $rencontres[] = $detailsTournoi->get_rencontre();
    $message = $detailsTournoi->get_message();

    $nomSport = $detailsTournoi->get_sportRepository()->getSportByTournamentId($tournament->id_tournoi, $message);
    $nomStatut = $detailsTournoi->get_statutRepository()->getStatutByTournamentId($tournament->id_tournoi, $message);

    $nombreParticipation = $detailsTournoi->get_participationRepository()->getNumberParticipationByTournamentId($tournament->id_tournoi, $message);
    $nombrePlacesRestantes = $tournament->placesDispo - $nombreParticipation;

    $result = $detailsTournoi->get_participationRepository()->getParticipationTrueFalse($_SESSION['id_utilisateur'], $tournament->id_tournoi, $message);

    if (isset($_POST['genererRencontre'])) {
        $detailsTournoi->genererRencontres();
    }

    if (isset($_POST['cloturerTournoi'])) {
        $detailsTournoi->cloturerTournoi();
    }

    $title = "Détails d'un tournoi";
    require 'inc/headerFour.inc.php';
  ?>  

        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="listeTournois.php">Liste tournois</a></li>
                    <li><a href="detailsTournoi.php?id_tournoi=<?php echo $tournament->id_tournoi?>">Détails tournoi</a></li>
                </ul>
            </div>
            <h1 class="h2 h2__main"><?php echo $tournament->nom ?></h1>
            <div class="main__bloc__center">
                <section class="main__section__detailsTour">
                        <div class="main__section__detailsTour__colonne">
                            <div class="titleDetails">
                                <p class="titleDetails__game"><?php echo $nomSport ?></p>
                                <p><?php echo $tournament->dateTournoi ?></p>
                            </div>
                            <?php
                            if ($nombrePlacesRestantes == 0) {?>
                                <p>Ce tournoi est complet !</p>
                            <?php
                            } else {
                            if (!$result) { ?>
                                <a class="fake__button__full__details" href="rejoindre.php?id_tournoi=<?php echo $tournament->id_tournoi?>">Rejoindre</a>
                           <?php
                            } else { ?>
                                <p>Vous êtes déjà inscrit !</p>
                           <?php
                                }
                            }
                            if ($tournament->id_organisateur == $_SESSION['id_utilisateur']) { ?>
                                <a class="fake__button__empty__details" href="editionTournoi.php?id_tournoi=<?php echo $tournament->id_tournoi?>">Modifier</a>
                            <?php
                            }
                            ?>
                        </div>
                    <div class="main__section__detailsTour__colonne">
                        <table class="tournament__table__details">
                            <thead>
                                <tr>
                                    <th>Informations</th>
                                </tr>
                            </thead>
                            <tr>
                                <th>Statut :</th>
                                <td><?php echo $nomStatut ?></td>
                            </tr>
                            <tr>
                                <th>Statut du joueur :</th>
                                <td><?php
                                    if ($result) {
                                        echo "Inscrit";
                                    } else {
                                        echo "Non-inscrit";
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <th>Nombre de joueurs :</th>
                                <td><?php echo $nombreParticipation ?></td>
                            </tr>
                            <tr>
                                <th>Places restantes :</th>
                                <td><?php echo $nombrePlacesRestantes ?></td>
                            </tr>
                            <tr>
                                <th>Fin des inscriptions :</th>
                                <td><?php echo $tournament->dateFinInscription ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="main__section__detailsTour__colonne">
                        <h3>Joueurs inscrits</h3>
                        <ul class="tournament__list__details">
                        <?php $participants[] = $detailsTournoi->get_participationRepository()->getParticipationByTournamentId($tournament->id_tournoi, $message);
                            foreach ($participants as $participant) {
                                for ($p = 0; $p < count($participant); $p++) {
                                    $urlPhoto = $detailsTournoi->get_userRepository()->getUrlPhotoId($participant[$p]->id_utilisateur, $message);
                                    $pseudo = $detailsTournoi->get_userRepository()->getPseudoId($participant[$p]->id_utilisateur, $message); ?>
                                    <?php
                                    if ($tournament->id_organisateur == $_SESSION['id_utilisateur']) {
                                    ?>
                            <li><img src="<?php echo $urlPhoto ?>" alt="photo" width="35em"/><a class="a__participant" href="supprimerJoueur.php?id_utilisateur=<?php echo $participant[$p]->id_utilisateur?>&id_tournoi=<?php echo $tournament->id_tournoi?>"><?php echo $pseudo?></a></li>
                                <?php } else {?>
                                        <li><?php echo $pseudo?></li>

                        <?php
                                    }
                                }
                            }

                        ?>
                        </ul>
                    </div>
                </section>
            </div>
            <div class="main__bloc__center">
                <section class="tour__fight">
                    <div class="tour1">
                        <form class="detailsTournoi_form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <?php
                        if ($tournament->id_organisateur != $_SESSION['id_utilisateur']) {
                            foreach ($rencontres[0] as $rencontre) {
                                $pseudoJoueurUn = $detailsTournoi->get_userRepository()->getPseudoId($rencontre->id_joueurUn, $message);
                                $scoreJoueurUn = $detailsTournoi->get_rencontreRepository()->getScorePlayerOne($rencontre->id_rencontre, $tournament->id_tournoi, $message);
                                $pseudoJoueurDeux = $detailsTournoi->get_userRepository()->getPseudoId($rencontre->id_joueurDeux, $message);
                                $scoreJoueurDeux = $detailsTournoi->get_rencontreRepository()->getScorePlayerTwo($rencontre->id_rencontre, $tournament->id_tournoi, $message);
                                ?>
                                <p><?php echo $pseudoJoueurUn . " (" . $scoreJoueurUn .")"  ?> vs <?php echo $pseudoJoueurDeux . " (" . $scoreJoueurDeux .")" ?></p>
                            <?php }
                        } else {
                            if ($tournament->statut == 1 || $tournament->statut == 2) {?>
                                <p>Vous ne pouvez pas générer l'arbre d'un tournoi non clôturé/généré/terminé<br>
                                    Voulez vous clôturer ce tournoi ?</p>
                                <input type="submit" name="cloturerTournoi" value="Clôturer"/>
                                <input type="hidden" name="id_tournoi" value="<?php if ($tournament->id_tournoi != null) {
                                    echo $tournament->id_tournoi;
                                }?>">

                            <?php }elseif($tournament->statut == 5 || $tournament->statut == 6){?>
                                <p>Vous ne pouvez pas générer l'arbre d'un tournoi en-cours/terminé.</p>

                            <?php }elseif ($rencontres[0] == null) {?>
                                <input type="submit" name="genererRencontre" value="Générer"/>
                                <input type="hidden" name="id_tournoi" value="<?php if ($tournament->id_tournoi != null) {
                                    echo $tournament->id_tournoi;
                                }?>">

                            <?php } else {
                                foreach ($rencontres[0] as $rencontre) {
                                    $pseudoJoueurUn = $detailsTournoi->get_userRepository()->getPseudoId($rencontre->id_joueurUn, $message);
                                    $pseudoJoueurDeux = $detailsTournoi->get_userRepository()->getPseudoId($rencontre->id_joueurDeux, $message);
                                    ?>
                                    <a class="fake__button__edit" href="supprimerArbre.php?id_tournoi=<?php echo $tournament->id_tournoi?>">Supprimer arbre</a>
                                    <p><?php echo $pseudoJoueurUn ?> vs <?php echo $pseudoJoueurDeux ?></p>
                                    <a class="fake__button__edit" href="editionScore.php?id_tournoi=<?php echo $tournament->id_tournoi?>&id_rencontre=<?php echo $rencontre->id_rencontre?>">Editer</a>
                                <?php }
                            }
                        }?>
                        </form>
                    </div>
                </section>
            </div>
        </main>

<?php 
    require 'inc/footer.inc.php';
?>