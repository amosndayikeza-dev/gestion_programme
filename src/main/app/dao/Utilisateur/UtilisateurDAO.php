<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "../../../config/Database.php";
require_once __DIR__ ."../../../model/Utilisateur/utilisateur.php";

class UtilisateurDAO{
    
    private static $bd;

    //etablir connexion a la bd
    public function __construct()
    {
        $pdo = new Database();
        self::$bd = $pdo->getConnexion();
    }
    //Ajouter un utilisateur
    public static function CreateUtilisateur(Utilisateur $utilisateur){
        try{
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
        }catch(PDOException $e){
            echo "Erreur : insertion a echoue" .$e->getMessage();
        }
    }
    //modifier utilisateur
    public static function UpdateUtilisateur(Utilisateur $utilisateur){
        try{
            $sql = "UPDATE utilisateur SET nom =:nom,prenom =:prenom,email =:email,mot_de_passe =:mot_de_passe,role =:role WHERE id_utilisateur = :id_utilisateur";
        $stmt = self::$bd->prepare($sql);
        return $stmt->execute([
            ":nom" =>$utilisateur->getNom(),
            ":prenom" =>$utilisateur->getPrenom(),
            ":email" =>$utilisateur->getEmail(),
            ":mot_de_passe" =>$utilisateur->getMotDePasse(),
            ":role" =>$utilisateur->getRole()
        ]);
        }catch(PDOException $e){
            echo "Erreur : modification a echoue" .$e->getMessage();
        }
    }
    //Afficher UN UTILISATEUR
    public function getOneUtilisateur($id_utilisateur){
        try{
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
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    public function getOneUtilisateurByEmail($email){
        try{
            $sql = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = self::$bd->prepare($sql);
        $stmt->execute([$email => 'email']);
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
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    //afficher tout les utilisateur
    public static function getALLUtilisateur(){
        try{
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
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    
    }
    //Supprimer utilisateur
     public static function DeleteUtilisateur($id_utilisateur){
        try{
            $sql = "DELETE FROM utilisateur WHERE id_utilisateur =:id_utilisateur";
            $stmt = self::$bd->prepare($sql);
            $stmt->bindValue(':id_utilisateur',$id_utilisateur);
            return $stmt->execute();
        }catch(PDOException $e){
            echo "Erreur : suppression a echoue" .$e->getMessage();
        }
    }
    //verifier l'email
    public function EmailExists($email){
        try{
            $sql = "SELECT COUNT(*) FROM utilisateur WHERE email = :email";
            $stmt = self::$bd->prepare($sql);
            $stmt->bindValue(":email",$email);
            $stmt->excute();
            return $stmt->fetchColumn() > 0;
        }catch(PDOException $e){
            echo "Erreur : verification a echoue" .$e->getMessage();
        }
    }   
    
    //fonction pour chercher un utilisateur
    public function searchUtilisateur($keyword){
        try{
            $sql = "SELECT * FROM utilisateur WHERE nom_utilisateur like :keyword or prenom_utilisateur like :keyword";
            $stmt = self::$bd->prepare($sql);
            $stmt->bindValue(":keyword","%" .$keyword. "%");
            $stmt->excute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Erreur : recherche a echoue" .$e->getMessage();
        }
    }

}






?>