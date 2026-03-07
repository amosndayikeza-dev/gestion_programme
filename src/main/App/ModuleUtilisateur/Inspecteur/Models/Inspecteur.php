<?php
namespace App\ModuleUtilisateur\Inspecteur\Models;  // ← CORRIGÉ (pas Inspcteur)

use App\ModuleUtilisateur\Models\Utilisateur;

use DateTime;

class Inspecteur extends Utilisateur
{
    // === ATTRIBUTS SPÉCIFIQUES ===
    private $idInspecteur;
    private $zoneGeographique;        // ← UN SEUL nom, celui de la table
    private $niveauHabilitation;   
    private $specialite;
    private $grade;
    private $etablissementsAssignes;
    private $dateNomination;
    private $dateFinMission;
    private $statutMission;
    private $rapportsEmis;
    private $derniereInspection;
    private $prochaineInspection;
    private $typeInspections;
    private $vehiculeDeFonction;
    private $primeInspection;
    private $formationsSuivies;
    private $certifications;

    // === CONSTRUCTEUR ===
    public function __construct(
        // Paramètres du parent
        $idUtilisateur = null,
        $nom = null,
        $prenom = null,
        $email = null,
        $telephone = null,
        $motDePasse = null,
        $role = 'inspecteurs',  // ✅ Défaut: TOUJOURS 'inspecteurs'
        $statut = 'actif',
        $dateCreation = null,
        $derniereConnexion = null,
        $photoProfil = null,
        $tokenReset = null,
        $dateExpirationToken = null,
        
        // Paramètres spécifiques
        $idInspecteur = null,
        $zoneGeographique = null,        // ← CORRIGÉ
        $niveauHabilitation = 1,
        $specialite = null,
        $grade = null,
        $dateNomination = null
    ) {
        // Appel du parent - force le rôle à 'inspecteurs'
        parent::__construct(
            $idUtilisateur,
            $nom,
            $prenom,
            $email,
            $telephone,
            $motDePasse,
            'inspecteurs',  // ✅ Force TOUJOURS 'inspecteurs'
            $statut,
            $dateCreation,
            $derniereConnexion,
            $photoProfil,
            $tokenReset,
            $dateExpirationToken
        );
        
        // Initialisation
        $this->idInspecteur = $idInspecteur ?? $idUtilisateur;
        $this->zoneGeographique = $zoneGeographique;
        $this->niveauHabilitation = $niveauHabilitation;
        $this->specialite = $specialite;
        $this->grade = $grade;
        $this->dateNomination = $dateNomination;
    }

    // === GETTERS ===
    public function getIdInspecteur() { return $this->idInspecteur; }
    public function getZoneGeographique() { return $this->zoneGeographique; }  // ← UN SEUL
    public function getNiveauHabilitation() { return $this->niveauHabilitation; }
    public function getSpecialite() { return $this->specialite; }
    public function getGrade() { return $this->grade; }
    public function getEtablissementsAssignes() { return $this->etablissementsAssignes; }
    public function getDateNomination() { return $this->dateNomination; }
    public function getDateFinMission() { return $this->dateFinMission; }
    public function getStatutMission() { return $this->statutMission; }
    public function getRapportsEmis() { return $this->rapportsEmis; }
    public function getDerniereInspection() { return $this->derniereInspection; }
    public function getProchaineInspection() { return $this->prochaineInspection; }
    public function getTypeInspections() { return $this->typeInspections; }
    public function getVehiculeDeFonction() { return $this->vehiculeDeFonction; }
    public function getPrimeInspection() { return $this->primeInspection; }
    public function getFormationsSuivies() { return $this->formationsSuivies; }
    public function getCertifications() { return $this->certifications; }

    // === SETTERS ===
    public function setIdInspecteur($id) { 
        $this->idInspecteur = $id;
        $this->setIdUtilisateur($id);
        return $this; 
    }
    public function setZoneGeographique($zone) { 
        $this->zoneGeographique = $zone; 
        return $this; 
    }
    public function setNiveauHabilitation($niveau) { 
        $this->niveauHabilitation = $niveau; 
        return $this; 
    }
    public function setSpecialite($specialite) { 
        $this->specialite = $specialite; 
        return $this; 
    }
    public function setGrade($grade) { 
        $this->grade = $grade; 
        return $this; 
    }
    public function setEtablissementsAssignes($etablissements) { 
        $this->etablissementsAssignes = $etablissements; 
        return $this; 
    }

