<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Immatriculation</th>
            <th>Marque</th>
            <th>Modèle</th>
            <th>Type</th>
            <th>Énergie</th>
            <th>Date d'achat</th>
            <th>Kilométrage</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($lesVehicules as $unVehicule) {
                echo "<tr>";
                echo "<td>".$unVehicule['id_vehicule']."</td>";
                echo "<td>".$unVehicule['immat']."</td>";
                echo "<td>".$unVehicule['marque']."</td>";
                echo "<td>".$unVehicule['modele']."</td>";
                echo "<td>".$unVehicule['type_vehicule']."</td>";
                echo "<td>".$unVehicule['energie']."</td>";
                echo "<td>".date('d/m/Y', strtotime($unVehicule['date_Achat']))."</td>";
                echo "<td>".number_format($unVehicule['nb_km'], 0, ',', ' ')." km</td>";
                echo "<td>
                        <a href='?page=4&action=modifier&id=".$unVehicule['id_vehicule']."'>Modifier</a> | 
                        <a href='?page=4&action=supprimer&id=".$unVehicule['id_vehicule']."' onclick='return confirm(\"Confirmer la suppression ?\")'>Supprimer</a>
                      </td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
