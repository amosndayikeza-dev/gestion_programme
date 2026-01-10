<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Badge
{
    private  $idBadge;
    private  $nomBadge;
    private  $description;

    public function __construct(
         $idBadge,
         $nomBadge,
         $description
    ) {
        $this->idBadge = $idBadge;
        $this->nomBadge = $nomBadge;
        $this->description = $description;
    }

    public function getIdBadge() { return $this->idBadge; }
    public function setIdBadge( $id) { $this->idBadge = $id; }

    public function getNomBadge() { return $this->nomBadge; }
    public function setNomBadge( $nom) { $this->nomBadge = $nom; }

    public function getDescription(){ return $this->description; }
    public function setDescription($desc): void { $this->description = $desc; }
}
