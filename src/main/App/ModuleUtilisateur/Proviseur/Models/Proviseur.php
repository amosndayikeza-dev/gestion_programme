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
    $idUtilisateur = null,
    $nom = null,
    $prenom = null,
    $email = null,
    $motDePasse = null,
    $role = RoleEnum::PROVISEUR,
    $statut = 'actif',
    $telephone = null,
    $dateCreation = null,
    $derniereConnexion = null,
    $photoProfil = null,
    $tokenReset = null,
    $dateExpirationToken = null,
    // Spécifiques à Proviseur
    $idProviseur = null,
    $etablissement = null,
    $bureau = null,
    $telephonePro = null,
    $dureeMandat = null
) {
    // Appel au parent avec TOUS les paramètres
    parent::__construct(
        $idUtilisateur, $nom, $prenom, $email, $motDePasse, 
        $role, $statut, $telephone, $dateCreation, 
        $derniereConnexion, $photoProfil, $tokenReset, $dateExpirationToken
    );
    
    $this->idProviseur = $idProviseur;
    $this->etablissement = $etablissement;
    $this->bureau = $bureau;
    $this->telephonePro = $telephonePro;
    $this->dureeMandat = $dureeMandat;
}
    public function getIdProviseur() { return $this->idProviseur; } 
    public function setIdProviseur($id) { 
        $this->idProviseur = $id;
        //$this->setIdUtilisateur($id);
        }

    public function getEtablissement() { return $this->etablissement; }
    public function setEtablissement($etablissement) { $this->etablissement = $etablissement; }

    public function getBureau() { return $this->bureau; }
    public function setBureau($bureau) { $this->bureau = $bureau; }

    public function getTelephonePro() { return $this->telephonePro; }
    public function setTelephonePro($telephone) { $this->telephonePro = $telephone; }

    public function getDureeMandat() { return $this->dureeMandat; }
    public function setDureeMandat($date) { $this->dureeMandat = $date; }

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
