<h3>Modification d'un moniteur</h3>

<form method="post">
    <table>
        <tr>
            <td>Nom :</td>
            <td><input type="text" name="nomM" value="<?php echo $unMoniteur['nomM']; ?>" required></td>
        </tr>
        <tr>
            <td>Prénom :</td>
            <td><input type="text" name="prenomM" value="<?php echo $unMoniteur['prenomM']; ?>" required></td>
        </tr>
        <tr>
            <td>Email :</td>
            <td><input type="email" name="emailM" value="<?php echo $unMoniteur['emailM']; ?>" required></td>
        </tr>
        <tr>
            <td>Téléphone :</td>
            <td><input type="tel" name="telephoneM" value="<?php echo $unMoniteur['telephoneM']; ?>"></td>
        </tr>
        <tr>
            <td>Date d'embauche :</td>
            <td><input type="date" name="date_embauche" value="<?php echo $unMoniteur['date_embauche']; ?>" required></td>
        </tr>
        <tr>
            <td><a href="index.php?page=3"><input type="button" value="Annuler"></a></td>
            <td><input type="submit" name="ModifierMoniteur" value="Modifier"></td>
        </tr>
    </table>
</form>

<?php
    if (isset($_POST['ModifierMoniteur'])) {
        $tab = array(
            "id_moniteur" => $_GET['id'],
            "nomM" => $_POST['nomM'],
            "prenomM" => $_POST['prenomM'],
            "emailM" => $_POST['emailM'],
            "telephoneM" => $_POST['telephoneM'],
            "date_embauche" => $_POST['date_embauche']
        );
        $unControleur->update_moniteur($tab);
        echo "<p style='color: green;'>Moniteur modifié avec succès !</p>";
        header("Refresh:1; url=index.php?page=3");
    }
?>
