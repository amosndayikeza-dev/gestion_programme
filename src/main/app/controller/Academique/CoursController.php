<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../service/Academique/MatiereService.php";

class CoursController{
    private coursService $cours_service;

    public function __construct()
    {
       $cours_service = new coursService();
    }

    //liste des matieres
    public function liste(){
        $cours = $this->cours_service->ListeCours();
        require __DIR__ ."/../../views/cours/liste.php":
    }

    //detail
    public function detail(){
        $cours = $this->cours_service->getCours($_GET["id_cours"]);
        require __DIR__ ."/../../views/cours/detail.php";
    }
}
















?>