<?php
require 'php/session.inc.php';
require_once 'inc/db_user.inc.php';
require_once 'inc/db_tournoi.inc.php';
require_once 'inc/db_statut.inc.php';
require_once 'inc/db_sport.inc.php';
require_once 'php/mesTournois.inc.php';

$mesTournois = new MesTournois();
$message = $mesTournois->get_message();
$title = "Tournois utilisateur";
require 'inc/headerThree.inc.php';

if (empty($_SESSION['id_utilisateur']) || $_SESSION['id_utilisateur'] == "") {
    header('location: listeTournoiAno.php');
}
?>

    <main>
        <div class="filAriane">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="listeTournois.php">Liste tournois</a></li>
                <li><a href="mesTournois.php">Mes tournois</a></li>
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

        <div class="main__sections">
            <?php
            $participations[] = $mesTournois->get_participations();
            foreach ($participations[0] as $participation) {
                $tournament = $mesTournois->get_tournament();
                $tournament->id_tournoi = $participation->id_tournoi;
                $tournament->nom = $mesTournois->get_tournamentRepository()->getNom($tournament->id_tournoi, $message);
                $tournament->id_sport = $mesTournois->get_sportRepository()->getSportIdByTournamentId($tournament->id_tournoi, $message);
                $tournament->placesDispo = $mesTournois->get_tournamentRepository()->getPlacesDispo($tournament->id_tournoi, $message);
                $tournament->statut = $mesTournois->get_statutRepository()->getStatutIdByTournamentId($tournament->id_tournoi, $message);
                $tournament->dateTournoi = $mesTournois->get_tournamentRepository()->getDateTournoi($tournament->id_tournoi, $message);
                $tournament->dateFinInscription = $mesTournois->get_tournamentRepository()->getDateFinInscription($tournament->id_tournoi, $message);
                $tournament->estActif = $mesTournois->get_tournamentRepository()->getEstActif($tournament->id_tournoi,$message);
                $tournament->id_organisateur = $mesTournois->get_tournamentRepository()->getOrganisateur($tournament->id_tournoi, $message);

                $nomSport = $mesTournois->get_sportRepository()->getSportByTournamentId($tournament->id_sport, $message);
                $statut = $mesTournois->get_statutRepository()->getStatutByTournamentId($tournament->statut, $message);


                $nombreParticipation = $mesTournois->get_participesRepository()->getNumberParticipationByTournamentId($tournament->id_tournoi, $message);
                $nombrePlacesRestantes = $tournament->placesDispo - $nombreParticipation;
                ?>

                <section class="main__sections__game">
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
            ?>
        </div>
    </main>

<?php
require 'inc/footer.inc.php';
?>