<h3>Ajout d'un moniteur</h3>

<form method="post">
    <table>
        <tr>
            <td>Nom :</td>
            <td><input type="text" name="nomM" required></td>
        </tr>
        <tr>
            <td>Prénom :</td>
            <td><input type="text" name="prenomM" required></td>
        </tr>
        <tr>
            <td>Email :</td>
            <td><input type="email" name="emailM" required></td>
        </tr>
        <tr>
            <td>Téléphone :</td>
            <td><input type="tel" name="telephoneM"></td>
        </tr>
        <tr>
            <td>Date d'embauche :</td>
            <td><input type="date" name="date_embauche" value="<?php echo date('Y-m-d'); ?>" required></td>
        </tr>
        <tr>
            <td><input type="submit" name="Annuler" value="Annuler"></td>
            <td><input type="submit" name="ValiderMoniteur" value="Valider"></td>
        </tr>
    </table>
</form>

<?php
    if (isset($_POST['ValiderMoniteur'])) {
        $tab = array(
            "nomM" => $_POST['nomM'],
            "prenomM" => $_POST['prenomM'],
            "emailM" => $_POST['emailM'],
            "telephoneM" => $_POST['telephoneM'],
            "date_embauche" => $_POST['date_embauche']
        );
        $unControleur->insert_moniteur($tab);
        echo "<br><p style='color: green;'>Moniteur ajouté avec succès !</p>";
        header("Refresh:1");
    }
?>

<hr>
<h3>Liste des moniteurs</h3>

<?php
    require_once('vue/vue_select_moniteur.php');
?>
