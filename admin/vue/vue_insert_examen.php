<?php
    $messageSucces = false;
    
    if (isset($_POST['ValiderExamen'])) {
        $tab = array(
            "id_candidat" => $_POST['id_candidat'],
            "id_moniteur" => !empty($_POST['id_moniteur']) ? $_POST['id_moniteur'] : null,
            "id_vehicule" => !empty($_POST['id_vehicule']) ? $_POST['id_vehicule'] : null,
            "type_examen" => $_POST['type_examen'],
            "lieu_examen" => $_POST['lieu_examen'],
            "date_examen" => $_POST['date_examen'],
            "resultat" => $_POST['resultat'],
            "remarques" => $_POST['remarques']
        );
        $unControleur->insert_examen($tab);
        $unControleur->update_statut_candidat($_POST['id_candidat']);
        
        $messageSucces = true;
        echo "<meta http-equiv='refresh' content='1'>";
    }
?>

<h3>Inscription à un examen</h3>

<form method="post">
    <table>
        <tr>
            <td>Candidat :</td>
            <td>
                <select name="id_candidat" required>
                    <option value="">-- Choisir un candidat --</option>
                    <?php
                        foreach ($lesCandidats as $unCandidat) {
                            echo "<option value='".$unCandidat['id_candidat']."'>";
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
                    <option value="">-- Choisir --</option>
                    <option value="Code de la route">Code de la route</option>
                    <option value="Conduite Permis B">Conduite Permis B</option>
                    <option value="Conduite Permis A">Conduite Permis A (Moto)</option>
                    <option value="BSR">BSR</option>
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
                            echo "<option value='".$unMoniteur['id_moniteur']."'>";
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
                            echo "<option value='".$unVehicule['id_vehicule']."'>";
                            echo $unVehicule['marque'].' '.$unVehicule['modele'].' - '.$unVehicule['immat'];
                            echo "</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Lieu de l'examen :</td>
            <td><input type="text" name="lieu_examen"></td>
        </tr>
        <tr>
            <td>Date et heure de l'examen :</td>
            <td><input type="datetime-local" name="date_examen" required></td>
        </tr>
        <tr>
            <td>Résultat :</td>
            <td>
                <select name="resultat">
                    <option value="En attente" selected>En attente</option>
                    <option value="Reussi">Réussi</option>
                    <option value="Echoue">Échoué</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Remarques :</td>
            <td><textarea name="remarques" rows="3" cols="40" placeholder="Commentaires de l'inspecteur ou du moniteur..."></textarea></td>
        </tr>
        <tr>
            <td><input type="submit" name="Annuler" value="Annuler"></td>
            <td><input type="submit" name="ValiderExamen" value="Valider"></td>
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
<p id="message-succes" style="color: green;">Examen inscrit avec succès !</p>
<script>
    setTimeout(function() {
        document.getElementById('message-succes').style.opacity = '0';
    }, 800);
</script>
<?php endif; ?>

<hr>
<h3>Liste des examens</h3>

<?php
    require_once('vue/vue_select_examen.php');
?>