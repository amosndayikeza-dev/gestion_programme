<?php

 class classe{
    private $id_classe;
    private $nom_classe;
    private $niveau;
    private $id_etablissement;
    private $effectif_actuel;
    private $salle;
    private $annee_scolaire;
    private $description;

    //constructeur

    public function __construct($id_classe,$nom_classe,$niveau,$id_etablissement,$effectif_actuel,$salle,$annee_scolaire,$description)
    {
        $this->id_classe = $id_classe;
        $this->nom_classe = $nom_classe;
        $this->niveau = $niveau;
        $this->id_etablissement = $id_etablissement;
        $this->effectif_actuel = $effectif_actuel;
        $this->salle = $salle;
        $this->annee_scolaire = $annee_scolaire;
        $this->description = $description;
    }

    public function getIdclasse(){
        return $this->id_classe ;
    }
    public function getNomclasse(){
        return $this->nom_classe;
    }
    public function getNiveauclasse(){
        return $this->niveau;
    }
    public function getIdEtablissment(){
        return $this->id_etablissement;
    }
    public function getEffectifActuel(){
        return $this->effectif_actuel;
    }
    public function getSalle(){
        return $this->salle;
    }
    public function getAnneeScolaire(){
        return $this->annee_scolaire;
    }
    public function getDescription(){
        return $this->description;
    }

    //setters

    public function setIdclasse($id_classe){
         $this->id_classe = $id_classe;
    }
    public function setNomclasse($nom_classe){
         $this->nom_classe = $nom_classe;
    }
    public function setNiveauclasse($niveau){
         $this->niveau = $niveau;
    }
    public function setIdEtablissment($id_etablissement){
         $this->id_etablissement = $id_etablissement;
    }
    public function setEffectifActuel($effectif_actuel){
        return $this->effectif_actuel;
    }
    public function setSalle($salle){
         $this->salle = $salle;
    }
    public function setAnneeScolaire($annee_scolaire){
         $this->annee_scolaire = $annee_scolaire;
    }
    public function setDescription($description){
         $this->description = $description;
    }

 }
/*

 `id_classe` int NOT NULL AUTO_INCREMENT,
  `nom_classe` varchar(50) NOT NULL,
  `niveau` varchar(50) NOT NULL,
  `id_etablissement` int NOT NULL,
  `effectif_maximum` int DEFAULT NULL COMMENT 'Effectif maximum de la classe',
  `effectif_actuel` int DEFAULT '0' COMMENT 'Effectif actuel de la classe',
  `salle` varchar(50) DEFAULT NULL COMMENT 'Numéro ou nom de la salle',
  `annee_scolaire` varchar(20) DEFAULT NULL COMMENT 'Année scolaire (ex: 2024-2025)',
  `description` text COMMENT 'Description détaillée de la classe',
  PRIMARY KEY (`id_classe`),
  KEY `id_etablissement` (`id_etablissement`)







?>