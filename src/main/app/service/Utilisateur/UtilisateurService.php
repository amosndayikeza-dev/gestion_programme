<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Utilisateur/UtilisateurDAO.php";

clasS UtilisateurService{
    private UtilisateurDAO $utilisateurDao;

    public function __construct()
    {
        $utilisateurDao = new UtilisateurDAO();
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
        //Valider l'utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->setNom($nom);
        $utilisateur->setPrenom($prenom);
        $utilisateur->setEmail($email);
        $utilisateur->setMotDePasse(password_hash($mot_de_passe,PASSWORD_DEFAULT));
        $utilisateur->setRole($role);
        $utilisateur->setDateCreation($date_de_creation);


        $this->utilisateurDao->createUtilisateur($utilisateur);

        return $utilisateur;
    }
}









?>