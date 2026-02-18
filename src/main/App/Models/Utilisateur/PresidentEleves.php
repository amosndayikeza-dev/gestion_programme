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

class PresidentEleves extends Utilisateur
{
    private $mandat;
    private $vicePresident;
    private $membresBureau;
    private $projetsEnCours;

    public function __construct(
        $idUtilisateur,
        $nom,
        $prenom,
        $email,
        $motDePasse,
        $role = RoleEnum::PRESIDENT_ELEVES,
        $dateCreation,
        $mandat = null,
        $photoProfil = null
    ) {
        parent::__construct($idUtilisateur, $nom, $prenom, $email, $motDePasse, $role, $dateCreation, $photoProfil);
        $this->mandat = $mandat;
        $this->vicePresident = null;
        $this->membresBureau = [];
        $this->projetsEnCours = [];
    }

    public function getMandat() { return $this->mandat; }
    public function setMandat($mandat) { $this->mandat = $mandat; }

    public function getVicePresident() { return $this->vicePresident; }
    public function setVicePresident($vicePresident) { $this->vicePresident = $vicePresident; }

    public function getMembresBureau() { return $this->membresBureau; }
    public function setMembresBureau($membres) { $this->membresBureau = $membres; }

    public function getProjetsEnCours() { return $this->projetsEnCours; }
    public function setProjetsEnCours($projets) { $this->projetsEnCours = $projets; }

    public function ajouterMembreBureau($membreId, $role) {
        $this->membresBureau[$membreId] = $role;
    }

    public function supprimerMembreBureau($membreId) {
        unset($this->membresBureau[$membreId]);
    }

    public function ajouterProjet($projet) {
        $this->projetsEnCours[] = $projet;
    }

    public function peutRepresenteTousEleves(): bool {
        return true;
    }

    public function peutOrganiserEvenements(): bool {
        return true;
    }

    public function peutNegocierAvecAdministration(): bool {
        return true;
    }

    public function peutGererBudgetEtudiant(): bool {
        return true;
    }

    public function peutProposerAmeliorations(): bool {
        return true;
    }
}
?>
