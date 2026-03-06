<h2>Gestion des leçons</h2>

<?php
    if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['id'])) {
        $unControleur->delete_lecon($_GET['id']);
        echo "<p style='color: green;'>Leçon supprimée avec succès !</p>";
        header("Refresh:1; url=index.php?page=5");
    }

    if (isset($_GET['action']) && $_GET['action'] == 'modifier' && isset($_GET['id'])) {
        $uneLecon = $unControleur->selectWhere_lecon($_GET['id']);
        $lesCandidats = $unControleur->selectAll_candidats();
        $lesMoniteurs = $unControleur->selectAll_moniteurs();
        $lesVehicules = $unControleur->selectAll_vehicules();
        require_once('vue/vue_update_lecon.php');
    } else {
        if (isset($_GET['candidat'])) {
            $lesLecons = $unControleur->selectLecons_byCandidat($_GET['candidat']);
            $candidatInfo = $unControleur->selectWhere_candidat($_GET['candidat']);
            echo "<h3>Leçons de ".$candidatInfo['nomC']." ".$candidatInfo['prenomC']."</h3>";
            echo "<a href='?page=2'>← Retour à la liste des candidats</a>";
            echo "<hr>";
            
            require_once('vue/vue_select_lecon.php');
            
        } else {
            $lesLecons = $unControleur->selectAll_lecons();
            $lesCandidats = $unControleur->selectAll_candidats();
            $lesMoniteurs = $unControleur->selectAll_moniteurs();
            $lesVehicules = $unControleur->selectAll_vehicules();
            require_once('vue/vue_insert_lecon.php');
        }
    }
?>