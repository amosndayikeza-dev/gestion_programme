<?php
namespace App\ModuleUtilisateur\Inspcteur\Models;

use App\ModuleUtilisateur\Models\Utilisateur;
use DateTime;

class Inspecteur extends Utilisateur
{
    // === ATTRIBUTS SPÉCIFIQUES (table inspecteur) ===
    private $idInspecteur;
    private $zoneInspection;        // Zone géographique d'inspection
    private $niveauHabilitation;     // 1-4 (niveau d'expérience)

    // === CONSTRUCTEUR ===
    public function __construct(
        // Paramètres du parent (Utilisateur)
        $idUtilisateur = null,
        $nom = null,
        $prenom = null,
        $email = null,
        $telephone = null,
        $motDePasse = null,
        $role = 'inspecteur',  // Forcé
        $statut = 'actif',
        $dateCreation = null,
        $derniereConnexion = null,
        $photoProfil = null,
        $tokenReset = null,
        $dateExpirationToken = null,
        
        // Paramètres spécifiques Inspecteur
        $idInspecteur = null,
        $zoneInspection = null,
        $niveauHabilitation = 1
    ) {
        // Appel du constructeur parent
        parent::__construct(
            $idUtilisateur,
            $nom,
            $prenom,
            $email,
            $telephone,
            $motDePasse,
            $role,
            $statut,
            $dateCreation,
            $derniereConnexion,
            $photoProfil,
            $tokenReset,
            $dateExpirationToken
        );
        
        // Initialisation des attributs spécifiques
        $this->idInspecteur = $idInspecteur ?? $idUtilisateur;
        $this->zoneInspection = $zoneInspection;
        $this->niveauHabilitation = $niveauHabilitation;
    }

    // === GETTERS SPÉCIFIQUES ===
    public function getIdInspecteur() { return $this->idInspecteur; }
    public function getZoneInspection() { return $this->zoneInspection; }
    public function getNiveauHabilitation() { return $this->niveauHabilitation; }

    // === SETTERS SPÉCIFIQUES ===
    public function setIdInspecteur($id) { $this->idInspecteur = $id; return $this; }
    public function setZoneInspection($zone) { $this->zoneInspection = $zone; return $this; }
    public function setNiveauHabilitation($niveau) { $this->niveauHabilitation = $niveau; return $this; }

    // === MÉTHODES MÉTIER ===

    /**
     * Obtenir le nom complet
     */
    public function getNomComplet(): string
    {
        return trim($this->getPrenom() . ' ' . $this->getNom());
    }

    /**
     * Obtenir le libellé du niveau d'habilitation
     */
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

    /**
     * Obtenir la couleur associée au niveau
     */
    public function getNiveauCouleur(): string
    {
        $couleurs = [
            1 => 'info',      // Bleu
            2 => 'success',   // Vert
            3 => 'warning',   // Orange
            4 => 'danger'     // Rouge
        ];
        
        return $couleurs[$this->niveauHabilitation] ?? 'secondary';
    }

    /**
     * Vérifier si l'inspecteur peut inspecter un établissement
     */
    public function peutInspecter($etablissementZone): bool
    {
        if ($this->zoneInspection === 'National') {
            return true; // Les inspecteurs nationaux inspectent partout
        }
        
        return $this->zoneInspection === $etablissementZone;
    }

    /**
     * Vérifier si l'inspecteur a un niveau suffisant
     */
    public function niveauSuffisant($niveauRequis): bool
    {
        return $this->niveauHabilitation >= $niveauRequis;
    }

    /**
     * Obtenir l'expérience (nombre d'années depuis création)
     */
    public function getExperience(): int
    {
        if (!$this->getDateCreation()) return 0;
        
        $debut = new DateTime($this->getDateCreation());
        $today = new DateTime();
        
        return $today->diff($debut)->y;
    }

    /**
     * Vérifier si inspecteur senior (niveau 3+)
     */
    public function estSenior(): bool
    {
        return $this->niveauHabilitation >= 3;
    }

    /**
     * Vérifier si inspecteur général (niveau 4)
     */
    public function estInspecteurGeneral(): bool
    {
        return $this->niveauHabilitation === 4;
    }

    /**
     * Obtenir la zone d'inspection formatée
     */
    public function getZoneFormatee(): string
    {
        if ($this->zoneInspection === 'National') {
            return 'Nationale (tout le pays)';
        }
        
        return "Zone de {$this->zoneInspection}";
    }

    // === HYDRATE (tableau → objet) ===

    /**
     * Hydrate l'objet Inspecteur
     */
    public function hydrate(array $data)
    {
        // 1. Hydrate d'abord le parent
        parent::hydrate($data);
        
        // 2. Hydrate les propriétés spécifiques
        $mapping = [
            'id_inspecteur' => 'idInspecteur',
            'zone_inspection' => 'zoneInspection',
            'niveau_habilitation' => 'niveauHabilitation'
        ];
        
        foreach ($mapping as $dbKey => $property) {
            if (isset($data[$dbKey])) {
                $this->$property = $data[$dbKey];
            }
        }
        
        return $this;
    }

    // === TOARRAY (objet → tableau) ===

    /**
     * Convertit l'objet en tableau
     */
    public function toArray($mode = 'db')
    {
        // 1. Tableau du parent
        $parentArray = parent::toArray();
        
        // 2. Tableau spécifique
        $specificArray = [
            'id_inspecteur' => $this->idInspecteur,
            'zone_inspection' => $this->zoneInspection,
            'niveau_habilitation' => $this->niveauHabilitation
        ];
        
        // 3. Mode API (avec données formatées)
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

    /**
     * Version simplifiée pour le DAO
     */
    public function toArrayForDb()
    {
        // Données pour la table utilisateur
        $userData = [
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'email' => $this->getEmail(),
            'telephone' => $this->getTelephone(),
            'mot_de_passe' => $this->getMotDePasse(),
            'role' => 'inspecteur',
            'statut' => $this->getStatut(),
            'photo_profil' => $this->getPhotoProfil(),
            'date_creation' => $this->getDateCreation() ?? date('Y-m-d H:i:s')
        ];
        
        // Données pour la table inspecteur
        $inspecteurData = [
            'zone_inspection' => $this->zoneInspection,
            'niveau_habilitation' => $this->niveauHabilitation
        ];
        
        return [
            'user' => $userData,
            'inspecteur' => $inspecteurData
        ];
    }

    // === VALIDATION ===

    /**
     * Valider les données
     */
    public function valider(): array
    {
        $erreurs = [];
        
        // Validation du parent
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
        
        // Validation spécifique
        if (empty($this->zoneInspection)) {
            $erreurs[] = 'La zone d\'inspection est obligatoire';
        }
        
        if (!is_numeric($this->niveauHabilitation) || $this->niveauHabilitation < 1 || $this->niveauHabilitation > 4) {
            $erreurs[] = 'Le niveau d\'habilitation doit être entre 1 et 4';
        }
        
        return $erreurs;
    }

    /**
     * Liste des zones d'inspection possibles
     */
    public static function getZonesInspection(): array
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

    /**
     * Créer un objet à partir d'un tableau (factory)
     */
    public static function fromArray(array $data): self
    {
        $inspecteur = new self();
        return $inspecteur->hydrate($data);
    }
}