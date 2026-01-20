<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../service/Evaluation/exerciceService.php";

class ExerciceController{
    private ExerciceService $exercice_service;

    public function __construct()
    {
       $exercice_service = new ProgrammeService();
    }

    //liste des matieres
    public function soumettre(){
      $resultat = $this->exercice_service->corrigerExercice(
        $_POST["id_exercice"],
        $_POST['id_utilisateur'],
        $_POST['bonneReponse']
      );
      require __DIR__.'/../../views/exercice/resultat.php';
      
    }
}
















?>