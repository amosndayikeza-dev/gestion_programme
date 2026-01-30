<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."/../../service/Academique/coursService.php";
require_once __DIR__."/../../model/Academique/cours.php";

class CoursController{
    private CoursService $cours_service;

    public function __construct()
    {
       $this->cours_service = new CoursService();
    }

    /**
     * enregistrer un cours
     */
    public function TraiterFormulaireCours(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //recuperer les donnes depuis un formulaire
           $titre = $_POST['titre'];
           $description = $_POST['description'];
           $id_matiere = $_POST['id_matiere'];
           $id_programme = $_POST['id_programme'];
           $id_classe = $_POST['id_classe'];
           $statut = $_POST['statut'];
           $ordre_progression = $_POST['ordre_progression'];
           $niveau_difficulte = $_POST['niveau_difficulte'];
           $dureeEstimee = $_POST['dureeEstimee'];
           $type_cours = $_POST['type_cours'];
           $objectif_apprentissage = $_POST['objectif_apprentissage'];
           $prerequis = $_POST['prerequis'];
           $ressources_externes = $_POST['ressources_externes'];
           $nb_vues = $_POST['nb_vues'];    
           $taux_reussite = $_POST['taux_reussite'];
           $seuil_reussite = $_POST['seuil_reussite'];
           $createur_id = $_POST['createur_id'];
           $visible = $_POST['visible'];

            $cours = new Cours();
            if(!empty($_POST['id_cours'])){
                $cours->setIdCours($_POST['id_cours']);
            }
            $cours->setTitre($titre);
            $cours->setDescription($description);
            $cours->setIdMatiere($id_matiere);
            $cours->setIdProgramme($id_programme);
            $cours->setIdClasse($id_classe);
            $cours->setStatut($statut);
            $cours->setOrdreProgression($ordre_progression);
            $cours->setNiveauDifficulte($niveau_difficulte);    
            $cours->setDureeEstimee($dureeEstimee);
            $cours->setTypeCours($type_cours);
            $cours->setObjectifApprentissage($objectif_apprentissage);
            $cours->setPrerequis($prerequis);
            $cours->setRessourcesExternes($ressources_externes);
            $cours->setNbVues($nb_vues);
            $cours->setTauxReussite($taux_reussite);
            $cours->setSeuilReussite($seuil_reussite);
            $cours->setCreateurId($createur_id);
            $cours->setVisible($visible);

            //APPELER LE SERVICE    
            $success = $this->cours_service->ajouterCours($cours);
            if($success){
                header("location: /cours");
            }else{
                header("location: /cours");
                exit;
            }
        }else{
            require __DIR__ ."/../../views/cours/creer.php";
        }
    }
   
    
    /**
     * afficher une activite
     */
    public function afficherCours(){
        $cours = $this->cours_service->AfficherAllCours();
        require __DIR__ ."/../../views/cours/liste.php";
    }
    /**
     * supprimer une activite
     */
    public function supprimerCours($id_cours){
        $this->cours_service->supprimerCours($id_cours);
        header("location: /cours");
        exit;
    }































































    //liste des matieres
   /* public function liste(){
        $cours = $this->cours_service->ListeCours();
        require __DIR__ ."/../../views/cours/liste.php":
    }

    //detail
    public function detail(){
        $cours = $this->cours_service->getCours($_GET["id_cours"]);
        require __DIR__ ."/../../views/cours/detail.php";
    }*/
}
















?>