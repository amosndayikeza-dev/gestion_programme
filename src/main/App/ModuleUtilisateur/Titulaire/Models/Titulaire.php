<?php
namespace App\ModuleUtilisateur\Titulaire\Models;

use DateTime;
use App\ModuleUtilisateur\Models\Utilisateur;
class Titulaire extends Utilisateur
{
    // === ATTRIBUTS SPÉCIFIQUES (table titulaire) ===
    private $idTitulaire;
    private $matierePrincipale;
    private $volumeHoraire;
    private $dateTitularisation;

    // === CONSTRUCTEUR ===
    public function __construct(
        // Paramètres du parent (Utilisateur)
        $idUtilisateur = null,
        $nom = null,
        $prenom = null,
        $email = null,
        $telephone = null,
        $motDePasse = null,
        $role = 'enseignant',  // Forcé
        $statut = 'actif',
        $dateCreation = null,
        $derniereConnexion = null,
        $photoProfil = null,
        $tokenReset = null,
        $dateExpirationToken = null,
        
        // Paramètres spécifiques Titulaire
        $idTitulaire = null,
        $matierePrincipale = null,
        $volumeHoraire = null,
        $dateTitularisation = null
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
        $this->idTitulaire = $idTitulaire ?? $idUtilisateur;
        $this->matierePrincipale = $matierePrincipale;
        $this->volumeHoraire = $volumeHoraire;
        $this->dateTitularisation = $dateTitularisation;
    }

    // === GETTERS SPÉCIFIQUES ===
    public function getIdTitulaire() { return $this->idTitulaire; }
    public function getMatierePrincipale() { return $this->matierePrincipale; }
    public function getVolumeHoraire() { return $this->volumeHoraire; }
    public function getDateTitularisation() { return $this->dateTitularisation; }

    // === SETTERS SPÉCIFIQUES ===
    public function setIdTitulaire($id) { $this->idTitulaire = $id; return $this; }
    public function setMatierePrincipale($matiere) { $this->matierePrincipale = $matiere; return $this; }
    public function setVolumeHoraire($volume) { $this->volumeHoraire = $volume; return $this; }
    public function setDateTitularisation($date) { $this->dateTitularisation = $date; return $this; }

    // === MÉTHODES MÉTIER ===

    /**
     * Obtenir le nom complet
     */
    public function getNomComplet(): string
    {
        return trim($this->getPrenom() . ' ' . $this->getNom());
    }

    /**
     * Obtenir le titre complet (M./Mme + matière)
     */
    public function getTitreComplet(): string
    {
        //$civilite = $this->getSexe() === 'F' ? 'Mme' : 'M.';
        return  "M/Mse" . ' ' . $this->getNomComplet() . ' (' . $this->matierePrincipale . ')';
    }

    /**
     * Calculer l'ancienneté depuis la titularisation
     */
    public function getAnciennete(): int
    {
        if (!$this->dateTitularisation) return 0;
        
        $debut = new DateTime($this->dateTitularisation);
        $today = new DateTime();
        
        return $today->diff($debut)->y;
    }

    /**
     * Vérifier si le volume horaire est valide
     */
    public function volumeHoraireValide(): bool
    {
        return $this->volumeHoraire >= 0 && $this->volumeHoraire <= 40;
    }

    /**
     * Obtenir le statut (titulaire)
     */
    public function getStatutTitulaire(): string
    {
        return 'Titulaire depuis ' . $this->getAnciennete() . ' an(s)';
    }

    /**
     * Vérifier si disponible pour plus d'heures
     */
    public function estDisponible(): bool
    {
        return $this->volumeHoraire < 20; // Exemple: disponible si moins de 20h
    }

    /**
     * Obtenir la date de titularisation formatée
     */
    public function getDateTitularisationFormatee(): string
    {
        if (!$this->dateTitularisation) return '';
        $date = new DateTime($this->dateTitularisation);
        return $date->format('d/m/Y');
    }

    // === HYDRATE (tableau → objet) ===

    /**
     * Hydrate l'objet Titulaire
     */
    public function hydrate(array $data)
    {
        // 1. Hydrate d'abord le parent
        parent::hydrate($data);
        
        // 2. Hydrate les propriétés spécifiques
        $mapping = [
            'id_titulaire' => 'idTitulaire',
            'matiere_principale' => 'matierePrincipale',
            'volume_horaire' => 'volumeHoraire',
            'date_titularisation' => 'dateTitularisation'
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
            'id_titulaire' => $this->idTitulaire,
            'matiere_principale' => $this->matierePrincipale,
            'volume_horaire' => $this->volumeHoraire,
            'date_titularisation' => $this->dateTitularisation
        ];
        
        // 3. Mode API (avec données formatées)
        if ($mode === 'api') {
            $specificArray = array_merge($specificArray, [
                'nom_complet' => $this->getNomComplet(),
                'titre_complet' => $this->getTitreComplet(),
                'anciennete' => $this->getAnciennete(),
                'statut_titulaire' => $this->getStatutTitulaire(),
                'disponible' => $this->estDisponible(),
                'date_titularisation_formatee' => $this->getDateTitularisationFormatee()
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
            'role' => 'enseignant',
            'statut' => $this->getStatut(),
            'photo_profil' => $this->getPhotoProfil(),
            'date_creation' => $this->getDateCreation() ?? date('Y-m-d H:i:s')
        ];
        
        // Données pour la table titulaire
        $titulaireData = [
            'matiere_principale' => $this->matierePrincipale,
            'volume_horaire' => $this->volumeHoraire,
            'date_titularisation' => $this->dateTitularisation
        ];
        
        return [
            'user' => $userData,
            'titulaire' => $titulaireData
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
        if (empty($this->matierePrincipale)) {
            $erreurs[] = 'La matière principale est obligatoire';
        }
        
        if ($this->volumeHoraire && !$this->volumeHoraireValide()) {
            $erreurs[] = 'Le volume horaire doit être entre 0 et 40 heures';
        }
        
        if (empty($this->dateTitularisation)) {
            $erreurs[] = 'La date de titularisation est obligatoire';
        }
        
        return $erreurs;
    }

    /**
     * Liste des matières possibles
     */
    public static function getMatieresPossibles(): array
    {
        return [
            'maths' => 'Mathématiques',
            'physique' => 'Physique-Chimie',
            'svt' => 'SVT',
            'francais' => 'Français',
            'anglais' => 'Anglais',
            'histoire' => 'Histoire-Géo',
            'philo' => 'Philosophie',
            'eps' => 'EPS',
            'espagnol' => 'Espagnol',
            'allemand' => 'Allemand',
            'latin' => 'Latin',
            'si' => 'Sciences de l\'ingénieur'
        ];
    }

    /**
     * Créer un objet à partir d'un tableau (factory)
     */
    public static function fromArray(array $data): self
    {
        $titulaire = new self();
        return $titulaire->hydrate($data);
    }
}