<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\Organisation;
use DateTime;
use DateInterval;
use PDO;
use Exception;

class Classe
{
    private  $idClasse;
    private  $nomClasse;
    private  $niveau;
    private  $cycle;
    private  $idOption;
    private  $idSection;
    private  $capacite;
    private  $idEcole;
    private $description;
    private $effectifMaximal;
    private $salle;
    private $effectifActuel;
    private $anneeScolaire;

    public function __construct(
         $idClasse = null,
         $nomClasse = null,
         $niveau = null,
         $cycle = null,
         $idOption = null,
         $idSection = null,
         $capacite = null,
         $idEcole = null,
         $description = null,
         $effectifMaximal = null,
         $effectifActuel = null,
         $salle = null,
         $anneeScolaire = null,
    ) {
        $this->idClasse = $idClasse;
        $this->nomClasse = $nomClasse;
        $this->niveau = $niveau;
        $this->cycle = $cycle;
        $this->idOption = $idOption;
        $this->idSection = $idSection;
        $this->capacite = $capacite;
        $this->idEcole = $idEcole;
        $this->salle = $salle;
        $this->description = $description;
        $this->effectifMaximal = $effectifMaximal;
        $this->effectifActuel = $effectifActuel;
        $this->anneeScolaire = $anneeScolaire;
    }

    public function getIdClasse()  { return $this->idClasse; }
    public function setIdClasse( $id) { $this->idClasse = $id; }

    public function getNomClasse()  { return $this->nomClasse; }
    public function setNomClasse( $nom) { $this->nomClasse = $nom; }

    public function getNiveau()  { return $this->niveau; }
    public function setNiveau( $niveau) { $this->niveau = $niveau; }

    public function getIdEtablissement()  { return $this->idEcole; }
    public function setIdEtablissement( $id) { $this->idEcole = $id; }

    public function getCycle()  { return $this->cycle; }
    public function setCycle( $cycle) { $this->cycle = $cycle; }

    public function getIdOption()  { return $this->idOption; }
    public function setIdOption( $id) { $this->idOption = $id; }

    public function getIdSection()  { return $this->idSection; }
    public function setIdSection( $id) { $this->idSection = $id; }

    public function getCapacite()  { return $this->capacite; }
    public function setCapacite( $capacite) { $this->capacite = $capacite; }

    public function getIdEcole()  { return $this->idEcole; }
    public function setIdEcole( $id) { $this->idEcole = $id; }

    public function getSalle()  { return $this->salle; }
    public function setSalle( $salle) { $this->salle = $salle; }

    public function getDescription()  { return $this->description; }
    public function setDescription( $description) { $this->description = $description; }

    public function getEffectifMaximal()  { return $this->effectifMaximal; }
    public function setEffectifMaximal( $effectif) { $this->effectifMaximal = $effectif; }

    public function getEffectifActuel()  { return $this->effectifActuel; }
    public function setEffectifActuel( $effectif) { $this->effectifActuel = $effectif; }
    
    public function getAnneeScolaire()  { return $this->anneeScolaire; }
    public function setAnneeScolaire( $annee) { $this->anneeScolaire = $annee; }

}
