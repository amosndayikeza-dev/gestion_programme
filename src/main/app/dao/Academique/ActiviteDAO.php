<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../config/Database.php";
require_once __DIR__ ."../../../model/Academique/Activite.php";

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
    $sql = "INSERT INTO activite(nom_activite,type,instructions) VALUES(:id_activite,:nom_activite,:type,:instructions)";
    $stmt = self::$db->prepare($sql);
    return $stmt->execute([
        ":nom_activite" =>$activite->getNomActivite(),
        ":type" =>$activite->getType(),
        ":instructions" =>$activite->getInstruction()
    ]);
   }
   //MODIFIER UNE ACTIVITE
   public static function UpdateActivite(Activite $activite){
    $sql = "UPDATE activite SET  nom_activite = :nom_activite,type =:type,instructions = :instructions WHERE id_activite = :id_activite";
    $stmt = self::$db->prepare($sql);
    return $stmt->execute([
        ":nom_activite" =>$activite->getNomActivite(),
        ":type" =>$activite->getType(),
        ":instructions" =>$activite->getInstruction()
    ]);
   }
   //Afficher une activite
   public static function GetoneActivite($id_activite){
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
   }
   /**
    * findByUtilisateur
    */
    public static function findByUtilisateur($utilisateur){
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
    }
   //Afficher toutes les activites
   public static function getAllActivite(){
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
   }
   //Supprimer une activite
   public static function DeleteActivite($id_activite){
    $sql = "DELETE FROM activite WHERE id_activite = :id_activite";
    $stmt =self::$db->prepare($sql);
    $stmt->binValue(":id_activite",$id_activite);
    return $stmt->execute([":id_activite"=>$id_activite]);
   }
}