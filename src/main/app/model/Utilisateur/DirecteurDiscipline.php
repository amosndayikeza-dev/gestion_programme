<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/utilisateur.php';
require_once __DIR__ . '/RoleEnum.php';

class DirecteurDiscipline extends Utilisateur
{
    private $bureau;
    private $telephonePro;
    private $plagesDisponibilite;
    private $datedebut;
    private $datefin;

    public function __construct(
        $idUtilisateur,
        $nom,
        $prenom,
        $email,
        $motDePasse,
        $role = RoleEnum::DIRECTEUR_DISCIPLINE,
        $dateCreation,
        $bureau = null,
        $telephonePro = null,
        $datedebut = null,
        $datefin = null
    ) {
        parent::__construct($idUtilisateur, $nom, $prenom, $email, $motDePasse, $role, $dateCreation);
        $this->bureau = $bureau;
        $this->telephonePro = $telephonePro;
        $this->plagesDisponibilite = [];
        $this->datedebut = $datedebut;
        $this->datefin = $datefin;
    }

    public function getBureau() { return $this->bureau; }
    public function setBureau($bureau) { $this->bureau = $bureau; }

    public function getTelephonePro() { return $this->telephonePro; }
    public function setTelephonePro($telephone) { $this->telephonePro = $telephone; }

    public function getPlagesDisponibilite() { return $this->plagesDisponibilite; }
    public function setPlagesDisponibilite($plages) { $this->plagesDisponibilite = $plages; }

    public function getDatedebut() { return $this->datedebut; }
    public function setDatedebut($datedebut) { $this->datedebut = $datedebut; }

    public function getDatefin() { return $this->datefin; }
    public function setDatefin($datefin) { $this->datefin = $datefin; }    
    
    public function ajouterPlageDisponibilite($debut, $fin) {
        $this->plagesDisponibilite[] = ['debut' => $debut, 'fin' => $fin];
    }

    public function peutDonnerSanction(): bool {
        return true;
    }

    public function peutGererConseilDiscipline(): bool {
        return true;
    }

    public function peutVoirDossierDisciplinaire($eleveId): bool {
        return true;
    }

    public function peutExclureEleve(): bool {
        return true;
    }
}
?>
