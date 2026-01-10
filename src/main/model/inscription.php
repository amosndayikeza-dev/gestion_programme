<?php

class Inscription{
    private $id_inscription;
    private $id_utilisateur;
    private $id_classe;
    private $annee_scolaire;

    //constructeur

    public function __construct($id_inscription,$id_utilisateur,$id_classe,$annee_scolaire)
    {
       $this->$id_inscription = $id_inscription;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_classe = $id_classe;
        $this->annee_scolaire = $annee_scolaire;
    }

    //getters
    public function getIdInscription(){
        return $this->id_inscription;
    }
    public function getIdUtilisateur(){
        return $this->id_utilisateur;
    }
    public function getIdClass(){
        return $this->id_classe;
    }
        public function getAnneeScolaire(){
            return $this->annee_scolaire;
    }

    
    //setters
    public function setIdInscription($id_inscription){
         $this->id_classe = $id_inscription;
    }

    public function setIdUtilisateur($id_utilisateur){
         $this->id_utilisateur = $id_utilisateur;
    }

    public function setIdClass($id_classe){
         $this->id_classe  = $id_classe;
    }
        public function setAnneeScolaire($annee_scolaire){
             $this->annee_scolaire = $annee_scolaire;
    }
    
    
}

/*
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id_inscription` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `id_classe` int NOT NULL,
  `annee_scolaire` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_inscription`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_classe` (`id_classe`)
*/







?>