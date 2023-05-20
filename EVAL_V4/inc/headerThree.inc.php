<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel ="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
        <link rel="stylesheet" href="css/style.css">
        <title><?php echo $title ?></title>
    </head>
    <body>
        <header>
            <nav class="nav">
                <a href="index.php"><img class="img__logo" src="images/logoEwinsV2.png" alt="Logo eWins"/></a>
                <ul class="nav__links">
                    <li class="nav__links__element"><a class="a__link" href="index.php">Accueil</a></li>
                    <li class="nav__links__element"><a class="a__link" href="contact.php">Contact</a></li>
                    <li class="nav__links__element"><a class="a__link" href="listeTournois.php">Tournois</a></li>
                    <li class="nav__links__element"><a class="a__link" href="profil.php"><?php echo $_SESSION['nom'] . " " . $_SESSION['prenom'] ?></a></li>
                </ul>
            </nav>
        </header>