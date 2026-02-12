<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\Utilisateur\Utilisateur;
use PDO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "../../../config/Database.php";
require_once __DIR__ . "../../../model/Utilisateur/niveau.php";

class NiveauDAO{
    private static $db;

    //etablir la connexion 
    public function __construct()
    {
        $pdo = new Database();
        self::$db = $pdo->getConnexion();
    }
    //Ajouter un niveau
    public static function CreateNiveau(Niveau $niveau){
        try{
            $sql = "INSERT INTO niveau(nom_niveau,xp_min,xp_max) VALUES(:nom_niveau,:xp_min,:xp_max)";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(
                [
                    ":nom_niveau" =>$niveau->getNomNiveau(),
                    ":xp_min" =>$niveau->getXpMin(),
                    ":xp_max" =>$niveau->getXpMax()
                ]
                );
        }catch(PDOException $e){
            echo "Erreur : insertion a echoue" .$e->getMessage();
        }
    }
    //Modofier Niveau
    public static function UpdateNiveau(Niveau $niveau){
        try{
            $sql = "UPDATE niveau SET nom_niveau = :nom_niveau,xp_min = :xp_min,xp_max =:xp_max WHERE id_niveau = :id_niveau";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(
                [
                    ":id_niveau" =>$niveau->getIdNiveau(),
                    ":nom_niveau" =>$niveau->getNomNiveau(),
                    ":xp_min" =>$niveau->getXpMin(),
                    ":xp_max" =>$niveau->getXpMax()
                ]
                );
        }catch(PDOException $e){
            echo "Erreur : modification a echoue" .$e->getMessage();
        }
    }
    //Afficher un niveau
    public static function getOneNiveau($id_niveau){
        try{
            $sql = "SELECT * FROM niveau WHERE id_niveau = :id_niveau";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([":id_niveau"=>$id_niveau]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                return new Niveau(
                    $row['id_niveau'],
                    $row['nom_niveau'],
                    $row['xp_min'],
                    $row['xp_max']
                );
            }else{
                return NULL;
            }
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    //Aficher tous les niveaux
    public static function AfficherToutLesNiveau(){
        try{
            $sql = "SELECT *FROM niveau";
            $stmt = self::$db->query($sql);
            $ListeNiveau = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $ListeNiveau [] = new Niveau(
                    $row['id_niveau'],
                    $row['nom_niveau'],
                    $row['xp_min'],
                    $row['xp_max']
                );
            }
            return $ListeNiveau;
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    //Supprimer un niveau
    public static function DeleteNiveau($id_niveau){
        try{
            $sql = "DELETE FROM niveau WHERE id_niveau = :id_niveau";
            $stmt = self::$db->prepare($sql);
            $stmt->bindValue(":id_niveau",$id_niveau);
            return $stmt->execute([":id_niveau"=>$id_niveau]);
        }catch(PDOException $e){
            echo "Erreur : suppression a echoue" .$e->getMessage();
        }
    }
}









?>