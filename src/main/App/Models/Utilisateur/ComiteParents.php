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
class ComiteParents extends Utilisateur
{
    private $poste;
    private $mandat;
    private $enfantsScolarises;
    private $specialites;

    public function __construct(
        $idUtilisateur,
        $nom,
        $prenom,
        $email,
        $motDePasse,
        $role = RoleEnum::COMITE_PARENTS,
        $dateCreation,
        $poste = 'membre',
        $mandat = null,
        $photoProfil = null
    ) {
        parent::__construct($idUtilisateur, $nom, $prenom, $email, $motDePasse, $role, $dateCreation, $photoProfil);
        $this->poste = $poste;
        $this->mandat = $mandat;
        $this->enfantsScolarises = [];
        $this->specialites = [];
    }

    public function getPoste() { return $this->poste; }
    public function setPoste($poste) { $this->poste = $poste; }

    public function getMandat() { return $this->mandat; }
    public function setMandat($mandat) { $this->mandat = $mandat; }

    public function getEnfantsScolarises() { return $this->enfantsScolarises; }
    public function setEnfantsScolarises($enfants) { $this->enfantsScolarises = $enfants; }

    public function getSpecialites() { return $this->specialites; }
    public function setSpecialites($specialites) { $this->specialites = $specialites; }

    public function ajouterEnfantScolarise($enfantId, $classe) {
        $this->enfantsScolarises[$enfantId] = $classe;
    }

    public function ajouterSpecialite($specialite) {
        if (!in_array($specialite, $this->specialites)) {
            $this->specialites[] = $specialite;
        }
    }

    public function peutRepresenteParents(): bool {
        return true;
    }

    public function peutParticiperReunions(): bool {
        return true;
    }

    public function peutProposerProjets(): bool {
        return true;
    }

    public function peutAiderOrganisation(): bool {
        return true;
    }

    public function peutCollecterFonds(): bool {
        return $this->poste === 'tresorier' || $this->poste === 'president';
    }

    public function peutPrendreDecisions(): bool {
        return in_array($this->poste, ['president', 'vice-president', 'secretaire', 'tresorier']);
    }
}
?>
