<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\academique\Lecon;
use PDO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//require_once __DIR__ ."../../../config/Database.php";
//require_once __DIR__ ."../../../model/Academique/Lecon.php";

class LeconDAO{
    private static $db;

    //contructeur
    public function __construct()
    {
       $pdo = new Database();
       self::$db = $pdo->getConnexion();
    }

    //Ajouter une lecon
    public static function CreateLecon(Lecon $lecon){
       try{
         $sql = "INSERT INTO lecon(id_cours,titre,ordre,annee_estime,description,statut) VALUES(:id_cours,:titre,:ordre,:annee_estime,:description,:statut)";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(
                [
                    ":id_cours" =>$lecon->getIdCours(),
                    ":titre" =>$lecon->getTitre(),
                    ":ordre" =>$lecon->getOrdre(),
                    ":annee_estime" =>$lecon->getAnneeEstime(),
                    ":description" =>$lecon->getDescription(),
                    ":statut" =>$lecon->getStatut()
                ]
                );
       }catch(PDOException $e){
        echo "Erreur : insertion a echoue" .$e->getMessage();
       }
    }

    //modifier une lecon
    public static function UpdateLecon(Lecon $lecon){
        try{
            $sql = "UPDATE lecon SET id_cours = :id_cours,titre = :titre,ordre = :ordre,annee_estime = :annee_Estime,description = :description,statut =:statut WHERE id_lecon = id_lecon";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(
                [
                    ":id_cours" =>$lecon->getIdCours(),
                    ":titre" =>$lecon->getTitre(),
                    ":ordre" =>$lecon->getOrdre(),
                    ":annee_estime" =>$lecon->getAnneeEstime(),
                    ":description" =>$lecon->getDescription(),
                    ":statut" =>$lecon->getStatut()
                ]
                );
        }catch(PDOException $e){
            echo "Erreur : modification a echoue" .$e->getMessage();
        }
    }

    //Afficher une lecon
    public static function getOneLecon($id_lecon){
        try{
            $sql = "SELECT * FROM lecon WHERE id_lecon = :id_lecon";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(["id_lecon" => $id_lecon]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                return NULL;
            } else{
                return new Lecon(
                    $row['id_lecon'],
                    $row['id_cours'],
                    $row['titre'],
                    $row['ordre'],
                    $row['annee_estime'],
                    $row['description'],
                    $row['statut']
                );
            }
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }

    //Afficher toutes les lecons
    public static function getAllLecon(){
        try{
            $sql = "SELECT * FROM lecon";
            $stmt = self::$db->query($sql);
            $ListeLecon = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $ListeLecon [] = new Lecon(
                    $row['id_lecon'],
                    $row['id_cours'],
                    $row['titre'],
                    $row['ordre'],
                    $row['annee_estime'],
                    $row['description'],
                    $row['statut']
                );
            }
            return $ListeLecon; 
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    
    //Supprimer une lecon
    public static function DeleteLecon($id_lecon){
        try{
            $sql = "DELETE FROM lecon WHERE id_lecon = :id_lecon";
            $stmt = self::$db->prepare($sql);
            $stmt->bindValue(":id_lecon",$id_lecon);
            return $stmt->execute(["id_lecon" => $id_lecon]);
        }catch(PDOException $e){
            echo "Erreur : suppression a echoue" .$e->getMessage();
        }
    }









}










?>