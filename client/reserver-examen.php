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

    
    if (isset($_POST['ReserverExamen'])) {
        $tab = array(
            "id_candidat" => $id_candidat,
            "id_moniteur" => null,  
            "id_vehicule" => null,
            "type_examen" => $_POST['type_examen'],
            "lieu_examen" => $_POST['lieu_examen'],
            "date_examen" => $_POST['date_examen'],
            "resultat" => 'En attente',
            "remarques" => "Réservation en ligne - En attente de confirmation"
        );
        
        $unControleur->insert_examen($tab);
        $unControleur->update_statut_candidat($id_candidat);
        $messageSucces = true;
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un examen</title>
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
                <p>Réserver un examen</p>
            </div>
            <div class="nav-links">
                <a href="index.php">← Tableau de bord</a>
                <a href="reserver-lecon.php">Réserver une leçon</a>
                <a href="logout.php">Déconnexion</a>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if ($messageSucces): ?>
            <div class="success-message">
                Votre demande d'inscription à l'examen a été enregistrée !<br>
                <strong>L'auto-école vous contactera pour confirmer la date et vous fournir le numéro de convocation.</strong>
            </div>
        <?php endif; ?>

        <div class="info-box">
            <h3>Informations importantes</h3>
            <ul>
                <li><strong>Cette demande nécessite une confirmation de l'auto-école</strong></li>
                <li>Un moniteur et un véhicule vous seront attribués</li>
                <li>Vous recevrez votre numéro de convocation par email</li>
                <li>Assurez-vous d'avoir suivi le nombre d'heures requis</li>
                <li>L'examen doit être réservé au moins 15 jours à l'avance</li>
            </ul>
        </div>

        <div class="card">
            <h2>Demander une inscription à un examen</h2>
            
            <form method="post">
                <div class="form-group">
                    <label for="type_examen">Type d'examen *</label>
                    <select name="type_examen" id="type_examen" required>
                        <option value="">-- Choisir --</option>
                        <option value="Code de la route">Code de la route</option>
                        <option value="Conduite Permis B">Conduite Permis B</option>
                        <option value="Conduite Permis A">Conduite Permis A (Moto)</option>
                        <option value="BSR">BSR</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_examen">Date souhaitée *</label>
                    <input type="date" id="date_examen" name="date_examen" 
                           min="<?php echo date('d-m-Y', strtotime('+15 days')); ?>" 
                           required>
                    <small style="color: #666;">Minimum 15 jours à l'avance</small>
                </div>

                <div class="form-group">
                    <label for="lieu_examen">Lieu de passage souhaité *</label>
                    <select name="lieu_examen" id="lieu_examen" required>
                        <option value="">-- Choisir --</option>
                        <option value="Centre d'examen de Toulon">Centre d'examen de Toulon</option>
                        <option value="Centre d'examen de La Garde">Centre d'examen de La Garde</option>
                        <option value="Centre d'examen de Hyères">Centre d'examen de Hyères</option>
                        <option value="Autre (préciser dans remarques)">Autre (à préciser)</option>
                    </select>
                </div>

                <button type="submit" name="ReserverExamen" class="btn-submit">
                    Envoyer la demande d'inscription
                </button>
            </form>

            <div style="margin-top: 20px; padding: 15px; background: #f5f5f5; border-radius: 8px;">
                <h4 style="margin-bottom: 10px; color: #2e7d32;">Prérequis avant de passer l'examen :</h4>
                <ul style="margin-left: 20px; color: #666;">
                    <li><strong>Code de la route :</strong> Révisions complètes</li>
                    <li><strong>Permis B :</strong> Minimum 20 heures de conduite</li>
                    <li><strong>Permis A :</strong> Minimum 20 heures (plateau + circulation)</li>
                    <li><strong>BSR :</strong> 7 heures de formation obligatoires</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>