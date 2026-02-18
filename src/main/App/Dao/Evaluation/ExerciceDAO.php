<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\Evaluation\Exercice;
use PDO;
use PDOException;

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
        try{
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
        }catch(PDOException $e){
            echo "Erreur : insertion a echoue" .$e->getMessage();
        }
    }
    //Modofier Exercice
    public static function UpdateExercice(Exercice $exercice){
        try{
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
        }catch(PDOException $e){
            echo "Erreur : modification a echoue" .$e->getMessage();
        }
    }
    //Afficher un exercice
    public static function getOneExercice($id_exrcice){
        try{
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
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }

    //afficher beacoup d'exerice
    public static function getALLExercice(){
        try{
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
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    
    }
    
    //SUPPRIMER UN EXERCICE
    public static function deleteExercice($id_exercice){
        try{
            $sql = "DELETE FROM exercice WHERE id_exercice = :id_exercice";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute([':id_exercice' =>$id_exercice]);
        }catch(PDOException $e){
            echo "Erreur : suppression a echoue" .$e->getMessage();
        }
    }
}

//$exercice = new ExerciceDAO();
//$exercices = new Exercice(null,1,"C'EST QUOI PHP","programmation",1,20);
//echo $exercice::AjouterExercice($exercices);








?>