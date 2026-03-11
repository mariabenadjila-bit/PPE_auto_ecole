<h2>Gestion des examens</h2>

<?php
    if (isset($_SESSION['message'])) {
        echo "<p style='color: green;'>".$_SESSION['message']."</p>";
        unset($_SESSION['message']);
    }

    if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['id'])) {
        $unControleur->delete_examen($_GET['id']);
        echo "<p style='color: green;'>Examen supprimé avec succès !</p>";
        header("Refresh:1; url=index.php?page=6");
    }

    if (isset($_GET['action']) && $_GET['action'] == 'modifier' && isset($_GET['id'])) {
        $unExamen = $unControleur->selectWhere_examen($_GET['id']);
        $lesCandidats = $unControleur->selectAll_candidats();
        $lesMoniteurs = $unControleur->selectAll_moniteurs();
        $lesVehicules = $unControleur->selectAll_vehicules();
        require_once('vue/vue_update_examen.php');
    } else {
        if (isset($_GET['candidat'])) {
            $lesExamens = $unControleur->selectExamens_byCandidat($_GET['candidat']);
            $candidatInfo = $unControleur->selectWhere_candidat($_GET['candidat']);
            echo "<h3>Examens de ".$candidatInfo['nomC']." ".$candidatInfo['prenomC']."</h3>";
            echo "<a href='?page=2'>← Retour à la liste des candidats</a>";
            echo "<hr>";
            
            require_once('vue/vue_select_examen.php');
            
        } else {
            $lesExamens = $unControleur->selectAll_examens();
            $lesCandidats = $unControleur->selectAll_candidats();
            $lesMoniteurs = $unControleur->selectAll_moniteurs();
            $lesVehicules = $unControleur->selectAll_vehicules();
            require_once('vue/vue_insert_examen.php');
        }
    }
?>