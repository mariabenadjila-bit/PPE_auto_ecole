<h2>Gestion des moniteurs</h2>

<?php
    if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['id'])) {
        $unControleur->delete_moniteur($_GET['id']);
        echo "<p style='color: green;'>Moniteur supprimé avec succès !</p>";
        header("Refresh:1; url=index.php?page=3");
    }

    if (isset($_GET['action']) && $_GET['action'] == 'modifier' && isset($_GET['id'])) {
        $unMoniteur = $unControleur->selectWhere_moniteur($_GET['id']);
        require_once('vue/vue_update_moniteur.php');
    } else {
        $lesMoniteurs = $unControleur->selectAll_moniteurs();
        require_once('vue/vue_insert_moniteur.php');
    }
?>
