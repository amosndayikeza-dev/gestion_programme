<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\academique\Matiere;
use PDO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../model/Academique/Matiere.php';

class MatiereDAO{
    private static $db;

    //constructeur qui initialise la connexion à la base de données
    public function __construct()
    {
        $pdo = new Database();
        self::$db = $pdo->getConnexion();
    }
    //Ajouter une matiere
    public static function CreateMatiere(Matiere $matiere){
        try{
            $sql = "INSERT INTO matiere(id_matiere,nom_matiere,coefficient,description) VALUES (:id_matiere,:nom_matiere,:coefficient,:description)";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(
                [
                    ":nom_matiere" =>$matiere->getNomMatiere(),
                    ":coefficient" =>$matiere->getCoefficient(),
                    ":description" =>$matiere->getDescription(),
                ]
            )  ;
        }catch(PDOException $e){
            echo "Erreur : insertion a echoue" .$e->getMessage();
        }
    }
    //Modifier une matiere
    public static function UpdateMatiere(matiere $matiere){
       try{
            $sql = "UPDATE matiere SET id_matiere=:id_matiere,nom_matiere=:nom_matiere,coefficient=:coefficient,description=:description WHERE id_matiere=:id_matiere";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(
                [
                    ":id_matiere" =>$matiere->getIdMatiere(),
                     ":nom_matiere" =>$matiere->getNomMatiere(),
                    ":coefficient" =>$matiere->getCoefficient(),
                    ":description" =>$matiere->getDescription(),

                ]
            );
       }catch(PDOException $e){
        echo "Erreur : modification a echoue" .$e->getMessage();
       }
    }
    //Afficher une matiere
    public static function GetoneMatiere($id_matiere){
        try{
            $sql = "SELECT * FROM matiere WHERE id_matiere = :id_matiere";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([":id_matiere" => $id_matiere]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Matiere(
                    $row['id_matiere'],
                    $row['nom_matiere'],
                    $row['coefficient'],
                    $row['description']
                );
            }else{
                return NULL;
            }
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    //Afficher toutes les matieres
    public static function AfficherToutesLesMatiere(){
        try{
            $sql = "SELECT * FROM matiere";
            $stmt = self::$db->prepare($sql);
            $stmt->execute();
            $listeMatiere = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $listeMatiere [] = new Matiere(
                    $row['id_matiere'],
                    $row['nom_matiere'],
                    $row['coefficient'],
                    $row['description']
                );
            }
            return $listeMatiere;
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    //Supprimer une matiere
    public static function DeleteMatiere($id_matiere){
        try{
            $sql = "DELETE FROM matiere WHERE id_matiere = :id_matiere";
            $stmt = self::$db->prepare($sql);
            $stmt->bindValue("id_matiere",$id_matiere);
            return $stmt->execute(["id_matiere"=>$id_matiere]);
        }catch(PDOException $e){
            echo "Erreur : suppression a echoue" .$e->getMessage();
        }
    }
}






?>