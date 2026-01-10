<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Progression
{
    private  $idProgression;
    private  $idUtilisateur;
    private  $idCours;
    private  $pourcentage;

    public function __construct(
         $idProgression,
         $idUtilisateur,
         $idCours,
         $pourcentage
    ) {
        $this->idProgression = $idProgression;
        $this->idUtilisateur = $idUtilisateur;
        $this->idCours = $idCours;
        $this->pourcentage = $pourcentage;
    }

    public function getIdProgression() { return $this->idProgression; }
    public function setIdProgression( $id) { $this->idProgression = $id; }

    public function getIdUtilisateur() { return $this->idUtilisateur; }
    public function setIdUtilisateur( $id) { $this->idUtilisateur = $id; }

    public function getIdCours() { return $this->idCours; }
    public function setIdCours( $id) { $this->idCours = $id; }

    public function getPourcentage() { return $this->pourcentage; }
    public function setPourcentage( $p) { $this->pourcentage = $p; }
}