    // === OVERRIDE SETTERS POUR FORCER LE RÔLE INSPECTEURS ===
    /**
     * Force toujours le rôle à 'inspecteurs' pour éviter les incohérences
     */
    public function setRole($role = null) {
        // Toujours forcer 'inspecteurs', ignorer toute autre valeur
        return parent::setRole('inspecteurs');
    }
    public function setDateNomination($date) { 
        $this->dateNomination = $date; 
        return $this; 
    }
    public function setDateFinMission($date) { 
        $this->dateFinMission = $date; 
        return $this; 
    }
    public function setStatutMission($statut) { 
        $this->statutMission = $statut; 
        return $this; 
    }
    public function setRapportsEmis($rapports) { 
        $this->rapportsEmis = $rapports; 
        return $this; 
    }
    public function setDerniereInspection($date) { 
        $this->derniereInspection = $date; 
        return $this; 
    }   
    public function setProchaineInspection($date) { 
        $this->prochaineInspection = $date; 
        return $this; 
    }
    public function setTypeInspections($types) { 
        $this->typeInspections = $types; 
        return $this; 
    }
    public function setVehiculeDeFonction($vehicule) { 
        $this->vehiculeDeFonction = $vehicule; 
        return $this; 
    }

    public function setPrimeInspection($prime) { 
        $this->primeInspection = $prime; 
        return $this; 
    }
    public function setFormationsSuivies($formations) { 
        $this->formationsSuivies = $formations; 
        return $this; 
    }
    public function setCertifications($certifications) { 
        $this->certifications = $certifications; 
        return $this; 
    }

    // === MÉTHODES MÉTIER ===
    public function getNomComplet(): string
    {
        return trim($this->getPrenom() . ' ' . $this->getNom());
    }

    public function getNiveauLibelle(): string
    {
        $niveaux = [
            1 => 'Inspecteur stagiaire',
            2 => 'Inspecteur confirmé',
            3 => 'Inspecteur principal',
            4 => 'Inspecteur général'
        ];
        return $niveaux[$this->niveauHabilitation] ?? 'Niveau inconnu';
    }

    public function getNiveauCouleur(): string
    {
        $couleurs = [
            1 => 'info',
            2 => 'success',
            3 => 'warning',
            4 => 'danger'
        ];
        return $couleurs[$this->niveauHabilitation] ?? 'secondary';
    }

    public function peutInspecter($etablissementZone): bool
    {
        if ($this->zoneGeographique === 'National') {
            return true;
        }
        return $this->zoneGeographique === $etablissementZone;
    }

    public function niveauSuffisant($niveauRequis): bool
    {
        return $this->niveauHabilitation >= $niveauRequis;
    }

    public function getExperience(): int
    {
        if (!$this->getDateCreation()) return 0;
        $debut = new DateTime($this->getDateCreation());
        $today = new DateTime();
        return $today->diff($debut)->y;
    }

    public function estSenior(): bool
    {
        return $this->niveauHabilitation >= 3;
    }

    public function estInspecteurGeneral(): bool
    {
        return $this->niveauHabilitation === 4;
    }

    public function getZoneFormatee(): string
    {
        if ($this->zoneGeographique === 'National') {
            return 'Nationale (tout le pays)';
        }
        return "Zone de {$this->zoneGeographique}";
    }

    // === HYDRATE ===
    public function hydrate(array $data)
    {
        parent::hydrate($data);
        
        // ✅ CORRECTION : Forcer le rôle à 'inspecteurs' après hydratation du parent
        // Cela évite les erreurs si le rôle en BDD est NULL ou invalide
        parent::setRole('inspecteurs');
        
        $mapping = [
            'id_inspecteur' => 'idInspecteur',
            'zone_geographique' => 'zoneGeographique',  // ← CORRIGÉ
            'niveau_habilitation' => 'niveauHabilitation',
            'specialite' => 'specialite',
            'grade' => 'grade',
            'etablissements_assignes' => 'etablissementsAssignes',
            'date_nomination' => 'dateNomination',
            'date_fin_mission' => 'dateFinMission',
            'statut_mission' => 'statutMission',
            'rapports_emis' => 'rapportsEmis',
            'derniere_inspection' => 'derniereInspection',
            'prochaine_inspection' => 'prochaineInspection',
            'type_inspections' => 'typeInspections',
            'vehicule_de_fonction' => 'vehiculeDeFonction',
            'prime_inspection' => 'primeInspection',
            'formations_suivies' => 'formationsSuivies',
            'certifications' => 'certifications'
        ];
        
        foreach ($mapping as $dbKey => $property) {
            if (isset($data[$dbKey])) {
                $this->$property = $data[$dbKey];
            }
        }
        
        return $this;
    }

