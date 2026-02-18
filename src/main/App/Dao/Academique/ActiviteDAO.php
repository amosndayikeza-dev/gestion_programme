<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\academique\Activite;
use PDO;
use PDOException;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ActiviteDAO{
    private static $db;

    //etablir la connexion 
    public function __construct()
    {
        $pdo = new Database();
        self::$db = $pdo->getConnexion();
    }
    //Ajouter une activite
   public static function CreateActivite(Activite $activite){
    try{
        $sql = "INSERT INTO activite(nom_activite,type,instructions) VALUES(:id_activite,:nom_activite,:type,:instructions)";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([
            ":nom_activite" =>$activite->getNomActivite(),
            ":type" =>$activite->getType(),
            ":instructions" =>$activite->getInstruction()
        ]);
    }catch(PDOException $e){
        echo "Erreur : insertion a echoue" .$e->getMessage();
    }
   }

   //MODIFIER UNE ACTIVITE
   public static function UpdateActivite(Activite $activite){
    try{
        $sql = "UPDATE activite SET  nom_activite = :nom_activite,type =:type,instructions = :instructions WHERE id_activite = :id_activite";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([
            ":nom_activite" =>$activite->getNomActivite(),
            ":type" =>$activite->getType(),
            ":instructions" =>$activite->getInstruction()
        ]);
    }catch(PDOException $e){
        echo "Erreur : modification a echoue" .$e->getMessage();
    }
   }

   //Afficher une activite
   public static function GetoneActivite($id_activite){
    try{
        $sql  = "SELECT * FROM activite WHERE id_activite = :id_activite";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([':id_activite'=>$id_activite]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return NULL;
        }else{
            return new Activite(
                $row['id_activite'],
                $row['nom_activite'],
                $row['type'],
                $row['instructions']
            );
        }
    }catch(PDOException $e){
        echo "Erreur : lecture a echoue" .$e->getMessage();
    }
   }

   /**
    * findByUtilisateur
    */
    public static function findByUtilisateur($utilisateur){
        try{
            $sql = "SELECT * FROM activite WHERE utilisateur = : utilisateur";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([":utilisateur" =>$utilisateur]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                return null;
            }else{
                return new Activite(
                    $row['id_activite'],
                    $row['nom_activite'],
                    $row['[type'],
                    $row['instruction']
                );
            }
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    
    }
   //Afficher toutes les activites
   public static function getAllActivites(){
    try{
        $sql = "SELECT * FROM activite";
        $stmt = self::$db->query($sql);
        $stmt->execute();
        $ListeActivite = [];
        while($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
            $ListeActivite [] = new Activite(
                $row['id_activite'],
                $row['nom_activite'],
                $row['type'],
                $row['instructions']
            );
        }
        return $ListeActivite;
    }catch(PDOException $e){
        echo "Erreur : lecture a echoue" .$e->getMessage();
    }
   }
   
   //Supprimer une activite
   public static function DeleteActivite($id_activite){
    try{
        $sql = "DELETE FROM activite WHERE id_activite = :id_activite";
        $stmt =self::$db->prepare($sql);
        $stmt->binValue(":id_activite",$id_activite);
        return $stmt->execute([":id_activite"=>$id_activite]);
    }catch(PDOException $e){
        echo "Erreur : suppression a echoue" .$e->getMessage();
    }
   }


   
}