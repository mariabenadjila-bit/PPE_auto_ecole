<?php
    session_start();

    if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'client') {
        header('Location: ../login.php');
        exit();
    }

    require_once('../admin/controleur/controleur_class.php');
    $unControleur = new Controleur();

    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $candidat = $unControleur->selectCandidatByNomPrenom($nom, $prenom);

    if (!$candidat) {
        header('Location: index.php');
        exit();
    }

    $id_candidat = $candidat['id_candidat'];
    $messageSucces = false;

    if (isset($_POST['ReserverLecon'])) {
        $tab = array(
            "id_candidat" => $id_candidat,
            "id_moniteur" => null,
            "id_vehicule" => null,  
            "date_lecon" => $_POST['date_lecon'],
            "libelle" => $_POST['libelle'],
            "duree_lecon" => $_POST['duree_lecon'],
            "compterendu" => "Réservation en ligne - En attente d'attribution moniteur/véhicule"
        );
        
        $unControleur->insert_lecon($tab);
        $messageSucces = true;
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver une leçon - CASTELLANE-AUTO</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        .header {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        h2 {
            color: #2e7d32;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #4caf50;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #4caf50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background: #45a049;
        }

        .success-message {
            background: #c8e6c9;
            color: #2e7d32;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #4caf50;
        }

        .info-box {
            background: #fff3e0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #ff9800;
        }

        .info-box h3 {
            color: #f57c00;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .info-box ul {
            margin-left: 20px;
            color: #555;
        }

        .info-box li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <h1>Castellane-auto</h1>
                <p>Réserver une leçon</p>
            </div>
            <div class="nav-links">
                <a href="index.php">← Tableau de bord</a>
                <a href="reserver-examen.php">Réserver un examen</a>
                <a href="logout.php">Déconnexion</a>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if ($messageSucces): ?>
            <div class="success-message">
                Votre demande de leçon a été enregistrée !<br>
                <strong>L'auto-école vous contactera pour confirmer et vous attribuer un moniteur et un véhicule.</strong>
            </div>
        <?php endif; ?>

        <div class="info-box">
            <h3>Informations importantes</h3>
            <ul>
                <li><strong>Cette demande nécessite une confirmation de l'auto-école</strong></li>
                <li>Un moniteur et un véhicule vous seront attribués</li>
                <li>Vous recevrez une confirmation par email ou téléphone</li>
                <li>Réservez au moins 48h à l'avance</li>
                <li>Les leçons durent généralement 55 minutes</li>
            </ul>
        </div>

        <div class="card">
            <h2>Demander une leçon</h2>
            
            <form method="post">
                <div class="form-group">
                    <label for="libelle">Type de cours *</label>
                    <select name="libelle" id="libelle" required>
                        <option value="">-- Choisir --</option>
                        <option value="Permis B">Permis B (Voiture)</option>
                        <option value="Permis A">Permis A (Moto)</option>
                        <option value="Conduite accompagnée">Conduite accompagnée</option>
                        <option value="Code de la route">Code de la route</option>
                        <option value="BSR">BSR</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_lecon">Date et heure souhaitées *</label>
                    <input type="datetime-local" id="date_lecon" name="date_lecon" 
                           min="<?php echo date('d-m-Y\TH:i', strtotime('+48 hours')); ?>" 
                           required>
                    <small style="color: #666;">Minimum 48h à l'avance</small>
                </div>

                <div class="form-group">
                    <label for="duree_lecon">Durée souhaitée *</label>
                    <select name="duree_lecon" id="duree_lecon" required>
                        <option value="30">30 minutes</option>
                        <option value="45">45 minutes</option>
                        <option value="60" selected>1 heure (55 min)</option>
                        <option value="90">1h30</option>
                        <option value="120">2 heures</option>
                    </select>
                </div>

                <button type="submit" name="ReserverLecon" class="btn-submit">
                    Envoyer la demande de leçon
                </button>
            </form>

            <div style="margin-top: 20px; padding: 15px; background: #f5f5f5; border-radius: 8px;">
                <h4 style="margin-bottom: 10px; color: #2e7d32;">Après votre demande :</h4>
                <ul style="margin-left: 20px; color: #666;">
                    <li>L'auto-école vous contactera pour confirmer</li>
                    <li>Un moniteur disponible vous sera attribué</li>
                    <li>Un véhicule adapté sera réservé pour vous</li>
                    <li>Vous verrez la leçon confirmée dans votre tableau de bord</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>