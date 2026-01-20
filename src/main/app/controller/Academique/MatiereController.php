<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../service/Academique/MatiereService.php";

class MatiereController{
    private MatiereService $matiere_service;

    public function __construct()
    {
       $matiere_service = new ProgrammeService();
    }

    //liste des matieres
    public function liste(){
        $matiere = $this->matiere_service->ListeMatiere();
        require __DIR__ ."/../../views/matiere/liste.php":
    }
}
















?>