<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../service/Evaluation/QuizService.php";

class QuizController{
    private QuizService $quiz_service;

    public function __construct()
    {
       $quiz_service = new QuizService();
    }

    public function soumettre(){
        $score = $this->quiz_service->soumettreQuiz(
            $_POST['id_quiz'],
            $_POST['id_utilisateur'],
            $_POST['reponse_utilisateur']
        );

        require __DIR__."/../../views/quiz/resultat.php";
    }
}









?>