<h3>Modification d'un candidat</h3>

<form method="post">
    <table>
        <tr>
            <td>Nom :</td>
            <td><input type="text" name="nomC" value="<?php echo $unCandidat['nomC']; ?>" required></td>
        </tr>
        <tr>
            <td>Prénom :</td>
            <td><input type="text" name="prenomC" value="<?php echo $unCandidat['prenomC']; ?>" required></td>
        </tr>
        <tr>
            <td>Date de naissance :</td>
            <td><input type="date" name="date_naissanceC" value="<?php echo $unCandidat['date_naissanceC']; ?>" required></td>
        </tr>
        <tr>
            <td>Adresse :</td>
            <td><input type="text" name="adresseC" value="<?php echo $unCandidat['adresseC']; ?>"></td>
        </tr>
        <tr>
            <td>Téléphone :</td>
            <td><input type="tel" name="telephoneC" value="<?php echo $unCandidat['telephoneC']; ?>"></td>
        </tr>
        <tr>
            <td>Date d'inscription :</td>
            <td><input type="date" name="date_inscription" value="<?php echo $unCandidat['date_inscription']; ?>" required></td>
        </tr>
        <tr>
            <td><a href="index.php?page=2"><input type="button" value="Annuler"></a></td>
            <td><input type="submit" name="ModifierCandidat" value="Modifier"></td>
        </tr>
    </table>
</form>

<?php
    if (isset($_POST['ModifierCandidat'])) {
        $tab = array(
            "id_candidat" => $_GET['id'],
            "nomC" => $_POST['nomC'],
            "prenomC" => $_POST['prenomC'],
            "date_naissanceC" => $_POST['date_naissanceC'],
            "adresseC" => $_POST['adresseC'],
            "telephoneC" => $_POST['telephoneC'],
            "date_inscription" => $_POST['date_inscription']
        );
        $unControleur->update_candidat($tab);
        echo "<p style='color: green;'>Candidat modifié avec succès !</p>";
        header("Refresh:1; url=index.php?page=2");
    }
?>
