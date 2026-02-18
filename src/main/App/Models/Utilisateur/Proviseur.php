<?php

namespace App\Models\Utilisateur;
use DateTime;
use DateInterval;
use PDO;
use Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Models\Utilisateur\utilisateur;
use App\Models\Utilisateur\RoleEnum;

//require_once __DIR__ . '/utilisateur.php';
//require_once __DIR__ . '/RoleEnum.php';

class Proviseur extends Utilisateur
{
    private $etablissement;
    private $bureau;
    private $telephonePro;
    private $dateDebutMandat;

    public function __construct(
        $idUtilisateur,
        $nom,
        $prenom,
        $email,
        $motDePasse,
        $role = RoleEnum::PROVISEUR,
        $dateCreation,
        $etablissement = null,
        $bureau = null,
        $telephonePro = null,
        $dateDebutMandat = null,
        $photoProfil = null
    ) {
        parent::__construct($idUtilisateur, $nom, $prenom, $email, $motDePasse, $role, $dateCreation, $photoProfil);
        $this->etablissement = $etablissement;
        $this->bureau = $bureau;
        $this->telephonePro = $telephonePro;
        $this->dateDebutMandat = $dateDebutMandat;
    }

    public function getEtablissement() { return $this->etablissement; }
    public function setEtablissement($etablissement) { $this->etablissement = $etablissement; }

    public function getBureau() { return $this->bureau; }
    public function setBureau($bureau) { $this->bureau = $bureau; }

    public function getTelephonePro() { return $this->telephonePro; }
    public function setTelephonePro($telephone) { $this->telephonePro = $telephone; }

    public function getDateDebutMandat() { return $this->dateDebutMandat; }
    public function setDateDebutMandat($date) { $this->dateDebutMandat = $date; }

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
