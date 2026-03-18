<?php
session_start();

// Vérifier si connecté et si c'est un client
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'client') {
    header('Location: ../login.php');
    exit();
}

require_once('../admin/controleur/controleur_class.php');
$unControleur = new Controleur();

$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$candidat = $unControleur->selectCandidatByNomPrenom($nom, $prenom);

if (!$candidat) {
    header('Location: index.php');
    exit();
}

$toutes_questions = array(
    array("question" => "Quelle est la vitesse maximale autorisée en agglomération ?", "reponses" => array("30 km/h", "50 km/h", "70 km/h", "90 km/h"), "bonne_reponse" => 1),
    array("question" => "Sur autoroute, quelle est la vitesse maximale autorisée par temps de pluie ?", "reponses" => array("90 km/h", "110 km/h", "130 km/h", "150 km/h"), "bonne_reponse" => 1),
    array("question" => "Sur route hors agglomération, quelle est la vitesse maximale autorisée ?", "reponses" => array("70 km/h", "80 km/h", "90 km/h", "110 km/h"), "bonne_reponse" => 1),
    array("question" => "À quelle distance minimale d'un passage piéton devez-vous vous arrêter ?", "reponses" => array("3 mètres", "5 mètres", "10 mètres", "Juste avant"), "bonne_reponse" => 1),
    array("question" => "La distance de sécurité correspond à la distance parcourue en combien de temps ?", "reponses" => array("1 seconde", "2 secondes", "3 secondes", "5 secondes"), "bonne_reponse" => 1),
    array("question" => "Sur autoroute, la vitesse minimale autorisée sur la voie de gauche est :", "reponses" => array("50 km/h", "70 km/h", "80 km/h", "90 km/h"), "bonne_reponse" => 2),
    array("question" => "Par temps de brouillard, la vitesse est limitée à :", "reponses" => array("30 km/h", "50 km/h", "70 km/h", "90 km/h"), "bonne_reponse" => 1),
    array("question" => "Dans une zone 30, la vitesse maximale est de :", "reponses" => array("20 km/h", "30 km/h", "40 km/h", "50 km/h"), "bonne_reponse" => 1),
    
    array("question" => "Vous devez céder le passage à droite :", "reponses" => array("Toujours", "Sauf indication contraire", "Jamais", "Uniquement en ville"), "bonne_reponse" => 1),
    array("question" => "À un stop, vous devez :", "reponses" => array("Ralentir", "Marquer l'arrêt", "Klaxonner", "Accélérer"), "bonne_reponse" => 1),
    array("question" => "Un triangle pointe en bas signifie :", "reponses" => array("Stop", "Cédez le passage", "Sens interdit", "Danger"), "bonne_reponse" => 1),
    array("question" => "À un rond-point, qui a la priorité ?", "reponses" => array("Celui qui entre", "Celui déjà engagé", "À droite", "À gauche"), "bonne_reponse" => 1),
    array("question" => "Un véhicule prioritaire avec gyrophare et sirène approche, vous devez :", "reponses" => array("Accélérer", "Vous arrêter", "Faciliter son passage", "Klaxonner"), "bonne_reponse" => 2),
    
    array("question" => "Un panneau triangulaire avec un bord rouge signifie :", "reponses" => array("Interdiction", "Danger", "Obligation", "Indication"), "bonne_reponse" => 1),
    array("question" => "Un panneau rond avec un fond bleu et une flèche blanche indique :", "reponses" => array("Interdiction", "Danger", "Obligation", "Indication"), "bonne_reponse" => 2),
    array("question" => "Un panneau rond avec fond blanc et bordure rouge indique :", "reponses" => array("Interdiction", "Danger", "Obligation", "Indication"), "bonne_reponse" => 0),
    array("question" => "Un panneau carré bleu indique :", "reponses" => array("Interdiction", "Danger", "Obligation", "Indication"), "bonne_reponse" => 3),
    array("question" => "Un panneau rond rouge barré de blanc signifie :", "reponses" => array("Stop", "Sens interdit", "Stationnement interdit", "Fin d'interdiction"), "bonne_reponse" => 1),
    
    array("question" => "Le taux d'alcoolémie maximum autorisé pour un conducteur confirmé est :", "reponses" => array("0,2 g/L", "0,5 g/L", "0,8 g/L", "1,0 g/L"), "bonne_reponse" => 1),
    array("question" => "Le taux d'alcoolémie maximum pour un jeune conducteur est :", "reponses" => array("0 g/L", "0,2 g/L", "0,5 g/L", "0,8 g/L"), "bonne_reponse" => 1),
    array("question" => "Combien de verres standards éliminez-vous par heure ?", "reponses" => array("0,10 g/L", "0,15 g/L", "0,20 g/L", "0,50 g/L"), "bonne_reponse" => 1),
    array("question" => "Conduire sous l'emprise de stupéfiants est sanctionné par :", "reponses" => array("Amende", "Retrait de points", "Suspension de permis", "Toutes ces réponses"), "bonne_reponse" => 3),
    
    array("question" => "Combien de temps devez-vous garder votre permis probatoire sans infraction pour obtenir les 12 points ?", "reponses" => array("1 an", "2 ans", "3 ans", "4 ans"), "bonne_reponse" => 2),
    array("question" => "Un jeune conducteur commence avec combien de points ?", "reponses" => array("6 points", "8 points", "10 points", "12 points"), "bonne_reponse" => 0),
    array("question" => "Combien de points perdez-vous pour un excès de vitesse de 40 km/h ?", "reponses" => array("1 point", "2 points", "4 points", "6 points"), "bonne_reponse" => 2),
    array("question" => "Le non-respect d'un stop fait perdre :", "reponses" => array("1 point", "2 points", "4 points", "6 points"), "bonne_reponse" => 2),
    array("question" => "L'usage du téléphone au volant fait perdre :", "reponses" => array("1 point", "2 points", "3 points", "4 points"), "bonne_reponse" => 2),
    
    array("question" => "Les feux de croisement doivent être allumés :", "reponses" => array("La nuit uniquement", "Par mauvaise visibilité", "Dans un tunnel", "Toutes ces réponses"), "bonne_reponse" => 3),
    array("question" => "Les feux de brouillard arrière doivent être utilisés quand la visibilité est inférieure à :", "reponses" => array("50 mètres", "100 mètres", "150 mètres", "200 mètres"), "bonne_reponse" => 0),
    array("question" => "Les feux de position doivent être utilisés :", "reponses" => array("Jamais", "La nuit en ville éclairée", "Toujours", "Sur autoroute"), "bonne_reponse" => 1),
    array("question" => "Dans un tunnel, vous devez allumer :", "reponses" => array("Feux de position", "Feux de croisement", "Feux de route", "Warning"), "bonne_reponse" => 1),
    
    array("question" => "Vous pouvez stationner sur un trottoir :", "reponses" => array("Toujours", "Jamais", "Si pas de place", "La nuit uniquement"), "bonne_reponse" => 1),
    array("question" => "Le stationnement est interdit à moins de combien de mètres d'un passage piéton ?", "reponses" => array("3 mètres", "5 mètres", "10 mètres", "15 mètres"), "bonne_reponse" => 1),
    array("question" => "Un stationnement gênant est sanctionné par :", "reponses" => array("Rien", "Une amende", "Un retrait de points", "Les deux"), "bonne_reponse" => 1),
    array("question" => "En ville, vous pouvez stationner du côté gauche :", "reponses" => array("Toujours", "Jamais", "Dans une rue à sens unique", "La nuit"), "bonne_reponse" => 2),
    
    array("question" => "Vous pouvez dépasser par la droite :", "reponses" => array("Toujours", "Jamais", "Sur autoroute si trafic dense", "En ville uniquement"), "bonne_reponse" => 2),
    array("question" => "Le dépassement est interdit :", "reponses" => array("En haut de côte", "Dans un virage", "À l'approche d'un passage piéton", "Toutes ces réponses"), "bonne_reponse" => 3),
    array("question" => "Avant de dépasser, vous devez :", "reponses" => array("Accélérer", "Contrôler rétroviseurs", "Klaxonner", "Allumer les warnings"), "bonne_reponse" => 1),
    
    array("question" => "Le port de la ceinture est obligatoire :", "reponses" => array("À l'avant uniquement", "À l'arrière uniquement", "Partout", "Sur autoroute"), "bonne_reponse" => 2),
    array("question" => "Un enfant de moins de 10 ans doit être installé :", "reponses" => array("À l'avant", "À l'arrière", "N'importe où", "Debout"), "bonne_reponse" => 1),
    array("question" => "Le siège auto est obligatoire jusqu'à :", "reponses" => array("2 ans", "5 ans", "10 ans ou 135 cm", "12 ans"), "bonne_reponse" => 2),
    array("question" => "Le non-port de la ceinture fait perdre :", "reponses" => array("1 point", "2 points", "3 points", "4 points"), "bonne_reponse" => 2),
    
    array("question" => "Le chargement ne doit pas dépasser de plus de combien à l'arrière ?", "reponses" => array("1 mètre", "2 mètres", "3 mètres", "4 mètres"), "bonne_reponse" => 2),
    array("question" => "Avec une remorque, la vitesse maximale sur autoroute est :", "reponses" => array("90 km/h", "110 km/h", "130 km/h", "150 km/h"), "bonne_reponse" => 1),
    
    array("question" => "Le port du casque à moto est :", "reponses" => array("Conseillé", "Obligatoire", "Facultatif en ville", "Pour les jeunes"), "bonne_reponse" => 1),
    array("question" => "Les deux-roues peuvent circuler entre les files :", "reponses" => array("Toujours", "Jamais", "Si autorisé", "En ville"), "bonne_reponse" => 1),
    
    array("question" => "Le contrôle technique est obligatoire tous les :", "reponses" => array("1 an", "2 ans", "3 ans", "4 ans"), "bonne_reponse" => 1),
    array("question" => "Jeter un déchet par la fenêtre est sanctionné par :", "reponses" => array("Rien", "Une amende", "Retrait de points", "Les deux"), "bonne_reponse" => 1),
    array("question" => "La vignette Crit'Air est obligatoire :", "reponses" => array("Partout", "Dans certaines zones", "Jamais", "Sur autoroute"), "bonne_reponse" => 1),
    
    array("question" => "En cas d'accident, vous devez :", "reponses" => array("Fuir", "Sécuriser et appeler secours", "Déplacer les véhicules", "Rien"), "bonne_reponse" => 1),
    array("question" => "Le triangle de présignalisation doit être placé à :", "reponses" => array("10 mètres", "30 mètres", "50 mètres", "100 mètres"), "bonne_reponse" => 1),
    array("question" => "Le gilet jaune doit être porté :", "reponses" => array("Dans la voiture", "En sortant du véhicule", "Jamais", "La nuit"), "bonne_reponse" => 1),
    array("question" => "En cas de panne sur autoroute, vous devez :", "reponses" => array("Rester dans la voiture", "Sortir par la droite", "Appeler un ami", "Réparer"), "bonne_reponse" => 1),
    
    array("question" => "Pour économiser du carburant, vous devez :", "reponses" => array("Accélérer fort", "Rouler en sous-régime", "Adopter une conduite souple", "Freiner brusquement"), "bonne_reponse" => 2),
    array("question" => "Le point mort permet d'économiser du carburant :", "reponses" => array("Vrai", "Faux", "En descente uniquement", "Sur autoroute"), "bonne_reponse" => 1),
    
    array("question" => "Le niveau d'huile doit être vérifié :", "reponses" => array("Tous les jours", "Toutes les semaines", "Tous les mois", "Au contrôle technique"), "bonne_reponse" => 2),
    array("question" => "La pression des pneus doit être vérifiée :", "reponses" => array("À chaud", "À froid", "Après 100 km", "Jamais"), "bonne_reponse" => 1),
    array("question" => "La profondeur minimale des sculptures de pneus est de :", "reponses" => array("0,8 mm", "1,6 mm", "3 mm", "5 mm"), "bonne_reponse" => 1),
    
    array("question" => "L'assurance responsabilité civile couvre :", "reponses" => array("Vos dégâts", "Les dégâts aux autres", "Tout", "Rien"), "bonne_reponse" => 1),
    array("question" => "Rouler sans assurance est sanctionné par :", "reponses" => array("Amende", "Suspension de permis", "Confiscation du véhicule", "Toutes ces réponses"), "bonne_reponse" => 3),
    array("question" => "Le constat amiable doit être envoyé sous :", "reponses" => array("24h", "48h", "5 jours", "1 mois"), "bonne_reponse" => 2),
    
    array("question" => "Sur une route à 3 voies, vous devez circuler :", "reponses" => array("À droite", "Au milieu", "À gauche", "N'importe où"), "bonne_reponse" => 0),
    array("question" => "Vous doublez un cycliste, vous devez laisser :", "reponses" => array("50 cm", "1 mètre", "1,5 mètre", "2 mètres"), "bonne_reponse" => 1),
    array("question" => "Un terre-plein central se franchit :", "reponses" => array("Toujours", "Jamais", "Si discontinu", "En cas d'urgence"), "bonne_reponse" => 1),
    array("question" => "Les bandes blanches continues signifient :", "reponses" => array("Interdiction de franchir", "Autorisation de franchir", "Danger", "Indication"), "bonne_reponse" => 0),
    
    array("question" => "Sur l'autoroute, vous devez utiliser la bande d'arrêt d'urgence :", "reponses" => array("Pour doubler", "En cas de panne", "Pour téléphoner", "Jamais"), "bonne_reponse" => 1),
    array("question" => "La distance entre deux aires de repos sur autoroute est d'environ :", "reponses" => array("10 km", "20 km", "40 km", "100 km"), "bonne_reponse" => 2),
    array("question" => "Faire demi-tour sur autoroute est :", "reponses" => array("Autorisé", "Interdit", "Toléré", "Conseillé"), "bonne_reponse" => 1),
    
    array("question" => "Un piéton s'engage sur un passage piéton, vous devez :", "reponses" => array("Accélérer", "Klaxonner", "Vous arrêter", "Ralentir"), "bonne_reponse" => 2),
    array("question" => "Les cyclistes peuvent rouler à deux de front :", "reponses" => array("Toujours", "Jamais", "Hors agglomération", "En ville uniquement"), "bonne_reponse" => 0),
    
    array("question" => "Le klaxon doit être utilisé :", "reponses" => array("Pour saluer", "En cas de danger immédiat", "Pour doubler", "La nuit"), "bonne_reponse" => 1),
    array("question" => "Le téléphone en mode kit mains-libres :", "reponses" => array("Est interdit", "Est autorisé", "Est toléré", "Fait perdre des points"), "bonne_reponse" => 1),
    array("question" => "Les oreillettes et écouteurs au volant sont :", "reponses" => array("Autorisés", "Interdits", "Tolérés", "Conseillés"), "bonne_reponse" => 1),
    array("question" => "En cas de dépassement de la vitesse de 50 km/h, le permis peut être :", "reponses" => array("Suspendu", "Retiré", "Annulé", "Toutes ces réponses"), "bonne_reponse" => 0),
    
    array("question" => "Par temps de pluie, la distance de freinage :", "reponses" => array("Diminue", "Augmente", "Ne change pas", "Double"), "bonne_reponse" => 1),
    array("question" => "Sur route verglacée, vous devez :", "reponses" => array("Accélérer", "Freiner fort", "Éviter les freinages brusques", "Rouler vite"), "bonne_reponse" => 2),
    array("question" => "L'aquaplaning se produit quand :", "reponses" => array("Il fait chaud", "La route est mouillée", "Il neige", "Il fait sec"), "bonne_reponse" => 1),
    
    array("question" => "À une intersection sans signalisation, qui a la priorité ?", "reponses" => array("Celui de droite", "Celui de gauche", "Le plus rapide", "Personne"), "bonne_reponse" => 0),
    array("question" => "Le feu orange signifie :", "reponses" => array("Accélérer", "S'arrêter si possible", "Continuer", "Ralentir"), "bonne_reponse" => 1),
    array("question" => "Griller un feu rouge fait perdre :", "reponses" => array("1 point", "2 points", "4 points", "6 points"), "bonne_reponse" => 2),
    
    array("question" => "Le nombre maximum de passagers dans une voiture est indiqué :", "reponses" => array("Sur la carte grise", "Dans le manuel", "Par le constructeur", "Libre"), "bonne_reponse" => 0),
    array("question" => "Transporter un enfant sans siège adapté fait perdre :", "reponses" => array("1 point", "2 points", "3 points", "4 points"), "bonne_reponse" => 2),
    
    array("question" => "En cas de fatigue, vous devez :", "reponses" => array("Continuer", "Vous arrêter", "Boire du café", "Ouvrir la fenêtre"), "bonne_reponse" => 1),
    array("question" => "Il est conseillé de faire une pause toutes les :", "reponses" => array("30 min", "1 heure", "2 heures", "3 heures"), "bonne_reponse" => 2),
    array("question" => "Certains médicaments peuvent :", "reponses" => array("Améliorer la conduite", "Diminuer la vigilance", "Augmenter les réflexes", "N'ont aucun effet"), "bonne_reponse" => 1),
    
    array("question" => "Les documents obligatoires à bord sont :", "reponses" => array("Permis uniquement", "Carte grise uniquement", "Permis, carte grise, assurance", "Aucun"), "bonne_reponse" => 2),
    array("question" => "Le certificat d'immatriculation doit être :", "reponses" => array("À la maison", "Dans la boîte à gants", "Sur le pare-brise", "Nulle part"), "bonne_reponse" => 1),
    
    array("question" => "Un verre standard contient environ :", "reponses" => array("5g d'alcool", "10g d'alcool", "15g d'alcool", "20g d'alcool"), "bonne_reponse" => 1),
    array("question" => "Le café permet d'éliminer l'alcool :", "reponses" => array("Vrai", "Faux", "Partiellement", "Rapidement"), "bonne_reponse" => 1),
    
    array("question" => "Regarder loin devant permet de :", "reponses" => array("Aller plus vite", "Anticiper les dangers", "Économiser", "Rien"), "bonne_reponse" => 1),
    array("question" => "Les rétroviseurs doivent être vérifiés :", "reponses" => array("Jamais", "Rarement", "Régulièrement", "Au démarrage"), "bonne_reponse" => 2),
    
    array("question" => "Face à un bus qui redémarre, vous devez :", "reponses" => array("Doubler", "Klaxonner", "Faciliter sa sortie", "Continuer"), "bonne_reponse" => 2),
    array("question" => "Un tracteur agricole roule lentement, vous :", "reponses" => array("Klaxonnez", "Le doublez si possible", "Collez derrière", "Insultez"), "bonne_reponse" => 1),
);

