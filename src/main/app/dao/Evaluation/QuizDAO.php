<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'../../../config/Database.php'; 
require_once __DIR__."../../../model/Evaluation/Quiz.php";

class QuizDAO{
    private static $db;

    //Etablir la connexion
    public function __construct()
    {
        $pdo = new Database();
        self::$db = $pdo->getConnexion();
    }
    //AJouter UN quiZ 
    public static function CreateResultat(Quiz $quiz){
        $sql = "INSERT INTO quiz(id_lecon,titre,scoreMin) VALUES(:id_lecon,:titre,:scoreMin)";
        $stmt = self::$db->prpare($sql);
        return $stmt->execute(
            [
            ":id_quiz" =>$quiz->getIdQuiz(),
            ":id_lecon" =>$quiz->getIdLecon(),
            ":titre"=>$quiz->getTitre(),
            ":scoreMin"=>$quiz->getScoreMin(),
            ]
            );
    }
    //Afficher un quiz
    public static function getOneQuiz($id_quiz){
        $sql = "SELECT * FROM quiz WHERE id_quiz = :id_quiz";
        $stmt = self::$db->prepare($sql);
        $stmt->excute(['id_quiz'=>$id_quiz]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return NULL;
        }else{
            return new Quiz(
                $row['id_quiz'],
                $row['id_lecon'],
                $row['titre'],
                $row['scoreMin']
            );
        }
    }
    //Afficher Tout les quiz 
    public static function getAllQuiz(){
        $sql = "SELECT * FROM quiz";
        $stmt = self::$db->query($sql);
        $ListeQuiz = [];
        while($row = $stmt->fetchall(PDO::FETCH_ASSOC)){
            return  $ListeQuiz [] =  new Quiz(
                $row['id_quiz'],
                $row['id_lecon'],
                $row['titre'],
                $row['scoreMin']
            );
        }
    }
    //Afficher Modifier un Quiz 
    public static function Update(Quiz $quiz){
        $sql = "UPDATE quiz SET id_quiz = :id_quiz, id_lecon = :id_lecon,titre = :titre,scoreMin = :scoreMin";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([
            ":id_quiz" => $quiz->getIdQuiz(),
            ":id_lecon" => $quiz->getIdLecon(),
            ":titre" =>$quiz->getTitre(),
            ":scoreMin"=>$quiz->getScoreMin()
        ]);
    }
    //SUPPRIMER un quiz
    public static function DeleteQuiz($id_quiz){
        $sql = "DELETE FROM quiz WHERE id_quiz = :id_quiz";
        $stmt = self::$db->prepare($sql);
        $stmt->bindValue("id_quiz",$id_quiz);
        return $stmt->execute();
    }
}








?>