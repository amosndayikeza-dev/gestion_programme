<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../config/Database.php";
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
        $sql = "INSERT INTO etablissement (nom,type,location) VALUES(:nom,:type,:location)";
        $stmt = self::$db->prepare($sql);
         return $stmt->execute(
            [
                ":nom" =>$etablissement->getNom(),
                ":type" =>$etablissement->getType(),
                ":location" =>$etablissement->getLocalisation()
            ]
            );
    }
    //Afficher un etablissement
    public static function getOneEtalissement($id_etablissement){
        $sql = "SELECT * FROM etablissement WHERE id_etablissement  = :id_etablissement";
        $stmt = self::$db->prepare($sql);
        $stmt->exeute(["id_etablissement" => $id_etablissement]);
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
    }
    // Afficher tout les etablissment
    public function AfficherToutEtalissement(){
        $sql = "SELECT * FROM etablisssement";
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
    }
    //Modifier Etablissement
    public static function UpdateEtablissement(Etablissement $etablissement){
        $sql = "UPADATE etablissement SET nom = :nom,type = :type, location = :location WHERE id_etablissement = :id_etablissement";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute(
           [ ":id_etablissement" =>$etablissement->getIdEtablissement(),
            ":nom " =>$etablissement->getNom(),
            ":type"=>$etablissement->getType(),
            ":location"=>$etablissement->getLocalisation()
            ]
        );
    }
    //Supprimer Etablissement
    public function DeleteEtablissement($id_etablissement){
        $sql = "DELETE FROM etablissement WHERE id_etablissement = :id_etablissement";
        $stmt =self::$db->prepare($sql);
        $stmt->bindValue(":id_etablissement",$id_etablissement);
        return $stmt->execute();
    }

}











?>