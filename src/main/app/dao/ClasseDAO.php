<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "../../config/Database.php";
require_once __DIR__ ."../../model/Classe.php";
class ClasseDAO{
    private static $bd;

    //etablir connexion a la bd
    public static function EtablirConnexion(){
        $pdo = new Database();
        while(self::$bd = $pdo->getConnexion()){
            echo "connexion etablie";
            exit;
        }
    }
    //Ajouter une classe
    public static function Create(Classe $classe){
        $requette = "INSERT INTO classe(nom_classe,niveau,,idEtablissement,effectif_maximal,effectif_actuel,description,annee_scolaire,) ;
                    VALUES(:nom_classe,:annee_scolaire,:id_programme)";
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
    }
    //Afficher une classe
    public static function Read($idClasse){
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
    }

    //Update classe
    public static function Update(Classe $classe){
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
    }
    //Delete classe
    public static function Delete($idClasse){
        $sql = "DELETE FROM classe WHERE idClasse = :idClasse";
        $stmt = self::$bd->prepare($sql);
        return $stmt->execute([":idClasse" => $idClasse]);
    }
}










?>