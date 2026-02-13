<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\academique;
class Programme
{
    private  $idProgramme;
    private  $nom_programme;
    private  $niveau;
    private  $description;
    private  $statut;

    public function __construct(
        $idProgramme = null,
        $nom_programme = null,
        $niveau = null,
        $description = null,
        $statut = null,
    ) {
        $this->idProgramme = $idProgramme;
        $this->nom_programme = $nom_programme;
        $this->niveau = $niveau;
        $this->description = $description;
        $this->statut = $statut;
    }

    public function getIdProgramme()  { return $this->idProgramme; }
    public function setIdProgramme( $id): void { $this->idProgramme = $id; }

    public function getNomProgramme() { return $this->nom_programme; }
    public function setNomProgramme( $nom): void { $this->nom_programme = $nom; }

    public function getNiveau()  { return $this->niveau; }
    public function setNiveau( $niveau): void { $this->niveau = $niveau; }

    public function getDescription() { return $this->description; }
    public function setDescription( $desc): void { $this->description = $desc; }

    public function getStatut()  { return $this->statut; }
    public function setStatut( $statut): void { $this->statut = $statut; }
}
