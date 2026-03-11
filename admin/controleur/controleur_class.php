<?php 
    require_once(__DIR__ . '/../modele/modele.php');

    class Controleur {
        private $unModele;
        
        public function __construct(){
            $this->unModele = new Modele();
        }
    

        /***************** gestion des users *****************/ 

        public function select_user($email, $mdp){
            $unUser = $this->unModele->select_user($email, $mdp);
            return $unUser;
        }

        public function insert_user($tab){
            $this->unModele->insert_user($tab);
        }


        /***************** gestion des candidats *****************/ 

        public function insert_candidat($tab){
            $this->unModele->insert_candidat($tab);
        }

        public function selectAll_candidats(){
            $lesCandidats = $this->unModele->selectAll_candidats();
            return $lesCandidats; 
        }

        public function selectLike_candidats($filtre){
            $lesCandidats = $this->unModele->selectLike_candidats($filtre); 
            return $lesCandidats; 
        }

        public function delete_candidat($id_candidat){
            $this->unModele->delete_candidat($id_candidat);
        }

        public function update_candidat($tab){
            $this->unModele->update_candidat($tab);
        }

        public function selectWhere_candidat($id_candidat){
            $unCandidat = $this->unModele->selectWhere_candidat($id_candidat);
            return $unCandidat;
        }

        public function count_lecons_candidat($id_candidat){
            return $this->unModele->count_lecons_candidat($id_candidat);
        }

        public function update_statut_candidat($id_candidat){
            $this->unModele->update_statut_candidat($id_candidat);
        }


        /***************** gestion des moniteurs *****************/ 

        public function insert_moniteur($tab){
            $this->unModele->insert_moniteur($tab);
        }

        public function selectAll_moniteurs(){
            $lesMoniteurs = $this->unModele->selectAll_moniteurs();
            return $lesMoniteurs;
        }

        public function selectLike_moniteurs($filtre){
            $lesMoniteurs = $this->unModele->selectLike_moniteurs($filtre); 
            return $lesMoniteurs; 
        }

        public function delete_moniteur($id_moniteur){
            $this->unModele->delete_moniteur($id_moniteur);
        }

        public function update_moniteur($tab){
            $this->unModele->update_moniteur($tab);
        }

        public function selectWhere_moniteur($id_moniteur){
            $unMoniteur = $this->unModele->selectWhere_moniteur($id_moniteur);
            return $unMoniteur;
        }


        /***************** gestion des véhicules *****************/ 

        public function insert_vehicule($tab){
            $this->unModele->insert_vehicule($tab);
        }

        public function selectAll_vehicules(){
            $lesVehicules = $this->unModele->selectAll_vehicules();
            return $lesVehicules;
        }

        public function selectLike_vehicules($filtre){
            $lesVehicules = $this->unModele->selectLike_vehicules($filtre); 
            return $lesVehicules; 
        }

        public function delete_vehicule($id_vehicule){
            $this->unModele->delete_vehicule($id_vehicule);
        }

        public function update_vehicule($tab){
            $this->unModele->update_vehicule($tab);
        }

        public function selectWhere_vehicule($id_vehicule){
            $unVehicule = $this->unModele->selectWhere_vehicule($id_vehicule);
            return $unVehicule;
        }


        /***************** gestion des leçons *****************/ 

        public function insert_lecon($tab){
            $this->unModele->insert_lecon($tab);
        }

        public function selectAll_lecons(){
            $lesLecons = $this->unModele->selectAll_lecons();
            return $lesLecons;
        }

        public function selectLike_lecons($filtre){
            $lesLecons = $this->unModele->selectLike_lecons($filtre); 
            return $lesLecons; 
        }

        public function delete_lecon($id_lecon){
            $this->unModele->delete_lecon($id_lecon);
        }

        public function update_lecon($tab){
            $this->unModele->update_lecon($tab);
        }

        public function selectWhere_lecon($id_lecon){
            $uneLecon = $this->unModele->selectWhere_lecon($id_lecon);
            return $uneLecon;
        }

        public function selectLecons_byCandidat($id_candidat){
            $lesLecons = $this->unModele->selectLecons_byCandidat($id_candidat);
            return $lesLecons;
        }

        /***************** gestion des examens *****************/ 
        
        public function insert_examen($tab){
            $this->unModele->insert_examen($tab);
        }

        public function selectAll_examens(){
            $lesExamens = $this->unModele->selectAll_examens();
            return $lesExamens;
        }

        public function selectLike_examens($filtre){
            $lesExamens = $this->unModele->selectLike_examens($filtre); 
            return $lesExamens; 
        }

        public function delete_examen($id_examen){
            $this->unModele->delete_examen($id_examen);
        }

        public function update_examen($tab){
            $this->unModele->update_examen($tab);
        }

        public function selectWhere_examen($id_examen){
            $unExamen = $this->unModele->selectWhere_examen($id_examen);
            return $unExamen;
        }

        public function selectExamens_byCandidat($id_candidat){
            $lesExamens = $this->unModele->selectExamens_byCandidat($id_candidat);
            return $lesExamens;
        }

        public function count_examens_candidat($id_candidat){
            return $this->unModele->count_examens_candidat($id_candidat);
        }

        /***************** gestion du calendrier des événements *****************/ 

        public function selectAll_evenements(){
            $lesEvenements = $this->unModele->selectAll_evenements();
            return $lesEvenements;
        }

        public function selectEvenements_byMonth($annee, $mois){
            $lesEvenements = $this->unModele->selectEvenements_byMonth($annee, $mois);
            return $lesEvenements;
        }

        public function selectEvenements_prochains($nbJours = 7){
            $lesEvenements = $this->unModele->selectEvenements_prochains($nbJours);
            return $lesEvenements;
        }

        /***************** gestion du calendrier par moniteur ******************/ 
        public function selectEvenements_byMoniteurAndMonth($id_moniteur, $annee, $mois){
            $lesEvenements = $this->unModele->selectEvenements_byMoniteurAndMonth($id_moniteur, $annee, $mois);
            return $lesEvenements;
        }

        public function selectEvenements_prochains_moniteur($id_moniteur, $nbJours = 7){
            $lesEvenements = $this->unModele->selectEvenements_prochains_moniteur($id_moniteur, $nbJours);
            return $lesEvenements;
        }

        // Connexion utilisateur
        public function login($email, $mdp){
            $utilisateur = $this->unModele->login($email, $mdp);
            return $utilisateur;
        }
    }

    
 
?>
