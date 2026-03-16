<?php
session_start();

require_once('admin/controleur/controleur_class.php');
$unControleur = new Controleur();

$messageSucces = false;
$messageErreur = "";

// Traitement du formulaire
if (isset($_POST['Inscription'])) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $mdp_confirm = $_POST['mdp_confirm'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    
    // Vérifications
    if ($mdp != $mdp_confirm) {
        $messageErreur = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'email existe déjà
        $userExist = $unControleur->verifierEmailExiste($email);
        
        if ($userExist) {
            $messageErreur = "Cet email est déjà utilisé. <a href='login.php'>Se connecter</a>";
        } else {
            // 1. Créer le compte utilisateur
            $tabUser = array(
                "email" => $email,
                "mdp" => $mdp,
                "nom" => $nom,
                "prenom" => $prenom,
                "role" => "client"
            );
            $unControleur->insert_user($tabUser);
            
            // 2. Créer le candidat
            $tabCandidat = array(
                "nomC" => $nom,
                "prenomC" => $prenom,
                "date_naissanceC" => $date_naissance,
                "adresseC" => $adresse,
                "telephoneC" => $telephone,
                "date_inscription" => date('Y-m-d'),
                "statut" => "En formation"
            );
            $unControleur->insert_candidat($tabCandidat);
            
            $messageSucces = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CASTELLANE-AUTO</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .logo {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .logo h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        h2 {
            color: #2e7d32;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
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

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4caf50;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
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
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: #45a049;
        }

        .success-message {
            background: #c8e6c9;
            color: #2e7d32;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #4caf50;
            text-align: center;
        }

        .success-message h3 {
            margin-bottom: 10px;
        }

        .error-message {
            background: #ffcdd2;
            color: #c62828;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #f44336;
        }

        .link-login {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .link-login a {
            color: #4caf50;
            text-decoration: none;
            font-weight: 600;
        }

        .link-login a:hover {
            text-decoration: underline;
        }

        .info-box {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #2196f3;
            font-size: 14px;
        }

        .info-box strong {
            color: #1976d2;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>🚗 CASTELLANE-AUTO</h1>
            <p>Inscription en ligne</p>
        </div>

        <div class="card">
            <?php if ($messageSucces): ?>
                <div class="success-message">
                    <h3>✅ Inscription réussie !</h3>
                    <p>Votre compte a été créé avec succès.</p>
                    <p>Vous pouvez maintenant vous connecter et réserver vos leçons.</p>
                    <a href="login.php" class="btn-submit" style="margin-top: 20px; display: inline-block; text-decoration: none;">
                        Se connecter
                    </a>
                </div>
            <?php else: ?>
                <?php if ($messageErreur): ?>
                    <div class="error-message">
                        ❌ <?php echo $messageErreur; ?>
                    </div>
                <?php endif; ?>

                <h2>Créer mon compte</h2>
                <p class="subtitle">Remplissez le formulaire pour vous inscrire à l'auto-école</p>

                <div class="info-box">
                    <strong>ℹ️ Après inscription, vous pourrez :</strong><br>
                    • Réserver vos leçons de conduite en ligne<br>
                    • Vous inscrire aux examens<br>
                    • Consulter votre planning et vos résultats
                </div>

                <form method="post">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nom">Nom *</label>
                            <input type="text" id="nom" name="nom" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom *</label>
                            <input type="text" id="prenom" name="prenom" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="date_naissance">Date de naissance *</label>
                        <input type="date" id="date_naissance" name="date_naissance" 
                               max="<?php echo date('Y-m-d', strtotime('-14 years')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" placeholder="exemple@email.fr" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="mdp">Mot de passe *</label>
                            <input type="password" id="mdp" name="mdp" minlength="6" required>
                        </div>
                        <div class="form-group">
                            <label for="mdp_confirm">Confirmer mot de passe *</label>
                            <input type="password" id="mdp_confirm" name="mdp_confirm" minlength="6" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telephone">Téléphone *</label>
                        <input type="tel" id="telephone" name="telephone" placeholder="06 XX XX XX XX" required>
                    </div>

                    <div class="form-group">
                        <label for="adresse">Adresse complète *</label>
                        <input type="text" id="adresse" name="adresse" placeholder="10 rue de la Paix, 83000 Toulon" required>
                    </div>

                    <button type="submit" name="Inscription" class="btn-submit">
                        ✅ Créer mon compte
                    </button>
                </form>

                <div class="link-login">
                    Vous avez déjà un compte ? <a href="login.php">Se connecter</a>
                </div>
            <?php endif; ?>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="index.html" style="color: white; text-decoration: none; font-weight: 600;">
                ← Retour au site
            </a>
        </div>
    </div>
</body>
</html>
