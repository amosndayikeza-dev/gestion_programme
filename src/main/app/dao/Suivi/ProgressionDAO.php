<?php
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
    }
    //Afficher une progression
    public static function getOneProgresion($id_progression){
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
    }
    //Afficher toutes les progressions
    public static function AfficherToutProgression(){
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
    }
    //Modifier une Progression
    public static function UpdateProgression(Progression $progression){
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
    }
    // Supprimer une Progression
    public static function DeleteProgression($id_progression){
        $sql = "DELETE FROM progression WHERE id_progression = :id_progression ";
        $stmt = self::$db->prepare($sql);
        $stmt->bindValue(":id_progression",$id_progression);
        return $stmt->execute();
    }
}











?>