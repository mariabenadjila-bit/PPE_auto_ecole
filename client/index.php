<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil client</title>
</head>
<body>
    <center>
        <h1>Bienvenue sur votre espace client CASTELLANE-AUTO</h1>
        <a href="index.php?page=1"> <img src="images/mon_compte.png" width="100" height="100" alt="Accueil"></a>
        <a href="index.php?page=2"> <img src="images/mes_cours.png" width="100" height="100" alt="Mes Cours"></a>
        <a href="index.php?page=3"> <img src="images/reservation.png" width="100" height="100" alt="Réservation"></a>
        <a href="index.php?page=4"> <img src="images/deconnexion.jpg" width="100" height="100" alt="Déconnexion"></a>

        <?php
            if (isset($_GET["page"])) {
                $page = $_GET["page"];
            } else {
                $page = 1;
            }
            
            switch ($page) {
                case 1: require_once("index.php"); break;
                case 2: require_once("mes_cours.php"); break;
                case 3: require_once("reservation.php"); break;
                case 4: 
                    session_destroy();
                        unset($_SESSION['email']);
                        header("Location: ../login.php");
                        break;
                default: require_once(__DIR__ . "../admin/controleur/erreur.php"); break;
            }
        ?>
    </center>
</body>
</html>