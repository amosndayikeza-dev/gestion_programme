<?php
namespace App\Models\Utilisateur;

use DateTime;

class PrefetEnseignant extends Utilisateur
{
    // === ATTRIBUTS SPÉCIFIQUES (table prefet_enseignant) ===
    private $idPrefet;
    private $departement;           // Département pédagogique
    private $specialite;            // Spécialité dans le département
    private $echelleTraitement;      // 1-10 (échelle salariale)

    // === CONSTRUCTEUR ===
    public function __construct(
        // Paramètres du parent (Utilisateur)
        $idUtilisateur = null,
        $nom = null,
        $prenom = null,
        $email = null,
        $telephone = null,
        $motDePasse = null,
        $role = 'prefet_enseignant',  // Forcé
        $statut = 'actif',
        $dateCreation = null,
        $derniereConnexion = null,
        $photoProfil = null,
        $tokenReset = null,
        $dateExpirationToken = null,
        
        // Paramètres spécifiques PrefetEnseignant
        $idPrefet = null,
        $departement = null,
        $specialite = null,
        $echelleTraitement = 1
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
        $this->idPrefet = $idPrefet ?? $idUtilisateur;
        $this->departement = $departement;
        $this->specialite = $specialite;
        $this->echelleTraitement = $echelleTraitement;
    }

    // === GETTERS SPÉCIFIQUES ===
    public function getIdPrefet() { return $this->idPrefet; }
    public function getDepartement() { return $this->departement; }
    public function getSpecialite() { return $this->specialite; }
    public function getEchelleTraitement() { return $this->echelleTraitement; }

    // === SETTERS SPÉCIFIQUES ===
    public function setIdPrefet($id) { $this->idPrefet = $id; return $this; }
    public function setDepartement($departement) { $this->departement = $departement; return $this; }
    public function setSpecialite($specialite) { $this->specialite = $specialite; return $this; }
    public function setEchelleTraitement($echelle) { $this->echelleTraitement = $echelle; return $this; }

    // === MÉTHODES MÉTIER ===

    /**
     * Obtenir le nom complet
     */
    public function getNomComplet(): string
    {
        return trim($this->getPrenom() . ' ' . $this->getNom());
    }

    /**
     * Obtenir le titre complet
     */
    public function getTitreComplet(): string
    {
        return "Préfet du département {$this->departement} - " . $this->getNomComplet();
    }

    /**
     * Obtenir le libellé de l'échelle de traitement
     */
    public function getEchelleLibelle(): string
    {
        $echelles = [
            1 => 'Échelon 1 (Débutant)',
            2 => 'Échelon 2 (Confirmé)',
            3 => 'Échelon 3 (Avancé)',
            4 => 'Échelon 4 (Senior)',
            5 => 'Échelon 5 (Expert)',
            6 => 'Échelon 6 (Principal)',
            7 => 'Échelon 7 (Hors classe)',
            8 => 'Échelon 8 (Exceptionnel)',
            9 => 'Échelon 9 (Très exceptionnel)',
            10 => 'Échelon 10 (Émérite)'
        ];
        
        return $echelles[$this->echelleTraitement] ?? 'Échelon inconnu';
    }

    /**
     * Obtenir la couleur associée à l'échelle
     */
    public function getEchelleCouleur(): string
    {
        if ($this->echelleTraitement <= 3) return 'info';
        if ($this->echelleTraitement <= 6) return 'success';
        if ($this->echelleTraitement <= 8) return 'warning';
        return 'danger';
    }

    /**
     * Obtenir le salaire approximatif basé sur l'échelle
     */
    public function getSalaireEstime(): float
    {
        $base = 300000; // Salaire de base FCFA
        $coefficient = 1 + ($this->echelleTraitement * 0.1); // +10% par échelon
        
        return round($base * $coefficient, -3); // Arrondi au millier
    }

    /**
     * Vérifier si le préfet peut superviser une matière
     */
    public function peutSuperviser($matiere): bool
    {
        // Peut superviser si dans son département
        return $this->departement === $this->getDepartementPourMatiere($matiere);
    }

    /**
     * Obtenir le nombre d'années d'expérience
     */
    public function getExperience(): int
    {
        if (!$this->getDateCreation()) return 0;
        
        $debut = new DateTime($this->getDateCreation());
        $today = new DateTime();
        
        return $today->diff($debut)->y;
    }

