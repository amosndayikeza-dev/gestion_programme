<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/utilisateur.php';
require_once __DIR__ . '/RoleEnum.php';
use App\Models\Utilisateur\Utilisateur;
use App\Models\Utilisateur\RoleEnum;

class Prefet extends Utilisateur
{
    private $ecole;
    private $specialite;

    public function __construct(
        $idUtilisateur,
        $nom,
        $prenom,
        $email,
        $motDePasse,
        $role = RoleEnum::PREFET,
        $dateCreation,
        $ecole = null,
        $specialite = null,
        $photoProfil = null
    ) {
        parent::__construct($idUtilisateur, $nom, $prenom, $email, $motDePasse, $role, $dateCreation, $photoProfil);
        $this->ecole = $ecole;
        $this->specialite = $specialite;
    }

    public function getClasseSurveillee() { return $this->classeSurveillee; }
    public function setClasseSurveillee($classe) { $this->classeSurveillee = $classe; }

    public function getNiveauAutorite() { return $this->niveauAutorite; }
    public function setNiveauAutorite($niveau) { $this->niveauAutorite = $niveau; }

    public function peutSurveillerClasse($classeId): bool {
        return $this->classeSurveillee === $classeId || $this->niveauAutorite === 'eleve';
    }

    public function peutDonnerSanction(): bool {
        return in_array($this->niveauAutorite, ['moyen', 'eleve']);
    }

    public function peutRapporterProbleme(): bool {
        return true;
    }
}
?>
