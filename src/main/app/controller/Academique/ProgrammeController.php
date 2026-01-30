<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../service/Academique/ProgrammeService.php";
require_once __DIR__ . "/../../model/Academique/Programme.php";

class ProgrammeController{
    private ProgrammeService $programme_service;

    public function __construct()
    {
       $this->programme_service = new ProgrammeService();
    }
    /**
     * ajouter Programme
     */
    public function ajouterProgramme(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //recuperer
            $nom_programme = $_POST['nom_programme'];
            $description = $_POST['description'];
            $niveau = $_POST['niveau'];
            $statut = $_POST['statut'];

            //creer un objet programme
            $programme = new Programme();
            
            if(!empty($_POST['id_programme'])){
                $programme->setIdProgramme($_POST['id_programme']);
            }
            $programme->setNomProgramme($nom_programme);
            $programme->setDescription($description);
            $programme->setNiveau($niveau);
            $programme->setStatut($statut);

            //appeler un service
            $success = $this->programme_service->ajouterProgramme($programme);  
            if($success){
                header("location: /programmes");
            }else{
                header("location: /programmes");
                exit;
            }
        }else{
            require __DIR__ ."/../../views/programme/ajouter.php";

        }
    }
    //liste des programmes
    public function listeToutesProgramme(){
        $programme = $this->programme_service->afficherProgrammes();
        require __DIR__ ."/../../views/programme/liste.php";
    }
    //afficher un seul Programme
    public function afficher($id_programme){
        $programme = $this->programme_service->afficherProgramme($id_programme);
        require __DIR__ ."/../../views/programme/detail.php";
    }
    //supprimer un programme

    public function supprimer($id_programme){
        $this->programme_service->supprimerProgramme($id_programme);
        header("Location: /programmes");
        exit;
    }
}









?>