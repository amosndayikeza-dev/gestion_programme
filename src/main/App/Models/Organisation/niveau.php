<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


namespace App\Models\Organisation;
use DateTime;
use DateInterval;
use PDO;
use Exception;

class Niveau
{
    private  $id_niveau;
    private  $nom_niveau;
    private  $xp_min;
    private  $xp_max;

    public function __construct(
         $id_niveau,
         $nom_niveau,
         $xp_min,
         $xp_max
    ) {
        $this->id_niveau = $id_niveau;
        $this->nom_niveau = $nom_niveau;
        $this->xp_min = $xp_min;
        $this->xp_max = $xp_max;
    }

    public function getIdNiveau()  { return $this->id_niveau; }
    public function setIdNiveau( $id): void { $this->id_niveau = $id; }
    
    public function getNomNiveau()  { return $this->nom_niveau; }
    public function setNomNiveau( $nom): void { $this->nom_niveau = $nom; }

    public function getXpMin()  { return $this->xp_min; }
    public function setXpMin( $xp): void { $this->xp_min = $xp; }

    public function getXpMax()  { return $this->xp_max; }
    public function setXpMax( $xp): void { $this->xp_max = $xp; }
}
