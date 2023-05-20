<?php
  require 'php/session.inc.php';
  require_once 'inc/db_user.inc.php';
  require_once 'inc/db_tournoi.inc.php';
  require_once 'inc/db_statut.inc.php';
  require_once 'inc/db_sport.inc.php';
  require_once 'php/listeTournois.inc.php';

  $listeTournois = new ListeTournois();
  $message = $listeTournois->get_message();
  $title = "Tournois";
  require 'inc/headerFour.inc.php';

  if (empty($_SESSION['id_utilisateur']) || $_SESSION['id_utilisateur'] == "") {
     header('location: listeTournoiAno.php');
  }
  ?>  

        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="listeTournois.php">Liste tournois</a></li>
                </ul>
            </div>
            <h1 class="h2 h2__main">Vos tournois</h1>
            <?php echo $message ?>
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <div class="options__tournois">
                    <div class="option__tournois">
                        <label for="form__listeTournois__statut">Statut :</label>
                        <select name="form__listeTournois__statut" id="form__listeTournois__statut">
                            <option value="all">Tous</option>
                            <option value="1">Ouvert</option>
                            <option value="2">Fermé</option>
                            <option value="3">Clôturé</option>
                            <option value="4">Généré</option>
                            <option value="5">En-cours</option>
                            <option value="6">Terminé</option>
                        </select>
                    </div>
                    <div class="option__tournois">
                        <label for="form__listeTournois__sport">Sport :</label>
                        <select name="form__listeTournois__sport" id="form__listeTournois__sport">
                            <option value="all">Tous</option>
                            <option value="1">Jeu d'échecs</option>
                            <option value="2">Belote</option>
                            <option value="3">FIFA</option>
                            <option value="4">Tennis</option>
                            <option value="5">Ping-Pong</option>
                        </select>
                    </div>
                    <input type="submit" name="form__button__submit">
                </div>
            </form>

            <?php if ($listeTournois->get_nePasAfficher() == 1) { ?>
            <h1>Vous ne participez à aucun tournoi !</h1>
            <?php } else { ?>
            <div class="main__sections">
                <?php
                $participations[] = $listeTournois->get_participations();
                $id_tournament = array();
                foreach ($participations[0] as $participation) {
                    $tournament = $listeTournois->get_tournament();
                    $tournament->id_tournoi = $participation->id_tournoi;
                    array_push($id_tournament, $tournament->id_tournoi);
                    $tournament->nom = $listeTournois->get_tournamentRepository()->getNom($tournament->id_tournoi, $message);
                    $tournament->id_sport = $listeTournois->get_sportRepository()->getSportIdByTournamentId($tournament->id_tournoi, $message);
                    $tournament->placesDispo = $listeTournois->get_tournamentRepository()->getPlacesDispo($tournament->id_tournoi, $message);
                    $tournament->statut = $listeTournois->get_statutRepository()->getStatutIdByTournamentId($tournament->id_tournoi, $message);
                    $tournament->dateTournoi = $listeTournois->get_tournamentRepository()->getDateTournoi($tournament->id_tournoi, $message);
                    $tournament->dateFinInscription = $listeTournois->get_tournamentRepository()->getDateFinInscription($tournament->id_tournoi, $message);
                    $tournament->estActif = $listeTournois->get_tournamentRepository()->getEstActif($tournament->id_tournoi,$message);
                    $tournament->id_organisateur = $listeTournois->get_tournamentRepository()->getOrganisateur($tournament->id_tournoi, $message);

                    $nomSport = $listeTournois->get_sportRepository()->getSportByTournamentId($tournament->id_sport, $message);
                    $statut = $listeTournois->get_statutRepository()->getStatutByTournamentId($tournament->statut, $message);
                    $result = $listeTournois->get_participesRepository()->getParticipationTrueFalse($_SESSION['id_utilisateur'], $tournament->id_tournoi, $message);
                    if (!$result) {
                        $statutJoueur = "Non-inscrit";
                    } else {
                        $statutJoueur ="Inscrit";
                    }

                    $nombreParticipation = $listeTournois->get_participesRepository()->getNumberParticipationByTournamentId($tournament->id_tournoi, $message);
                    $nombrePlacesRestantes = $tournament->placesDispo - $nombreParticipation;
                    ?>

                    <section class="main__sections__game">
                    <div class="box__size">
                    </div>
                    <div class="main__sections__game__item">
                        <div class="title">
                            <p class="title__game"><?php echo $nomSport?></p>
                            <p><?php echo $tournament->dateTournoi ?></p>
                        </div>
                        <h2 class="tournament__title"><?php echo $tournament->nom ?></h2>

                        <table class="tournament__table">
                            <tr>
                                <th>Statut :</th>
                                <td><?php echo $statut?></td>
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
                            <tr>
                                <th>Statut joueur :</th>
                                <td><?php echo $statutJoueur ?></td>
                            </tr>
                        </table>
                        <a class="a__details" href="detailsTournoi.php?id_tournoi=<?php echo $tournament->id_tournoi?>">Afficher détails</a>
                        <?php if ($_SESSION['id_utilisateur'] == $tournament->id_organisateur) { ?>
                            <a class="fake__button__delete" href="supprimerTournoi.php?id_tournoi=<?php echo $tournament->id_tournoi?>">Supprimer</a>
                       <?php
                        }
                        ?>
                    </div>
                </section>
                    <?php
                    }
                }
                    ?>
            </div>
            <a class="fake__button__full__create" href="creaTournois.php">Créer</a>
            <h1 class="h2 h2__main">Tous les tournois</h1>
            <div class="main__sections">
                <?php
                $allTournaments[] = $listeTournois->get_allTournaments();
                $id_tournament2 = array();
                foreach ($allTournaments[0] as $allTournament) {
                    $tournament2 = $listeTournois->get_tournament2();
                    $tournament2->id_tournoi = $allTournament->id_tournoi;
                    if (!in_array($tournament2->id_tournoi, $id_tournament2)) {
                        $tournament2->nom = $listeTournois->get_tournamentRepository()->getNom($tournament2->id_tournoi, $message);
                        $tournament2->id_sport = $listeTournois->get_sportRepository()->getSportIdByTournamentId($tournament2->id_tournoi, $message);
                        $tournament2->placesDispo = $listeTournois->get_tournamentRepository()->getPlacesDispo($tournament2->id_tournoi, $message);
                        $tournament2->statut = $listeTournois->get_statutRepository()->getStatutIdByTournamentId($tournament2->id_tournoi, $message);
                        $tournament2->dateTournoi = $listeTournois->get_tournamentRepository()->getDateTournoi($tournament2->id_tournoi, $message);
                        $tournament2->dateFinInscription = $listeTournois->get_tournamentRepository()->getDateFinInscription($tournament2->id_tournoi, $message);
                        $tournament2->estActif = $listeTournois->get_tournamentRepository()->getEstActif($tournament2->id_tournoi,$message);
                        $tournament2->id_organisateur = $listeTournois->get_tournamentRepository()->getOrganisateur($tournament2->id_tournoi, $message);

                        $nomSport2 = $listeTournois->get_sportRepository()->getSportByTournamentId($tournament2->id_sport, $message);
                        $statut2 = $listeTournois->get_statutRepository()->getStatutByTournamentId($tournament2->statut, $message);
                        $result2 = $listeTournois->get_participesRepository()->getParticipationTrueFalse($_SESSION['id_utilisateur'], $tournament2->id_tournoi, $message);
                        if (!$result2) {
                            $statutJoueur2 = "Non-inscrit";
                        } else {
                            $statutJoueur2 ="Inscrit";
                        }

                        $nombreParticipation2 = $listeTournois->get_participesRepository()->getNumberParticipationByTournamentId($tournament2->id_tournoi, $message);
                        $nombrePlacesRestantes2 = $tournament2->placesDispo - $nombreParticipation2;
                    ?>

                    <section class="main__sections__game">
                        <div class="box__size">
                        </div>
                        <div class="main__sections__game__item">
                            <div class="title">
                                <p class="title__game"><?php echo $nomSport2?></p>
                                <p><?php echo $tournament2->dateTournoi ?></p>
                            </div>

                            <h2 class="tournament__title"><?php echo $tournament2->nom ?></h2>
                            <table class="tournament__table">
                                <tr>
                                    <th>Statut :</th>
                                    <td><?php echo $statut2 ?></td>
                                </tr>
                                <tr>
                                    <th>Nombre de joueurs :</th>
                                    <td><?php echo $nombreParticipation2 ?></td>
                                </tr>
                                <tr>
                                    <th>Places restantes :</th>
                                    <td><?php echo $nombrePlacesRestantes2 ?></td>
                                </tr>
                                <tr>
                                    <th>Fin des inscriptions :</th>
                                    <td><?php echo $tournament2->dateFinInscription ?></td>
                                </tr>
                                <tr>
                                    <th>Statut joueur :</th>
                                    <td><?php echo $statutJoueur2 ?></td>
                                </tr>
                            </table>
                            <a class="a__details" href="detailsTournoi.php?id_tournoi=<?php echo $tournament2->id_tournoi?>">Afficher détails</a>
                            <?php if ($_SESSION['id_utilisateur'] == $tournament2->id_organisateur) { ?>
                                <a class="fake__button__delete" href="supprimerTournoi.php?id_tournoi=<?php echo $tournament2->id_tournoi?>">Supprimer</a>
                                <?php
                            }
                            ?>
                        </div>
                    </section>
                    <?php
                    }
                 }
                ?>
            </div>
        </main>

<?php 
    require 'inc/footer.inc.php';
?>