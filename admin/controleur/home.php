<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        .filter-section {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin: 20px 0;
        }
        
        .filter-section select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 10px;
        }
        
        .filter-section button {
            padding: 8px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .filter-section button:hover {
            background: #45a049;
        }
        
        .filter-section .btn-reset {
            background: #888;
        }
        
        .filter-section .btn-reset:hover {
            background: #666;
        }
        
        .dashboard {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }
        
        .calendar-section {
            flex: 2;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .upcoming-section {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-height: 600px;
            overflow-y: auto;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .calendar-nav {
            display: flex;
            gap: 10px;
        }
        
        .btn-nav {
            padding: 8px 15px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        
        .btn-nav:hover {
            background: #45a049;
        }
        
        .calendar-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-top: 20px;
        }
        
        .calendar-day-header {
            text-align: center;
            font-weight: bold;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 4px;
        }
        
        .calendar-day {
            min-height: 100px;
            border: 1px solid #ddd;
            padding: 5px;
            background: white;
            border-radius: 4px;
            position: relative;
        }
        
        .calendar-day.other-month {
            background: #f9f9f9;
            color: #999;
        }
        
        .calendar-day.today {
            background: #e3f2fd;
            border: 2px solid #2196F3;
        }
        
        .day-number {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .event-item {
            font-size: 10px;
            padding: 3px 4px;
            margin: 2px 0;
            border-radius: 3px;
            cursor: pointer;
            overflow: hidden;
            line-height: 1.2;
        }
        
        .event-lecon {
            background: #bbdefb;
            color: #1565c0;
        }
        
        .event-examen {
            background: #ffccbc;
            color: #d84315;
            font-weight: bold;
        }
        
        .event-time {
            font-weight: bold;
            display: block;
        }
        
        .event-name {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .upcoming-item {
            padding: 12px;
            margin: 10px 0;
            border-left: 4px solid #4CAF50;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .upcoming-item.examen {
            border-left-color: #f44336;
        }
        
        .upcoming-date {
            font-weight: bold;
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .upcoming-title {
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .upcoming-details {
            font-size: 13px;
            color: #777;
        }
        
        .legend {
            display: flex;
            gap: 20px;
            margin: 15px 0;
            font-size: 14px;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 3px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        
        .stat-card:nth-child(2) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .stat-card:nth-child(3) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .stat-card:nth-child(4) {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .moniteur-info {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #856404;
        }
    </style>
</head>
<body>

<h1>Tableau de bord - Auto-école Castellane-Auto</h1>

<p>Bonjour <?php echo $_SESSION['prenom'].' '.$_SESSION['nom']; ?> !</p>

<?php
$nbCandidats = count($unControleur->selectAll_candidats());
$nbMoniteurs = count($unControleur->selectAll_moniteurs());
$nbVehicules = count($unControleur->selectAll_vehicules());
$nbLeconsSemaine = count($unControleur->selectEvenements_prochains(7));
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Candidats inscrits</div>
        <div class="stat-number"><?php echo $nbCandidats; ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Moniteurs</div>
        <div class="stat-number"><?php echo $nbMoniteurs; ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Véhicules</div>
        <div class="stat-number"><?php echo $nbVehicules; ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Événements cette semaine</div>
        <div class="stat-number"><?php echo $nbLeconsSemaine; ?></div>
    </div>
</div>

<div class="filter-section">
    <form method="get" style="display: inline;">
        <input type="hidden" name="page" value="1">
        <label for="moniteur">Filtrer par moniteur :</label>
        <select name="moniteur" id="moniteur">
            <option value="">-- Tous les moniteurs --</option>
            <?php
                $lesMoniteurs = $unControleur->selectAll_moniteurs();
                foreach ($lesMoniteurs as $unMoniteur) {
                    $selected = (isset($_GET['moniteur']) && $_GET['moniteur'] == $unMoniteur['id_moniteur']) ? 'selected' : '';
                    echo "<option value='".$unMoniteur['id_moniteur']."' $selected>";
                    echo $unMoniteur['nomM'].' '.$unMoniteur['prenomM'];
                    echo "</option>";
                }
            ?>
        </select>
        <button type="submit">Filtrer</button>
        <?php if (isset($_GET['moniteur']) && $_GET['moniteur'] != ''): ?>
            <a href="?page=1"><button type="button" class="btn-reset">Réinitialiser</button></a>
        <?php endif; ?>
    </form>
</div>

<?php
if (isset($_GET['moniteur']) && $_GET['moniteur'] != '') {
    $moniteurSelectionne = $unControleur->selectWhere_moniteur($_GET['moniteur']);
    echo '<div class="moniteur-info">';
    echo '📅 Planning de : '.$moniteurSelectionne['nomM'].' '.$moniteurSelectionne['prenomM'];
    echo '</div>';
}
?>

<div class="dashboard">
    <div class="calendar-section">
        <?php
        $mois = isset($_GET['mois']) ? intval($_GET['mois']) : intval(date('m'));
        $annee = isset($_GET['annee']) ? intval($_GET['annee']) : intval(date('Y'));
        $moniteurFiltre = isset($_GET['moniteur']) ? $_GET['moniteur'] : '';
        
        $moisPrec = $mois - 1;
        $anneePrec = $annee;
        if ($moisPrec < 1) {
            $moisPrec = 12;
            $anneePrec--;
        }
        
        $moisSuiv = $mois + 1;
        $anneeSuiv = $annee;
        if ($moisSuiv > 12) {
            $moisSuiv = 1;
            $anneeSuiv++;
        }
        
        $urlParams = "page=1&mois=%d&annee=%d";
        if ($moniteurFiltre != '') {
            $urlParams .= "&moniteur=$moniteurFiltre";
        }
        
        if ($moniteurFiltre != '') {
            $evenements = $unControleur->selectEvenements_byMoniteurAndMonth($moniteurFiltre, $annee, $mois);
        } else {
            $evenements = $unControleur->selectEvenements_byMonth($annee, $mois);
        }
        
        $evenementsParJour = array();
        foreach ($evenements as $evt) {
            $jour = intval(date('j', strtotime($evt['date_evenement'])));
            if (!isset($evenementsParJour[$jour])) {
                $evenementsParJour[$jour] = array();
            }
            $evenementsParJour[$jour][] = $evt;
        }
        
        $nomsMois = array('', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
                          'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        $premierJour = mktime(0, 0, 0, $mois, 1, $annee);
        $nbJours = date('t', $premierJour);
        $jourSemaine = date('N', $premierJour);
        ?>
        
        <div class="calendar-header">
            <div class="calendar-nav">
                <a href="?<?php echo sprintf($urlParams, $moisPrec, $anneePrec); ?>" class="btn-nav">◄ Précédent</a>
                <a href="?page=1<?php echo $moniteurFiltre ? '&moniteur='.$moniteurFiltre : ''; ?>" class="btn-nav">Aujourd'hui</a>
                <a href="?<?php echo sprintf($urlParams, $moisSuiv, $anneeSuiv); ?>" class="btn-nav">Suivant ►</a>
            </div>
            <div class="calendar-title"><?php echo $nomsMois[$mois] . ' ' . $annee; ?></div>
        </div>
        
        <div class="legend">
            <div class="legend-item">
                <div class="legend-color" style="background: #bbdefb;"></div>
                <span>Leçon de conduite</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background: #ffccbc;"></div>
                <span>Examen</span>
            </div>
        </div>
        
        <div class="calendar-grid">
            <!-- En-têtes des jours -->
            <div class="calendar-day-header">Lun</div>
            <div class="calendar-day-header">Mar</div>
            <div class="calendar-day-header">Mer</div>
            <div class="calendar-day-header">Jeu</div>
            <div class="calendar-day-header">Ven</div>
            <div class="calendar-day-header">Sam</div>
            <div class="calendar-day-header">Dim</div>
            
            <?php
            for ($i = 1; $i < $jourSemaine; $i++) {
                echo '<div class="calendar-day other-month"></div>';
            }
            
            $aujourdhui = intval(date('j'));
            $moisCourant = intval(date('m'));
            $anneeCourante = intval(date('Y'));
            
            for ($jour = 1; $jour <= $nbJours; $jour++) {
                $isToday = ($jour == $aujourdhui && $mois == $moisCourant && $annee == $anneeCourante);
                $classe = $isToday ? 'calendar-day today' : 'calendar-day';
                
                echo '<div class="' . $classe . '">';
                echo '<div class="day-number">' . $jour . '</div>';
                
                if (isset($evenementsParJour[$jour])) {
                    foreach ($evenementsParJour[$jour] as $evt) {
                        $classeEvent = ($evt['type_evenement'] == 'lecon') ? 'event-lecon' : 'event-examen';
                        $heure = date('H:i', strtotime($evt['date_evenement']));
                        
                        $nom = isset($evt['nom_candidat']) ? $evt['nom_candidat'] : '';
                        $prenom = isset($evt['prenom_candidat']) ? $evt['prenom_candidat'] : '';
                        
                        if (strlen($nom) > 8) {
                            $affichage = $prenom;
                        } else {
                            $affichage = $nom . ' ' . substr($prenom, 0, 1) . '.';
                        }
                        
                        echo '<div class="event-item ' . $classeEvent . '" title="' . htmlspecialchars($evt['candidat_nom'] . ' - ' . $evt['libelle']) . '">';
                        echo '<span class="event-time">' . $heure . '</span>';
                        echo '<span class="event-name">' . htmlspecialchars($affichage) . '</span>';
                        echo '</div>';
                    }
                }
                
                echo '</div>';
            }
            
            $dernierJourSemaine = date('N', mktime(0, 0, 0, $mois, $nbJours, $annee));
            for ($i = $dernierJourSemaine; $i < 7; $i++) {
                echo '<div class="calendar-day other-month"></div>';
            }
            ?>
        </div>
    </div>
    
    <div class="upcoming-section">
        <h3>Prochains événements (7 jours)</h3>
        
        <?php
        if ($moniteurFiltre != '') {
            $prochains = $unControleur->selectEvenements_prochains_moniteur($moniteurFiltre, 7);
        } else {
            $prochains = $unControleur->selectEvenements_prochains(7);
        }
        
        if (count($prochains) == 0) {
            echo '<p style="color: #999; text-align: center; margin-top: 50px;">Aucun événement prévu dans les 7 prochains jours</p>';
        } else {
            $jourActuel = '';
            $joursFr = array(
                'Monday' => 'Lundi',
                'Tuesday' => 'Mardi',
                'Wednesday' => 'Mercredi',
                'Thursday' => 'Jeudi',
                'Friday' => 'Vendredi',
                'Saturday' => 'Samedi',
                'Sunday' => 'Dimanche'
            );
            $moisFr = array(
                'January' => 'janvier',
                'February' => 'février',
                'March' => 'mars',
                'April' => 'avril',
                'May' => 'mai',
                'June' => 'juin',
                'July' => 'juillet',
                'August' => 'août',
                'September' => 'septembre',
                'October' => 'octobre',
                'November' => 'novembre',
                'December' => 'décembre'
            );
            
            foreach ($prochains as $evt) {
                $timestamp = strtotime($evt['date_evenement']);
                $jourSemaineEn = date('l', $timestamp);
                $numeroJour = date('j', $timestamp);
                $moisEn = date('F', $timestamp);
                $anneeEvt = date('Y', $timestamp);
                
                $jourTraduit = $joursFr[$jourSemaineEn] . ' ' . $numeroJour . ' ' . $moisFr[$moisEn] . ' ' . $anneeEvt;
                
                if ($jourTraduit != $jourActuel) {
                    if ($jourActuel != '') echo '<hr style="margin: 15px 0; border: none; border-top: 1px solid #eee;">';
                    echo '<h4 style="color: #4CAF50; margin: 15px 0 10px 0;">' . $jourTraduit . '</h4>';
                    $jourActuel = $jourTraduit;
                }
                
                $classe = ($evt['type_evenement'] == 'examen') ? 'upcoming-item examen' : 'upcoming-item';
                $icone = ($evt['type_evenement'] == 'examen') ? '📝' : '🚗';
                
                echo '<div class="' . $classe . '">';
                echo '<div class="upcoming-date">' . $icone . ' ' . date('H:i', strtotime($evt['date_evenement']));
                if ($evt['duree_lecon']) {
                    echo ' (' . $evt['duree_lecon'] . ' min)';
                }
                echo '</div>';
                echo '<div class="upcoming-title">' . htmlspecialchars($evt['candidat_nom']) . '</div>';
                echo '<div class="upcoming-details">';
                echo $evt['libelle'];
                if ($evt['moniteur_nom']) {
                    echo ' - Moniteur : ' . htmlspecialchars($evt['moniteur_nom']);
                }
                if ($evt['vehicule_info'] && $evt['type_evenement'] == 'lecon') {
                    echo '<br>Véhicule : ' . htmlspecialchars($evt['vehicule_info']);
                }
                if ($evt['vehicule_info'] && $evt['type_evenement'] == 'examen') {
                    echo '<br>Lieu : ' . htmlspecialchars($evt['vehicule_info']);
                }
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>

</body>
</html>