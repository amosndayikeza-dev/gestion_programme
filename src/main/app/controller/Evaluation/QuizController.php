<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."/../../service/Evaluation/QuizService.php";
require_once __DIR__."/../../model/Evaluation/Quiz.php";

class QuizController{
    private QuizService $quiz_service;

    public function __construct()
    {
       $this->quiz_service = new QuizService();
    }

    public function TraiterFormulaireQuiz(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //recuperer les donnes depuis un formulaire
            $id_lecon = $_POST['id_lecon'];
            $titre = $_POST['titre'];
            $scoreMin = $_POST['scoreMin'];

            //creer l'objet quiz
            $quiz = new Quiz();
            // C'est cet ID qui dira au Service de faire un UPDATE et non un CREATE
            if(!empty($_POST['id_quiz'])){
                $quiz->setIdQuiz($_POST['id_quiz']);
            }
            $quiz->setIdLecon($id_lecon);
            $quiz->setTitre($titre);
            $quiz->setScoreMin($scoreMin);

            //appeler un service    
            $success = $this->quiz_service->ajouterQuiz($quiz);
            if($success){
                header("location: /quiz");
                exit;
            }else{
                header("location: /quiz");
                exit;
            }

        }else{
            header("location: /quiz");
            exit;
        }
    }
    //afficher quiz
    public function afficherQuiz($id_quiz){
        $quiz = $this->quiz_service->afficherQuiz($id_quiz);
        require __DIR__ ."/../../views/quiz/liste.php";
    }
    //afficher supprimer quiz
    public function supprimerQuiz($id_quiz){
        $this->quiz_service->supprimerQuiz($id_quiz);   
        header("location: /quiz");
        exit;
    }




















}









?>