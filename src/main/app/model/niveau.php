<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Niveau
{
    private  $idNiveau;
    private  $nomNiveau;
    private  $xpMin;
    private  $xpMax;

    public function __construct(
         $idNiveau,
         $nomNiveau,
         $xpMin,
         $xpMax
    ) {
        $this->idNiveau = $idNiveau;
        $this->nomNiveau = $nomNiveau;
        $this->xpMin = $xpMin;
        $this->xpMax = $xpMax;
    }

    public function getIdNiveau()  { return $this->idNiveau; }
    public function setIdNiveau( $id): void { $this->idNiveau = $id; }

    public function getNomNiveau()  { return $this->nomNiveau; }
    public function setNomNiveau( $nom): void { $this->nomNiveau = $nom; }

    public function getXpMin()  { return $this->xpMin; }
    public function setXpMin( $xp): void { $this->xpMin = $xp; }

    public function getXpMax()  { return $this->xpMax; }
    public function setXpMax( $xp): void { $this->xpMax = $xp; }
}
