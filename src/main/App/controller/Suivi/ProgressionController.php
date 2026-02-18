<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../service/suivi/ProgressionService.php";

class ProgressionController{
    private ProgressionService $progression_service;

    public function __construct()
    {
       $progression_service = new ProgressionService();
    }

    public function consulter(){
        $progression = $this->progression_service->CalculerProgressionProgramme(
            $_SESSION['utilisateur']->getId(),
            $_GET['id_programme']
        );

        require __DIR__ ."/../../views/progression/consultation.php";
    }
}










?>