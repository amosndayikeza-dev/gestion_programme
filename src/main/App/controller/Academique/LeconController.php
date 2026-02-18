<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../service/Academique/LeconService.php";
require_once __DIR__ . "/../../model/Academique/Lecon.php";

class LeconController{
    private LeconService $lecon_service;

    public function __construct()
    {
      $this->lecon_service = new LeconService();
    }
    /**
     * AJOUTER UNE LECON
     */
    public function AddLecon(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //recuper les donnees
        $id_cours = $_POST['id_cours'];
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $ordre = $_POST['ordre'];
        $duree = $_POST['duree_estime'];
        $statut = $_POST['statut'];

        //creer un objet lecon
        $lecon = new Lecon();
        if(!empty($_POST['id_lecon'])){
          $lecon->setIdLecon($_POST['id_lecon']);
        }
        $lecon->setIdCours($id_cours);
        $lecon->setTitre($titre);
        $lecon->setDescription($description);
        $lecon->setOrdre($ordre);
        $lecon->setAnneeEstime($duree);
        $lecon->setStatut($statut);
        //appeler un service
       $success = $this->lecon_service->ajouterLecon($lecon);

        if($success){
            header("location: /cours/liste?success=1");
        } else {
            header("location: /cours/liste?error=1");
        }
        exit;
        }else{
          header("location: /cours/liste");
          exit;
        }

    }
    /**
     * afficher toutes LECON
     */
    public function afficherToutesLesLecons(){
       $this->lecon_service->afficherToutesLesLecons();
       require __DIR__ ."/../../views/lecon/liste.php";
    }
    /**
     * afficher une lecon
     */
    public function afficherLecon($id_lecon){
       $this->lecon_service->afficherLecon($id_lecon);
       require_once __DIR__ ."/../../views/lecon/detail.php";
    }
    /**
     * supprimer une lecon
     */
    public function supprimerLecon($id_lecon){
      $this->lecon_service->supprimerLecon($id_lecon);
      header("location: /cours/liste");
      exit;
    }
    
   
    

}












?>