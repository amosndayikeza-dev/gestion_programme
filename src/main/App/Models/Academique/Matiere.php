<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
namespace App\Models\academique;
class Matiere
{
    private  $id_matiere;
    private  $nom_matiere;
    private int $coefficient;
    private  $description;

    public function __construct(
         $id_matiere = null,
         $nom_matiere = null,
         $coefficient = null,
         $description = null,
    ) {
        $this->id_matiere = $id_matiere;
        $this->nom_matiere = $nom_matiere;
        $this->coefficient = $coefficient;
        $this->description = $description;
    }

    public function getIdMatiere()  { return $this->id_matiere; }
    public function setIdMatiere( $id): void { $this->id_matiere = $id; }

    public function getNomMatiere()  { return $this->nom_matiere; }
    public function setNomMatiere( $nom): void { $this->nom_matiere = $nom; }
    
    public function getCoefficient() { return $this->coefficient; }
    public function setCoefficient(int $coef): void { $this->coefficient = $coef; }

    public function getDescription() { return $this->description; }
    public function setDescription( $desc): void { $this->description = $desc; }
}
