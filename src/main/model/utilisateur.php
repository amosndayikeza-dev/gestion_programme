<?php

class utilisateur{
    private $id_utilisateur; 
    private $nom;
    private $prenom;
    private $email;
    private $mot_de_passe;
    private  $role;
    private $date_creattion;

     //constructeur
     public function __construct($id_utilisateur,$nom,$prenom,$email,$mot_de_passe,$role,$date_creattion)
     {
        $this->id_utilisateur = $id_utilisateur;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->role = $role;
        $this->mot_de_passe = $mot_de_passe;
        $this->date_creattion = $date_creattion;
     }

     //getters 

     public function getIdUtilisateur(){
        return $this->id_utilisateur;
     }
     public function getNomUtilisateur(){
        return $this->nom;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getRole(){
        return $this->role;
    }
    public function getMotDePasse(){
        return $this->mot_de_passe;
    }
    public function getDateCreation(){
        return $this->date_creattion;
    }

    //setters
     public function setIdUtilisateur($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
     }
     public function setNomUtilisateur($nom){
        $this->nom = $nom;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setRole($role){
       $this->role = $role;
    }
    public function setMotDePasse($mot_de_passe){
        $this->mot_de_passe = $mot_de_passe;
    }

    public function setDateCreation($date_creattion){
        $this->date_creattion = $date_creattion;
    }
}






/*
`id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('eleve','enseignant','inspecteur','administrateur') NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`)
*/







?>