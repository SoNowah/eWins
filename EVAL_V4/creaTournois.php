<?php
    require 'php/session.inc.php';
    require_once 'php/creaTournois.inc.php';

    $creationTournoi = new CreerTournoi();
    $creationTournoi->creationTournoi();
    $title = "Création de tounois";
    include('inc/headerThree.inc.php');
?>

        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="listeTournois.php">Liste tournois</a></li>
                    <li><a href="creaTournois.php">Création tournoi</a> </li>
                </ul>
            </div>
            <h1 class="h2 h2__main">Création du tournoi</h1>
            <div class="main__bloc__center">
                <section class="main main__section__creationTour">
                    <?php echo $creationTournoi->get_message(); ?>
                    <form class="main__section__creationTour__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form__split form__split__left">

                            <label for="form__creationTour__name">Nom*</label> <input type="text" name="form__creationTour__name" id="form__creationTour__name" autofocus required value="<?php echo isset($_POST['form__creationTour__name']) ? trim($_POST['form__creationTour__name']) : "" ?>"/>

                            <label for="form__creationTour__sport">Sport*</label><br/>
                            <select name="form__creationTour__sport" id="form__creationTour__sport">
                                <option value="1">Jeu d'échecs</option>
                                <option value="2">Belote</option>
                                <option value="3">FIFA</option>
                                <option value="4">Tennis</option>
                                <option value="5">Ping-Pong</option>
                            </select>
                        </div>
                        <div class="form__split form__split__right__creationTour">
                            <label for="form__creationTour__nbPlaceDispo">Nombre de place disponibles</label> <input type="number" name="form__creationTour__nbPlaceDispo" id="form__creationTour__nbPlaceDispo"  min="2" required value="<?php echo isset($_POST['form__creationTour__nbPlaceDispo']) ? trim($_POST['form__creationTour__nbPlaceDispo']) : "10" ?>"/>

                            <label for="form__creationTour__dateTour">Date du tournoi*</label> <input type="date" name="form__creationTour__dateTour" id="form__creationTour__dateTour" required value="<?php echo isset($_POST['form__creationTour__dateTour']) ? trim($_POST['form__creationTour__dateTour']) : "" ?>"/>

                            <label for="form__creationTour__dateTourFin">Date de fin des inscriptions*</label> <input type="date" name="form__creationTour__dateTourFin" id="form__creationTour__dateTourFin" required value="<?php echo isset($_POST['form__creationTour__dateTourFin']) ? trim($_POST['form__creationTour__dateTourFin']) : "" ?>"/>
                        </div>
                        <input type="submit" name="form__button__submit" value="Créer"/>
                    </form>
                </section>
            </div>
        </main>

<?php 
    include('inc/footer.inc.php');
?>