<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


namespace App\Models\Evaluation;

class Resultat
{
    private  $id_resultat;
    private  $id_utilisateur;
    private  $id_exercice;
    private  $score;
    private  $date_resultat;

    public function __construct(
         $id_resultat = null,
         $id_utilisateur = null,
         $id_exercice = null,
         $score = null,
         $date_resultat = null,
    ) {
        $this->id_resultat = $id_resultat;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_exercice = $id_exercice;
        $this->score = $score;
        $this->date_resultat = $date_resultat;
    }

    public function getIdResultat() { return $this->id_resultat; }
    public function setIdResultat( $id_resultat) { $this->id_resultat = $id_resultat; }

    public function getIdUtilisateur() { return $this->id_utilisateur; }
    public function setIdUtilisateur( $id_utilisateur) { $this->id_utilisateur = $id_utilisateur; }
    public function getIdExercice() { return $this->id_exercice; }
    public function setIdExercice( $id_exercice) { $this->id_exercice = $id_exercice; }

    public function getScore() { return $this->score; }
    public function setScore( $score) { $this->score = $score; }

    public function getDateResultat() { return $this->date_resultat; }
    public function setDateResultat( $date_resultat) { $this->date_resultat = $date_resultat; }
}
