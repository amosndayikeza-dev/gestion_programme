<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Exercice
{
    private  $idExercice;
    private  $idLecon;
    private  $question;
    private  $type;
    private $niveau;
    private $score;

    public function __construct(
         $idExercice,
         $idLecon,
         $question,
         $type,
         $niveau,
         $score,
    ) {
        $this->idExercice = $idExercice;
        $this->idLecon = $idLecon;
        $this->question = $question;
        $this->type = $type;
        $this->niveau = $niveau;
        $this->score = $score;
    }

    public function getIdExercice(){ return $this->idExercice; }
    public function setIdExercice( $id): void { $this->idExercice = $id; }

    public function getIdLecon(){ return $this->idLecon; }
    public function setIdLecon( $id): void { $this->idLecon = $id; }

    public function getQuestion(){ return $this->question; }
    public function setQuestion( $q): void { $this->question = $q; }

    public function getType(){ return $this->type; }
    public function setType( $type): void { $this->type = $type; }
}
