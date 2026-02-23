<?php

namespace App\ModuleUtilisateur\Proviseur\Models;
use DateTime;
use DateInterval;
use PDO;
use Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\ModuleUtilisateur\Models\Utilisateur;
use App\ModuleUtilisateur\Models\RoleEnum;


class Proviseur extends Utilisateur
{
    private $etablissement;
    private $bureau;
    private $telephonePro;
    //private $dureeMandat;
    private $idProviseur;
    private $dureeMandat ; // Durée standard du mandat en années

    public function __construct(
        $idProviseur = null,
        $idUtilisateur = NULL,
        $nom = NULL,
        $prenom = NULL,
        $email = NULL,
        $motDePasse = NULL,
        $role = RoleEnum::PROVISEUR ,
        $dateCreation = NULL,
        $etablissement = null,
        $bureau = null,
        $telephonePro = null,
        $dureeMandat = null,
        $photoProfil = null,
        //$dureeMandat = null

    ) {
        parent::__construct($idUtilisateur, $nom, $prenom, $email, $motDePasse, $role, $dateCreation, $photoProfil);
        $this->etablissement = $etablissement;
        $this->bureau = $bureau;
        $this->telephonePro = $telephonePro;
        $this->dureeMandat = $dureeMandat;
    }

    public function getIdProviseur() { return $this->idProviseur; } 
    public function setIdProviseur($id) { $this->idProviseur = $id; }

    public function getEtablissement() { return $this->etablissement; }
    public function setEtablissement($etablissement) { $this->etablissement = $etablissement; }

    public function getBureau() { return $this->bureau; }
    public function setBureau($bureau) { $this->bureau = $bureau; }

    public function getTelephonePro() { return $this->telephonePro; }
    public function setTelephonePro($telephone) { $this->telephonePro = $telephone; }

    public function getdureeMandat() { return $this->dureeMandat; }
    public function setdureeMandat($date) { $this->dureeMandat = $date; }

    public function peutGererPersonnel(): bool {
        return true;
    }

    public function peutValiderDecisions(): bool {
        return true;
    }

    public function peutVoirTousRapports(): bool {
        return true;
    }

    public function peutGererBudget(): bool {
        return true;
    }

    public function peutOrganiserEvenements(): bool {
        return true;
    }

    public function peutReprésenterEtablissement(): bool {
        return true;
    }
}
?>
