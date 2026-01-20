<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../service/Academique/ProgrammeService.php";

class ProgrammeController{
    private ProgrammeService $programme_service;

    public function __construct()
    {
       $programme_service = new ProgrammeService();
    }
    //liste des programmes
    public function liste(){
        $programme = $this->programme_service->listerProgrammes();
        require __DIR__ ."/../../views/programme/liste.php";
    }

    public function publier(){
        $this->programme_service->publierProgramme($_POST['id_programme']);
        header("localtion: /programmes");
        exit;
    }
}









?>