<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../config/Database.php";
require_once __DIR__ ."../../../model/Evaluation/Exercice.php";

class ExerciceDAO{
    private static $db;

    //etablir la connexion 
    public function __construct()
    {
        $pdo = new Database();
        self::$db = $pdo->getConnexion();
    }
    //Ajouter un exercice
    public static function AjouterExercice(Exercice $exercice){
        $sql = "INSERT INTO exercice(id_lecon,question,type,niveau,score) VALUES(:id_lecon,:question,:type,:niveau,:score)";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute(
            [
                ":id_lecon" =>$exercice->getIdLecon(),
                ":question" =>$exercice->getQuestion(),
                ":type" =>$exercice->getType(),
                ":niveau" =>$exercice->getNiveau(),
                ":score" =>$exercice->getScore()
            ]
            );
    }
    //Modofier Exercice
    public static function UpdateExercice(Exercice $exercice){
        $sql = "UPDATE exercice SET id_lecon = :iid_lecon,question = :question,type:type,niveau =:niveau,:score";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute(
            [
                ":id_lecon" =>$exercice->getIdLecon(),
                ":question" =>$exercice->getQuestion(),
                ":type" =>$exercice->getType(),
                ":niveau" =>$exercice->getNiveau(),
                ":score" =>$exercice->getScore(),
            ]
            );
    }
    //Afficher un exercice
    public static function getOneExercice($id_exrcice){
        $sql = "SELECT FROM exercice WHERE id_exercice = :id_exercice";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([":id_exercice" =>$id_exrcice]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return NULL;
        }else{
            return new Exercice(
                $row['id_exercice'],
                $row['id_lecon'],
                $row['question'],
                $row['type'],
                $row['niveau'],
                $row['score']
            );
        }
    }

    //afficher beacoup d'exerice
    public static function getALLExercice(){
        $sql = "SELECT * FROM exercice";
        $stmt = self::$db->query($sql);
        $ListeExercice = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $ListeExercice [] = new Exercice(
                $row['id_exercice'],
                $row['id_lecon'],
                $row['question'],
                $row['type'],
                $row['niveau'],
                $row['score']
            );
        }
        return $ListeExercice;
    }
    
    //SUPPRIMER UN EXERCICE
    public static function deleteExercice($id_exercice){
        $sql = "DELETE FROM exercice WHERE id_exercice = :id_exercice";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([':id_exercice' =>$id_exercice]);
    }
}












?>