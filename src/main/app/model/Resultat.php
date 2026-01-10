<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Resultat
{
    private  $idResultat;
    private  $idUtilisateur;
    private  $idExercice;
    private  $score;
    private  $dateResultat;

    public function __construct(
         $idResultat,
         $idUtilisateur,
         $idExercice,
         $score,
         $dateResultat
    ) {
        $this->idResultat = $idResultat;
        $this->idUtilisateur = $idUtilisateur;
        $this->idExercice = $idExercice;
        $this->score = $score;
        $this->dateResultat = $dateResultat;
    }

    public function getIdResultat() { return $this->idResultat; }
    public function setIdResultat( $id) { $this->idResultat = $id; }

    public function getIdUtilisateur() { return $this->idUtilisateur; }
    public function setIdUtilisateur( $id) { $this->idUtilisateur = $id; }

    public function getIdExercice() { return $this->idExercice; }
    public function setIdExercice( $id) { $this->idExercice = $id; }

    public function getScore() { return $this->score; }
    public function setScore( $score) { $this->score = $score; }

    public function getDateResultat() { return $this->dateResultat; }
    public function setDateResultat( $date) { $this->dateResultat = $date; }
}