    /**
     * Vérifier si échelon élevé (7+)
     */
    public function estHautEchelon(): bool
    {
        return $this->echelleTraitement >= 7;
    }

    /**
     * Vérifier si peut prétendre à une promotion
     */
    public function peutEtrePromu(): bool
    {
        return $this->echelleTraitement < 10 && $this->getExperience() >= 2;
    }

    /**
     * Obtenir le prochain échelon
     */
    public function getProchainEchelon(): ?int
    {
        if ($this->echelleTraitement >= 10) {
            return null;
        }
        return $this->echelleTraitement + 1;
    }

    /**
     * Obtenir le département pour une matière
     */
    private function getDepartementPourMatiere($matiere): string
    {
        $mapping = [
            'maths' => 'Scientifique',
            'physique' => 'Scientifique',
            'svt' => 'Scientifique',
            'francais' => 'Littéraire',
            'anglais' => 'Linguistique',
            'histoire' => 'Littéraire',
            'philo' => 'Littéraire',
            'eps' => 'Sportif'
        ];
        
        return $mapping[$matiere] ?? 'Autre';
    }

    /**
     * Obtenir le nombre de classes sous sa supervision (via DAO)
     */
    public function getNombreClasses(ClasseDAO $classeDAO): int
    {
        return count($classeDAO->findByDepartement($this->departement));
    }

    /**
     * Obtenir la liste des enseignants du département (via DAO)
     */
    public function getEnseignants(EnseignantDAO $enseignantDAO): array
    {
        return $enseignantDAO->findByDepartement($this->departement);
    }

    // === HYDRATE (tableau → objet) ===

    /**
     * Hydrate l'objet PrefetEnseignant
     */
    public function hydrate(array $data)
    {
        // 1. Hydrate d'abord le parent
        parent::hydrate($data);
        
        // 2. Hydrate les propriétés spécifiques
        $mapping = [
            'id_prefet' => 'idPrefet',
            'departement' => 'departement',
            'specialite' => 'specialite',
            'echelle_traitement' => 'echelleTraitement'
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
            'id_prefet' => $this->idPrefet,
            'departement' => $this->departement,
            'specialite' => $this->specialite,
            'echelle_traitement' => $this->echelleTraitement
        ];
        
        // 3. Mode API (avec données formatées)
        if ($mode === 'api') {
            $specificArray = array_merge($specificArray, [
                'nom_complet' => $this->getNomComplet(),
                'titre_complet' => $this->getTitreComplet(),
                'echelle_libelle' => $this->getEchelleLibelle(),
                'echelle_couleur' => $this->getEchelleCouleur(),
                'salaire_estime' => $this->getSalaireEstime(),
                'experience' => $this->getExperience(),
                'est_haut_echelon' => $this->estHautEchelon(),
                'peut_etre_promu' => $this->peutEtrePromu(),
                'prochain_echelon' => $this->getProchainEchelon()
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
            'role' => 'prefet_enseignant',
            'statut' => $this->getStatut(),
            'photo_profil' => $this->getPhotoProfil(),
            'date_creation' => $this->getDateCreation() ?? date('Y-m-d H:i:s')
        ];
        
        // Données pour la table prefet_enseignant
        $prefetData = [
            'departement' => $this->departement,
            'specialite' => $this->specialite,
            'echelle_traitement' => $this->echelleTraitement
        ];
        
        return [
            'user' => $userData,
            'prefet' => $prefetData
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
        if (empty($this->departement)) {
            $erreurs[] = 'Le département est obligatoire';
        }
        
        if (!is_numeric($this->echelleTraitement) || $this->echelleTraitement < 1 || $this->echelleTraitement > 10) {
            $erreurs[] = "L'échelle de traitement doit être entre 1 et 10";
        }
        
        return $erreurs;
    }

    /**
     * Liste des départements possibles
     */
    public static function getDepartements(): array
    {
        return [
            'Scientifique' => 'Département Scientifique',
            'Littéraire' => 'Département Littéraire',
            'Linguistique' => 'Département Linguistique',
            'Sportif' => 'Département Sportif',
            'Artistique' => 'Département Artistique',
            'Technique' => 'Département Technique'
        ];
    }

    /**
     * Créer un objet à partir d'un tableau (factory)
     */
    public static function fromArray(array $data): self
    {
        $prefet = new self();
        return $prefet->hydrate($data);
    }
}