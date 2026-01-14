<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../model/Academique/Matiere.php';

class MatiereDAODAO{
    private static $db;

    //constructeur qui initialise la connexion à la base de données
    public function __construct()
    {
        $pdo = new Database();
        self::$db = $pdo->getConnexion();
    }
    //Ajouter une lecon
    public static function CreateMatiere(Lecon $lecon){
        $sql = "INSERT INTO lecon(id_matiere,nom_matiere,coefficient,description) VALUES (:id_matiere,:nom_matiere,:coefficient,:description)";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute(
            [
                ":id_matiere" =>$lecon->getIdCours(),
                ":nom_matiere" =>$lecon->getTitre(),
                ":coefficient" =>$lecon->getOrdre(),
                ":description" =>$lecon->getAnneeEstime(),
                ":description" =>$lecon->getDescription(),
            ]
        )  ;
    }
    //Modifier une lecon
    public static function UpdateMatiere(Lecon $lecon){
        $sql = "UPDATE lecon SET id_matiere=:id_matiere,nom_matiere=:nom_matiere,coefficient=:coefficient,description=:description WHERE id_matiere=:id_matiere";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute(
            [
                ":id_matiere" =>$lecon->getIdCours(),
                ":nom_matiere" =>$lecon->getTitre(),
                ":coefficient" =>$lecon->getOrdre(),
                ":description" =>$lecon->getAnneeEstime(),
            ]
        );
    }
    //Afficher une matiere
    public static function GetoneMatiere($id_matiere){
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
    }
    //Afficher toutes les matieres
    public static function AfficherToutMatiere(){
        $sql = "SELECT * FROM matiere";
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $listeMatiere = [];
        while($row = $stmt->fetchAll(PDO::FETCH_CLASS)){
            $listeMatiere [] = new Matiere(
                $row['id_matiere'],
                $row['nom_matiere'],
                $row['coefficient'],
                $row['description']
            );
        }
        return $listeMatiere;
    }
    //Supprimer une matiere
    public static function DeleteMatiere($id_matiere){
        $sql = "DELETE FROM matiere WHERE id_matiere = :id_matiere";
        $stmt = self::$db->prepare($sql);
        $stmt->bindValue("id_matiere",$id_matiere);
        return $stmt->execute(["id_matiere"=>$id_matiere]);
    }
}






?>