<?php


class Matiere{
    private $id_matiere;
    private $nom_matiere;
    private $description;

    //constructeur

    public function __construct($id_matiere,$nom_matiere,$description)
    {
        $this->id_matiere = $id_matiere;
        $this->nom_matiere = $nom_matiere;
        $this->description = $description;
    }


    //getters
     public function getIdMatiere(){
        return $this->id_matiere;
    }
    public function getNomMatiere(){
        return $this->nom_matiere;
    }
    public function getDescription(){
        return $this->description;
    }

    //setters
    public function setIdMatiere($id_matiere){
         $this->id_matiere = $id_matiere;
    }

    public function setNomMatiere($nom_matiere){
         $this->nom_matiere = $nom_matiere;
    }
    public function setDescription($description){
         $this->description = $description;
    }
}













?>