<?php
    $messageSucces = false;
    
    if (isset($_POST['ModifierExamen'])) {
        $tab = array(
            "id_examen" => $_GET['id'],
            "id_candidat" => $_POST['id_candidat'],
            "id_moniteur" => !empty($_POST['id_moniteur']) ? $_POST['id_moniteur'] : null,
            "id_vehicule" => !empty($_POST['id_vehicule']) ? $_POST['id_vehicule'] : null,
            "type_examen" => $_POST['type_examen'],
            "lieu_examen" => $_POST['lieu_examen'],
            "date_examen" => $_POST['date_examen'],
            "resultat" => $_POST['resultat'],
            "remarques" => $_POST['remarques']
        );
        $unControleur->update_examen($tab);
        $unControleur->update_statut_candidat($_POST['id_candidat']);
        
        $messageSucces = true;
        echo "<meta http-equiv='refresh' content='1;url=index.php?page=6'>";
    }
?>

<h3>Modification d'un examen</h3>

<form method="post">
    <table>
        <tr>
            <td>Candidat :</td>
            <td>
                <select name="id_candidat" required>
                    <?php
                        foreach ($lesCandidats as $unCandidat) {
                            $selected = ($unCandidat['id_candidat'] == $unExamen['id_candidat']) ? 'selected' : '';
                            echo "<option value='".$unCandidat['id_candidat']."' $selected>";
                            echo $unCandidat['nomC'].' '.$unCandidat['prenomC'];
                            echo "</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Type d'examen :</td>
            <td>
                <select name="type_examen" id="type_examen" required onchange="toggleVehiculeMoniteur()">
                    <option value="Code de la route" <?php if($unExamen['type_examen']=='Code de la route') echo 'selected'; ?>>Code de la route</option>
                    <option value="Conduite Permis B" <?php if($unExamen['type_examen']=='Conduite Permis B') echo 'selected'; ?>>Conduite Permis B</option>
                    <option value="Conduite Permis A" <?php if($unExamen['type_examen']=='Conduite Permis A') echo 'selected'; ?>>Conduite Permis A (Moto)</option>
                    <option value="BSR" <?php if($unExamen['type_examen']=='BSR') echo 'selected'; ?>>BSR</option>
                </select>
            </td>
        </tr>
        <tr id="row_moniteur">
            <td>Moniteur accompagnateur :</td>
            <td>
                <select name="id_moniteur">
                    <option value="">-- Aucun --</option>
                    <?php
                        foreach ($lesMoniteurs as $unMoniteur) {
                            $selected = ($unMoniteur['id_moniteur'] == $unExamen['id_moniteur']) ? 'selected' : '';
                            echo "<option value='".$unMoniteur['id_moniteur']."' $selected>";
                            echo $unMoniteur['nomM'].' '.$unMoniteur['prenomM'];
                            echo "</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr id="row_vehicule">
            <td>Véhicule :</td>
            <td>
                <select name="id_vehicule">
                    <option value="">-- Aucun --</option>
                    <?php
                        foreach ($lesVehicules as $unVehicule) {
                            $selected = ($unVehicule['id_vehicule'] == $unExamen['id_vehicule']) ? 'selected' : '';
                            echo "<option value='".$unVehicule['id_vehicule']."' $selected>";
                            echo $unVehicule['marque'].' '.$unVehicule['modele'].' - '.$unVehicule['immat'];
                            echo "</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Lieu de l'examen :</td>
            <td><input type="text" name="lieu_examen" value="<?php echo $unExamen['lieu_examen']; ?>"></td>
        </tr>
        <tr>
            <td>Date et heure de l'examen :</td>
            <td><input type="datetime-local" name="date_examen" value="<?php echo date('Y-m-d\TH:i', strtotime($unExamen['date_examen'])); ?>" required></td>
        </tr>
        <tr>
            <td>Résultat :</td>
            <td>
                <select name="resultat">
                    <option value="En attente" <?php if($unExamen['resultat']=='En attente') echo 'selected'; ?>>En attente</option>
                    <option value="Reussi" <?php if($unExamen['resultat']=='Reussi') echo 'selected'; ?>>Réussi</option>
                    <option value="Echoue" <?php if($unExamen['resultat']=='Echoue') echo 'selected'; ?>>Échoué</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Remarques :</td>
            <td><textarea name="remarques" rows="3" cols="40"><?php echo $unExamen['remarques']; ?></textarea></td>
        </tr>
        <tr>
            <td><a href="index.php?page=6"><input type="button" value="Annuler"></a></td>
            <td><input type="submit" name="ModifierExamen" value="Modifier"></td>
        </tr>
    </table>
</form>

<script>
    function toggleVehiculeMoniteur() {
        var typeExamen = document.getElementById('type_examen').value;
        var rowMoniteur = document.getElementById('row_moniteur');
        var rowVehicule = document.getElementById('row_vehicule');
        
        if (typeExamen === 'Code de la route') {
            rowMoniteur.style.display = 'none';
            rowVehicule.style.display = 'none';
        } else {
            rowMoniteur.style.display = 'table-row';
            rowVehicule.style.display = 'table-row';
        }
    }

    window.onload = function() {
        toggleVehiculeMoniteur();
    };
</script>

<?php if ($messageSucces): ?>
    <p id="message-succes" style="color: green;">Examen modifié avec succès !</p>
    <script>
        setTimeout(function() {
            document.getElementById('message-succes').style.opacity = '0';
        }, 800);
    </script>
<?php endif; ?>