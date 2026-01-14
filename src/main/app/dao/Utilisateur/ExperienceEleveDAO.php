<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../config/Database.php";
require_once __DIR__ ."../../../model/Utilisateur/ExperienceEleve.php";

class ExperienceEleveDAO{
    private static $bd;
    //etablir connexion a la bd
    public function __construct()
    {
        $pdo = new Database();
        self::$bd = $pdo->getConnexion();
    }
    //Ajouter une experience eleve
    public static function CreateExperienceEleve(ExperienceEleve $experienceEleve){
        $requette = "INSERT INTO experience_eleve(id_utilisateur,xp_total,id_niveau) 
                     VALUES(:id_utilisateur,:xp_total,:id_niveau)";
        $stmt = self::$bd->prepare($requette);
        return  $stmt->execute(
                    [
                        ":id_utilisateur" =>$experienceEleve->getIdUtilisateur(),
                        ":xp_total" =>$experienceEleve->getXpTotal(),
                        ":id_niveau" =>$experienceEleve->getIdNiveau(),
                    ]
                );
    }
    //Modifier experience eleve
    public static function UpdateExperienceEleve(ExperienceEleve $experienceEleve){
        $requette = "UPDATE experience_eleve SET id_utilisateur=:id_utilisateur,xp_total=:xp_total,id_niveau=:id_niveau WHERE id_experience=:id_experience";
        $stmt = self::$bd->prepare($requette);
        return  $stmt->execute(
                    [
                        ":id_experience" =>$experienceEleve->getIdExperience(),
                        ":id_utilisateur" =>$experienceEleve->getIdUtilisateur(),
                        ":xp_total" =>$experienceEleve->getXpTotal(),
                        ":id_niveau" =>$experienceEleve->getIdNiveau(),
                    ]
                );
    }
    //Afficher une experience eleve
    public static function GetoneExperienceEleve($id_experience){
        $sql = "SELECT * FROM experience_eleve WHERE id_experience = :id_experience";
        $stmt = self::$bd->prepare($sql);
        $stmt->execute([":id_experience" => $id_experience]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new ExperienceEleve(
                $row['id_experience'],
                $row['id_utilisateur'],
                $row['xp_total'],
                $row['id_niveau']
            );
        }else{
            return NULL;
        }
    }
    //Afficher toutes les experiences eleve
    public static function GetAllExperienceEleve(){
        $sql = "SELECT * FROM experience_eleve";
        $stmt = self::$bd->prepare($sql);
        $stmt->execute();
        $listeExperienceEleve = [];
        while($row = $stmt->fetchAll(PDO::FETCH_CLASS)){
            $listeExperienceEleve [] = new ExperienceEleve(
                $row['id_experience'],
                $row['id_utilisateur'],
                $row['xp_total'],
                $row['id_niveau']
            );
        }
    }
    //Supprimer une experience eleve
    public static function DeleteExperienceEleve($id_experience){
        $sql = "DELETE FROM experience_eleve WHERE id_experience = :id_experience";
        $stmt = self::$bd->prepare($sql);
        $stmt->bindValue(":id_experience",$id_experience);
        return $stmt->execute([":id_experience" => $id_experience]);
    }
}
?>