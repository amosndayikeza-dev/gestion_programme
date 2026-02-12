<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\Organisation\Classe;
use PDO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//require_once __DIR__ . "../../../config/Database.php";
//require_once __DIR__ ."../../../model/Organisation/classe.php";
class ClasseDAO{
    private static $bd;

    //etablir connexion a la bd
    public function __construct()
    {
       $pdo = new Database();
       self::$bd = $pdo->getConnexion();
    }
    //Ajouter une classe
    public static function CreateClasse(Classe $classe){
        try{
            $requette = "INSERT INTO classe(nom_classe,niveau,idEtablissement,effectif_maximal,effectif_actuel,description,annee_scolaire,salle) VALUES(:nom_classe,:niveau,:idEtablissement,:effectif_maximal,:effectif_actuel,:description,:annee_scolaire,:salle)";
                    $stmt = self::$bd->prepare($requette);
                    return  $stmt->execute(
                                [
                                    ":nom_classe" =>$classe->getNomClasse(),
                                    ":annee_scolaire" =>$classe->getAnneeScolaire(),
                                    ":description" =>$classe->getDescription(),
                                    ":effectif_maximal" =>$classe->getEffectifMaximal(),
                                    ":effectif_actuel" =>$classe->getEffectifActuel(),
                                    ":salle" =>$classe->getSalle(),
                                    ":idEtablissement" =>$classe->getIdEtablissement(),
                                    ":niveau" =>$classe->getNiveau(),
                                ]
                            );
        }catch(PDOException $e){
            echo "Erreur : insertion a echoue" .$e->getMessage();
        }
    }
    //Afficher une classe
    public static function getOneClasse($idClasse){
        try{
            $sql = "SELECT * FROM classe WHERE idClasse = :idClasse";
        $stmt = self::$bd->prepare($sql);
        $stmt->execute([":idClasse" => $idClasse]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            return new Classe(
                $row['idClasse'],
                $row['nom_classe'],
                $row['niveau'],
                $row['idEtablissement'],
                $row['description'],
                $row['effectif_maximal'],
                $row['effectif_actuel'],
                $row['salle'],
                $row['annee_scolaire']
            );
        }
        return null;
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    //afficher beacoup de classe
    public static function getALLClasse(){
       try{
         $sql = "SELECT * FROM classe";
        $stmt = self::$bd->query($sql);
        $ListeClasse = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $ListeClasse [] = new Classe(
                $row['id_classe'],
                $row['nom_classe'],
                $row['niveau'],
                $row["id_etablissement"],
                $row['description'],
                $row['effectif_maximal'],
                $row['effectif_actuel'],
                $row['salle'],
                $row['annee_scolaire']
            );
        }
        return $ListeClasse;
       }catch(PDOException $e){
        echo "Erreur : lecture a echoue" .$e->getMessage();
       }
    
    }

    //Update classe
    public static function UpdateClasse(Classe $classe){
        TRY{
            $sql = "UPDATE classe SET 
                    nom_classe = :nom_classe,
                    niveau = :niveau,
                    idEtablissement = :idEtablissement,
                    description = :description,
                    effectif_maximal = :effectif_maximal,
                    effectif_actuel = :effectif_actuel,
                    salle = :salle,
                    annee_scolaire = :annee_scolaire
                WHERE idClasse = :idClasse";
        $stmt = self::$bd->prepare($sql);
        return $stmt->execute(
            [
                ":nom_classe" =>$classe->getNomClasse(),
                ":niveau" =>$classe->getNiveau(),
                ":idEtablissement" =>$classe->getIdEtablissement(),
                ":description" =>$classe->getDescription(),
                ":effectif_maximal" =>$classe->getEffectifMaximal(),
                ":effectif_actuel" =>$classe->getEffectifActuel(),
                ":salle" =>$classe->getSalle(),
                ":annee_scolaire" =>$classe->getAnneeScolaire(),
                ":idClasse" =>$classe->getIdClasse(),
            ]
        );
        }catch(PDOException $e){
            echo "Erreur : modification a echoue" .$e->getMessage();
        }
    }
    //Delete classe
    public static function DeleteOneClasse($idClasse){
        try{
            $sql = "DELETE FROM classe WHERE idClasse = :idClasse";
            $stmt = self::$bd->prepare($sql);
            return $stmt->execute([":idClasse" => $idClasse]);
        }catch(PDOException $e){
            echo "Erreur : suppression a echoue" .$e->getMessage();
        }
    }
}










?>