<?php

 class Leecon{
    private $id_lecon;
    private $id_cours;
    private $titre;
    private $description;
    private $ordre;
    private $duree_estimee;
    private $statut;

    //constructeur
    public function __construct($id_lecon,$id_cours,$titre,$description,$ordre,$duree_estimee,$statut)
    {
       $this->id_lecon = $id_lecon;
       $this->id_cours = $id_cours;
       $this->titre = $titre;
       $this->description = $description;
       $this->ordre = $ordre;
       $this->duree_estimee = $duree_estimee;
       $this->statut =$statut;
    }

    //getters
    public function getIdLecon(){
        return $this->id_lecon;
    }
    public function getIdCours(){
        return $this->id_cours;
    }
    public function getTitre(){
        return $this->titre;
    }
    public function getDescription(){
        return  $this->description;
    }
    public function getOrdre(){
        return $this->ordre;
    }
    public function getDureeEstimee(){
        return  $this->duree_estimee;
    }
    public function getStatut(){
        return $this->statut;
    }

    //setters
    public function setIdLecon($id_lecon){
         $this->id_lecon = $id_lecon;
    }
    public function setIdCours($id_cours){
         $this->id_cours = $id_cours;
    }
    public function setTitre($titre){
         $this->titre = $titre;
    }

    public function setDescription($description){
          $this->description = $description;
    }

    public function setOrdre($ordre){
         $this->ordre = $ordre;
    }
    public function setDureeEstimee($duree_estimee){
          $this->duree_estimee = $duree_estimee;
    }
    public function setStatut($statut){
         $this->statut = $statut;
    }
 }
/*
`id_lecon` int NOT NULL AUTO_INCREMENT,
  `id_cours` int NOT NULL,
  `titre` varchar(150) DEFAULT NULL,
  `description` text,
  `ordre` int DEFAULT NULL,
  `duree_estimee` int DEFAULT NULL,
  `statut` enum('brouillon','publie') DEFAULT 'brouillon',
  PRIMARY KEY (`id_lecon`),
  KEY `id_cours` (`id_cours`)
*/

?>