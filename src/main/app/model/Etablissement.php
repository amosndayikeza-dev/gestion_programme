<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Etablissement
{
    private  $idEtablissement;
    private  $nom;
    private  $type;
    private  $localisation;

    public function __construct(
        $idEtablissement,
        $nom,
        $type,
        $localisation
    ) {
        $this->idEtablissement = $idEtablissement;
        $this->nom = $nom;
        $this->type = $type;
        $this->localisation = $localisation;
    }

    public function getIdEtablissement(){ return $this->idEtablissement; }
    public function setIdEtablissement( $id): void { $this->idEtablissement = $id; }

    public function getNom(){ return $this->nom; }
    public function setNom( $nom): void { $this->nom = $nom; }

    public function getType(){ return $this->type; }
    public function setType( $type): void { $this->type = $type; }

    public function getLocalisation() { return $this->localisation; }
    public function setLocalisation($loc): void { $this->localisation = $loc; }

    
}
