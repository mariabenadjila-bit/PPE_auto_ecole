<h3>Modification d'un véhicule</h3>

<form method="post">
    <table>
        <tr>
            <td>Immatriculation :</td>
            <td><input type="text" name="immat" value="<?php echo $unVehicule['immat']; ?>" required></td>
        </tr>
        <tr>
            <td>Date d'achat :</td>
            <td><input type="date" name="date_Achat" value="<?php echo $unVehicule['date_Achat']; ?>" required></td>
        </tr>
        <tr>
            <td>Kilométrage :</td>
            <td><input type="number" name="nb_km" value="<?php echo $unVehicule['nb_km']; ?>" required></td>
        </tr>
        <tr>
            <td>Énergie :</td>
            <td>
                <select name="energie" required>
                    <option value="Essence" <?php if($unVehicule['energie']=='Essence') echo 'selected'; ?>>Essence</option>
                    <option value="Diesel" <?php if($unVehicule['energie']=='Diesel') echo 'selected'; ?>>Diesel</option>
                    <option value="Électrique" <?php if($unVehicule['energie']=='Électrique') echo 'selected'; ?>>Électrique</option>
                    <option value="Hybride" <?php if($unVehicule['energie']=='Hybride') echo 'selected'; ?>>Hybride</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Marque :</td>
            <td><input type="text" name="marque" value="<?php echo $unVehicule['marque']; ?>" required></td>
        </tr>
        <tr>
            <td>Modèle :</td>
            <td><input type="text" name="modele" value="<?php echo $unVehicule['modele']; ?>" required></td>
        </tr>
        <tr>
            <td>Type de véhicule :</td>
            <td>
                <select name="type_vehicule" required>
                    <option value="Voiture" <?php if($unVehicule['type_vehicule']=='Voiture') echo 'selected'; ?>>Voiture</option>
                    <option value="Moto" <?php if($unVehicule['type_vehicule']=='Moto') echo 'selected'; ?>>Moto</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><a href="index.php?page=4"><input type="button" value="Annuler"></a></td>
            <td><input type="submit" name="ModifierVehicule" value="Modifier"></td>
        </tr>
    </table>
</form>

<?php
    if (isset($_POST['ModifierVehicule'])) {
        $tab = array(
            "id_vehicule" => $_GET['id'],
            "immat" => $_POST['immat'],
            "date_Achat" => $_POST['date_Achat'],
            "nb_km" => $_POST['nb_km'],
            "energie" => $_POST['energie'],
            "marque" => $_POST['marque'],
            "modele" => $_POST['modele'],
            "type_vehicule" => $_POST['type_vehicule']
        );
        $unControleur->update_vehicule($tab);
        echo "<p style='color: green;'>Véhicule modifié avec succès !</p>";
        header("Refresh:1; url=index.php?page=4");
    }
?>
