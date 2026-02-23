<?php
namespace App\ModuleUtilisateur\Models\Admin;

use App\ModuleUtilisateur\Models\Utilisateur;

class Administrateur extends Utilisateur
{
    // === 1. PROPRIÉTÉS SPÉCIFIQUES (UNIQUEMENT celles de la table administrateurs) ===
    private $idAdministrateur;        // id_administrateur (même que id_utilisateur)
    private $niveauAcces;            // niveau_acces
    private $departement;           // departement
    private $datePriseFonction;     // date_prise_fonction
    private $dateFinFonction;       // date_fin_fonction
    private $permissionsSpeciales;  // permissions_speciales
    private $dernierAudit;          // dernier_audit
    private $adresseIpAutorisees;   // adresse_ip_autorisees
    private $authentification2Facteurs; // authentification_2facteurs
    private $cle2FA;               // cle_2fa
    private $niveauAudit;          // niveau_audit
    private $zoneIntervention;     // zone_intervention
    private $superviseur;          // superviseur

    // === 2. CONSTRUCTEUR - TOUS LES PARAMÈTRES DU PARENT + SES PROPRES PARAMÈTRES ===
    public function __construct(
        // === PARAMÈTRES DU PARENT (UTILISATEUR) - TOUS ! ===
        $idUtilisateur = null,
        $nom = null,
        $prenom = null,
        $email = null,
        $motDePasse = null,
        $role = 'administrateur',        // ⚠️ FORCÉ À 'administrateur'
        $statut = 'actif',
        $telephone = null,
        $dateCreation = null,
        $derniereConnexion = null,
        $photoProfil = null,
        $tokenReset = null,
        $dateExpirationToken = null,
        
        // === PARAMÈTRES SPÉCIFIQUES ADMIN (SA TABLE À LUI) ===
        $idAdministrateur = null,
        $niveauAcces = null,
        $departement = null,
        $datePriseFonction = null,
        $dateFinFonction = null,
        $permissionsSpeciales = null,
        $dernierAudit = null,
        $adresseIpAutorisees = null,
        $authentification2Facteurs = false,
        $cle2FA = null,
        $niveauAudit = 'basique',
        $zoneIntervention = null,
        $superviseur = null
    ) {
        // === 1. APPEL DU CONSTRUCTEUR PARENT (TOUS LES PARAMÈTRES) ===
        parent::__construct(
        $idUtilisateur,
        $nom,
        $prenom,
        $email,
        $motDePasse,
        $role,
        $statut,
        $telephone,
        $dateCreation,
        $derniereConnexion,
        $photoProfil,
        $tokenReset,
        $dateExpirationToken  // ← PLUS DE VIRGULE ICI !
    );
            
        // === 2. INITIALISATION DES PROPRIÉTÉS SPÉCIFIQUES ADMIN ===
        $this->idAdministrateur = $idAdministrateur ?? $idUtilisateur;
        $this->niveauAcces = $niveauAcces;
        $this->departement = $departement;
        $this->datePriseFonction = $datePriseFonction;
        $this->dateFinFonction = $dateFinFonction;
        $this->permissionsSpeciales = $permissionsSpeciales;
        $this->dernierAudit = $dernierAudit;
        $this->adresseIpAutorisees = $adresseIpAutorisees;
        $this->authentification2Facteurs = $authentification2Facteurs;
        $this->cle2FA = $cle2FA;
        $this->niveauAudit = $niveauAudit;
        $this->zoneIntervention = $zoneIntervention;
        $this->superviseur = $superviseur;
    }

    // === 3. GETTERS SPÉCIFIQUES ADMIN ===
    public function getIdAdministrateur() { return $this->idAdministrateur; }
    public function getNiveauAcces() { return $this->niveauAcces; }
    public function getDepartement() { return $this->departement; }
    public function getDatePriseFonction() { return $this->datePriseFonction; }
    public function getDateFinFonction() { return $this->dateFinFonction; }
    public function getPermissionsSpeciales() { return $this->permissionsSpeciales; }
    public function getDernierAudit() { return $this->dernierAudit; }
    public function getAdresseIpAutorisees() { return $this->adresseIpAutorisees; }
    public function getAuthentification2Facteurs() { return $this->authentification2Facteurs; }
    public function getCle2FA() { return $this->cle2FA; }
    public function getNiveauAudit() { return $this->niveauAudit; }
    public function getZoneIntervention() { return $this->zoneIntervention; }
    public function getSuperviseur() { return $this->superviseur; }

    // === 4. SETTERS SPÉCIFIQUES ADMIN (AVEC CHAÎNAGE) ===
    public function setIdAdministrateur($id) { 
        $this->idAdministrateur = $id; 
        return $this; 
    }
    
