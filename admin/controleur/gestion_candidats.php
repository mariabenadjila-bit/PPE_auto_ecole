<h2>Gestion des candidats</h2>

<?php
    if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['id'])) {
        $unControleur->delete_candidat($_GET['id']);
        echo "<p style='color: green;'>Candidat supprimé avec succès !</p>";
        header("Refresh:1; url=index.php?page=2");
    }

    if (isset($_GET['action']) && $_GET['action'] == 'modifier' && isset($_GET['id'])) {
        $unCandidat = $unControleur->selectWhere_candidat($_GET['id']);
        require_once('vue/vue_update_candidat.php');
    } else {
        $lesCandidats = $unControleur->selectAll_candidats();
        require_once('vue/vue_insert_candidat.php');
    }
?>
