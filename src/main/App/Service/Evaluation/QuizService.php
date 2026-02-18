<?php
namespace App\Service\Evaluation;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Dao\Evaluation\QuizDAO;
use App\Dao\Evaluation\ResultatDAO;
use App\Models\Evaluation\Resultat;
use App\Models\Evaluation\Quiz;
use Exception;

require_once __DIR__ . "/../../dao/Evaluation/QuizDAO.php";
require_once __DIR__ . "/../../dao/Evaluation/resultatDAO.php";
class QuizService {
    private QuizDAO $quiz_dao;
    private ResultatDAO $resultat_dao;

    public function __construct()
    {
        $this->quiz_dao = new QuizDAO();
        $this->resultat_dao = new ResultatDAO();
    }

    //netoyer les donnees
    private function cleanData($data){
        return htmlspecialchars(trim($data));
    }
    /**
     * create and update
     */
    public function ajouterQuiz(Quiz $quiz){
        $quiz->setIdLecon($this->cleanData($quiz->getIdLecon()));
        $quiz->setTitre($this->cleanData($quiz->getTitre()));
        $quiz->setScoreMin($this->cleanData($quiz->getScoreMin()));

        //verifier les donnees
        if(empty($quiz->getIdLecon()) || empty($quiz->getTitre()) || empty($quiz->getScoreMin())){
            throw new Exception("Tous les champs sont obligatoires");
        }
        if($quiz->getIdQuiz()){
            return $this->quiz_dao->UpdateQuiz($quiz);
        }
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