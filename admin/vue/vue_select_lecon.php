<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Candidat</th>
            <th>Moniteur</th>
            <th>Véhicule</th>
            <th>Type de cours</th>
            <th>Date et heure</th>
            <th>Durée</th>
            <th>Compte-rendu</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($lesLecons as $uneLecon) {
                echo "<tr>";
                echo "<td>".$uneLecon['id_lecon']."</td>";
                echo "<td>".$uneLecon['nomC']." ".$uneLecon['prenomC']."</td>";
                echo "<td>".$uneLecon['nomM']." ".$uneLecon['prenomM']."</td>";
                if (!empty($uneLecon['immat'])) {
                    echo "<td>".$uneLecon['marque']." ".$uneLecon['modele']." - ".$uneLecon['immat']."</td>";
                } else {
                    echo "<td><em>Sans véhicule</em></td>";
                }
                echo "<td>".$uneLecon['libelle']."</td>";
                echo "<td>".date('d/m/Y H:i', strtotime($uneLecon['date_lecon']))."</td>";
                echo "<td>".$uneLecon['duree_lecon']." min</td>";
                echo "<td>".substr($uneLecon['compterendu'], 0, 50)."...</td>";
                echo "<td>
                        <a href='?page=5&action=modifier&id=".$uneLecon['id_lecon']."'>Modifier</a> | 
                        <a href='?page=5&action=supprimer&id=".$uneLecon['id_lecon']."' onclick='return confirm(\"Confirmer la suppression ?\")'>Supprimer</a>
                      </td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
