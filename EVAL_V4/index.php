<?php
    require 'php/session.inc.php';
    require_once 'inc/db_tournoi.inc.php';
    require_once 'inc/db_statut.inc.php';
    require_once 'inc/db_sport.inc.php';
    require_once 'php/listeTournoiAno.inc.php';

    $index = new ListeTournoisAno();
    $message = $index->get_message();
    $title = "Index";
    if (empty($_SESSION['id_utilisateur']) || $_SESSION['id_utilisateur'] == "") {
        require 'inc/headerTwo.inc.php';
    } else {
        require 'inc/headerThree.inc.php';
    }
?>

        <main>
            <h1 class="h2 h2__main">Bienvenue sur eWins,</h1>
            <h1 class="h2 h2__under">votre site de tournois préféré</h1>
            <?php echo $message ?>
                <div class="main__sections">
                    <?php
                    $participations[] = $index->get_participations();
                    for ($i = 0; $i < 5; $i++) {
                        $tournament = $index->get_tournament();
                        $tournament->id_tournoi = $participations[0][$i]->id_tournoi;
                        $tournament->nom = $index->get_tournamentRepository()->getNom($tournament->id_tournoi, $message);
                        $tournament->id_sport = $index->get_sportRepository()->getSportIdByTournamentId($tournament->id_tournoi, $message);
                        $tournament->placesDispo = $index->get_tournamentRepository()->getPlacesDispo($tournament->id_tournoi, $message);
                        $tournament->statut = $index->get_statutRepository()->getStatutIdByTournamentId($tournament->id_tournoi, $message);
                        $tournament->dateTournoi = $index->get_tournamentRepository()->getDateTournoi($tournament->id_tournoi, $message);
                        $tournament->dateFinInscription = $index->get_tournamentRepository()->getDateFinInscription($tournament->id_tournoi, $message);
                        $tournament->estActif = $index->get_tournamentRepository()->getEstActif($tournament->id_tournoi,$message);
                        $tournament->id_organisateur = $index->get_tournamentRepository()->getOrganisateur($tournament->id_tournoi, $message);

                        $nomSport = $index->get_sportRepository()->getSportByTournamentId($tournament->id_sport, $message);
                        $statut = $index->get_statutRepository()->getStatutByTournamentId($tournament->statut, $message);

                        $nombreParticipation = $index->get_participesRepository()->getNumberParticipationByTournamentId($tournament->id_tournoi, $message);
                        $nombrePlacesRestantes = $tournament->placesDispo - $nombreParticipation;
                        ?>
                    <section class="main__sections__game">
                        <div class="main__sections__game__item">
                            <div class="title">
                                <p class="title__game"><?php echo $nomSport ?></p>
                                <p><?php echo $tournament->dateTournoi ?></p>
                            </div>
                            
                            <h2 class="tournament__title"><?php echo $tournament->nom ?></h2>
                            <table class="tournament__table">
                                <tr>
                                    <th>Statut :</th>
                                    <td><?php echo $statut ?></td>
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
                                    <td><?php echo $tournament->dateFinInscription?></td>
                                </tr>
                            </table>
                        </div>
                    </section>
                        <?php
                        }
                        ?>
                </div>
        </main>

<?php 
    require 'inc/footer.inc.php';
?>