shuffle($toutes_questions);
$questions = array_slice($toutes_questions, 0, 30);

$score = null;
$reponses_utilisateur = array();
$corrections = array();

if (isset($_POST['ValiderTest'])) {
    $score = 0;
    foreach ($questions as $index => $q) {
        $reponse_user = isset($_POST['q_' . $index]) ? intval($_POST['q_' . $index]) : -1;
        $reponses_utilisateur[$index] = $reponse_user;
        
        if ($reponse_user === $q['bonne_reponse']) {
            $score++;
            $corrections[$index] = true;
        } else {
            $corrections[$index] = false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entraînement Code - CASTELLANE-AUTO</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        .header {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .intro-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .intro-box h2 {
            color: #2e7d32;
            margin-bottom: 15px;
        }

        .info-box {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #2196f3;
        }

        .question-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .question-number {
            background: #2e7d32;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .question-text {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .reponses {
            display: grid;
            gap: 15px;
        }

        .reponse-item {
            position: relative;
        }

        .reponse-item input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .reponse-item label {
            display: block;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 16px;
        }

        .reponse-item input[type="radio"]:checked + label {
            border-color: #4caf50;
            background: #f1f8f4;
        }

        .reponse-item label:hover {
            border-color: #4caf50;
        }

        .reponse-item.correct label {
            border-color: #4caf50;
            background: #c8e6c9;
            color: #2e7d32;
        }

        .reponse-item.incorrect label {
            border-color: #f44336;
            background: #ffcdd2;
            color: #c62828;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: #4caf50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background: #45a049;
        }

        .result-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .score-display {
            font-size: 72px;
            font-weight: bold;
            margin: 20px 0;
        }

        .score-display.success {
            color: #4caf50;
        }

        .score-display.fail {
            color: #f44336;
        }

        .result-message {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .btn-retry {
            display: inline-block;
            padding: 15px 40px;
            background: #2e7d32;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
        }

        .btn-retry:hover {
            background: #1b5e20;
        }

        .progress-bar {
            background: #e0e0e0;
            height: 8px;
            border-radius: 4px;
            margin: 20px 0;
            overflow: hidden;
        }

        .progress-fill {
            background: #4caf50;
            height: 100%;
            transition: width 0.3s;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <h1>Castellane-auto</h1>
                <p>Entraînement au Code de la Route</p>
            </div>
            <div class="nav-links">
                <a href="index.php">← Tableau de bord</a>
                <a href="logout.php">Déconnexion</a>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if ($score === null): ?>
            <div class="intro-box">
                <h2>Testez vos connaissances !</h2>
                <p>Vous allez répondre à <strong>30 questions</strong> tirées aléatoirement parmi 100 questions officielles.</p>
                <p>Pour réussir l'examen officiel du code de la route, vous devez obtenir au moins <strong>35/40</strong> bonnes réponses <em>(soit 88%)</em>.</p>
                <p>Dans ce test : <strong>26/30 minimum</strong> pour réussir.</p>
                
                <div class="info-box">
                    <strong>Conseils :</strong><br>
                    • Lisez attentivement chaque question<br>
                    • Une seule réponse est correcte par question<br>
                    • Prenez votre temps, il n'y a pas de limite<br>
                    • À la fin, vous verrez votre score et les corrections détaillées
                </div>
            </div>

            <form method="post" id="quizForm">
                <?php foreach ($questions as $index => $q): ?>
                    <div class="question-card">
                        <div class="question-number">Question <?php echo ($index + 1); ?>/30</div>
                        <div class="question-text"><?php echo $q['question']; ?></div>
                        
                        <div class="reponses">
                            <?php foreach ($q['reponses'] as $rep_index => $reponse): ?>
                                <div class="reponse-item">
                                    <input type="radio" 
                                           id="q<?php echo $index; ?>_r<?php echo $rep_index; ?>" 
                                           name="q_<?php echo $index; ?>" 
                                           value="<?php echo $rep_index; ?>"
                                           required>
                                    <label for="q<?php echo $index; ?>_r<?php echo $rep_index; ?>">
                                        <?php echo chr(65 + $rep_index); ?>. <?php echo $reponse; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <button type="submit" name="ValiderTest" class="btn-submit">
                    Valider mes réponses
                </button>
            </form>

        <?php else: ?>
            <div class="result-box">
                <h2>Votre résultat</h2>
                <div class="score-display <?php echo ($score >= 26) ? 'success' : 'fail'; ?>">
                    <?php echo $score; ?>/30
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo ($score / 30 * 100); ?>%"></div>
                </div>
                <div class="result-message">
                    <?php if ($score >= 26): ?>
                        <strong>ADMIS</strong> - Vous avez réussi le test !
                    <?php else: ?>
                        <strong>NON ADMIS</strong> - Continuez à vous entraîner !
                    <?php endif; ?>
                </div>
                <p>
                    <?php 
                    $pourcentage = round(($score / 30) * 100);
                    echo "Vous avez obtenu <strong>$pourcentage%</strong> de bonnes réponses.<br>";
                    
                    if ($score == 30) {
                        echo "Parfait ! Vous maîtrisez le code à 100% !";
                    } elseif ($score >= 28) {
                        echo "Excellent ! Vous êtes prêt pour l'examen !";
                    } elseif ($score >= 26) {
                        echo "Très bien ! Encore quelques révisions et c'est parfait !";
                    } elseif ($score >= 23) {
                        echo "Presque ! Révisez les points faibles et recommencez.";
                    } else {
                        echo "Il faut travailler davantage. Révisez le cours et recommencez !";
                    }
                    ?>
                </p>
                <a href="entrainement-code.php" class="btn-retry">Refaire un nouveau test</a>
            </div>

            <h2 style="color: #2e7d32; margin-bottom: 20px;">Corrections détaillées</h2>
            <?php foreach ($questions as $index => $q): ?>
                <div class="question-card">
                    <div class="question-number">
                        Question <?php echo ($index + 1); ?>/30 
                        <?php echo $corrections[$index] ? '✅' : '❌'; ?>
                    </div>
                    <div class="question-text"><?php echo $q['question']; ?></div>
                    
                    <div class="reponses">
                        <?php foreach ($q['reponses'] as $rep_index => $reponse): ?>
                            <?php
                            $class = '';
                            if ($rep_index === $q['bonne_reponse']) {
                                $class = 'correct';
                            } elseif (isset($reponses_utilisateur[$index]) && $reponses_utilisateur[$index] === $rep_index && !$corrections[$index]) {
                                $class = 'incorrect';
                            }
                            ?>
                            <div class="reponse-item <?php echo $class; ?>">
                                <input type="radio" 
                                       id="corr_q<?php echo $index; ?>_r<?php echo $rep_index; ?>" 
                                       name="corr_q_<?php echo $index; ?>" 
                                       value="<?php echo $rep_index; ?>"
                                       <?php echo (isset($reponses_utilisateur[$index]) && $reponses_utilisateur[$index] === $rep_index) ? 'checked' : ''; ?>
                                       disabled>
                                <label for="corr_q<?php echo $index; ?>_r<?php echo $rep_index; ?>">
                                    <?php echo chr(65 + $rep_index); ?>. <?php echo $reponse; ?>
                                    <?php if ($rep_index === $q['bonne_reponse']): ?>
                                        ✅ <strong>Bonne réponse</strong>
                                    <?php endif; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</body>
</html>
