<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center>
        <h1>Bienvenue sur le site de gestion d'auto-école</h1>
        <?php
            if (!isset($_SESSION['email'])) {
                require_once("vue/vue_connexion.php");
            }
            
            if (isset($_POST['Connexion'])) {
                $email = $_POST['email'];
                $mdp   = $_POST['mdp'];

                $unUser = $unControleur->select_user($email, $mdp);
                if ($unUser == null) {
                    echo "<br> Veuillez vérifier vos identifiants.";
                } else {
                    $_SESSION['email'] = $unUser['email'];
                    $_SESSION['nom'] = $unUser['nom'];
                    $_SESSION['prenom'] = $unUser['prenom'];
                    $_SESSION['role'] = $unUser['role'];
                    header("Location: index.php?page=1"); 
                }  
            }

            if (isset($_SESSION['email'])) {
                echo '
                <a href="index.php?page=1"> <img src="images/logoAutoEcole.png" width="100" height="100" alt="Accueil"></a>
                <a href="index.php?page=2"> <img src="images/candidat.png"      width="100" height="100" alt="Candidats"></a>
                <a href="index.php?page=3"> <img src="images/moniteur.png"      width="100" height="100" alt="Moniteurs"></a>
                <a href="index.php?page=4"> <img src="images/vehicule.png"      width="100" height="100" alt="Véhicules"></a>
                <a href="index.php?page=5"> <img src="images/lecon.png"         width="100" height="100" alt="Leçons"></a>
                <a href="index.php?page=6"> <img src="images/examen.png"        width="100" height="100" alt="Examens"></a>
                <a href="index.php?page=7"> <img src="images/deconnexion.jpg"   width="100" height="100" alt="Déconnexion"></a>
                ';

                
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
                    case 7: 
                        session_destroy();
                        unset($_SESSION['email']);
                        header("Location: index.php");
                        break;
                    default: require_once("controleur/erreur.php"); break;
                }  
            }
        ?>
    </center>
    
</body>
</html>
    
