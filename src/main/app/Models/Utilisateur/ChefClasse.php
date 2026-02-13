<?php

namespace App\Models\Utilisateur;
use DateTime;
use DateInterval;
use PDO;
use Exception;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Models\Utilisateur\RoleEnum;
use App\Models\Utilisateur\Utilisateur;;

//require_once __DIR__ . '/utilisateur.php';
//require_once __DIR__ . '/RoleEnum.php';

class ChefClasse extends Utilisateur
{
    private $classe;
    private $delegues;
    private $responsabilites;
    private $dateDebut;
    private $dateFin;

    public function __construct(
        $idUtilisateur,
        $nom,
        $prenom,
        $email,
        $motDePasse,
        $role = RoleEnum::CHEF_CLASSE,
        $dateCreation,
        $classe = null,
        $dateDebut = null,
        $dateFin = null,
        $photoProfil = null
    ) {
        parent::__construct($idUtilisateur, $nom, $prenom, $email, $motDePasse, $role, $dateCreation, $photoProfil);
        $this->classe = $classe;
        $this->delegues = [];
        $this->responsabilites = [];
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

    public function getClasse() { return $this->classe; }
    public function setClasse($classe) { $this->classe = $classe; }

    public function getDelegues() { return $this->delegues; }
    public function setDelegues($delegues) { $this->delegues = $delegues; }

    public function getResponsabilites() { return $this->responsabilites; }
    public function setResponsabilites($responsabilites) { $this->responsabilites = $responsabilites; }

    public function getDateDebut() { return $this->dateDebut; }
    public function setDateDebut($dateDebut) { $this->dateDebut = $dateDebut; }

    public function getDateFin() { return $this->dateFin; }
    public function setDateFin($dateFin) { $this->dateFin = $dateFin; }
    public function ajouterDelegue($delegueId) {
        if (!in_array($delegueId, $this->delegues)) {
            $this->delegues[] = $delegueId;
        }
    }

    public function supprimerDelegue($delegueId) {
        $key = array_search($delegueId, $this->delegues);
        if ($key !== false) {
            unset($this->delegues[$key]);
            $this->delegues = array_values($this->delegues);
        }
    }

    public function ajouterResponsabilite($responsabilite) {
        if (!in_array($responsabilite, $this->responsabilites)) {
            $this->responsabilites[] = $responsabilite;
        }
    }

    public function peutRepresenteClasse(): bool {
        return true;
    }

    public function peutOrganiserActivitesClasse(): bool {
        return true;
    }

    public function peutCommiquerAvecAdministration(): bool {
        return true;
    }

    public function peutGererProblemesClasse(): bool {
        return true;
    }
}
?>
