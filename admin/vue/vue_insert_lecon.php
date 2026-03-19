<!-- <h3>Ajout d'une leçon</h3>

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
            <td>Moniteur :</td>
            <td>
                <select name="id_moniteur" required>
                    <option value="">-- Choisir un moniteur --</option>
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
        <tr>
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
            <td>Date et heure :</td>
            <td><input type="datetime-local" name="date_lecon" required></td>
        </tr>
        <tr>
            <td>Type de cours :</td>
            <td>
                <select name="libelle" required>
                    <option value="">-- Choisir un cours --</option>
                    <option value="Permis A">Permis A</option>
                    <option value="Permis B">Permis B</option>
                    <option value="BSR">BSR</option>
                    <option value="Code de la route">Code de la route</option>
                    <option value="Conduite accompagnée">Conduite accompagnée</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Durée :</td>
            <td>
                <select name="duree_lecon" required>
                    <option value="">-- Choisir --</option>
                    <option value="30">30 minutes</option>
                    <option value="45">45 minutes</option>
                    <option value="60">1 heure</option>
                    <option value="90">1h30</option>
                    <option value="120">2 heures</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Compte-rendu :</td>
            <td><textarea name="compterendu" rows="4" cols="40"></textarea></td>
        </tr>
        <tr>
            <td><input type="submit" name="Annuler" value="Annuler"></td>
            <td><input type="submit" name="ValiderLecon" value="Valider"></td>
        </tr>
    </table>
</form>

<?php
    if (isset($_POST['ValiderLecon'])) {
        $tab = array(
            "id_candidat" => $_POST['id_candidat'],
            "id_moniteur" => $_POST['id_moniteur'],
            "id_vehicule" => !empty($_POST['id_vehicule']) ? $_POST['id_vehicule'] : null,
            "date_lecon" => $_POST['date_lecon'],
            "libelle" => $_POST['libelle'],
            "duree_lecon" => $_POST['duree_lecon'],
            "compterendu" => $_POST['compterendu']
        );
        $unControleur->insert_lecon($tab);
        echo "<br><p style='color: green;'>Leçon ajoutée avec succès !</p>";
        header("Refresh:1");
    }
?> -->

<hr>
<h3>Liste des leçons</h3>

<?php
    require_once('vue/vue_select_lecon.php');
?>
