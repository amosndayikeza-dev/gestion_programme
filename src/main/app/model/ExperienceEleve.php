<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class ExperienceEleve
{
    private  $idExperience;
    private  $idUtilisateur;
    private  $xpTotal;
    private  $idNiveau;

    public function __construct(
         $idExperience,
         $idUtilisateur,
         $xpTotal,
         $idNiveau
    ) {
        $this->idExperience = $idExperience;
        $this->idUtilisateur = $idUtilisateur;
        $this->xpTotal = $xpTotal;
        $this->idNiveau = $idNiveau;
    }

    public function getIdExperience() { return $this->idExperience; }
    public function setIdExperience( $id): void { $this->idExperience = $id; }

    public function getIdUtilisateur()  { return $this->idUtilisateur; }
    public function setIdUtilisateur( $id): void { $this->idUtilisateur = $id; }

    public function getXpTotal() { return $this->xpTotal; }
    public function setXpTotal( $xp): void { $this->xpTotal = $xp; }

    public function getIdNiveau()  { return $this->idNiveau; }
    public function setIdNiveau( $id): void { $this->idNiveau = $id; }
}
