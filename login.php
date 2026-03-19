<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CASTELLANE-AUTO</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 450px;
            width: 100%;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            color: #2e7d32;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .logo p {
            color: #666;
            font-size: 14px;
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
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4caf50;
        }

        .btn-login {
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

        .btn-login:hover {
            background: #45a049;
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c62828;
        }

        .info-box {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 14px;
            color: #1976d2;
            border-left: 4px solid #1976d2;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #4caf50;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .role-badges {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .role-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-admin {
            background: #ffd54f;
            color: #f57f17;
        }

        .badge-moniteur {
            background: #81c784;
            color: #2e7d32;
        }

        .badge-client {
            background: #64b5f6;
            color: #1565c0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>Castellane-auto</h1>
            <p>Connexion à votre espace</p>
        </div>

        <?php
        session_start();

        if (isset($_SESSION['id_user'])) {
            $role = $_SESSION['role'];
            if ($role == 'admin' || $role == 'moniteur') {
                header('Location: admin/index.php');
            } else {
                header('Location: client/index.php');
            }
            exit();
        }

        require_once('admin/controleur/controleur_class.php');
        $unControleur = new Controleur();

        $erreur = "";

        if (isset($_POST['Valider'])) {
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];
            
            $utilisateur = $unControleur->login($email, $mdp);
            
            if ($utilisateur) {
                $_SESSION['id_user'] = $utilisateur['id_user'];
                $_SESSION['email'] = $utilisateur['email'];
                $_SESSION['nom'] = $utilisateur['nom'];
                $_SESSION['prenom'] = $utilisateur['prenom'];
                $_SESSION['role'] = $utilisateur['role'];
                
                $role = $utilisateur['role'];
                
                if ($role == 'admin' || $role == 'moniteur') {
                    header('Location: admin/index.php');
                    exit();
                } else if ($role == 'client') {
                    header('Location: client/index.php');
                    exit();
                }
                
            } else {
                $erreur = "❌ Email ou mot de passe incorrect";
            }
        }
        ?>

        <?php if ($erreur != ""): ?>
            <div class="error-message">
                <?php echo $erreur; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="votre.email@exemple.fr" required>
            </div>

            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" id="mdp" name="mdp" placeholder="••••••••" required>
            </div>

            <button type="submit" name="Valider" class="btn-login">
                Se connecter
            </button>
        </form>

        <div class="link-signup" style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
            Pas encore de compte ? <a href="inscription.php" style="color: #4caf50; text-decoration: none; font-weight: 600;">S'inscrire</a>
        </div>

        <div class="back-link">
            <a href="index.html">← Retour au site public</a>
        </div>
    </div>
</body>
</html>