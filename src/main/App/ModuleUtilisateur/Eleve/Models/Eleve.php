<?php
namespace App\Models\Utilisateur;

use DateTime;
use Exception;

class Eleve extends Utilisateur
{
    // Propriétés spécifiques à l'élève SEULEMENT
    private $idEleve;           // Identifiant unique de l'élève dans la table eleves
    private $idClasse;          // Référence vers la classe
    private $idTuteur;          // Référence vers le parent/tuteur
    private $dateNaissance;
    private $lieuNaissance;
    private $sexe;
    private $adresse;
    private $dateInscription;
    private $matricule;
    
    // Constructeur
    public function __construct(
        $idUtilisateur = null,
        $nom = null,
        $prenom = null,
        $email = null,
        $motDePasse = null,
        $statut = null,
        $telephone = null,
        // Propriétés spécifiques Eleve
        $idEleve = null,
        $idClasse = null,
        $idTuteur = null,
        $dateNaissance = null,
        $lieuNaissance = null,
        $sexe = null,
        $adresse = null,
        $dateInscription = null,
        $matricule = null
    ) {
        // Appel du constructeur parent
        parent::__construct(
            $idUtilisateur,
            $nom,
            $prenom,
            $email,
            $motDePasse,
            'eleve',           // Role fixé à 'eleve'
            $statut,
            $telephone,
            null,              // dateCreation
            null,              // derniereConnexion
            null,              // photoProfil
            null,              // tokenReset
            null               // dateExpirationToken
        );
        
        // Initialisation des propriétés spécifiques
        $this->idEleve = $idEleve;
        $this->idClasse = $idClasse;
        $this->idTuteur = $idTuteur;
        $this->dateNaissance = $dateNaissance;
        $this->lieuNaissance = $lieuNaissance;
        $this->sexe = $sexe;
        $this->adresse = $adresse;
        $this->dateInscription = $dateInscription ?? date('Y-m-d H:i:s');
        $this->matricule = $matricule;
    }
    
    // Getters spécifiques
    public function getIdEleve() { return $this->idEleve; }
    public function getIdClasse() { return $this->idClasse; }
    public function getIdTuteur() { return $this->idTuteur; }
    public function getDateNaissance() { return $this->dateNaissance; }
    public function getLieuNaissance() { return $this->lieuNaissance; }
    public function getSexe() { return $this->sexe; }
    public function getAdresse() { return $this->adresse; }
    public function getDateInscription() { return $this->dateInscription; }
    public function getMatricule() { return $this->matricule; }
    
    // Setters spécifiques
    public function setIdEleve($id) { $this->idEleve = $id; return $this; }
    public function setIdClasse($id) { $this->idClasse = $id; return $this; }
    public function setIdTuteur($id) { $this->idTuteur = $id; return $this; }
    public function setDateNaissance($date) { $this->dateNaissance = $date; return $this; }
    public function setLieuNaissance($lieu) { $this->lieuNaissance = $lieu; return $this; }
    public function setSexe($sexe) { $this->sexe = $sexe; return $this; }
    public function setAdresse($adresse) { $this->adresse = $adresse; return $this; }
    public function setDateInscription($date) { $this->dateInscription = $date; return $this; }
    public function setMatricule($matricule) { $this->matricule = $matricule; return $this; }
    
    // Méthodes métier
    public function getAge() {
        if(!$this->dateNaissance) return null;
        $birthDate = new DateTime($this->dateNaissance);
        $today = new DateTime();
        $age = $today->diff($birthDate);
        return $age->y;
    }
    
    public function isAdult() {
        return $this->getAge() >= 18;
    }
    
    // Override de la méthode hydrate
   public function hydrate(array $data)
{
    // 1. Appelle d'abord l'hydratation du parent (Utilisateur)
    //    Cela remplit nom, prénom, email, etc.
    parent::hydrate($data);
    
    // 2. Mapping spécifique pour les propriétés de l'élève
    //    Car les noms de colonnes BDD sont en snake_case
    //    et les propriétés en camelCase
    $mapping = [
        'id_eleve' => 'idEleve',           // colonne BDD => propriété objet
        'id_classe' => 'idClasse',
        'id_tuteur' => 'idTuteur',
        'date_naissance' => 'dateNaissance',
        'lieu_naissance' => 'lieuNaissance',
        'sexe' => 'sexe',
        'adresse' => 'adresse',
        'date_inscription' => 'dateInscription',
        'matricule' => 'matricule'
    ];
    
    foreach ($mapping as $dbKey => $property) {
        if (isset($data[$dbKey])) {
            // Affectation directe aux propriétés privées
            $this->$property = $data[$dbKey];
        }
    }
    
    return $this;
}
    
    // Override de toArray
    public function toArray() {
        $parentArray = parent::toArray();
        $childArray = [
            'id_eleve' => $this->idEleve,
            'id_classe' => $this->idClasse,
            'id_tuteur' => $this->idTuteur,
            'date_naissance' => $this->dateNaissance,
            'lieu_naissance' => $this->lieuNaissance,
            'sexe' => $this->sexe,
            'adresse' => $this->adresse,
            'date_inscription' => $this->dateInscription,
            'matricule' => $this->matricule
        ];
        
        return array_merge($parentArray, $childArray);
    }
    
    public static function fromDbRow(array $eleveRow, array $utilisateurRow = null)
{
    // Si on a deux tableaux séparés, on les fusionne
    $data = $utilisateurRow ? array_merge($utilisateurRow, $eleveRow) : $eleveRow;
    
    $eleve = new self();  // Crée un nouvel objet Eleve
    $eleve->hydrate($data);  // L'hydrate avec toutes les données
    
    return $eleve;
}
}