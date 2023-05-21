<?php
  require 'php/session.inc.php';
  require_once 'php/editionTournoi.inc.php';

  $editionTournoi = new EditionTournoi();
  if (isset($_POST['butEdTournoi'])) {
      $editionTournoi->editerTournoi();
  }
  $tournament = $editionTournoi->get_tournament();
  $title = "Edition d'un tournoi";
  include('inc/headerThree.inc.php');
  ?>  

        <main>
            <div class="filAriane">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="listeTournois.php">Liste tournois</a></li>
                    <li><a href="detailsTournoi.php?id_tournoi=<?php echo $tournament->id_tournoi?>">Détails tournoi</a></li>
                    <li><a href="editionTournoi.php?id_tournoi=<?php echo $tournament->id_tournoi?>">Modifier tournoi</a> </li>
                </ul>
            </div>
            <h1 class="h2 h2__main">Modification du tournoi</h1>
            <div class="main__bloc__center">
                <section class="main main__section__editionTour">
                    <?php echo $editionTournoi->get_message(); ?>
                    <form class="main__section__editionTour__form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form__split form__split__left">
                            <label for="form__editionTour__name">Nom</label> <input type="text" name="form__editionTour__name" id="form__editionTour__name" autofocus required value="<?php echo isset($_POST['form__editionTour__name']) ? trim($_POST['form__editionTour__name']) : $tournament->nom ?>"/>

                            <label for="form__editionTour__sport">Sport</label><br/>
                            <select name="form__editionTour__sport" id="form__editionTour__sport">
                                <?php
                                switch ($tournament->id_sport) {
                                    case 1:?>
                                        <option value="1" selected>Jeu d'échecs</option>
                                        <option value="2">Belote</option>
                                        <option value="3">FIFA</option>
                                        <option value="4">Tennis</option>
                                        <option value="5">Ping-Pong</option>
                                    <?php
                                        break;

                                    case 2:?>
                                        <option value="1">Jeu d'échecs</option>
                                        <option value="2" selected>Belote</option>
                                        <option value="3">FIFA</option>
                                        <option value="4">Tennis</option>
                                        <option value="5">Ping-Pong</option>
                                    <?php
                                        break;

                                    case 3:?>
                                        <option value="1">Jeu d'échecs</option>
                                        <option value="2">Belote</option>
                                        <option value="3" selected>FIFA</option>
                                        <option value="4">Tennis</option>
                                        <option value="5">Ping-Pong</option>
                                    <?php
                                        break;

                                    case 4:?>
                                        <option value="1">Jeu d'échecs</option>
                                        <option value="2">Belote</option>
                                        <option value="3">FIFA</option>
                                        <option value="4" selected>Tennis</option>
                                        <option value="5">Ping-Pong</option>
                                    <?php
                                        break;

                                    case 5:?>
                                        <option value="1" >Jeu d'échecs</option>
                                        <option value="2">Belote</option>
                                        <option value="3">FIFA</option>
                                        <option value="4">Tennis</option>
                                        <option value="5" selected>Ping-Pong</option>
                                    <?php
                                        break;

                                    default:
                                        break;
                                }
                                ?>
                            </select>
                        </div>     
                        <div class="form__split form__split__right__editionTour">

                            <label for="form__editionTour__nbplaceDispo">Nombre de place disponibles</label> <input type="number" name="form__editionTour__nbplaceDispo" id="form__editionTour__nbplaceDispo" min="2" required value="<?php echo isset($_POST['form__editionTour__nbplaceDispo']) ? 10 : $tournament->placesDispo ?>"/>

                            <label for="form__editionTour__dateFinTour">Date du tournoi</label> <input type="date" name="form__editionTour__dateFinTour" id="form__editionTour__dateFinTour" required value="<?php echo isset($_POST['form__editionTour__dateFinTour']) ? trim($_POST['form__editionTour__dateFinTour']) : $tournament->dateTournoi ?>" />

                            <label for="form__editionTour__dateFinIscription">Date de fin des inscriptions</label> <input type="date" name="form__editionTour__dateFinIscription" id="form__editionTour__dateFinIscription" required value="<?php echo isset($_POST['form__editionTour__dateFinIscription']) ? trim($_POST['form__editionTour__dateFinIscription']) : $tournament->dateFinInscription ?>"/>
                        </div>

                        <input type="submit" name="butEdTournoi" value="Modifier"/>
                        <input type="hidden" name="id_tournoi" value="<?php if ($tournament->id_tournoi != null) {
                            echo $tournament->id_tournoi;
                        }?>">
                    </form>
                </section>
            </div>
        </main>

<?php 
    include('inc/footer.inc.php'); 
?>