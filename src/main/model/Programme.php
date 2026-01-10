<?php
 class Programme{
    private $id_programme;
    private $id_matiere;
    private $titre;
    private $description;

    public function __construct($id_programme,$id_matiere,$titre,$description)
     {
        $this->$id_programme = $$id_programme;
        $this->id_matiere = $id_matiere;
        $this->titre = $titre;
        $this->description = $description;
     }

     //getters
     //getters 

     public function getIdProgramme(){
        return $this->id_programme;
     }
     public function getIdMatiere(){
        return $this->id_matiere;
    }
    public function getTitre(){
        return $this->titre;
    }
    public function getDescription(){
        return $this->description;
    }

    //setters
     public function setIdProgramme($id_programme){
        $this->id_programme = $id_programme;
     }
     public function setIdMatiere($id_matiere){
        $this->id_matiere = $id_matiere;
    }

    public function setTitre($titre){
        $this->titre = $titre;
    }
    public function setDescription($description){
       $this->description = $description;
    }


 }

?>