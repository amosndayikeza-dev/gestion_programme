<?php
namespace App\Models\Suivi;
use DateTime;
use DateInterval;
use PDO;
use Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class BadgeObtenu
{
    private  $id;
    private  $idBadge;
    private  $idUtilisateur;
    private  $dateObtention;

    //constructeur
    public function __construct(
         $id,
         $idBadge,
         $idUtilisateur,
         $dateObtention
    ) {
        $this->id = $id;
        $this->idBadge = $idBadge;
        $this->idUtilisateur = $idUtilisateur;
        $this->dateObtention = $dateObtention;
    }

    //setters et getters
    public function getId()  { return $this->id; }
    public function setId( $id): void { $this->id = $id; }

    public function getIdBadge()  { return $this->idBadge; }
    public function setIdBadge( $id) { $this->idBadge = $id; }

    public function getIdUtilisateur(){ return $this->idUtilisateur; }
    public function setIdUtilisateur( $id) { $this->idUtilisateur = $id; }

    public function getDateObtention() { return $this->dateObtention; }
    public function setDateObtention( $date) { $this->dateObtention = $date; }
}
