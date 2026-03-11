<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Date d'embauche</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($lesMoniteurs as $unMoniteur) {
                echo "<tr>";
                echo "<td>".$unMoniteur['id_moniteur']."</td>";
                echo "<td>".$unMoniteur['nomM']."</td>";
                echo "<td>".$unMoniteur['prenomM']."</td>";
                echo "<td>".$unMoniteur['emailM']."</td>";
                echo "<td>".$unMoniteur['telephoneM']."</td>";
                echo "<td>".date('d/m/Y', strtotime($unMoniteur['date_embauche']))."</td>";
                echo "<td>
                        <a href='?page=3&action=modifier&id=".$unMoniteur['id_moniteur']."'>Modifier</a> | 
                        <a href='?page=3&action=supprimer&id=".$unMoniteur['id_moniteur']."' onclick='return confirm(\"Confirmer la suppression ?\")'>Supprimer</a>
                      </td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
