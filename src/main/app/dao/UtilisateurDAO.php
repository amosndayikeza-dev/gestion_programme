<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "../../config/Database.php";
require_once __DIR__ ."../../model/Utilisateur.php";

class UtilisateurDAO{
    private static $bd;

    //etablir connexion a la bd
    public static function EtablirConnexion(){
        $pdo = new Database();
        while(self::$bd = $pdo->getConnexion()){
            echo "connexion etablie";
            exit;
        }
    }
    //Ajouter un utilisateur
    public static function Create(Utilisateur $utilisateur){
        $requette = "INSERT INTO utilisateur(nom,prenom,email,mot_de_passe,role) 
                     VALUES(:nom,:prenom,:email,:mot_de_passe,:role)";
        $stmt = self::$bd->prepare($requette);
        return  $stmt->execute(
                    [
                        ":nom" =>$utilisateur->getNom(),
                        ":prenom" =>$utilisateur->getPrenom(),
                        ":email" =>$utilisateur->getEmail(),
                        ":mot_de_passe" =>$utilisateur->getMotDePasse(),
                        ":role" =>$utilisateur->getRole(),
                    ]
                );
    }
    //modifier utilisateur
    public static function UpdateUtilisateur(Utilisateur $utilisateur){
        $sql = "UPDATE utilisateur SET nom =:nom,prenom =:prenom,email =:email,mot_de_passe =:mot_de_passe,role =:role WHERE id_utilisateur = :id_utilisateur";
        $stmt = self::$bd->prepare($sql);
        return $stmt->execute([
            ":nom" =>$utilisateur->getNom(),
            ":prenom" =>$utilisateur->getPrenom(),
            ":email" =>$utilisateur->getEmail(),
            ":mot_de_passe" =>$utilisateur->getMotDePasse(),
            ":role" =>$utilisateur->getRole()
        ]);
    }
    //Afficher UN UTILISATEUR
    public function getOneUtilisateur($id_utilisateur){
        $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur";
        $stmt = self::$bd->prepare($sql);
        $stmt->execute([$id_utilisateur => 'id_utilisateur']);
        $row = $stmt->fetchALL(PDO::FETCH_ASSOC);
        if(!$row){
            return NULL;
        }else{
            return new Utilisateur(
                $row["id_utilisateur"],
                $row["nom"],
                $row["prenom"],
                $row["email"],
                $row["mot_de_passe"],
                $row["role"],
                $row["date_creation"]
            );
        }
    }
    //afficher tout les utilisateur
    public static function getALLUtilisateur(){
        $sql = "SELECT * FROM utilisateur";
        $stmt = self::$bd->query($sql);
        $utilisateurs = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $utilisateurs[] = new Utilisateur(
                $row["id_utilisateur"],
                $row["nom"],
                $row["prenom"],
                $row["email"],
                $row["mot_de_passe"],
                $row["role"],
                $row["date_creation"]
            );
        }
        return $utilisateurs;
    }
        
    
    //Supprimer utilisateur
    public static function DeleteUtilisateur($id_utilisateur){
        $sql = "DELETE FROM utilisateur WHERE id_utilisateur =:id_utilisateur";
        $stmt = self::$bd->prepare($sql);
        $stmt->bindValue(':id_utilisateur',$id_utilisateur);
        return $stmt->execute();
    }       
}






?>