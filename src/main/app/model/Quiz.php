<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Quiz
{
    private  $idQuiz;
    private  $idLecon;
    private  $titre;
    private  $scoreMin;

    public function __construct(
         $idQuiz,
         $idLecon,
         $titre,
         $scoreMin
    ) {
        $this->idQuiz = $idQuiz;
        $this->idLecon = $idLecon;
        $this->titre = $titre;
        $this->scoreMin = $scoreMin;
    }

    public function getIdQuiz(){ return $this->idQuiz; }
    public function setIdQuiz( $id): void { $this->idQuiz = $id; }

    public function getIdLecon(){ return $this->idLecon; }
    public function setIdLecon( $id): void { $this->idLecon = $id; }

    public function getTitre(){ return $this->titre; }
    public function setTitre( $titre): void { $this->titre = $titre; }

    public function getScoreMin(){ return $this->scoreMin; }
    public function setScoreMin( $score): void { $this->scoreMin = $score; }
}
