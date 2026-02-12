<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\Organisation\Etablissement;
use PDO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__."../../../model/Organisation/Etablissement.php";

// DAO pour l'entité Etablissement
class EtablissementDAO {
    private static $db;
   // Etablir la connexion
   public function __construct()
   {
    $pdo =new Database();
    self::$db =  $pdo->getConnexion();
   }
    //Ajouter Etablissement
    public static function AjouterEtablissement(Etablissement $etablissement){
        try{
            $sql = "INSERT INTO etablissement (nom,type,location) VALUES(:nom,:type,:location)";
        $stmt = self::$db->prepare($sql);
         return $stmt->execute(
            [
                ":nom" =>$etablissement->getNom(),
                ":type" =>$etablissement->getType(),
                ":location" =>$etablissement->getLocalisation()
            ]
            );
        }catch(PDOException $e){
            echo "Erreur : insertion a echoue" .$e->getMessage();
        }
    }
    //Afficher un etablissement
    public static function getOneEtalissement($id_etablissement){
        try{
            $sql = "SELECT * FROM etablissement WHERE id_etablissement  = :id_etablissement";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(["id_etablissement" => $id_etablissement]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                return NULL;
            } else{
                return new Etablissement(
                    $row['id_etablissement'],
                    $row['nom'],
                    $row['type'],
                    $row['location']
                );
            }
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    // Afficher tout les etablissment
    public function AfficherToutEtalissement(){
        try{
            $sql = "SELECT * FROM etablissement";
            $stmt = self::$db->query($sql);
            $ListeEtablissement = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $ListeEtablissement [] = NEW Etablissement(
                    $row['id_etablissement'],
                    $row['nom'],
                    $row['type'],
                    $row['location']
                );
            }
            return $ListeEtablissement;

        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    
    }
    //Modifier Etablissement
    public static function UpdateEtablissement(Etablissement $etablissement){
        try{
            $sql = "UPDATE etablissement SET nom = :nom,type = :type, location = :location WHERE id_etablissement = :id_etablissement";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(
            [ ":id_etablissement" =>$etablissement->getIdEtablissement(),
                ":nom " =>$etablissement->getNom(),
                ":type"=>$etablissement->getType(),
                ":location"=>$etablissement->getLocalisation()
                ]
            );
        }catch(PDOException $e){
            echo "Erreur : modification a echoue" .$e->getMessage();
        }
    }
    //Supprimer Etablissement
    public function DeleteEtablissement($id_etablissement){
       try{
         $sql = "DELETE FROM etablissement WHERE id_etablissement = :id_etablissement";
        $stmt =self::$db->prepare($sql);
        $stmt->bindValue(":id_etablissement",$id_etablissement);
        return $stmt->execute();
       }catch(PDOException $e){
        echo "Erreur : suppression a echoue" .$e->getMessage();
       }
    }

}











?>