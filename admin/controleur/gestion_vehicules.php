<h2>Gestion des véhicules</h2>

<?php
    if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['id'])) {
        $unControleur->delete_vehicule($_GET['id']);
        echo "<p style='color: green;'>Véhicule supprimé avec succès !</p>";
        header("Refresh:1; url=index.php?page=4");
    }

    if (isset($_GET['action']) && $_GET['action'] == 'modifier' && isset($_GET['id'])) {
        $unVehicule = $unControleur->selectWhere_vehicule($_GET['id']);
        require_once('vue/vue_update_vehicule.php');
    } else {
        $lesVehicules = $unControleur->selectAll_vehicules();
        require_once('vue/vue_insert_vehicule.php');
    }
?>
