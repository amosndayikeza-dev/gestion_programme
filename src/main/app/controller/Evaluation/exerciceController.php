<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."/../../service/Evaluation/ExerciceService.php";
require_once __DIR__."/../../model/Evaluation/Exercice.php";

class ExerciceController{
    private ExerciceService $exercice_service;

    public function __construct()
    {
       $this->exercice_service = new ExerciceService();
    }

    //triater les donnees du formulaire
    public function TraiterFormulaireExercice(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //recuperer les donnes depuis un formulaire
            $id_lecon = $_POST['id_lecon'];
            $question = $_POST['question'];
            $type = $_POST['type'];
            $niveau = $_POST['niveau'];
            $score = $_POST['score'];

            //creer un objet EXERCICE
            $exercice = new Exercice();
                        // C'est cet ID qui dira au Service de faire un UPDATE et non un CREATE
            if(!empty($_POST['id_exercice'])){
                $exercice->setIdExercice($_POST['id_exercice']);
            }
            //
            $exercice->setIdLecon($id_lecon);
            $exercice->setQuestion($question);
            $exercice->setType($type);
            $exercice->setNiveau($niveau);
            $exercice->setScore($score);

            //appeler le service
            $success = $this->exercice_service->ajouterExercice($exercice);
            if($success){
                header("location: /exercice");
            }else{
                header("location: /exercice");
                exit;
            }
        }else{
            require __DIR__ ."/../../views/exercice/creer.php";
        }
    }
  //liste des exercices
  public function listeExercice(){
    $exercices = $this->exercice_service->afficherToutesLesExercices();
    require __DIR__ ."/../../views/exercice/liste.php";
  }
  //afficher un exercice
  public function afficherExercice($id_exercice){
    $exercice = $this->exercice_service->afficherUnExercice($id_exercice);
    require __DIR__ ."/../../views/exercice/detail.php";
  }
  //supprimer un exercice
  public function supprimerExercice($id_exercice){
    $this->exercice_service->supprimerExercice($id_exercice);
    header("location: /exercice");
  }

   
}
















?>