    public function setNiveauAcces($niveauAcces) { 
        $this->niveauAcces = $niveauAcces; 
        return $this; 
    }
    
    public function setDepartement($departement) { 
        $this->departement = $departement; 
        return $this; 
    }
    
    public function setDatePriseFonction($date) { 
        $this->datePriseFonction = $date; 
        return $this; 
    }
    
    public function setDateFinFonction($date) { 
        $this->dateFinFonction = $date; 
        return $this; 
    }
    
    public function setPermissionsSpeciales($permissions) { 
        $this->permissionsSpeciales = $permissions; 
        return $this; 
    }
    
    public function setDernierAudit($date) { 
        $this->dernierAudit = $date; 
        return $this; 
    }
    
    public function setAdresseIpAutorisees($ips) { 
        $this->adresseIpAutorisees = $ips; 
        return $this; 
    }
    

    public function setAuthentification2Facteurs($bool) { 
        $this->authentification2Facteurs = $bool; 
        return $this; 
    }
    
    public function setCle2FA($cle) { 
        $this->cle2FA = $cle; 
        return $this; 
    }
    
    public function setNiveauAudit($niveau) { 
        $this->niveauAudit = $niveau; 
        return $this; 
    }
    
    public function setZoneIntervention($zone) { 
        $this->zoneIntervention = $zone; 
        return $this; 
    }
    
    public function setSuperviseur($superviseur) { 
        $this->superviseur = $superviseur; 
        return $this; 
    }

    // === 5. HYDRATE SPÉCIFIQUE ===
    public function hydrate(array $data) {
        // 1. Hydrate d'abord le parent (Utilisateur)
        parent::hydrate($data);
        
        // 2. Hydrate les propriétés spécifiques Admin
        $mapping = [
            'id_administrateur' => 'idAdministrateur',
            'niveau_acces' => 'niveauAcces',
            'departement' => 'departement',
            'date_prise_fonction' => 'datePriseFonction',
            'date_fin_fonction' => 'dateFinFonction',
            'permissions_speciales' => 'permissionsSpeciales',
            'dernier_audit' => 'dernierAudit',
            'adresse_ip_autorisees' => 'adresseIpAutorisees',
            'authentification_2facteurs' => 'authentification2Facteurs',
            'cle_2fa' => 'cle2FA',
            'niveau_audit' => 'niveauAudit',
            'zone_intervention' => 'zoneIntervention',
            'superviseur' => 'superviseur'
        ];
        
        foreach ($mapping as $dbKey => $property) {
            if (isset($data[$dbKey])) {
                $this->$property = $data[$dbKey];
            }
        }
        
        return $this;
    }

    // === 6. TOARRAY SPÉCIFIQUE ===
    public function toArray() {
        // 1. Récupère le tableau du parent
        $parentArray = parent::toArray();
        
        // 2. Ajoute les propriétés spécifiques
        $childArray = [
            'id_administrateur' => $this->idAdministrateur,
            'niveau_acces' => $this->niveauAcces,
            'departement' => $this->departement,
            'date_prise_fonction' => $this->datePriseFonction,
            'date_fin_fonction' => $this->dateFinFonction,
            'permissions_speciales' => $this->permissionsSpeciales,
            'dernier_audit' => $this->dernierAudit,
            'adresse_ip_autorisees' => $this->adresseIpAutorisees,
            'authentification_2facteurs' => $this->authentification2Facteurs,
            'cle_2fa' => $this->cle2FA,
            'niveau_audit' => $this->niveauAudit,
            'zone_intervention' => $this->zoneIntervention,
            'superviseur' => $this->superviseur
        ];
        
        // 3. Fusionne et retourne
        return array_merge($parentArray, $childArray);
    }

    // === 7. MÉTHODES MÉTIER SPÉCIFIQUES ===
    public function estSuperAdmin() {
       // return $this->getEstSuperAdmin(); // Hérité de Utilisateur
    }
    
    public function estAdminSysteme() {
        return $this->niveauAcces === 'admin_systeme';
    }
    
    public function estAdminReseau() {
        return $this->niveauAcces === 'admin_reseau';
    }
    
    public function estAdminDonnees() {
        return $this->niveauAcces === 'admin_donnees';
    }
    
    public function a2FAActif() {
        return $this->authentification2Facteurs === true;
    }
    
    public function estEnFonction() {
        if (!$this->dateFinFonction) return true;
        return strtotime($this->dateFinFonction) > time();
    }
    
    public function getAnciennete() {
        if (!$this->datePriseFonction) return null;
        $debut = new \DateTime($this->datePriseFonction);
        $today = new \DateTime();
        return $today->diff($debut)->y;
    }
}