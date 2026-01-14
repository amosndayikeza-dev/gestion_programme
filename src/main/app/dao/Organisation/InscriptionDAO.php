<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../config/Database.php";
require_once __DIR__ ."../../../model/Organisation/Inscription.php";
class InscriptionDAO{
    private static $db;

   //etablir la connexion
   public function __construct()
   {
    $pdo  =new Database();
    self::$db = $pdo->getConnexion();
   }
    //Ajouter une inscription
    public static function CreateInscription(Inscription $inscription){
        $sql = "INSERT INTO inscription(id_inscription,id_utilisateur,id_classe,annee_scolaire) VALUES(:id_inscription,:id_utilisateur,:id_classe,:annee_scolaire)";
        $stmt = self::$db->prepare($sql);
         return $stmt->execute(
            [
                ":id_inscription" =>$inscription->getIdInscription(),
                ":id_utilisateur" =>$inscription->getIdUtilisateur(),
                ":id_classe" =>$inscription->getIdClass(),
                ":annee_scolaire"=>$inscription->getAnneeScolaire()
            ]
            );
    }
    //Afficher un utilisateur
    public static function getOneInscription($id_inscription){
        $sql = "SELECT * FROM inscription WHERE id_inscription = :id_inscription";
        $stmt = self::$db->prepare($sql);
        $stmt->exeute(["id_inscription" => $id_inscription]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return NULL;
        }else{
            return new Inscription(
            $row['id_inscriptiom'],
            $row['id_utilisateur'],
            $row['id_classe'],
            $row['annee_scolaire']);
        }
    }
    //Afficher les inscriptions
    public static function AfficherToutInscription(){
        $sql = "SELECT * FROM inscription";
        $stmt = self::$db->query($sql);
        $listeInscription = [];
        while($row = $stmt->fetchall(PDO::FETCH_CLASS)){
            $listeInscription [] = new Inscription(
                $row['id_inscription'],
                $row['id_utilisateur'],
                $row['id_classe'],
                $row['annee_scolaire']
            );
        }
        return $listeInscription;
    }
    //Modifiier Inscription
    public function UpdateInscription(Inscription $inscription){
        $sql = "UPDATE inscription SET id_utilisateur =:id_utilisateur,id_classe = :id_classe WHERE id_inscription = :id_inscription";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([
            "id_inscription" =>$inscription->getIdInscription(),
            "id_utilisateur" =>$inscription->getIdUtilisateur(),
            "id_classe" =>$inscription->getIdClass(),
            "annee_scolaire" =>$inscription->getAnneeScolaire()
        ]);
    }
    //Supprimer une inscription
    public static function DeleteInscription($id_inscription){
        $sql = "DELETE FROM inscription WHERE id_inscription = :id_inscription";
        $stmt = self::$db->prepare($sql);
        $stmt->bindValue(":id_inscription",$id_inscription);
        return $stmt->execute();
    }
}












?>