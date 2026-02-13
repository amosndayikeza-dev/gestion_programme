<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\academique;
class Lecon
{
    private  $id_lecon;
    private  $id_cours;
    private  $titre;
    private $ordre;
    private $annee_estime;
    private  $description;
    private  $statut;

    public function __construct(
         $id_lecon = null,
         $id_cours = null,
         $titre = null,
         $ordre = null,
         $annee_estime = null,
         $description = null,
         $statut = null,
    ) {
        $this->id_lecon = $id_lecon;
        $this->id_cours = $id_cours;
        $this->titre = $titre;
        $this->ordre = $ordre;
        $this->annee_estime = $annee_estime;    
        $this->description = $description;
        $this->statut = $statut;
    }

    public function getIdLecon()  { return $this->id_lecon; }
    public function setIdLecon( $id): void { $this->id_lecon = $id; }

    public function getIdCours()  { return $this->id_cours; }
    public function setIdCours( $id): void { $this->id_cours = $id; }

    public function getTitre()  { return $this->titre; }
    public function setTitre( $titre): void { $this->titre = $titre; }

    public function getOrdre()  { return $this->ordre; }
    public function setOrdre( $ordre): void { $this->ordre = $ordre; }

    public function getAnneeEstime() { return $this->annee_estime; }
    public function setAnneeEstime( $annee_estime): void { $this->annee_estime = $annee_estime; }

    public function getDescription() { return $this->description; }
    public function setDescription( $desc): void { $this->description = $desc; }

    public function getStatut()  { return $this->statut; }
    public function setStatut( $statut): void { $this->statut = $statut; }
}
