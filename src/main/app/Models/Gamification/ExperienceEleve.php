<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


namespace App\Models\Gamification;

class ExperienceEleve
{
    private  $id_experience;
    private  $id_utilisateur;
    private  $xp_total;
    private  $id_niveau;

    public function __construct(
         $id_experience,
         $id_utilisateur,
         $xp_total,
         $id_niveau
    ) {
        $this->id_experience = $id_experience;
        $this->id_utilisateur = $id_utilisateur;
        $this->xp_total = $xp_total;
        $this->id_niveau = $id_niveau;
    }

    public function getIdExperience() { return $this->id_experience; }
    public function setIdExperience( $id): void { $this->id_experience = $id; }

    public function getIdUtilisateur()  { return $this->id_utilisateur; }
    public function setIdUtilisateur( $id): void { $this->id_utilisateur = $id; }
    
    public function getXpTotal() { return $this->xp_total; }
    public function setXpTotal( $xp): void { $this->xp_total = $xp; }

    public function getIdNiveau()  { return $this->id_niveau; }
    public function setIdNiveau( $id): void { $this->id_niveau = $id; }
}
