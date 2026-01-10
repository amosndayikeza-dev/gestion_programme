<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Lecon
{
    private  $idLecon;
    private  $idCours;
    private  $titre;
    private $ordre;
    private $anneeEstime;
    private  $description;
    private  $statut;

    public function __construct(
         $idLecon,
         $idCours,
         $titre,
         $description,
         $statut
    ) {
        $this->idLecon = $idLecon;
        $this->idCours = $idCours;
        $this->titre = $titre;
        $this->description = $description;
        $this->statut = $statut;
    }

    public function getIdLecon()  { return $this->idLecon; }
    public function setIdLecon( $id): void { $this->idLecon = $id; }

    public function getIdCours()  { return $this->idCours; }
    public function setIdCours( $id): void { $this->idCours = $id; }

    public function getTitre()  { return $this->titre; }
    public function setTitre( $titre): void { $this->titre = $titre; }

    public function getDescription() { return $this->description; }
    public function setDescription( $desc): void { $this->description = $desc; }

    public function getStatut()  { return $this->statut; }
    public function setStatut( $statut): void { $this->statut = $statut; }
}
