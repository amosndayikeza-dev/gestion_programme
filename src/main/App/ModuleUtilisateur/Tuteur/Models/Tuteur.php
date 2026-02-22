<?php
namespace App\Models\Utilisateur;

use DateTime;

class Tuteur extends Utilisateur
{
    // === ATTRIBUTS SPÉCIFIQUES ===
    private $idTuteur;
    private $profession;
    private $adresse;
    private $lienParental;      // Père, Mère, Tuteur légal
    private $pieceIdentite;     // CNI, Passeport

    // === CONSTRUCTEUR ===
    public function __construct(
        // Paramètres du parent (Utilisateur)
        $idUtilisateur = null,
        $nom = null,
        $prenom = null,
        $email = null,
        $telephone = null,
        $motDePasse = null,
        $role = 'parent',  // Forcé à 'parent'
        $statut = 'actif',
        $dateCreation = null,
        $derniereConnexion = null,
        $photoProfil = null,
        $tokenReset = null,
        $dateExpirationToken = null,
        
        // Paramètres spécifiques Tuteur
        $idTuteur = null,
        $profession = null,
        $adresse = null,
        $lienParental = null,
        $pieceIdentite = null
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
        $this->idTuteur = $idTuteur ?? $idUtilisateur;
        $this->profession = $profession;
        $this->adresse = $adresse;
        $this->lienParental = $lienParental;
        $this->pieceIdentite = $pieceIdentite;
    }

    // === GETTERS SPÉCIFIQUES ===
    public function getIdTuteur() { return $this->idTuteur; }
    public function getProfession() { return $this->profession; }
    public function getAdresse() { return $this->adresse; }
    public function getLienParental() { return $this->lienParental; }
    public function getPieceIdentite() { return $this->pieceIdentite; }

    // === SETTERS SPÉCIFIQUES ===
    public function setIdTuteur($id) { $this->idTuteur = $id; return $this; }
    public function setProfession($profession) { $this->profession = $profession; return $this; }
    public function setAdresse($adresse) { $this->adresse = $adresse; return $this; }
    public function setLienParental($lien) { $this->lienParental = $lien; return $this; }
    public function setPieceIdentite($piece) { $this->pieceIdentite = $piece; return $this; }

    // === MÉTHODES MÉTIER ===

    /**
     * Obtenir le nom complet (hérité + spécifique)
     */
    public function getNomComplet(): string
    {
        return trim($this->getPrenom() . ' ' . $this->getNom());
    }

    /**
     * Obtenir le lien parental formaté
     */
    public function getLienParentalLibelle(): string
    {
        $liens = [
            'pere' => 'Père',
            'mere' => 'Mère',
            'tuteur' => 'Tuteur légal',
            'oncle' => 'Oncle',
            'tante' => 'Tante',
            'grand_parent' => 'Grand-parent',
            'autre' => 'Autre'
        ];
        
        return $liens[$this->lienParental] ?? $this->lienParental ?? 'Non spécifié';
    }

    /**
     * Vérifier si une pièce d'identité est fournie
     */
    public function aPieceIdentite(): bool
    {
        return !empty($this->pieceIdentite);
    }

    /**
     * Obtenir l'adresse complète
     */
    public function getAdresseComplete(): string
    {
        return $this->adresse ?? 'Adresse non renseignée';
    }

    /**
     * Formater le téléphone (hérité)
     */
    public function getTelephoneFormate(): string
    {
        $tel = $this->getTelephone();
        if (!$tel) return 'Non renseigné';
        
        // Format: XX XX XX XX XX
        return preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1 $2 $3 $4 $5', $tel);
    }

    /**
     * Vérifier si le tuteur a des enfants (via DAO)
     */
    public function aEnfants(EleveDAO $eleveDAO): bool
    {
        return count($eleveDAO->findByTuteur($this->idTuteur)) > 0;
    }

    /**
     * Obtenir le nombre d'enfants
     */
    public function getNombreEnfants(EleveDAO $eleveDAO): int
    {
        return count($eleveDAO->findByTuteur($this->idTuteur));
    }

    /**
     * Vérifier si le compte est actif
     */
    public function estActif(): bool
    {
        return $this->getStatut() === 'actif';
    }

    // === HYDRATE (tableau → objet) ===

    /**
     * Hydrate l'objet Tuteur
     */
    public function hydrate(array $data)
    {
        // 1. Hydrate d'abord le parent (Utilisateur)
        parent::hydrate($data);
        
        // 2. Hydrate les propriétés spécifiques
        $mapping = [
            'id_tuteur' => 'idTuteur',
            'profession' => 'profession',
            'adresse' => 'adresse',
            'lien_parental' => 'lienParental',
            'piece_identite' => 'pieceIdentite'
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
        // 1. Récupère le tableau du parent
        $parentArray = parent::toArray();
        
        // 2. Ajoute les propriétés spécifiques
        $specificArray = [
            'id_tuteur' => $this->idTuteur,
            'profession' => $this->profession,
            'adresse' => $this->adresse,
            'lien_parental' => $this->lienParental,
            'piece_identite' => $this->pieceIdentite
        ];
        
        // 3. Mode API (avec données formatées)
        if ($mode === 'api') {
            $specificArray = array_merge($specificArray, [
                'nom_complet' => $this->getNomComplet(),
                'lien_parental_libelle' => $this->getLienParentalLibelle(),
                'telephone_formate' => $this->getTelephoneFormate(),
                'a_piece_identite' => $this->aPieceIdentite()
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
            'role' => 'parent',
            'statut' => $this->getStatut(),
            'photo_profil' => $this->getPhotoProfil()
        ];
        
        // Données pour la table tuteur
        $tuteurData = [
            'profession' => $this->profession,
            'adresse' => $this->adresse,
            'lien_parental' => $this->lienParental,
            'piece_identite' => $this->pieceIdentite
        ];
        
        return [
            'user' => $userData,
            'tuteur' => $tuteurData
        ];
    }

    // === VALIDATION ===

    /**
     * Valider les données du tuteur
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
        if (empty($this->lienParental)) {
            $erreurs[] = 'Le lien parental est obligatoire';
        }
        
        return $erreurs;
    }

    /**
     * Liste des liens parentaux possibles
     */
    public static function getLiensParentaux(): array
    {
        return [
            'pere' => 'Père',
            'mere' => 'Mère',
            'tuteur' => 'Tuteur légal',
            'oncle' => 'Oncle',
            'tante' => 'Tante',
            'grand_parent' => 'Grand-parent',
            'autre' => 'Autre'
        ];
    }

    /**
     * Créer un objet à partir d'un tableau (factory)
     */
    public static function fromArray(array $data): self
    {
        $tuteur = new self();
        return $tuteur->hydrate($data);
    }
}