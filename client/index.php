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
        $erreurCandidat = true;
    } else {
        $id_candidat = $candidat['id_candidat'];
        // Récupérer les prochaines leçons
        $prochaines_lecons = $unControleur->selectProchaines_lecons_candidat($id_candidat, 30);
        if ($prochaines_lecons === null) {
            $prochaines_lecons = array();
        }
        
        $prochains_examens = $unControleur->selectProchains_examens_candidat($id_candidat);
        
        $historique_lecons = $unControleur->selectHistorique_lecons_candidat($id_candidat);
        
        $total_lecons = count($unControleur->selectLecons_byCandidat($id_candidat));
        $total_examens = count($unControleur->selectExamens_byCandidat($id_candidat));
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - CASTELLANE-AUTO</title>
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

        /* Header */
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

        .user-info {
            text-align: right;
        }

        .btn-logout {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
            border: 2px solid white;
        }

        .btn-logout:hover {
            background: white;
            color: #2e7d32;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* Welcome */
        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .welcome-section h2 {
            color: #2e7d32;
            margin-bottom: 15px;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #4caf50;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
        }

        /* Section */
        .section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .section h3 {
            color: #2e7d32;
            margin-bottom: 20px;
            font-size: 22px;
            border-bottom: 2px solid #4caf50;
            padding-bottom: 10px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        thead {
            background: #f5f5f5;
        }

        th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #4caf50;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-lecon {
            background: #e3f2fd;
            color: #1976d2;
        }

        .badge-examen {
            background: #fff3e0;
            color: #f57c00;
        }

        .badge-reussi {
            background: #c8e6c9;
            color: #2e7d32;
        }

        .badge-attente {
            background: #fff9c4;
            color: #f57f17;
        }

        .badge-echoue {
            background: #ffcdd2;
            color: #c62828;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .error-box {
            background: #ffebee;
            border-left: 4px solid #f44336;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .error-box h3 {
            color: #c62828;
            margin-bottom: 10px;
        }

        .btn-primary {
            background: #4caf50;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            margin-top: 15px;
        }

        .btn-primary:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <h1>Castellane-auto</h1>
                <p>Espace Client</p>
            </div>
            <div class="user-info">
                <p>Bonjour <strong><?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></strong></p>
                <a href="logout.php" class="btn-logout">Déconnexion</a>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (isset($erreurCandidat) && $erreurCandidat): ?>
            <div class="error-box">
                <h3>Compte non lié à un candidat</h3>
                <p>Votre compte n'est pas encore lié à un dossier candidat. Veuillez contacter l'auto-école pour finaliser votre inscription.</p>
                <p><strong>Téléphone :</strong> 04 XX XX XX XX</p>
                <p><strong>Email :</strong> contact@castellane-auto.fr</p>
                <a href="../index.html" class="btn-primary">Retour au site</a>
            </div>
        <?php else: ?>
            <div class="welcome-section">
                <h2>Bienvenue dans votre espace personnel</h2>
                <p>Retrouvez ici toutes vos leçons de conduite et examens à venir.</p>
                <div style="display: flex; gap: 15px; margin-top: 20px; flex-wrap: wrap;">
                    <a href="reserver-lecon.php" class="btn-primary">Réserver une leçon</a>
                    <a href="reserver-examen.php" class="btn-primary">S'inscrire à un examen</a>
                    <a href="entrainement-code.php" class="btn-primary">S'entraîner au code</a>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_lecons; ?></div>
                    <div class="stat-label">Leçons suivies</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo count($prochaines_lecons); ?></div>
                    <div class="stat-label">Leçons à venir</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_examens; ?></div>
                    <div class="stat-label">Examens</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $candidat['statut']; ?></div>
                    <div class="stat-label">Statut</div>
                </div>
            </div>

            <div class="section">
                <h3>Mes prochaines leçons <em>(30 prochains jours)</em></h3>
                
                <?php if (count($prochaines_lecons) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date & Heure</th>
                                <th>Type de cours</th>
                                <th>Durée</th>
                                <th>Moniteur</th>
                                <th>Véhicule</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prochaines_lecons as $lecon): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo date('d/m/Y', strtotime($lecon['date_lecon'])); ?></strong><br>
                                        <small><?php echo date('H:i', strtotime($lecon['date_lecon'])); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge badge-lecon"><?php echo $lecon['libelle']; ?></span>
                                    </td>
                                    <td><?php echo $lecon['duree_lecon']; ?> min</td>
                                    <td><?php echo $lecon['nomM'] . ' ' . $lecon['prenomM']; ?></td>
                                    <td>
                                        <?php if ($lecon['immat']): ?>
                                            <?php echo $lecon['marque'] . ' ' . $lecon['modele']; ?>
                                        <?php else: ?>
                                            <em>Aucun</em>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <p>Aucune leçon prévue dans les 30 prochains jours</p>
                        <p><small>Contactez votre moniteur pour planifier vos prochaines sessions</small></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="section">
                <h3>Mes examens</h3>
                
                <?php if (count($prochains_examens) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date & Heure</th>
                                <th>Type d'examen</th>
                                <th>Lieu</th>
                                <th>Moniteur</th>
                                <th>Résultat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prochains_examens as $examen): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo date('d/m/Y', strtotime($examen['date_examen'])); ?></strong><br>
                                        <small><?php echo date('H:i', strtotime($examen['date_examen'])); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge badge-examen"><?php echo $examen['type_examen']; ?></span>
                                    </td>
                                    <td><?php echo $examen['lieu_examen']; ?></td>
                                    <td>
                                        <?php if ($examen['nomM']): ?>
                                            <?php echo $examen['nomM'] . ' ' . $examen['prenomM']; ?>
                                        <?php else: ?>
                                            <em>-</em>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $badgeClass = '';
                                        switch($examen['resultat']) {
                                            case 'Reussi': $badgeClass = 'badge-reussi'; break;
                                            case 'Echoue': $badgeClass = 'badge-echoue'; break;
                                            default: $badgeClass = 'badge-attente';
                                        }
                                        ?>
                                        <span class="badge <?php echo $badgeClass; ?>">
                                            <?php 
                                            if ($examen['resultat'] == 'Reussi') echo 'Réussi';
                                            elseif ($examen['resultat'] == 'Echoue') echo 'Échoué';
                                            else echo 'En attente';
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <p>Aucun examen prévu pour le moment</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="section">
                <h3>Historique de mes leçons passées</h3>
                
                <?php if (count($historique_lecons) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type de cours</th>
                                <th>Durée</th>
                                <th>Moniteur</th>
                                <th>Compte-rendu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($historique_lecons, 0, 10) as $lecon): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y H:i', strtotime($lecon['date_lecon'])); ?></td>
                                    <td><?php echo $lecon['libelle']; ?></td>
                                    <td><?php echo $lecon['duree_lecon']; ?> min</td>
                                    <td><?php echo $lecon['nomM'] . ' ' . $lecon['prenomM']; ?></td>
                                    <td>
                                        <?php if ($lecon['compterendu']): ?>
                                            <?php echo substr($lecon['compterendu'], 0, 50) . '...'; ?>
                                        <?php else: ?>
                                            <em>-</em>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if (count($historique_lecons) > 10): ?>
                        <p style="text-align: center; margin-top: 15px; color: #666;">
                            <small>Affichage des 10 dernières leçons sur <?php echo count($historique_lecons); ?> au total</small>
                        </p>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p>Aucune leçon passée</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>