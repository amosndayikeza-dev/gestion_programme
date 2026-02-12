<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\Evaluation;

class Quiz
{
    private  $id_quiz;
    private  $id_lecon;
    private  $titre;
    private  $scoreMin;

    public function __construct(
         $id_quiz = null,
         $id_lecon = null,
         $titre = null,
         $scoreMin = null,
    ) {
        $this->id_quiz = $id_quiz;
        $this->id_lecon = $id_lecon;
        $this->titre = $titre;
        $this->scoreMin = $scoreMin;
    }

    public function getIdQuiz(){ return $this->id_quiz; }
    public function setIdQuiz( $id_quiz): void { $this->id_quiz = $id_quiz; }

    public function getIdLecon(){ return $this->id_lecon; }
    public function setIdLecon( $id_lecon): void { $this->id_lecon = $id_lecon; }

    public function getTitre(){ return $this->titre; }
    public function setTitre( $titre): void { $this->titre = $titre; }

    public function getScoreMin(){ return $this->scoreMin; }
    public function setScoreMin( $score): void { $this->scoreMin = $score; }
}
