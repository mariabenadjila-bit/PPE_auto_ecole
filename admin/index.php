<?php
    session_start();
    if (!isset($_SESSION['id_user'])) {
        header('Location: ../login.php');
        exit();
    }
    require_once('controleur/controleur_class.php');
    $unControleur = new Controleur();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Auto-École - Castellane-auto</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php if (isset($_SESSION['email'])): ?>
        <div class="header-container">
            <div class="header-left">
                <h1>Castellane-auto - Gestion</h1>
                <div class="user-info">
                    Connecté en tant que : <strong><?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></strong>
                    (<?php echo ucfirst($_SESSION['role']); ?>)
                </div>
            </div>
            <div class="header-right">
                <a href="index.php?page=8" class="btn-logout">
                    Déconnexion
                </a>
            </div>
        </div>

        <div class="nav-icons">
            <a href="index.php?page=1" class="nav-icon-link">
                <img src="images/logoAutoEcole.png" alt="Accueil">
                <span class="nav-icon-label">Accueil</span>
            </a>
            <a href="index.php?page=2" class="nav-icon-link">
                <img src="images/candidat.png" alt="Candidats">
                <span class="nav-icon-label">Candidats</span>
            </a>
            <a href="index.php?page=3" class="nav-icon-link">
                <img src="images/moniteur.png" alt="Moniteurs">
                <span class="nav-icon-label">Moniteurs</span>
            </a>
            <a href="index.php?page=4" class="nav-icon-link">
                <img src="images/vehicule.png" alt="Véhicules">
                <span class="nav-icon-label">Véhicules</span>
            </a>
            <a href="index.php?page=5" class="nav-icon-link">
                <img src="images/lecon.png" alt="Leçons">
                <span class="nav-icon-label">Leçons</span>
            </a>
            <a href="index.php?page=6" class="nav-icon-link">
                <img src="images/examen.png" alt="Examens">
                <span class="nav-icon-label">Examens</span>
            </a>
            <a href="index.php?page=7" class="nav-icon-link">
                <img src="images/demandes.png" alt="Demandes">
                <span class="nav-icon-label">Demandes</span>
            </a>
        </div>

        <div class="content-container">
            <?php
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                }
                
                switch ($page) {
                    case 1: require_once("controleur/home.php"); break;
                    case 2: require_once("controleur/gestion_candidats.php"); break;
                    case 3: require_once("controleur/gestion_moniteurs.php"); break;
                    case 4: require_once("controleur/gestion_vehicules.php"); break;
                    case 5: require_once("controleur/gestion_lecons.php"); break;
                    case 6: require_once("controleur/gestion_examens.php"); break;
                    case 7: require_once("controleur/gestion_demandes.php"); break;
                    case 8: 
                        session_destroy();
                        unset($_SESSION['email']);
                        header("Location: ../login.php");
                        break;
                    default: require_once("controleur/erreur.php"); break;
                }
            ?>
        </div>
    <?php endif; ?>
</body>
</html>