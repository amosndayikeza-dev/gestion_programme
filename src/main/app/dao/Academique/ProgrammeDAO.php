<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "../../../config/Database.php";
require_once __DIR__ ."../../../model/Academique/Programme.php";

class ProgrammeDAO{
    private static $bd;

    //etablir connexion a la bd
   public function __construct()
   {
   $pdo = new Database();
   self::$bd = $pdo->getConnexion();
   }
    //Ajouter un programme
    public static function Create(Programme $programme){
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
    }
    //M0difier programme
    public static function UpdateProgramme(Programme $programme){
        $sql = "UPDATE programme SET nom_programme =:nom_programme,niveau =:niveau,description =:description,statut =:statut WHERE id_programme = :id_programme";
        $stmt = self::$bd->prepare($sql);
        return $stmt->execute([
            ":nom_programme" =>$programme->getNomProgramme(),
                        ":niveau" =>$programme->getNiveau(),
                        ":description" =>$programme->getDescription(),
                        ":statut" =>$programme->getStatut()
        ]);
    }

    //Afficher UN PROGRAMME
    public function getOneProgramme($id_programme){
        $sql = "SELECT * FROM programme WHERE id_programme = :id_programme";
        $stmt = self::$bd->prepare($sql);
        $stmt->execute([$id_programme => 'id_programme']);
        $row = $stmt->fetchALL(PDO::FETCH_ASSOC);
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
    }
    //afficher tout les programme
    public static function getALLProgramme(){
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
            return $listeProgramme;
        }
    }
    // SUPPRIMER UN PROGRAMME
    public static function DeleteProgramme($id_programme){
        $sql = "DELETE FROM programme WHERE id_programme =:id_programme";
        $stmt = self::$bd->prepare($sql);
        $stmt->bindValue(':id_programme',$id_programme);
        return $stmt->execute();
    }


}

//ProgrammeDAO::EtablirConnexion();













?>