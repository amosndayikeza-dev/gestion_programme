<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Classe
{
    private  $idClasse;
    private  $nomClasse;
    private  $niveau;
    private  $idEtablissement;
    private $description;
    private $effectifMaximal;
    private $salle;
    private $effectifActuel;
    private $anneeScolaire;

    public function __construct(
         $idClasse = null,
         $nomClasse = null,
         $niveau = null,
         $idEtablissement = null,
         $description = null,
         $effectifMaximal = null,
         $effectifActuel = null,
         $salle = null,
         $anneeScolaire = null,
    ) {
        $this->idClasse = $idClasse;
        $this->nomClasse = $nomClasse;
        $this->niveau = $niveau;
        $this->idEtablissement = $idEtablissement;
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

    public function getIdEtablissement()  { return $this->idEtablissement; }
    public function setIdEtablissement( $id) { $this->idEtablissement = $id; }

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