    // === TOARRAY ===
    public function toArray($mode = 'db')
    {
        $parentArray = parent::toArray();
        
        $specificArray = [
            'id_inspecteur' => $this->idInspecteur,
            'zone_geographique' => $this->zoneGeographique,  // ← CORRIGÉ
            'niveau_habilitation' => $this->niveauHabilitation,
            'specialite' => $this->specialite,
            'grade' => $this->grade,
            'etablissements_assignes' => $this->etablissementsAssignes,
            'date_nomination' => $this->dateNomination,
            'date_fin_mission' => $this->dateFinMission,
            'statut_mission' => $this->statutMission,
            'rapports_emis' => $this->rapportsEmis,
            'derniere_inspection' => $this->derniereInspection,
            'prochaine_inspection' => $this->prochaineInspection,
            'type_inspections' => $this->typeInspections,
            'vehicule_de_fonction' => $this->vehiculeDeFonction,
            'prime_inspection' => $this->primeInspection,
            'formations_suivies' => $this->formationsSuivies,
            'certifications' => $this->certifications
        ];
        
        if ($mode === 'api') {
            $specificArray = array_merge($specificArray, [
                'nom_complet' => $this->getNomComplet(),
                'niveau_libelle' => $this->getNiveauLibelle(),
                'niveau_couleur' => $this->getNiveauCouleur(),
                'zone_formatee' => $this->getZoneFormatee(),
                'experience' => $this->getExperience(),
                'est_senior' => $this->estSenior(),
                'est_inspecteur_general' => $this->estInspecteurGeneral()
            ]);
        }
        
        return array_merge($parentArray, $specificArray);
    }

    public function valider(): array
    {
        $erreurs = [];
        
        if (empty($this->getNom())) {
            $erreurs[] = 'Le nom est obligatoire';
        }
        
        if (empty($this->getPrenom())) {
            $erreurs[] = 'Le prénom est obligatoire';
        }
        
        if (empty($this->getEmail())) {
            $erreurs[] = "L'email est obligatoire";
        } elseif (!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $erreurs[] = "L'email n'est pas valide";
        }
        
        if (empty($this->zoneGeographique)) {  // ← CORRIGÉ
            $erreurs[] = 'La zone géographique est obligatoire';
        }
        
        if (empty($this->specialite)) {
            $erreurs[] = 'La spécialité est obligatoire';
        }
        
        if (empty($this->grade)) {
            $erreurs[] = 'Le grade est obligatoire';
        }
        
        if (empty($this->dateNomination)) {
            $erreurs[] = 'La date de nomination est obligatoire';
        }
        
        if (!is_numeric($this->niveauHabilitation) || $this->niveauHabilitation < 1 || $this->niveauHabilitation > 4) {
            $erreurs[] = 'Le niveau d\'habilitation doit être entre 1 et 4';
        }
        
        return $erreurs;
    }

    public static function getZonesGeographiques(): array
    {
        return [
            'Dakar' => 'Dakar',
            'Thiès' => 'Thiès',
            'Saint-Louis' => 'Saint-Louis',
            'Ziguinchor' => 'Ziguinchor',
            'Kaolack' => 'Kaolack',
            'Diourbel' => 'Diourbel',
            'Louga' => 'Louga',
            'Tambacounda' => 'Tambacounda',
            'Kolda' => 'Kolda',
            'Matam' => 'Matam',
            'Kédougou' => 'Kédougou',
            'Sédhiou' => 'Sédhiou',
            'National' => 'Nationale'
        ];
    }

    public static function fromArray(array $data): self
    {
        $inspecteur = new self();
        return $inspecteur->hydrate($data);
    }
}