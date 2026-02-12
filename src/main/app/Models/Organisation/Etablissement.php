<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\Organisation;
use DateTime;
use DateInterval;
use PDO;
use Exception;

class Etablissement
{
    private  $id_etablissement;
    private  $nom;
    private  $type;
    private  $localisation;

    public function __construct(
        $id_etablissement = null,
        $nom = null,
        $type = null,
        $localisation = null,
    ) {
        $this->id_etablissement = $id_etablissement;
        $this->nom = $nom;
        $this->type = $type;
        $this->localisation = $localisation;
    }

    public function getIdEtablissement(){ return $this->id_etablissement; }
    public function setIdEtablissement( $id_etablissement): void { $this->id_etablissement = $id_etablissement; }

    public function getNom(){ return $this->nom; }
    public function setNom( $nom): void { $this->nom = $nom; }

    public function getType(){ return $this->type; }
    public function setType( $type): void { $this->type = $type; }

    public function getLocalisation() { return $this->localisation; }
    public function setLocalisation($loc): void { $this->localisation = $loc; }

    
}
