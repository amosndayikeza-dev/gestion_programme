<?php
 class Exercice{
    private $id_exercice;
    private $id_lecon;
    private $question;
    private $type;
    private $niveau;
    private $score;

    //constructeur
    public function __construct($id_exercice,$id_lecon,$type,$niveau,$question,$score)
    {
        $this->id_exercice = $id_exercice;
        $this->id_lecon = $id_lecon;
        $this->question = $question;
        $this->type = $type;
        $this->niveau = $niveau;
        $this->score = $score;
    }

    //getters
    public function getIdExercice(){
        return $this->id_exercice;
    }
    public function getIdLecon(){
        return $this->id_lecon;
    }
    public function getQuestion(){
        return $this->question;
    }
    public function getType(){
        return $this->type;
    }
    public function getNiveau(){
        return $this->niveau;
    }
     public function getScore(){
        return $this->score;
    }

    //setters
    public function setIdExercice($id_exercice){
         $this->id_exercice = $id_exercice;
    }
    public function setIdLecon($id_lecon){
         $this->id_lecon = $id_lecon;
    }
    public function setQuestion($question){
         $this->question = $question;
    }
    public function setType($type){
         $this->type = $type;
    }
    public function setNiveau($niveau){
         $this->niveau = $niveau;
    }
     public function setScore($score){
         $this->score  = $score;
    }
 }

/* *
`id_exercice` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `question` text,
  `type` enum('qcm','vrai_faux','reponse_libre') DEFAULT NULL,
  `niveau` enum('facile','moyen','difficile') DEFAULT NULL,
  `score` int DEFAULT '1',
  PRIMARY KEY (`id_exercice`),
  KEY `id_lecon` (`id_lecon`)



**/
?>