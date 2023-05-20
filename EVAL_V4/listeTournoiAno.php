<?php
require_once 'inc/db_tournoi.inc.php';
require_once 'inc/db_statut.inc.php';
require_once 'inc/db_sport.inc.php';
require_once 'php/listeTournoiAno.inc.php';

$listeTournoiAno = new ListeTournoisAno();
$message = $listeTournoiAno->get_message();
$title = "Liste des tournois";

require 'inc/headerTwo.inc.php';
?>

    <main>
        <div class="filAriane">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="listeTournoiAno.php">Liste tournois</a></li>
            </ul>
        </div>
        <h1 class="h2 h2__main">Liste des tournois</h1>
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
        <div class="main__sections">
            <?php
            $participations[] = $listeTournoiAno->get_participations();
            foreach ($participations[0] as $participation) {
                $tournament = $listeTournoiAno->get_tournament();
                $tournament->id_tournoi = $participation->id_tournoi;
                $tournament->nom = $listeTournoiAno->get_tournamentRepository()->getNom($tournament->id_tournoi, $message);
                $tournament->id_sport = $listeTournoiAno->get_sportRepository()->getSportIdByTournamentId($tournament->id_tournoi, $message);
                $tournament->placesDispo = $listeTournoiAno->get_tournamentRepository()->getPlacesDispo($tournament->id_tournoi, $message);
                $tournament->statut = $listeTournoiAno->get_statutRepository()->getStatutIdByTournamentId($tournament->id_tournoi, $message);
                $tournament->dateTournoi = $listeTournoiAno->get_tournamentRepository()->getDateTournoi($tournament->id_tournoi, $message);
                $tournament->dateFinInscription = $listeTournoiAno->get_tournamentRepository()->getDateFinInscription($tournament->id_tournoi, $message);
                $tournament->estActif = $listeTournoiAno->get_tournamentRepository()->getEstActif($tournament->id_tournoi,$message);
                $tournament->id_organisateur = $listeTournoiAno->get_tournamentRepository()->getOrganisateur($tournament->id_tournoi, $message);

                $nomSport = $listeTournoiAno->get_sportRepository()->getSportByTournamentId($tournament->id_sport, $message);
                $statut = $listeTournoiAno->get_statutRepository()->getStatutByTournamentId($tournament->statut, $message);

                $nombreParticipation = $listeTournoiAno->get_participesRepository()->getNumberParticipationByTournamentId($tournament->id_tournoi, $message);
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
                            <td><?php echo $tournament->dateFinInscription ?></td>
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