<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../service/Academique/MatiereService.php";
require_once __DIR__ . "/../../model/Academique/Matiere.php";

class MatiereController{
    private MatiereService $matiere_service;

    public function __construct()
    {
       $this->matiere_service = new MatiereService();
    }

    //liste des matieres
    public function liste(){
        $matiere = $this->matiere_service->afficherToutesLesMatieres();
        require __DIR__ ."/../../views/matiere/liste.php";
    }
    //ajouter matiere
    public function ajouterMatiere(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //recuperer les donnees
        $nom_matiere = $_POST['nom_matiere'];
        $coefficient = $_POST['coefficient'];
        $description = $_POST['description'];

        //creer l'objet
        $matiere = new Matiere();
        if(!empty($_POST['id_matiere'])){
          $matiere->setIdMatiere($_POST['id_matiere']);
        }
        $matiere->setNomMatiere($nom_matiere);
        $matiere->setCoefficient($coefficient);
        $matiere->setDescription($description);
        //appeler un service
        $success = $this->matiere_service->ajouterMatiere($matiere);
        if($success){
            header("location: /matiere/liste");
        }else{
            header("location: /matiere/liste");
            exit;
        }
       }else{
        require __DIR__ ."/../../views/matiere/ajouter.php";
       }

    }
    /**
     * afficher touts les resultats
     */
    public function afficherMatieres(){
          $matieres = $this->matiere_service->afficherToutesLesMatieres();  
          require_once __DIR__ ."/../../views/matiere/liste.php";
        }
    /**
     * afficher une matiere
     */
     public function afficherMatiere($id_matiere){
        $matiere = $this->matiere_service->afficherUneMatiere($id_matiere);
        require_once __DIR__ ."/../../views/matiere/detail.php";
    }
    /**
     * supprimer une matiere
     */
    public function supprimerMatiere($id_matiere){
        $this->matiere_service->supprimerMatiere($id_matiere);
        header("location: /matiere/liste");
        exit;
    }

    






















}
   
   















?>