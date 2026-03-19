<?php
    class Modele {
        private $unPdo;

        public function __construct(){
            $url  = "mysql:host=localhost;dbname=auto_ecole";
            $user = "root";
            $mdp  = "";

            try {
                $this->unPdo = new PDO($url, $user, $mdp);
                $this->unPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $exp){
                echo "<br> Erreur de connexion à ".$url;
                echo $exp->getMessage();
            }
        }

        public function login($email, $mdp){
            $requete = "select * from user where email = :email and mdp = :mdp;";
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':email' => $email, ':mdp' => $mdp));
            $utilisateur = $exec->fetch();
            return $utilisateur;
        }

                            /* inscription */
    
        public function verifierEmailExiste($email){
            $requete = "select count(*) as nb from user where email = :email;";
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':email' => $email));
            $result = $exec->fetch();
            return $result['nb'] > 0;
        }

                            /* gestion des users */
        
        public function select_user($email, $mdp){
            $requete = "select * from user 
                        where email = :email 
                        and mdp = :mdp;";
            $donnees = array(":email" => $email, ":mdp" => $mdp);
            $select = $this->unPdo->prepare($requete); 
            $select->execute($donnees);  
            $unUser = $select->fetch();  
            return $unUser;
        }

        public function insert_user($tab) {
            $requete = "insert into user values (null, :email, :mdp, :nom, :prenom, :role);";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(
                ":email"   => $tab["email"],
                ":mdp"     => $tab["mdp"],
                ":nom"     => $tab["nom"],
                ":prenom"  => $tab["prenom"],
                ":role"    => $tab["role"]
            );
            $exec->execute($donnees);
        }

                            /* gestion des candidats */
        
        public function insert_candidat($tab) {
            $requete = "insert into candidat values (null, :nomC, :prenomC, :date_naissanceC, :adresseC, :telephoneC, :date_inscription, 'En Formation');";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(
                ":nomC"              => $tab["nomC"],
                ":prenomC"           => $tab["prenomC"],
                ":date_naissanceC"   => $tab["date_naissanceC"],
                ":adresseC"          => $tab["adresseC"],
                ":telephoneC"        => $tab["telephoneC"],
                ":date_inscription"  => $tab["date_inscription"]
            );
            $exec->execute($donnees);
        }

        public function selectAll_candidats(){
            $requete = "select * from candidat order by nomC, prenomC;";
            $exec = $this->unPdo->prepare($requete);
            $exec->execute();
            return $exec->fetchAll();
        }

        public function selectLike_candidats($filtre){
            $requete = "select * from candidat 
                        where nomC like :filtre 
                        or prenomC like :filtre 
                        or telephoneC like :filtre;";
            $donnees = array(":filtre" => "%".$filtre."%");
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetchAll();
        }

        public function delete_candidat($id_candidat){
            $requete = "delete from candidat 
                        where id_candidat = :id_candidat;";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(":id_candidat" => $id_candidat);
            $exec->execute($donnees);
        }

        public function update_candidat($tab){
            $requete = "update candidat set 
                        nomC = :nomC, 
                        prenomC = :prenomC, 
                        date_naissanceC = :date_naissanceC, 
                        adresseC = :adresseC, 
                        telephoneC = :telephoneC, 
                        date_inscription = :date_inscription 
                        where id_candidat = :id_candidat;";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(
                ":nomC"              => $tab["nomC"],
                ":prenomC"           => $tab["prenomC"],
                ":date_naissanceC"   => $tab["date_naissanceC"],
                ":adresseC"          => $tab["adresseC"],
                ":telephoneC"        => $tab["telephoneC"],
                ":date_inscription"  => $tab["date_inscription"],
                ":id_candidat"       => $tab["id_candidat"]
            );
            $exec->execute($donnees);
        }

        public function selectWhere_candidat($id_candidat){
            $requete = "select * from candidat 
                        where id_candidat = :id_candidat;";
            $donnees = array(":id_candidat" => $id_candidat);
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetch();
        }

        public function count_lecons_candidat($id_candidat){
            $requete = "select count(*) as nb 
                        from lecon 
                        where id_candidat = :id_candidat;";
            $donnees = array(":id_candidat" => $id_candidat);
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            $result = $exec->fetch();
            return $result['nb'];
        }

                            /* gestion automatique du statut candidat */
        
        public function update_statut_candidat($id_candidat) {
            $requete = "select count(*) as nb 
                        from examen 
                        where id_candidat = :id_candidat 
                        and (type_examen = 'Conduite Permis B' or type_examen = 'Conduite Permis A')
                        and resultat = 'Reussi'";
            
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':id_candidat' => $id_candidat));
            $result = $exec->fetch();
            
            if ($result['nb'] > 0) {
                $update = "update candidat set statut = 'Diplôme' where id_candidat = :id_candidat";
            } else {
                $requeteAttente = "select count(*) as nb 
                                from examen 
                                where id_candidat = :id_candidat 
                                and resultat = 'En attente'";
                
                $execAttente = $this->unPdo->prepare($requeteAttente);
                $execAttente->execute(array(':id_candidat' => $id_candidat));
                $resultAttente = $execAttente->fetch();
                
                if ($resultAttente['nb'] > 0) {
                    $update = "update candidat set statut = 'Examen en cours' where id_candidat = :id_candidat";
                } else {
                    $update = "update candidat set statut = 'En formation' where id_candidat = :id_candidat";
                }
            }
            
            $execUpdate = $this->unPdo->prepare($update);
            $execUpdate->execute(array(':id_candidat' => $id_candidat));
        }

                            /* gestion des moniteurs */
        
        public function insert_moniteur($tab) {
            $requete = "insert into moniteur values (null, :nomM, :prenomM, :emailM, :telephoneM, :date_embauche);";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(
                ":nomM"          => $tab["nomM"],
                ":prenomM"       => $tab["prenomM"],
                ":emailM"        => $tab["emailM"],
                ":telephoneM"    => $tab["telephoneM"],
                ":date_embauche" => $tab["date_embauche"]
            );
            $exec->execute($donnees);
        }

        public function selectAll_moniteurs(){
            $requete = "select * from moniteur 
                        order by nomM, prenomM;";
            $exec = $this->unPdo->prepare($requete);
            $exec->execute();
            return $exec->fetchAll();
        }

        public function selectLike_moniteurs($filtre){
            $requete = "select * from moniteur 
                        where nomM like :filtre 
                        or prenomM like :filtre 
                        or emailM like :filtre;";
            $donnees = array(":filtre" => "%".$filtre."%");
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetchAll();
        }

        public function delete_moniteur($id_moniteur){
            $requete = "delete from moniteur 
                        where id_moniteur = :id_moniteur;";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(":id_moniteur" => $id_moniteur);
            $exec->execute($donnees);
        }

        public function update_moniteur($tab){
            $requete = "update moniteur set 
                        nomM = :nomM, 
                        prenomM = :prenomM, 
                        emailM = :emailM, 
                        telephoneM = :telephoneM, 
                        date_embauche = :date_embauche 
                        where id_moniteur = :id_moniteur;";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(
                ":nomM"          => $tab["nomM"],
                ":prenomM"       => $tab["prenomM"],
                ":emailM"        => $tab["emailM"],
                ":telephoneM"    => $tab["telephoneM"],
                ":date_embauche" => $tab["date_embauche"],
                ":id_moniteur"   => $tab["id_moniteur"]
            );
            $exec->execute($donnees);
        }

        public function selectWhere_moniteur($id_moniteur){
            $requete = "select * from moniteur 
                        where id_moniteur = :id_moniteur;";
            $donnees = array(":id_moniteur" => $id_moniteur);
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetch();
        }

                            /* gestion des vehicules */
        
        public function insert_vehicule($tab) {
            $requete = "insert into vehicule values (null, :immat, :date_Achat, :nb_km, :energie, :marque, :modele, :type_vehicule);";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(
                ":immat"         => $tab["immat"],
                ":date_Achat"    => $tab["date_Achat"],
                ":nb_km"         => $tab["nb_km"],
                ":energie"       => $tab["energie"],
                ":marque"        => $tab["marque"],
                ":modele"        => $tab["modele"],
                ":type_vehicule" => $tab["type_vehicule"]
            );
            $exec->execute($donnees);
        }

        public function selectAll_vehicules(){
            $requete = "select * from vehicule 
                        order by marque, immat;";
            $exec = $this->unPdo->prepare($requete);
            $exec->execute();
            return $exec->fetchAll();
        }

        public function selectLike_vehicules($filtre){
            $requete = "select * from vehicule 
                        where immat like :filtre 
                        or marque like :filtre 
                        or type_vehicule like :filtre;";
            $donnees = array(":filtre" => "%".$filtre."%");
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetchAll();
        }

        public function delete_vehicule($id_vehicule){
            $requete = "delete from vehicule 
                        where id_vehicule = :id_vehicule;";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(":id_vehicule" => $id_vehicule);
            $exec->execute($donnees);
        }

        public function update_vehicule($tab){
            $requete = "update vehicule set 
                        immat = :immat, 
                        date_Achat = :date_Achat, 
                        nb_km = :nb_km, 
                        energie = :energie, 
                        marque = :marque, 
                        modele = :modele, 
                        type_vehicule = :type_vehicule 
                        where id_vehicule = :id_vehicule;";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(
                ":immat"         => $tab["immat"],
                ":date_Achat"    => $tab["date_Achat"],
                ":nb_km"         => $tab["nb_km"],
                ":energie"       => $tab["energie"],
                ":marque"        => $tab["marque"],
                ":modele"        => $tab["modele"],
                ":type_vehicule" => $tab["type_vehicule"],
                ":id_vehicule"   => $tab["id_vehicule"]
            );
            $exec->execute($donnees);
        }

        public function selectWhere_vehicule($id_vehicule){
            $requete = "select * from vehicule 
                        where id_vehicule = :id_vehicule;";
            $donnees = array(":id_vehicule" => $id_vehicule);
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetch();
        }

                            /* gestion des lecons */
        
        public function insert_lecon($tab) {
            $requete = "insert into lecon VALUES (null, :id_candidat, :id_moniteur, :id_vehicule, :date_lecon, :libelle, :duree_lecon, :compterendu);";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(
                ":id_candidat"  => $tab["id_candidat"],
                ":id_moniteur"  => $tab["id_moniteur"],
                ":id_vehicule"  => $tab["id_vehicule"],
                ":date_lecon"   => $tab["date_lecon"],
                ":libelle"      => $tab["libelle"],
                ":duree_lecon"  => $tab["duree_lecon"],
                ":compterendu"  => $tab["compterendu"]
            );
            $exec->execute($donnees);
        }

        public function selectAll_lecons(){
            $requete = "select l.*, c.nomC, c.prenomC, m.nomM, m.prenomM, v.immat, v.marque, v.modele 
                        from lecon l
                        left join candidat c on l.id_candidat = c.id_candidat
                        left join moniteur m on l.id_moniteur = m.id_moniteur
                        left join vehicule v on l.id_vehicule = v.id_vehicule
                        ORDER BY l.date_lecon DESC;";
            $exec = $this->unPdo->prepare($requete);
            $exec->execute();
            return $exec->fetchAll();
        }

        public function selectLike_lecons($filtre){
            $requete = "select l.*, c.nomC, c.prenomC, m.nomM, m.prenomM, v.immat, v.marque, v.modele 
                        from lecon l
                        left join candidat c on l.id_candidat = c.id_candidat
                        left join moniteur m on l.id_moniteur = m.id_moniteur
                        left join vehicule v on l.id_vehicule = v.id_vehicule
                        where c.nomC like :filtre 
                        or c.prenomC like :filtre 
                        or m.nomM like :filtre 
                        or m.prenomM like :filtre
                        order by l.date_lecon DESC;";
            $donnees = array(":filtre" => "%".$filtre."%");
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetchAll();
        }

        public function delete_lecon($id_lecon){
            $requete = "delete from lecon where id_lecon = :id_lecon;";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(":id_lecon" => $id_lecon);
            $exec->execute($donnees);
        }

        public function update_lecon($tab){
            $requete = "update lecon set 
                        id_candidat = :id_candidat, 
                        id_moniteur = :id_moniteur, 
                        id_vehicule = :id_vehicule, 
                        date_lecon = :date_lecon, 
                        libelle = :libelle,
                        duree_lecon = :duree_lecon, 
                        compterendu = :compterendu 
                        where id_lecon = :id_lecon;";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(
                ":id_candidat"  => $tab["id_candidat"],
                ":id_moniteur"  => $tab["id_moniteur"],
                ":id_vehicule"  => $tab["id_vehicule"],
                ":date_lecon"   => $tab["date_lecon"],
                ":libelle"      => $tab["libelle"],
                ":duree_lecon"  => $tab["duree_lecon"],
                ":compterendu"  => $tab["compterendu"],
                ":id_lecon"     => $tab["id_lecon"]
            );
            $exec->execute($donnees);
        }

        public function selectWhere_lecon($id_lecon){
            $requete = "select l.*, c.nomC, c.prenomC, m.nomM, m.prenomM, v.immat, v.marque, v.modele 
                        from lecon l
                        left join candidat c on l.id_candidat = c.id_candidat
                        left join moniteur m on l.id_moniteur = m.id_moniteur
                        left join vehicule v on l.id_vehicule = v.id_vehicule
                        where l.id_lecon = :id_lecon;";
            $donnees = array(":id_lecon" => $id_lecon);
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetch();
        }

        public function selectLecons_byCandidat($id_candidat){
            $requete = "select l.*, c.nomC, c.prenomC, m.nomM, m.prenomM, v.immat, v.marque, v.modele 
                        from lecon l
                        left join candidat c on l.id_candidat = c.id_candidat
                        left join moniteur m on l.id_moniteur = m.id_moniteur
                        left join vehicule v on l.id_vehicule = v.id_vehicule
                        where l.id_candidat = :id_candidat
                        order by l.date_lecon DESC;";
            $donnees = array(":id_candidat" => $id_candidat);
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetchAll();
        }

                            /* gestion des examens */
        
        public function insert_examen($tab) {
            $requete = "insert into examen values (null, :id_candidat, :id_moniteur, :id_vehicule, :type_examen, :lieu_examen, :date_examen, :resultat, :remarques);";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(
                ":id_candidat"  => $tab["id_candidat"],
                ":id_moniteur"  => $tab["id_moniteur"],
                ":id_vehicule"  => $tab["id_vehicule"],
                ":type_examen"  => $tab["type_examen"],
                ":lieu_examen"  => $tab["lieu_examen"],
                ":date_examen"  => $tab["date_examen"],
                ":resultat"     => $tab["resultat"],
                ":remarques"    => $tab["remarques"]
            );
            $exec->execute($donnees);
        }

        public function selectAll_examens(){
            $requete = "select e.*, c.nomC, c.prenomC, m.nomM, m.prenomM, v.immat, v.marque, v.modele 
                        from examen e
                        left join candidat c on e.id_candidat = c.id_candidat
                        left join moniteur m on e.id_moniteur = m.id_moniteur
                        left join vehicule v on e.id_vehicule = v.id_vehicule
                        order by e.date_examen desc;";
            $exec = $this->unPdo->query($requete);
            $exec->execute();
            return $exec->fetchAll();
        }

        public function selectLike_examens($filtre){
            $requete = "select e.*, c.nomC, c.prenomC, m.nomM, m.prenomM, v.immat, v.marque, v.modele 
                        from examen e
                        left join candidat c on e.id_candidat = c.id_candidat
                        left join moniteur m on e.id_moniteur = m.id_moniteur
                        left join vehicule v on e.id_vehicule = v.id_vehicule
                        where c.nomC like :filtre 
                        or c.prenomC like :filtre 
                        or e.type_examen like :filtre
                        order by e.date_examen desc;";
            $donnees = array(":filtre" => "%".$filtre."%");
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetchAll();
        }

        public function delete_examen($id_examen){
            $requete = "delete from examen 
                        where id_examen = :id_examen;";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(":id_examen" => $id_examen);
            $exec->execute($donnees);
        }

        public function update_examen($tab){
            $requete = "update examen set 
                        id_candidat = :id_candidat, 
                        id_moniteur = :id_moniteur, 
                        id_vehicule = :id_vehicule, 
                        type_examen = :type_examen,
                        lieu_examen = :lieu_examen, 
                        date_examen = :date_examen,
                        resultat = :resultat, 
                        remarques = :remarques
                        where id_examen = :id_examen;";
            $exec = $this->unPdo->prepare($requete);
            $donnees = array(
                ":id_candidat"         => $tab["id_candidat"],
                ":id_moniteur"         => $tab["id_moniteur"],
                ":id_vehicule"         => $tab["id_vehicule"],
                ":type_examen"         => $tab["type_examen"],
                ":date_examen"         => $tab["date_examen"],
                ":lieu_examen"         => $tab["lieu_examen"],
                ":resultat"            => $tab["resultat"],
                ":remarques"           => $tab["remarques"],
                ":id_examen"           => $tab["id_examen"]
            );
            $exec->execute($donnees);
        }

        public function selectWhere_examen($id_examen){
            $requete = "select e.*, c.nomC, c.prenomC, m.nomM, m.prenomM, v.immat, v.marque, v.modele 
                        from examen e
                        left join candidat c on e.id_candidat = c.id_candidat
                        left join moniteur m on e.id_moniteur = m.id_moniteur
                        left join vehicule v on e.id_vehicule = v.id_vehicule
                        where e.id_examen = :id_examen;";
            $donnees = array(":id_examen" => $id_examen);
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetch();
        }

        public function selectExamens_byCandidat($id_candidat){
            $requete = "select e.*, c.nomC, c.prenomC, m.nomM, m.prenomM, v.immat, v.marque, v.modele 
                        from examen e
                        left join candidat c on e.id_candidat = c.id_candidat
                        left join moniteur m on e.id_moniteur = m.id_moniteur
                        left join vehicule v on e.id_vehicule = v.id_vehicule
                        where e.id_candidat = :id_candidat
                        order by e.date_examen desc;";
            $donnees = array(":id_candidat" => $id_candidat);
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            return $exec->fetchAll();
        }

        public function count_examens_candidat($id_candidat){
            $requete = "select count(*) as nb from examen 
                        where id_candidat = :id_candidat;";
            $donnees = array(":id_candidat" => $id_candidat);
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
            $result = $exec->fetch();
            return $result['nb'];
        }

                            /* gestion du calendrier des événements */
        
        public function selectAll_evenements(){
            $requeteLecons = "select 
                                'lecon' as type_evenement,
                                l.id_lecon as id_evenement,
                                l.date_lecon as date_evenement,
                                l.duree_lecon,
                                l.libelle,
                                concat(c.nomC, ' ', c.prenomC) as candidat_nom,
                                concat(m.nomM, ' ', m.prenomM) as moniteur_nom,
                                v.immat as vehicule_info,
                                null as resultat
                            from lecon l
                            left join candidat c on l.id_candidat = c.id_candidat
                            left join moniteur m on l.id_moniteur = m.id_moniteur
                            left join vehicule v on l.id_vehicule = v.id_vehicule
                            where l.date_lecon >= curdate()";
            
            $requeteExamens = "select 
                                'examen' as type_evenement,
                                e.id_examen as id_evenement,
                                e.date_examen as date_evenement,
                                null as duree_lecon,
                                e.type_examen as libelle,
                                concat(c.nomC, ' ', c.prenomC) as candidat_nom,
                                concat(m.nomM, ' ', m.prenomM) as moniteur_nom,
                                e.lieu_examen as vehicule_info,
                                e.resultat
                            from examen e
                            left join candidat c on e.id_candidat = c.id_candidat
                            left join moniteur m on e.id_moniteur = m.id_moniteur
                            where e.date_examen >= curdate()";
            
            $requete = "($requeteLecons) union ($requeteExamens) order by date_evenement asc";
            
            $exec = $this->unPdo->prepare($requete);
            $exec->execute();
            return $exec->fetchAll();
        }
        
        public function selectEvenements_byMonth($annee, $mois){
            $mois = str_pad($mois, 2, '0', STR_PAD_LEFT);
            $annee = str_pad($annee, 4, '0', STR_PAD_LEFT);
            
            $requeteLecons = "select 
                                'lecon' as type_evenement,
                                l.id_lecon as id_evenement,
                                l.date_lecon as date_evenement,
                                l.duree_lecon,
                                l.libelle,
                                concat(c.nomC, ' ', c.prenomC) as candidat_nom,
                                c.nomC as nom_candidat,
                                c.prenomC as prenom_candidat,
                                concat(m.nomM, ' ', m.prenomM) as moniteur_nom,
                                v.immat as vehicule_info,
                                null as resultat
                            from lecon l
                            left join candidat c on l.id_candidat = c.id_candidat
                            left join moniteur m on l.id_moniteur = m.id_moniteur
                            left join vehicule v on l.id_vehicule = v.id_vehicule
                            where month(l.date_lecon) = :mois 
                            and year(l.date_lecon) = :annee";
            
            $requeteExamens = "select 
                                'examen' as type_evenement,
                                e.id_examen as id_evenement,
                                e.date_examen as date_evenement,
                                null as duree_lecon,
                                e.type_examen as libelle,
                                concat(c.nomC, ' ', c.prenomC) as candidat_nom,
                                c.nomC as nom_candidat,
                                c.prenomC as prenom_candidat,
                                concat(m.nomM, ' ', m.prenomM) as moniteur_nom,
                                e.lieu_examen as vehicule_info,
                                e.resultat
                            from examen e
                            left join candidat c on e.id_candidat = c.id_candidat
                            left join moniteur m on e.id_moniteur = m.id_moniteur
                            where month(e.date_examen) = :mois 
                            and year(e.date_examen) = :annee";
            
            $requete = "($requeteLecons) union ($requeteExamens) order by date_evenement asc";
            
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':mois' => intval($mois), ':annee' => intval($annee)));
            return $exec->fetchAll();
        }
        
        public function selectEvenements_prochains($nbJours = 7){
            $dateDebut = date('d-m-Y');
            $dateFin = date('d-m-Y', strtotime("+$nbJours days"));
            
            $requeteLecons = "select 
                                'lecon' as type_evenement,
                                l.id_lecon as id_evenement,
                                l.date_lecon as date_evenement,
                                l.duree_lecon,
                                l.libelle,
                                concat(c.nomC, ' ', c.prenomC) as candidat_nom,
                                concat(m.nomM, ' ', m.prenomM) as moniteur_nom,
                                v.immat as vehicule_info,
                                null as resultat
                            from lecon l
                            left join candidat c on l.id_candidat = c.id_candidat
                            left join moniteur m on l.id_moniteur = m.id_moniteur
                            left join vehicule v on l.id_vehicule = v.id_vehicule
                            where date(l.date_lecon) between :dateDebut and :dateFin";
            
            $requeteExamens = "select 
                                'examen' as type_evenement,
                                e.id_examen as id_evenement,
                                e.date_examen as date_evenement,
                                null as duree_lecon,
                                e.type_examen as libelle,
                                concat(c.nomC, ' ', c.prenomC) as candidat_nom,
                                concat(m.nomM, ' ', m.prenomM) as moniteur_nom,
                                e.lieu_examen as vehicule_info,
                                e.resultat
                            from examen e
                            left join candidat c on e.id_candidat = c.id_candidat
                            left join moniteur m on e.id_moniteur = m.id_moniteur
                            where date(e.date_examen) between :dateDebut and :dateFin";
            
            $requete = "($requeteLecons) union ($requeteExamens) order by date_evenement asc";
            
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':dateDebut' => $dateDebut, ':dateFin' => $dateFin));
            return $exec->fetchAll();
        }

                            /* gestion du calendrier par moniteur */
        
        public function selectEvenements_byMoniteurAndMonth($id_moniteur, $annee, $mois){
            $mois = str_pad($mois, 2, '0', STR_PAD_LEFT);
            $annee = str_pad($annee, 4, '0', STR_PAD_LEFT);
            
            $requeteLecons = "select 
                                'lecon' as type_evenement,
                                l.id_lecon as id_evenement,
                                l.date_lecon as date_evenement,
                                l.duree_lecon,
                                l.libelle,
                                concat(c.nomC, ' ', c.prenomC) as candidat_nom,
                                c.nomC as nom_candidat,
                                c.prenomC as prenom_candidat,
                                concat(m.nomM, ' ', m.prenomM) as moniteur_nom,
                                v.immat as vehicule_info,
                                null as resultat
                            from lecon l
                            left join candidat c on l.id_candidat = c.id_candidat
                            left join moniteur m on l.id_moniteur = m.id_moniteur
                            left join vehicule v on l.id_vehicule = v.id_vehicule
                            where l.id_moniteur = :id_moniteur
                            and month(l.date_lecon) = :mois 
                            and year(l.date_lecon) = :annee";
            
            $requeteExamens = "select 
                                'examen' as type_evenement,
                                e.id_examen as id_evenement,
                                e.date_examen as date_evenement,
                                null as duree_lecon,
                                e.type_examen as libelle,
                                concat(c.nomC, ' ', c.prenomC) as candidat_nom,
                                c.nomC as nom_candidat,
                                c.prenomC as prenom_candidat,
                                concat(m.nomM, ' ', m.prenomM) as moniteur_nom,
                                e.lieu_examen as vehicule_info,
                                e.resultat
                            from examen e
                            left join candidat c on e.id_candidat = c.id_candidat
                            left join moniteur m on e.id_moniteur = m.id_moniteur
                            where e.id_moniteur = :id_moniteur
                            and month(e.date_examen) = :mois 
                            and year(e.date_examen) = :annee";
            
            $requete = "($requeteLecons) union ($requeteExamens) order by date_evenement asc";
            
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':id_moniteur' => $id_moniteur, ':mois' => intval($mois), ':annee' => intval($annee)));
            return $exec->fetchAll();
        }
        
        public function selectEvenements_prochains_moniteur($id_moniteur, $nbJours = 7){
            $dateDebut = date('d-m-Y');
            $dateFin = date('d-m-Y', strtotime("+$nbJours days"));
            
            $requeteLecons = "select 
                                'lecon' as type_evenement,
                                l.id_lecon as id_evenement,
                                l.date_lecon as date_evenement,
                                l.duree_lecon,
                                l.libelle,
                                concat(c.nomC, ' ', c.prenomC) as candidat_nom,
                                concat(m.nomM, ' ', m.prenomM) as moniteur_nom,
                                v.immat as vehicule_info,
                                null as resultat
                            from lecon l
                            left join candidat c on l.id_candidat = c.id_candidat
                            left join moniteur m on l.id_moniteur = m.id_moniteur
                            left join vehicule v on l.id_vehicule = v.id_vehicule
                            where l.id_moniteur = :id_moniteur
                            and date(l.date_lecon) between :dateDebut and :dateFin";
            
            $requeteExamens = "select 
                                'examen' as type_evenement,
                                e.id_examen as id_evenement,
                                e.date_examen as date_evenement,
                                null as duree_lecon,
                                e.type_examen as libelle,
                                concat(c.nomC, ' ', c.prenomC) as candidat_nom,
                                concat(m.nomM, ' ', m.prenomM) as moniteur_nom,
                                e.lieu_examen as vehicule_info,
                                e.resultat
                            from examen e
                            left join candidat c on e.id_candidat = c.id_candidat
                            left join moniteur m on e.id_moniteur = m.id_moniteur
                            where e.id_moniteur = :id_moniteur
                            and date(e.date_examen) between :dateDebut and :dateFin";
            
            $requete = "($requeteLecons) union ($requeteExamens) order by date_evenement asc";
            
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':id_moniteur' => $id_moniteur, ':dateDebut' => $dateDebut, ':dateFin' => $dateFin));
            return $exec->fetchAll();
        }

                            /* fonction espace client */
    
        public function selectCandidatByEmail($email){
            $requete = "select u.*, c.* 
                        from user u
                        left join candidat c on u.email = concat(lower(c.prenomC), '.', lower(c.nomC), '@autoecole.fr')
                        where u.email = :email;";
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':email' => $email));
            $result = $exec->fetch();
            
            if (!$result || !isset($result['id_candidat'])) {
                $requete2 = "select c.* from candidat c where concat(lower(c.prenomC), '.', lower(c.nomC), '@autoecole.fr') = :email;";
                $exec2 = $this->unPdo->prepare($requete2);
                $exec2->execute(array(':email' => $email));
                $result = $exec2->fetch();
            }
            
            return $result;
        }

        public function selectCandidatByNomPrenom($nom, $prenom){
            $requete = "select * from candidat where nomC = :nom and prenomC = :prenom;";
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':nom' => $nom, ':prenom' => $prenom));
            return $exec->fetch();
        }
    

        public function selectProchaines_lecons_candidat($id_candidat, $nbJours = 30){
            $dateDebut = date('Y-m-d 00:00:00');
            $dateFin = date('Y-m-d 23:59:59', strtotime("+$nbJours days"));
            
            $requete = "select l.*, c.nomC, c.prenomC, m.nomM, m.prenomM, v.immat, v.marque, v.modele
                        from lecon l
                        left join candidat c on l.id_candidat = c.id_candidat
                        left join moniteur m on l.id_moniteur = m.id_moniteur
                        left join vehicule v on l.id_vehicule = v.id_vehicule
                        where l.id_candidat = :id_candidat
                        and l.date_lecon >= :dateDebut
                        and l.date_lecon <= :dateFin
                        order by l.date_lecon asc;";
            
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':id_candidat' => $id_candidat, ':dateDebut' => $dateDebut, ':dateFin' => $dateFin));
            return $exec->fetchAll();
        }
        
        public function selectProchains_examens_candidat($id_candidat){
            $requete = "select e.*, c.nomC, c.prenomC, m.nomM, m.prenomM
                        from examen e
                        left join candidat c on e.id_candidat = c.id_candidat
                        left join moniteur m on e.id_moniteur = m.id_moniteur
                        where e.id_candidat = :id_candidat
                        order by e.date_examen desc;";
            
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':id_candidat' => $id_candidat));
            return $exec->fetchAll();
        }
        
        public function selectHistorique_lecons_candidat($id_candidat){
            $dateAujourdhui = date('Y-m-d');
            
            $requete = "select l.*, c.nomC, c.prenomC, m.nomM, m.prenomM, v.immat, v.marque, v.modele
                        from lecon l
                        left join candidat c on l.id_candidat = c.id_candidat
                        left join moniteur m on l.id_moniteur = m.id_moniteur
                        left join vehicule v on l.id_vehicule = v.id_vehicule
                        where l.id_candidat = :id_candidat
                        and date(l.date_lecon) < :dateAujourdhui
                        order by l.date_lecon desc;";
            
            $exec = $this->unPdo->prepare($requete);
            $exec->execute(array(':id_candidat' => $id_candidat, ':dateAujourdhui' => $dateAujourdhui));
            return $exec->fetchAll();
        }

                            /* reservation client */
    
        public function verifierDisponibilite($date_lecon, $id_moniteur, $id_vehicule, $duree_lecon){
            $dateDebut = date('d-m-Y H:i:s', strtotime($date_lecon));
            $dateFin = date('d-m-Y H:i:s', strtotime($date_lecon . ' +' . $duree_lecon . ' minutes'));
            
            if (!empty($id_moniteur)) {
                $requete1 = "select count(*) as nb from lecon 
                            where id_moniteur = :id_moniteur
                            and ((date_lecon between :dateDebut and :dateFin)
                            or (date_add(date_lecon, interval duree_lecon minute) between :dateDebut and :dateFin));";
                $exec1 = $this->unPdo->prepare($requete1);
                $exec1->execute(array(':id_moniteur' => $id_moniteur, ':dateDebut' => $dateDebut, ':dateFin' => $dateFin));
                $result1 = $exec1->fetch();
                
                if ($result1['nb'] > 0) {
                    return false; 
                }
            }
            
            if (!empty($id_vehicule)) {
                $requete2 = "select count(*) as nb from lecon 
                            where id_vehicule = :id_vehicule
                            and ((date_lecon between :dateDebut and :dateFin)
                            or (date_add(date_lecon, interval duree_lecon minute) between :dateDebut and :dateFin));";
                $exec2 = $this->unPdo->prepare($requete2);
                $exec2->execute(array(':id_vehicule' => $id_vehicule, ':dateDebut' => $dateDebut, ':dateFin' => $dateFin));
                $result2 = $exec2->fetch();
                
                if ($result2['nb'] > 0) {
                }
            }
            return true;
        }

                            /* gestion des demandes */
        
        public function selectDemandes_lecons_attente(){
            $requete = "select l.*, c.nomC, c.prenomC, c.telephoneC 
                        from lecon l
                        inner join candidat c on l.id_candidat = c.id_candidat
                        where l.id_moniteur is null
                        and l.date_lecon >= CURDATE()
                        order by l.date_lecon asc;";
            $exec = $this->unPdo->query($requete);
            return $exec->fetchAll();
        }
        
        public function selectDemandes_examens_attente(){
            $requete = "select e.*, c.nomC, c.prenomC, c.telephoneC 
                        from examen e
                        inner join candidat c on e.id_candidat = c.id_candidat
                        where e.remarques like '%Réservation en ligne%'
                        and e.date_examen >= CURDATE()
                        order by e.date_examen asc;";
            $exec = $this->unPdo->query($requete);
            return $exec->fetchAll();
        }
        
        public function attribuerMoniteurVehicule_lecon($id_lecon, $id_moniteur, $id_vehicule){
            $requete = "update lecon 
                        set id_moniteur = :id_moniteur, 
                            id_vehicule = :id_vehicule,
                            compterendu = 'Confirmé par l\'auto-école'
                        where id_lecon = :id_lecon;";
            $donnees = array(
                ':id_lecon' => $id_lecon,
                ':id_moniteur' => $id_moniteur,
                ':id_vehicule' => $id_vehicule
            );
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
        }
        
        public function attribuerMoniteurVehicule_examen($id_examen, $id_moniteur, $id_vehicule){
            $requete = "update examen 
                        set id_moniteur = :id_moniteur, 
                            id_vehicule = :id_vehicule,
                            remarques = 'Confirmé par l\'auto-école'
                        where id_examen = :id_examen;";
            $donnees = array(
                ':id_examen' => $id_examen,
                ':id_moniteur' => $id_moniteur,
                ':id_vehicule' => $id_vehicule
            );
            $exec = $this->unPdo->prepare($requete);
            $exec->execute($donnees);
        }
    }
?>
