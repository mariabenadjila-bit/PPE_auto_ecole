<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Candidat</th>
            <th>Type d'examen</th>
            <th>Lieu</th>
            <th>Date</th>
            <th>Moniteur</th>
            <th>Véhicule</th>
            <th>Résultat</th>
            <th>Remarques</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($lesExamens as $unExamen) {
                echo "<tr>";
                echo "<td>".$unExamen['id_examen']."</td>";
                echo "<td>".$unExamen['nomC']." ".$unExamen['prenomC']."</td>";
                echo "<td>".$unExamen['type_examen']."</td>";
                echo "<td>".$unExamen['lieu_examen']."</td>";
                echo "<td>".date('d/m/Y H:i', strtotime($unExamen['date_examen']))."</td>";
                if (!empty($unExamen['nomM'])) {
                    echo "<td>".$unExamen['nomM']." ".$unExamen['prenomM']."</td>";
                } else {
                    echo "<td><em>-</em></td>";
                }

                if (!empty($unExamen['immat'])) {
                    echo "<td>".$unExamen['marque']." ".$unExamen['modele']."</td>";
                } else {
                    echo "<td><em>-</em></td>";
                }
                
                $couleur = '';
                switch($unExamen['resultat']) {
                    case 'Reussi': $couleur = 'color: green; font-weight: bold;'; break;
                    case 'Echoue': $couleur = 'color: red; font-weight: bold;'; break;
                    case 'En attente': $couleur = 'color: orange;'; break;
                }
                echo "<td style='$couleur'>".$unExamen['resultat']."</td>";
                
                echo "<td>".substr($unExamen['remarques'], 0, 30)."...</td>";
                echo "<td>
                        <a href='?page=6&action=modifier&id=".$unExamen['id_examen']."'>Modifier</a> | 
                        <a href='?page=6&action=supprimer&id=".$unExamen['id_examen']."' onclick='return confirm(\"Confirmer la suppression ?\")'>Supprimer</a>
                      </td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<!-- <style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }
    th {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        text-align: left;
    }
    td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }
    tr:hover {
        background-color: #f5f5f5;
    }
</style> -->
