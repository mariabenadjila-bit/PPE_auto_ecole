<h3>Modification d'une leçon</h3>

<form method="post">
    <table>
        <tr>
            <td>Candidat :</td>
            <td>
                <select name="id_candidat" required>
                    <?php
                        foreach ($lesCandidats as $unCandidat) {
                            $selected = ($unCandidat['id_candidat'] == $uneLecon['id_candidat']) ? 'selected' : '';
                            echo "<option value='".$unCandidat['id_candidat']."' $selected>";
                            echo $unCandidat['nomC'].' '.$unCandidat['prenomC'];
                            echo "</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Moniteur :</td>
            <td>
                <select name="id_moniteur" required>
                    <?php
                        foreach ($lesMoniteurs as $unMoniteur) {
                            $selected = ($unMoniteur['id_moniteur'] == $uneLecon['id_moniteur']) ? 'selected' : '';
                            echo "<option value='".$unMoniteur['id_moniteur']."' $selected>";
                            echo $unMoniteur['nomM'].' '.$unMoniteur['prenomM'];
                            echo "</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Véhicule :</td>
            <td>
                <select name="id_vehicule">
                    <option value="">-- Aucun (Code/BSR) --</option>
                    <?php
                        foreach ($lesVehicules as $unVehicule) {
                            $selected = ($unVehicule['id_vehicule'] == $uneLecon['id_vehicule']) ? 'selected' : '';
                            echo "<option value='".$unVehicule['id_vehicule']."' $selected>";
                            echo $unVehicule['marque'].' '.$unVehicule['modele'].' - '.$unVehicule['immat'];
                            echo "</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Date et heure :</td>
            <td><input type="datetime-local" name="date_lecon" value="<?php echo date('Y-m-d\TH:i', strtotime($uneLecon['date_lecon'])); ?>" required></td>
        </tr>
        <tr>
            <td>Type de cours :</td>
            <td>
                <select name="libelle" required>
                    <option value="Permis A" <?php if($uneLecon['libelle']=='Permis A') echo 'selected'; ?>>Permis A</option>
                    <option value="Permis B" <?php if($uneLecon['libelle']=='Permis B') echo 'selected'; ?>>Permis B</option>
                    <option value="BSR" <?php if($uneLecon['libelle']=='BSR') echo 'selected'; ?>>BSR</option>
                    <option value="Code de la route" <?php if($uneLecon['libelle']=='Code de la route') echo 'selected'; ?>>Code de la route</option>
                    <option value="Conduite accompagnée" <?php if($uneLecon['libelle']=='Conduite accompagnée') echo 'selected'; ?>>Conduite accompagnée</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Durée :</td>
            <td>
                <select name="duree_lecon" required>
                    <option value="30" <?php if($uneLecon['duree_lecon']==30) echo 'selected'; ?>>30 minutes</option>
                    <option value="45" <?php if($uneLecon['duree_lecon']==45) echo 'selected'; ?>>45 minutes</option>
                    <option value="60" <?php if($uneLecon['duree_lecon']==60) echo 'selected'; ?>>1 heure</option>
                    <option value="90" <?php if($uneLecon['duree_lecon']==90) echo 'selected'; ?>>1h30</option>
                    <option value="120" <?php if($uneLecon['duree_lecon']==120) echo 'selected'; ?>>2 heures</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Compte-rendu :</td>
            <td><textarea name="compterendu" rows="4" cols="40"><?php echo $uneLecon['compterendu']; ?></textarea></td>
        </tr>
        <tr>
            <td><a href="index.php?page=5"><input type="button" value="Annuler"></a></td>
            <td><input type="submit" name="ModifierLecon" value="Modifier"></td>
        </tr>
    </table>
</form>

<?php
    if (isset($_POST['ModifierLecon'])) {
        $tab = array(
            "id_lecon" => $_GET['id'],
            "id_candidat" => $_POST['id_candidat'],
            "id_moniteur" => $_POST['id_moniteur'],
            "id_vehicule" => !empty($_POST['id_vehicule']) ? $_POST['id_vehicule'] : null,
            "date_lecon" => $_POST['date_lecon'],
            "libelle" => $_POST['libelle'],
            "duree_lecon" => $_POST['duree_lecon'],
            "compterendu" => $_POST['compterendu']
        );
        $unControleur->update_lecon($tab);
        echo "<p style='color: green;'>Leçon modifiée avec succès !</p>";
        header("Refresh:1; url=index.php?page=5");
    }
?>
