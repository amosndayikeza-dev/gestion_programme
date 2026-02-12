<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\Evaluation\Resultat;
use PDO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//require_once __DIR__."../../../config/Database.php";
//require_once __DIR__ ."../../../model/Evaluation/Resultat.php";
class ResultatDAO{
    private static  $db;

    //etablir la connexion
    public function __construct()
    {
        $pdo = new Database();
        self::$db = $pdo->getConnexion();
    }
    //AjouterResultat
    public static function  CreateResultat(Resultat $resultat){
        try{
            $sql = "INSERT INTO resultat(id_utilisateur,id_exercice,score,date_resultat) VAlUES(:id_utilisateur,:id_exercice,score,date_resulatat)";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(
                [
                    ":id_utilisateur" =>$resultat->getIdUtilisateur(),
                    ":id_exercice" =>$resultat->getIdExercice(),
                    ":score" =>$resultat->getScore(),
                    ":date_resultat" =>$resultat->getDateResultat()
                ]
                );
        }catch(PDOException $e){
            echo "Erreur : insertion a echoue" .$e->getMessage();
        }
    }
    //Modifier Resultat
    public static function UpdateResultat(Resultat $resultat){
       try{
            $sql = "UPDATE resultat SET id_utilisateur = :id_utilisateur,id_exercice = :id_exercice,score =:score,date_resulatat = :date_resulatat WHERE id_resultat = :id_resultat";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute([
                ":id_utilisateur" =>$resultat->getIdUtilisateur(),
                ":id_exercice" =>$resultat->getIdExercice(),
                ":score" =>$resultat->getScore(),
                ":date_resultat" =>$resultat->getDateResultat()
            ]);
       }catch(PDOException $e){
        echo "Erreur : modification a echoue" .$e->getMessage();
       }
    }
    //Afficher un Resultat
    public function getOneResultat($id_resultat){
        try{
            $sql = "SELECT * FROM resultat WHERE id_resultat = :id_resultat";
            $stmt = self::$db->prepare($id_resultat);
            $stmt->execute(["id_resultat" =>$id_resultat]);
            $row = $stmt->fetchALL(PDO::FETCH_ASSOC);
            if(!$row){
                return NULL;
            }
            else{
                return new Resultat(
                    $row['id_resultat'],
                    $row['id_utilisateur'],
                    $row['id_exercice'],
                    $row['score'],
                    $row['date_resultat']
                );
            }
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    //Afficher tout les utilisateur
    public static function AfficherToutResultat(){
        try{
            $sql = "SELECT *  FROM resultat WHERE id_resultat = :id_resultat";
            $stmt = self::$db->query($sql);
            $ListResulatat = [];
            while($row = $stmt->fetchall(PDO::FETCH_CLASS)){
                $ListResulatat [] = new Resultat(
                    $row['id_resulatat'],
                    $row['id_utilisateur'],
                    $row['id_exercice'],
                    $row['score'],
                    $row['date_resultat'],
                );
            }
            return $ListResulatat;
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    
    }
    //Supprimer un resulatat
    public function DeleteResultat($id_resultat){
        try{
            $sql = "DELETE FROM resultat WHERE id_resultat = :id_resultat";
            $stmt = self::$db->prepare($sql);
            $stmt->bindValue("id_resulatat",$id_resultat);
            return $stmt->execute();
        }catch(PDOException $e){
            echo "Erreur : suppression a echoue" .$e->getMessage();
        }
    }
}











?>