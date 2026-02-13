<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


namespace App\Models\Evaluation;

class Exercice
{
    private  $id_exercice;
    private  $id_lecon;
    private  $question;
    private  $type;
    private $niveau;
    private $score;

    public function __construct(
         $id_exercice = null,
         $id_lecon = null,
         $question = null,
         $type = null,
         $niveau = null,
         $score = null,
    ) {
        $this->id_exercice = $id_exercice;
        $this->id_lecon = $id_lecon;
        $this->question = $question;
        $this->type = $type;
        $this->niveau = $niveau;
        $this->score = $score;
    }

    public function getIdExercice(){ return $this->id_exercice; }
    public function setIdExercice( $id_exercice): void { $this->id_exercice = $id_exercice; }

    public function getIdLecon(){ return $this->id_lecon; }
    public function setIdLecon( $id_lecon): void { $this->id_lecon = $id_lecon; }

    public function getQuestion(){ return $this->question; }
    public function setQuestion( $q): void { $this->question = $q; }

    public function getType(){ return $this->type; }
    public function setType( $type): void { $this->type = $type; }

    public function getNiveau(){ return $this->niveau; }
    public function setNiveau( $niveau): void { $this->niveau = $niveau; }

    public function getScore(){ return $this->score; }
    public function setScore( $score): void { $this->score = $score; }

    
}

