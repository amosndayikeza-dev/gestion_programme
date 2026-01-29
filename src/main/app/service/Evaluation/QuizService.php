<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Evaluation/QuizDAO.php";
require_once __DIR__ ."../../../dao/Evaluation/resultatDAO.php";
class QuizService {
    private QuizDAO $quiz_dao;
    private ResultatDAO $resultat_dao;

    public function __construct()
    {
        $this->quiz_dao = new QuizDAO();
        $this->resultat_dao = new ResultatDAO();
    }

    /**
     * Ajouter un quiz
     */
    public function ajouterQuiz(Quiz $quiz){
        return $this->quiz_dao->CreateQuiz($quiz);
    }
    /**
     * Modifier un quiz
     */
    public function modifierQuiz(Quiz $quiz){
        return $this->quiz_dao->UpdateQuiz($quiz);
    }
    /**
     * Afficher un quiz
     */
    public function afficherQuiz($id_quiz){
        return $this->quiz_dao->getOneQuiz($id_quiz);
    }
    /**
     * Supprimer un quiz
     */
    public function supprimerQuiz($id_quiz){
        return $this->quiz_dao->DeleteQuiz($id_quiz);
    
    }
    /**
     * Soumettre u  quiz
     */
    public function soumettreQuiz($id_quiz,$id_utilisateur,$reponse_utilisateur){
        /*//calculer score
        $score = $this->claculerScore($id_quiz,$reponse_utilisateur);
        $this->resultat_dao->CreateQuizResultat($id_utilisateur,$id_quiz,$score);
    
    return $score;*/
    }

    /**
     * calculer score
     */
    public function calculerScore($id_quiz,$reponse_utilisateur){
        //recuperer les question du quiz
        /*$questions = $this->quiz_dao->getQuestion($id_quiz);
        $score = 0;

            foreach($questions as $question){
                $id_question = $question['id_question'];
                if(isset ($reponse_utilisateur[$id_question]) && $reponse_utilisateur[$id_question] === $question['boonne_reposnse']){ 
                $score++;
            }
        }

        return $score;*/
    }
}











?>