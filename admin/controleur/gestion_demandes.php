<?php
    $demandesLecons = $unControleur->selectDemandes_lecons_attente();
    $demandesExamens = $unControleur->selectDemandes_examens_attente();

    $lesMoniteurs = $unControleur->selectAll_moniteurs();
    $lesVehicules = $unControleur->selectAll_vehicules();

    if (isset($_POST['AttribuerLecon'])) {
        $id_lecon = $_POST['id_lecon'];
        $id_moniteur = !empty($_POST['id_moniteur']) ? $_POST['id_moniteur'] : null;
        $id_vehicule = !empty($_POST['id_vehicule']) ? $_POST['id_vehicule'] : null;
        
        $unControleur->attribuerMoniteurVehicule_lecon($id_lecon, $id_moniteur, $id_vehicule);
        
        echo "<script>window.location.href='index.php?page=7';</script>";
        exit();
    }

    if (isset($_POST['AttribuerExamen'])) {
        $id_examen = $_POST['id_examen'];
        $id_moniteur = !empty($_POST['id_moniteur']) ? $_POST['id_moniteur'] : null;
        $id_vehicule = !empty($_POST['id_vehicule']) ? $_POST['id_vehicule'] : null;
        
        $unControleur->attribuerMoniteurVehicule_examen($id_examen, $id_moniteur, $id_vehicule);
        
        echo "<script>window.location.href='index.php?page=7';</script>";
        exit();
    }

    if (isset($_POST['RefuserLecon'])) {
        $id_lecon = $_POST['id_lecon'];
        $unControleur->delete_lecon($id_lecon);
        
        echo "<script>window.location.href='index.php?page=7';</script>";
        exit();
    }

    if (isset($_POST['RefuserExamen'])) {
        $id_examen = $_POST['id_examen'];
        $unControleur->delete_examen($id_examen);
        
        echo "<script>window.location.href='index.php?page=7';</script>";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demandes en attente</title>
    <style>
        .demandes-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .section-title {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 30px 0 20px 0;
            font-size: 20px;
        }

        .badge-attente {
            background: #ff9800;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }

        .demandes-grid {
            display: grid;
            gap: 20px;
            margin-bottom: 40px;
        }

        .demande-card {
            background: white;
            border: 2px solid #ff9800;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .demande-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .candidat-info {
            font-size: 18px;
            font-weight: 600;
            color: #2e7d32;
        }

        .date-info {
            color: #666;
            font-size: 14px;
        }

        .demande-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .detail-item {
            padding: 10px;
            background: #f5f5f5;
            border-radius: 5px;
        }

        .detail-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .attribution-form {
            display: grid;
            grid-template-columns: 1fr 1fr auto auto;
            gap: 15px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group select {
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-valider {
            background: #4caf50;
            color: white;
        }

        .btn-valider:hover {
            background: #45a049;
        }

        .btn-refuser {
            background: #f44336;
            color: white;
        }

        .btn-refuser:hover {
            background: #da190b;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="demandes-container">
        <h1>Gestion des demandes en attente</h1>

        <div class="section-title">
            Demandes de leçons
            <?php if (count($demandesLecons) > 0): ?>
                <span class="badge-attente"><?php echo count($demandesLecons); ?> en attente</span>
            <?php endif; ?>
        </div>

        <?php if (count($demandesLecons) > 0): ?>
            <div class="demandes-grid">
                <?php foreach ($demandesLecons as $lecon): ?>
                    <div class="demande-card">
                        <div class="demande-header">
                            <div>
                                <div class="candidat-info">
                                    <?php echo $lecon['nomC'] . ' ' . $lecon['prenomC']; ?>
                                </div>
                                <div class="date-info">
                                    Demandé le : <?php echo date('d/m/Y à H:i', strtotime($lecon['date_lecon'])); ?>
                                </div>
                            </div>
                        </div>

                        <div class="demande-details">
                            <div class="detail-item">
                                <div class="detail-label">Type de cours</div>
                                <div class="detail-value"><?php echo $lecon['libelle']; ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Date et heure</div>
                                <div class="detail-value"><?php echo date('d/m/Y à H:i', strtotime($lecon['date_lecon'])); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Durée</div>
                                <div class="detail-value"><?php echo $lecon['duree_lecon']; ?> min</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Contact</div>
                                <div class="detail-value"><?php echo $lecon['telephoneC']; ?></div>
                            </div>
                        </div>

                        <form method="post" class="attribution-form">
                            <input type="hidden" name="id_lecon" value="<?php echo $lecon['id_lecon']; ?>">
                            
                            <div class="form-group">
                                <label for="id_moniteur_<?php echo $lecon['id_lecon']; ?>">Attribuer moniteur *</label>
                                <select name="id_moniteur" id="id_moniteur_<?php echo $lecon['id_lecon']; ?>" required>
                                    <option value="">-- Choisir --</option>
                                    <?php foreach ($lesMoniteurs as $moniteur): ?>
                                        <option value="<?php echo $moniteur['id_moniteur']; ?>">
                                            <?php echo $moniteur['nomM'] . ' ' . $moniteur['prenomM']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_vehicule_<?php echo $lecon['id_lecon']; ?>">Attribuer véhicule</label>
                                <select name="id_vehicule" id="id_vehicule_<?php echo $lecon['id_lecon']; ?>">
                                    <option value="">-- Aucun --</option>
                                    <?php foreach ($lesVehicules as $vehicule): ?>
                                        <option value="<?php echo $vehicule['id_vehicule']; ?>">
                                            <?php echo $vehicule['marque'] . ' ' . $vehicule['modele'] . ' (' . $vehicule['immat'] . ')'; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" name="AttribuerLecon" class="btn btn-valider">
                                Confirmer
                            </button>

                            <button type="submit" name="RefuserLecon" class="btn btn-refuser" 
                                    onclick="return confirm('Refuser cette demande ?')">
                                Refuser
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Aucune demande de leçon en attente</p>
            </div>
        <?php endif; ?>

        <div class="section-title">
            Demandes d'inscription aux examens
            <?php if (count($demandesExamens) > 0): ?>
                <span class="badge-attente"><?php echo count($demandesExamens); ?> en attente</span>
            <?php endif; ?>
        </div>

        <?php if (count($demandesExamens) > 0): ?>
            <div class="demandes-grid">
                <?php foreach ($demandesExamens as $examen): ?>
                    <div class="demande-card">
                        <div class="demande-header">
                            <div>
                                <div class="candidat-info">
                                    <?php echo $examen['nomC'] . ' ' . $examen['prenomC']; ?>
                                </div>
                                <div class="date-info">
                                    Demandé le : <?php echo date('d/m/Y à H:i', strtotime($examen['date_examen'])); ?>
                                </div>
                            </div>
                        </div>

                        <div class="demande-details">
                            <div class="detail-item">
                                <div class="detail-label">Type d'examen</div>
                                <div class="detail-value"><?php echo $examen['type_examen']; ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Date et heure</div>
                                <div class="detail-value"><?php echo date('d/m/Y à H:i', strtotime($examen['date_examen'])); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Lieu</div>
                                <div class="detail-value"><?php echo $examen['lieu_examen']; ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Contact</div>
                                <div class="detail-value"><?php echo $examen['telephoneC']; ?></div>
                            </div>
                        </div>

                        <form method="post" class="attribution-form">
                            <input type="hidden" name="id_examen" value="<?php echo $examen['id_examen']; ?>">
                            
                            <div class="form-group">
                                <label for="id_moniteur_ex_<?php echo $examen['id_examen']; ?>">Attribuer moniteur *</label>
                                <select name="id_moniteur" id="id_moniteur_ex_<?php echo $examen['id_examen']; ?>" required>
                                    <option value="">-- Choisir --</option>
                                    <?php foreach ($lesMoniteurs as $moniteur): ?>
                                        <option value="<?php echo $moniteur['id_moniteur']; ?>">
                                            <?php echo $moniteur['nomM'] . ' ' . $moniteur['prenomM']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_vehicule_ex_<?php echo $examen['id_examen']; ?>">Attribuer véhicule</label>
                                <select name="id_vehicule" id="id_vehicule_ex_<?php echo $examen['id_examen']; ?>">
                                    <option value="">-- Aucun --</option>
                                    <?php foreach ($lesVehicules as $vehicule): ?>
                                        <option value="<?php echo $vehicule['id_vehicule']; ?>">
                                            <?php echo $vehicule['marque'] . ' ' . $vehicule['modele'] . ' (' . $vehicule['immat'] . ')'; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" name="AttribuerExamen" class="btn btn-valider">
                                Confirmer
                            </button>

                            <button type="submit" name="RefuserExamen" class="btn btn-refuser" 
                                    onclick="return confirm('Refuser cette demande ?')">
                                Refuser
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Aucune demande d'examen en attente</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
