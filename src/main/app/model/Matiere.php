<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Matiere
{
    private  $idMatiere;
    private  $nomMatiere;
    private int $coefficient;
    private  $description;

    public function __construct(
         $idMatiere,
         $nomMatiere,
         $coefficient,
         $description
    ) {
        $this->idMatiere = $idMatiere;
        $this->nomMatiere = $nomMatiere;
        $this->coefficient = $coefficient;
        $this->description = $description;
    }

    public function getIdMatiere()  { return $this->idMatiere; }
    public function setIdMatiere( $id): void { $this->idMatiere = $id; }

    public function getNomMatiere()  { return $this->nomMatiere; }
    public function setNomMatiere( $nom): void { $this->nomMatiere = $nom; }

    public function getCoefficient() { return $this->coefficient; }
    public function setCoefficient(int $coef): void { $this->coefficient = $coef; }

    public function getDescription() { return $this->description; }
    public function setDescription( $desc): void { $this->description = $desc; }
}
