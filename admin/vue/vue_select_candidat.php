<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de naissance</th>
            <th>Téléphone</th>
            <th>Adresse</th>
            <th>Date d'inscription</th>
            <th>Statut</th>
            <th>Nombre de leçons</th>
            <th>Nombre d'examens</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($lesCandidats as $unCandidat) {
                $nbLecons = $unControleur->count_lecons_candidat($unCandidat['id_candidat']);
                $nbExamens = $unControleur->count_examens_candidat($unCandidat['id_candidat']);
                
                echo "<tr>";
                echo "<td>".$unCandidat['id_candidat']."</td>";
                echo "<td>".$unCandidat['nomC']."</td>";
                echo "<td>".$unCandidat['prenomC']."</td>";
                echo "<td>".date('d/m/Y', strtotime($unCandidat['date_naissanceC']))."</td>";
                echo "<td>".$unCandidat['telephoneC']."</td>";
                echo "<td>".$unCandidat['adresseC']."</td>";
                echo "<td>".date('d/m/Y', strtotime($unCandidat['date_inscription']))."</td>";
                $couleur = '';
                switch($unCandidat['statut']) {
                    case 'Diplome': $couleur = 'color: green; font-weight: bold;'; break;
                    case 'Examen en cours': $couleur = 'color: orange; font-weight: bold;'; break;
                    case 'En formation': $couleur = 'color: blue;'; break;
                    case 'Abandonne': $couleur = 'color: red;'; break;
                }
                echo "<td style='$couleur'>".$unCandidat['statut']."</td>";
                echo "<td><a href='?page=5&candidat=".$unCandidat['id_candidat']."'>".$nbLecons." leçon(s)</a></td>";
                echo "<td><a href='?page=6&candidat=".$unCandidat['id_candidat']."'>".$nbExamens." examen(s)</a></td>";
                echo "<td>
                        <a href='?page=2&action=modifier&id=".$unCandidat['id_candidat']."'>Modifier</a> | 
                        <a href='?page=2&action=supprimer&id=".$unCandidat['id_candidat']."' onclick='return confirm(\"Confirmer la suppression ?\")'>Supprimer</a>
                      </td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
