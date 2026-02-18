<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\Suivi\Progression;
use PDO;
use PDOException;
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'../../../config/Database.php';
require_once __DIR__."../../../model/Suivi/Progression.php";
class ProgressionDAO{
    private static $db;
    //etablir la connexion
    public function __construct(){
        $pdo = new Database();
        self::$db = $pdo->getConnexion();
    }
    //Ajouter une progression
    public function CreateProgression(Progression $progression){
        try{
            $sql = "INSERT INTO progression(id_utilisateur,id_cours,pourcentage,derniere_mise_a_jour) VALUES(:id_utilisateur,:id_cours,:pourcentage,:derniere_mise_a_jour)";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(
                [
                    ":id_utilisateur" =>$progression->getIdUtilisateur(),
                    ":id_cours" =>$progression->getIdCours(),
                    ":pourcentage" =>$progression->getPourcentage(),
                    ":derniere_mise_a_jour" =>$progression->getDerniereMiseAJour()
                ]
                );
        }catch(PDOException $e){
            echo "Erreur : insertion a echoue" .$e->getMessage();
        }
    }
    //Afficher une progression
    public static function getOneProgresion($id_progression){
        try{
            $sql = "SELECT * FROM progression WHERE id_progression = :id_progression";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(["id_progression" => $id_progression]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                return NULL;
            } else{
                return new Progression(
                    $row['id_progression'],
                    $row['id_utilisateur'],
                    $row['id_cours'],
                    $row['pourcentage'],
                    $row['derniere_mise_a_jour']
                );
            }
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    //Afficher toutes les progressions
    public static function AfficherToutLesProgression(){
        try{
            $sql = "SELECT * FROM progression";
        $stmt = self::$db->query($sql);
        $ListeProgression = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $ListeProgression [] = new Progression(
                $row['id_progression'],
                $row['id_utilisateur'],
                $row['id_cours'],
                $row['pourcentage'],
                $row['derniere_mise_a_jour']
            );
        }
        return $ListeProgression;
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    
    }
    //Modifier une Progression
    public static function UpdateProgression(Progression $progression){
        try{
            $sql = "UPDATE progression SET id_utilisateur = :id_utilisateur,id_cours = :id_cours,pourcentage = :pourcentage,derniere_mise_a_jour = :derniere_mise_a_jour WHERE id_progression = :id_progression";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(
                [
                    ":id_utilisateur" =>$progression->getIdUtilisateur(),
                    ":id_cours" =>$progression->getIdCours(),
                    ":pourcentage" =>$progression->getPourcentage(),
                    ":derniere_mise_a_jour" =>$progression->getDerniereMiseAJour()
                ]
                );
        }catch(PDOException $e){
            echo "Erreur : modification a echoue" .$e->getMessage();
        }
    }
    // Supprimer une Progression
    public static function DeleteProgression($id_progression){
       try{
         $sql = "DELETE FROM progression WHERE id_progression = :id_progression ";
        $stmt = self::$db->prepare($sql);
        $stmt->bindValue(":id_progression",$id_progression);
        return $stmt->execute();
       }catch(PDOException $e){
        echo "Erreur : suppression a echoue" .$e->getMessage();
       }
    }
}











?>