<h3>Ajout d'un candidat</h3>

<form method="post">
    <table>
        <tr>
            <td>Nom :</td>
            <td><input type="text" name="nomC" required></td>
        </tr>
        <tr>
            <td>Prénom :</td>
            <td><input type="text" name="prenomC" required></td>
        </tr>
        <tr>
            <td>Date de naissance :</td>
            <td><input type="date" name="date_naissanceC" required></td>
        </tr>
        <tr>
            <td>Adresse :</td>
            <td><input type="text" name="adresseC"></td>
        </tr>
        <tr>
            <td>Téléphone :</td>
            <td><input type="tel" name="telephoneC"></td>
        </tr>
        <tr>
            <td>Date d'inscription :</td>
            <td><input type="date" name="date_inscription" value="<?php echo date('d-m-Y'); ?>" required></td>
        </tr>
        <tr>
            <td><input type="submit" name="Annuler" value="Annuler"></td>
            <td><input type="submit" name="ValiderCandidat" value="Valider"></td>
        </tr>
    </table>
</form>

<?php
    if (isset($_POST['ValiderCandidat'])) {
        $tab = array(
            "nomC" => $_POST['nomC'],
            "prenomC" => $_POST['prenomC'],
            "date_naissanceC" => $_POST['date_naissanceC'],
            "adresseC" => $_POST['adresseC'],
            "telephoneC" => $_POST['telephoneC'],
            "date_inscription" => $_POST['date_inscription']
        );
        $unControleur->insert_candidat($tab);
        echo "<br><p style='color: green;'>Candidat ajouté avec succès !</p>";
        header("Refresh:1");
    }
?>

<hr>
<h3>Liste des candidats</h3>

<?php
    require_once('vue/vue_select_candidat.php');
?>
