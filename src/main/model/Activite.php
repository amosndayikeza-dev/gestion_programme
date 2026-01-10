<?php


class Activite{
    private $id_activite;
    private $id_lesson;
    private $type;
    private $instruction;

    //constructeur

    public function __construct($id_activite,$id_lesson,$type,$instruction)
    {
       $this->id_activite = $id_activite;
       $this->id_lesson = $id_lesson;
       $this->type = $type;
       $this->instruction;
    }

    //getters
    public function getIdActivite(){
        return $this->id_activite;
    }
    public function getIdLesson(){
        return $this->id_lesson;
    }
    public function getType(){
        return $this->type;
    }
    public function getInstruction(){
        return $this->instruction;
    }

    //setters
     public function setIdActivite($id_activite){
         $this->id_activite = $id_activite;
    }
    public function setIdLesson($id_lesson){
         $this->id_lesson = $id_lesson;
    }
    public function setType($type){
         $this->type = $type;
    }
    public function setInstruction($instruction){
         $this->instruction = $instruction;
    }
}




/*
CREATE TABLE IF NOT EXISTS `activite` (
  `id_activite` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `type` enum('glisser_deposer','qcm','association','completer') DEFAULT NULL,
  `instruction` text,
  PRIMARY KEY (`id_activite`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- -------------
*/


?>