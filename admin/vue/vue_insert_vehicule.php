<h3>Ajout d'un véhicule</h3>

<form method="post">
    <table>
        <tr>
            <td>Immatriculation :</td>
            <td><input type="text" name="immat" required></td>
        </tr>
        <tr>
            <td>Date d'achat :</td>
            <td><input type="date" name="date_Achat" value="<?php echo date('d-m-Y'); ?>" required></td>
        </tr>
        <tr>
            <td>Kilométrage :</td>
            <td><input type="number" name="nb_km" value="0" required></td>
        </tr>
        <tr>
            <td>Énergie :</td>
            <td>
                <select name="energie" required>
                    <option value="">-- Choisir --</option>
                    <option value="Essence">Essence</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Électrique">Électrique</option>
                    <option value="Hybride">Hybride</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Marque :</td>
            <td><input type="text" name="marque" required></td>
        </tr>
        <tr>
            <td>Modèle :</td>
            <td><input type="text" name="modele" required></td>
        </tr>
        <tr>
            <td>Type de véhicule :</td>
            <td>
                <select name="type_vehicule" required>
                    <option value="">-- Choisir --</option>
                    <option value="Voiture">Voiture</option>
                    <option value="Moto">Moto</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><input type="submit" name="Annuler" value="Annuler"></td>
            <td><input type="submit" name="ValiderVehicule" value="Valider"></td>
        </tr>
    </table>
</form>

<?php
    if (isset($_POST['ValiderVehicule'])) {
        $tab = array(
            "immat" => $_POST['immat'],
            "date_Achat" => $_POST['date_Achat'],
            "nb_km" => $_POST['nb_km'],
            "energie" => $_POST['energie'],
            "marque" => $_POST['marque'],
            "modele" => $_POST['modele'],
            "type_vehicule" => $_POST['type_vehicule']
        );
        $unControleur->insert_vehicule($tab);
        echo "<br><p style='color: green;'>Véhicule ajouté avec succès !</p>";
        header("Refresh:1");
    }
?>

<hr>
<h3>Liste des véhicules</h3>

<?php
    require_once('vue/vue_select_vehicule.php');
?>
