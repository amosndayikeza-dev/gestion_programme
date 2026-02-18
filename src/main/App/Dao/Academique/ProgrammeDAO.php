<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\academique\Programme;
use PDO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//require_once __DIR__ . "/../../config/Database.php";
//require_once __DIR__ ."../../../model/Academique/Programme.php";

class ProgrammeDAO{
    private static $bd;

    //etablir connexion a la bd
   public function __construct()
   {
   $pdo = new Database();
   self::$bd = $pdo->getConnexion();
   }
    //Ajouter un programme
    public static function CreateProgramme(Programme $programme){
        try{
            $requette = "INSERT INTO programme(nom_programme,niveau,description,statut) 
                     VALUES(:nomProgramme,:niveau,:description,:statut)";
            $stmt = self::$bd->prepare($requette);
            return  $stmt->execute(
                        [
                            ":nom_programme" =>$programme->getNomProgramme(),
                            ":niveau" =>$programme->getNiveau(),
                            ":description" =>$programme->getDescription(),
                            ":statut" =>$programme->getStatut(),
                        ]
                    );
        }catch(PDOException $e){
            echo "Erreur : insertion a echoue" .$e->getMessage();
        }
    }
    //M0difier programme
    public static function UpdateProgramme(Programme $programme){
       try{
         $sql = "UPDATE programme SET nom_programme =:nom_programme,niveau =:niveau,description =:description,statut =:statut WHERE id_programme = :id_programme";
        $stmt = self::$bd->prepare($sql);
        return $stmt->execute([
            ":nom_programme" =>$programme->getNomProgramme(),
                        ":niveau" =>$programme->getNiveau(),
                        ":description" =>$programme->getDescription(),
                        ":statut" =>$programme->getStatut()
        ]);
       }catch(PDOException $e){
        echo "Erreur : modification a echoue" .$e->getMessage();
       }
    }

    //Afficher UN PROGRAMME
    public function getOneProgramme($id_programme){
        try{
            $sql = "SELECT * FROM programme WHERE id_programme = :id_programme";
            $stmt = self::$bd->prepare($sql);
            $stmt->execute([':id_programme' => $id_programme]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                return NULL;
            }else{
                return new Programme(
                    $row["id_programme"],
                    $row["nom_programme"],
                    $row["niveau"],
                    $row["description"],
                    $row["statut"],
                );
            }
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }

    //afficher tout les programme
    public static function getALLProgramme(){
        try{
            $sql = "SELECT * FROM programme";
            $stmt = self::$bd->query($sql);
            $listeProgramme = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
                $listeProgramme[] = new Programme(
                    $row["id_programme"],
                    $row["nom_programme"],
                    $row["niveau"],
                    $row["description"],
                    $row["statut"],
                );
            }
            return $listeProgramme;
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    
    }
    
    // SUPPRIMER UN PROGRAMME
    public static function DeleteProgramme($id_programme){
        try{
            $sql = "DELETE FROM programme WHERE id_programme =:id_programme";
            $stmt = self::$bd->prepare($sql);
            $stmt->bindValue(':id_programme',$id_programme);
            return $stmt->execute();
        }catch(PDOException $e){
            echo "Erreur : suppression a echoue" .$e->getMessage();
        }
    }


}













?>