<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../dao/Utilisateur/UtilisateurDAO.php";
require_once __DIR__ ."../../../model/Utilisateur/utilisateur.php";

class UtilisateurService{
    private UtilisateurDAO $utilisateurDao;

    public function __construct()
    {
        $this->utilisateurDao = new UtilisateurDAO();
    }
    //Ajouter utilisateur
    public function AjouterUtilisateur($nom,$prenom,$email,$mot_de_passe,$role,$date_de_creation){
    
        //verifier si le mot de passe et l'image sont saisis
        if(empty($email) OR empty($mot_de_passe)){
            throw new Exception("Le mot de passe ou l'email sont obligatoire");
        }

        if($this->utilisateurDao->EmailExists($email)){
            throw new Exception("L'email existe deja, veuillez utiliser un autre");
        }

        if(!in_array($role,['ELEVE','ENSEIGNANT','ADMIN'])){
            throw new Exception("Role invalide");
        }
        
        //Valider l'utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->setIdUtilisateur(null);
        $utilisateur->setNom($nom);
        $utilisateur->setPrenom($prenom);
        $utilisateur->setEmail($email);
        $utilisateur->setMotDePasse(password_hash($mot_de_passe,PASSWORD_DEFAULT));
        $utilisateur->setRole($role);
        $utilisateur->setDateCreation($date_de_creation);

        $this->utilisateurDao->CreateUtilisateur($utilisateur);

        return $utilisateur;
    }

    /**
     * changer le role d'un utilisateur
     */
    public function changerRoleUtilisateur($id_utilisateur){
        //verifier is utilisateur existe
        $utilisateur = $this->utilisateurDao->getOneUtilisateur($id_utilisateur);
        if(!$utilisateur){
            throw new Exception("utilisateur introuvable");
        }
        //mettre a jour le role
        $utilisateur->setRole("Etudiant");
        $this->utilisateurDao->UpdateUtilisateur($id_utilisateur);
    }
    public function activerUtilisateur($id_utilisateur){
        //verifier l'existance d'un utilisateur
        $utilisateur = $this->utilisateurDao->getOneUtilisateur($id_utilisateur);

        if(!$utilisateur){
            throw new Exception("UTILISATEUR INTROUVABLE");
        }
/*
        //METTREV A JOUR L;UTILISATEUR
        $utilisateur->setStatut("Actif");
        //mettre dans la base des donnees
        $this->utilisateurDao->UpdateUtilisateur($id_utilisateur);
    }
    public function desactiverUtilisateur($id_utilisateur){
          //verifier l'existance d'un utilisateur
        $utilisateur = $this->utilisateurDao->getOneUtilisateur($id_utilisateur);

        if(!$utilisateur){
            throw new Exception("UTILISATEUR INTROUVABLE");
        }

        //METTREV A JOUR L;UTILISATEUR
        $utilisateur->setStatut("Inactif");
        //mettre dans la base des donnees
        $this->utilisateurDao->UpdateUtilisateur($id_utilisateur);
    }*/

    }

    /**
     * CHANGER LE MOT DE PASSE
     */
    public function changerMotDePasse($id_utilisateur,$mot_de_passe,$nouveau_mot_de_passe){
        //verir si l'utilisateur existe
        $utilisateur = $this->utilisateurDao->getOneUtilisateur($id_utilisateur);
        if(!$utilisateur){
            throw new Exception("Utilisateur introuvable");
        }
        //verifier l'ancien mot de passe
        if(! password_verify($mot_de_passe,$utilisateur->getMotDePasse())){
            throw new Exception("Mot de passe incorrecte");
        }
        //verifier la solidite du nouveau mot de passe
        if(strlen($nouveau_mot_de_passe) < 8){
            throw new Exception("Le mot de passe doit avoir minimum 8 caractere");
        }
        //hasher le mot de passe 
        $motdePasseHash = password_hash($nouveau_mot_de_passe,PASSWORD_BCRYPT);

        //METTRE A JOUR LE MOT DE PASSE
        $utilisateur->setMotDePasse($motdePasseHash);

        //mettre dans la base des donnees
        $this->utilisateurDao->UpdateUtilisateur($id_utilisateur);
    }

    //rechercher un utilisateur
    public function rechercherUtilisateur($keyword){
        //verifier la longeur du mot 
        if(strlen($keyword) < 2){
            return [];
        }else{
            //mettre dans la base des donnees
            return $this->utilisateurDao->searchUtilisateur($keyword);
        }
    }
    /**
     * supprimer un utilisateur
     */
    public function supprimerUtilisateur($id_utilisateur){
        return $this->utilisateurDao->DeleteUtilisateur($id_utilisateur);

    }
    /**
     * afficher un utilisateur
     */
    public function afficherUtilisateur($id_utilisateur){
        return $this->utilisateurDao->getOneUtilisateur($id_utilisateur);
    }
    /**
     * afficher tout les utilisateur
     */
    public function afficherTousLesUtilisateurs(){
        return $this->utilisateurDao->getAllUtilisateur();
    }


}









?>