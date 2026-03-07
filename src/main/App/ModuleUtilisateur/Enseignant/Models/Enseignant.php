<?php

namespace App\ModuleUtilisateur\Enseignant\Models;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\ModuleUtilisateur\Models\Utilisateur;
use DateTime;
use DateInterval;
use PDO;
use Exception;
class Enseignant extends Utilisateur 
{
    private $idEnseignant;
    // ✅ SUPPRIMÉES: nom, prenom, email, telephone (les utiliser du parent!)
    private $sexe;
    private $grade;
    private $specialite;
    private $dateEmbauche;

    public function __construct(
        // Paramètres du parent
        $idUtilisateur = null,
        $nom = null,
        $prenom = null,
        $email = null,
        $telephone = null,
        $motDePasse = null,
        $role = 'enseignant',
        $statut = 'actif',
        
        // Paramètres spécifiques
        $idEnseignant = null,
        $sexe = null,
        $grade = null,
        $specialite = null,
        $dateEmbauche = null
    ) {
        // Appel du parent
        parent::__construct(
            $idUtilisateur,
            $nom,
            $prenom,
            $email,
            $telephone,
            $motDePasse,
            $role,
            $statut
        );
        
        // Initialisation spécifique
        $this->idEnseignant = $idEnseignant ?? $idUtilisateur;
        $this->sexe = $sexe;
        $this->grade = $grade;
        $this->specialite = $specialite;
        $this->dateEmbauche = $dateEmbauche ?? date('Y-m-d');
    }

    // Getters
    public function getIdEnseignant() { return $this->idEnseignant; }
    // ✅ Utiliser les getters du parent: getNom(), getPrenom(), getEmail(), getTelephone()
    public function getSexe() { return $this->sexe; }
    public function getGrade() { return $this->grade; }
    public function getSpecialite() { return $this->specialite; }
    public function getDateEmbauche() { return $this->dateEmbauche; }

    // Setters
    public function setIdEnseignant($idEnseignant) { 
        $this->idEnseignant = $idEnseignant;
        $this->setIdUtilisateur($idEnseignant);
        return $this;
    }
    // ✅ Utiliser les setters du parent: setNom(), setPrenom(), setEmail(), setTelephone()
    public function setSexe($sexe) { $this->sexe = $sexe; return $this; }
    public function setGrade($grade) { $this->grade = $grade; return $this; }
    public function setSpecialite($specialite) { $this->specialite = $specialite; return $this; }
    public function setDateEmbauche($dateEmbauche) { $this->dateEmbauche = $dateEmbauche; return $this; }

    // ✅ HYDRATE: Mapper les données de la BDD aux propriétés
    public function hydrate(array $data)
    {
        // Appeler parent::hydrate() pour mapper les colonnes Utilisateur
        parent::hydrate($data);

        // Mapper les colonnes spécifiques à Enseignant
        $mapping = [
            'id_enseignant' => 'idEnseignant',
            'sexe' => 'sexe',
            'grade' => 'grade',
            'specialite' => 'specialite',
            'date_embauche' => 'dateEmbauche'
        ];

        foreach ($mapping as $dbKey => $property) {
            if (isset($data[$dbKey])) {
                // Créer le nom du setter correctement
                $setter = 'set' . ucfirst($property);
                if (method_exists($this, $setter)) {
                    $this->$setter($data[$dbKey]);
                } else {
                    // Si pas de setter, assigner directement à la propriété
                    $this->$property = $data[$dbKey];
                }
            }
        }

        return $this;
    }

    // Méthodes utilitaires
  

    public function getAbreviation(): string {
        $noms = explode(' ', $this->getNom() . ' ' . $this->getPrenom());
        $abreviation = '';
        
        foreach ($noms as $nom) {
            if (!empty($nom)) {
                $abreviation .= strtoupper(substr($nom, 0, 1));
            }
        }
        
        return $abreviation;
    }

    public function estMasculin(): bool {
        return $this->sexe === 'M';
    }

    public function estFeminin(): bool {
        return $this->sexe === 'F';
    }

    public function getGenre(): string {
        return $this->estMasculin() ? 'Masculin' : 'Féminin';
    }

    public function getGenrePronom(): string {
        return $this->estMasculin() ? 'il' : 'elle';
    }

    public function estActif(): bool {
        return $this->getStatut() === 'actif';
    }

    public function estEnConge(): bool {
        return $this->getStatut() === 'en_conge';
    }

    public function estRetraite(): bool {
        return $this->getStatut() === 'retraite';
    }

    public function estSuspendu(): bool {
        return $this->getStatut() === 'suspendu';
    }

    public function getStatutCouleur(): string {
        $couleurs = [
            'actif' => 'success',
            'en_conge' => 'info',
            'retraite' => 'secondary',
            'suspendu' => 'danger'
        ];
        
        return $couleurs[$this->getStatut()] ?? 'secondary';
    }

    public function getStatutIcone(): string {
        $icones = [
            'actif' => 'fa-chalkboard-teacher',
            'en_conge' => 'fa-calendar-alt',
            'retraite' => 'fa-user-clock',
            'suspendu' => 'fa-user-slash'
        ];
        
        return $icones[$this->getStatut()] ?? 'fa-chalkboard-teacher';
    }

    public function getAnciennete(): int {
        $dateEmbauche = new DateTime($this->dateEmbauche);
        $aujourdHui = new DateTime();
        
        return $aujourdHui->diff($dateEmbauche)->y;
    }

    public function getAncienneteMois(): int {
        $dateEmbauche = new DateTime($this->dateEmbauche);
        $aujourdHui = new DateTime();
        
        return $dateEmbauche->diff($aujourdHui)->m + ($dateEmbauche->diff($aujourdHui)->y * 12);
    }

    public function getGradeNiveau(): int {
        // Convertir le grade en niveau numérique (A1=1, A2=2, ..., A10=10)
        return (int)substr($this->grade, 1);
    }

    public function getGradeLibelle(): string {
        $libelles = [
            'A1' => 'Agent de catégorie 1',
            'A2' => 'Agent de catégorie 2',
            'A3' => 'Agent de catégorie 3',
            'A4' => 'Agent de catégorie 4',
            'A5' => 'Agent de catégorie 5',
            'A6' => 'Agent de catégorie 6',
            'A7' => 'Agent de catégorie 7',
            'A8' => 'Agent de catégorie 8',
            'A9' => 'Agent de catégorie 9',
            'A10' => 'Agent de catégorie 10'
        ];
        
        return $libelles[$this->grade] ?? 'Grade inconnu';
    }

    public function getGradeCouleur(): string {
        $niveau = $this->getGradeNiveau();
        
        if ($niveau >= 8) {
            return 'success'; // Grades élevés
        } elseif ($niveau >= 5) {
            return 'info'; // Grades moyens
        } else {
            return 'warning'; // Grades débutants
        }
    }

    public function estGradeEleve(): bool {
        $niveau = $this->getGradeNiveau();
        return $niveau <= 4;
    }

    public function estGradeMoyen(): bool {
        $niveau = $this->getGradeNiveau();
        return $niveau >= 5 && $niveau <= 7;
    }

    public function estGradeSuperieur(): bool {
        $niveau = $this->getGradeNiveau();
        return $niveau >= 8;
    }

    public function peutEncadrer(): bool {
        return $this->estGradeSuperieur();
    }

    public function peutEtreDirecteur(): bool {
        return $this->getGradeNiveau() >= 7;
    }

    public function peutEtreProviseur(): bool {
        return $this->getGradeNiveau() >= 9;
    }

    public function getSpecialitesDisponibles(): array {
        return [
            'Mathématiques',
            'Physique',
            'Chimie',
            'Biologie',
            'Français',
            'Latin',
            'Philosophie',
            'Histoire',
            'Géographie',
            'Anglais',
            'Éducation Civique et Morale',
            'Économie',
            'Comptabilité',
            'Droit',
            'Informatique',
            'Éducation Physique et Sportive',
            'Arts Plastiques',
            'Musique',
            'Travaux Pratiques',
            'Sciences de la Vie et de la Terre'
        ];
    }

    public function getGradesDisponibles(): array {
        return ['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10'];
    }

    public function getStatutsDisponibles(): array {
        return ['actif', 'en_conge', 'retraite', 'suspendu'];
    }

    public function getInformationsProfessionnelles(): array {
        return [
            'grade' => $this->grade,
            'grade_libelle' => $this->getGradeLibelle(),
            'grade_niveau' => $this->getGradeNiveau(),
            'grade_couleur' => $this->getGradeCouleur(),
            'specialite' => $this->specialite,
            'statut' => $this->getStatut(),
            'statut_couleur' => $this->getStatutCouleur(),
            'statut_icone' => $this->getStatutIcone(),
            'date_embauche' => $this->dateEmbauche,
            'anciennete' => $this->getAnciennete(),
            'anciennete_mois' => $this->getAncienneteMois(),
            'est_grade_eleve' => $this->estGradeEleve(),
            'est_grade_moyen' => $this->estGradeMoyen(),
            'est_grade_superieur' => $this->estGradeSuperieur(),
            'peut_encadrer' => $this->peutEncadrer(),
            'peut_etre_directeur' => $this->peutEtreDirecteur(),
            'peut_etre_proviseur' => $this->peutEtreProviseur()
        ];
    }

    public function getInformationsContact(): array {
        return [
            'telephone' => $this->getTelephone(),
            'email' => $this->getEmail(),
            'telephone_valide' => $this->validerTelephone(),
            'email_valide' => $this->validerEmail()
        ];
    }

    public function getInformationsPersonnelles(): array {
        return [
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'abreviation' => $this->getAbreviation(),
            'sexe' => $this->sexe,
            'genre' => $this->getGenre(),
            'genre_pronom' => $this->getGenrePronom()
        ];
    }

    public function getProchainePromotion(): string {
        $niveauActuel = $this->getGradeNiveau();
        
        if ($niveauActuel >= 10) {
            return 'A10 (Grade maximum)';
        }
        
        $prochainNiveau = $niveauActuel + 1;
        return 'A' . $prochainNiveau;
    }

    public function peutEtrePromu(): bool {
        return $this->getGradeNiveau() < 10 && $this->estActif();
    }

    public function promouvoir(): bool {
        if (!$this->peutEtrePromu()) {
            return false;
        }
        
        $niveauActuel = $this->getGradeNiveau();
        $this->grade = 'A' . ($niveauActuel + 1);
        
        return true;
    }

    public function mettreEnConge(): bool {
        if (!$this->estActif()) {
            return false;
        }
        
        $this->setStatut('en_conge');
        return true;
    }

    public function reprendreService(): bool {
        if (!$this->estEnConge()) {
            return false;
        }
        
        $this->setStatut('actif');
        return true;
    }

    public function suspendre(): bool {
        if (!$this->estActif()) {
            return false;
        }
        
        $this->setStatut('suspendu');
        return true;
    }

    public function leverSuspension(): bool {
        if (!$this->estSuspendu()) {
            return false;
        }
        
        $this->setStatut('actif');
        return true;
    }

    public function mettreEnRetraite(): bool {
        if ($this->estRetraite()) {
            return false;
        }
        
        $this->setStatut('retraite');
        return true;
    }

    public function validerTelephone(): bool {
        if (empty($this->getTelephone())) {
            return true; // Téléphone non obligatoire
        }

        // Validation du format téléphonique congolais
        $pattern = '/^(\+243|0)[1-9][0-9]{8}$/';
        return preg_match($pattern, $this->getTelephone());
    }

    public function validerEmail(): bool {
        if (empty($this->getEmail())) {
            return true; // Email non obligatoire
        }

        return filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL) !== false;
    }

    public function validerGrade(): bool {
        return in_array($this->grade, $this->getGradesDisponibles());
    }

    public function validerSpecialite(): bool {
        return in_array($this->specialite, $this->getSpecialitesDisponibles());
    }

    public function toArray(): array {
        return array_merge(
            [
                'id_enseignant' => $this->idEnseignant,
                'nom' => $this->getNom(),
                'prenom' => $this->getPrenom(),
                'sexe' => $this->sexe,
                'grade' => $this->grade,
                'specialite' => $this->specialite,
                'telephone' => $this->getTelephone(),
                'email' => $this->getEmail(),
                'statut' => $this->getStatut(),
                'date_embauche' => $this->dateEmbauche
            ],
            $this->getInformationsPersonnelles(),
            $this->getInformationsContact(),
            $this->getInformationsProfessionnelles()
        );
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->getNom()) &&
               !empty($this->getPrenom()) &&
               in_array($this->sexe, ['M', 'F']) &&
               $this->validerGrade() &&
               $this->validerSpecialite() &&
               in_array($this->getStatut(), ['actif', 'en_conge', 'retraite', 'suspendu']) &&
               $this->validerTelephone() &&
               $this->validerEmail();
    }

    // Recherche textuelle
    public function rechercher(string $terme): bool {
        $terme = strtolower(trim($terme));

        if (empty($terme)) {
            return false;
        }

        // Recherche dans le nom
        if (strpos(strtolower($this->getNom()), $terme) !== false) {
            return true;
        }

        // Recherche dans le prénom
        if (strpos(strtolower($this->getPrenom()), $terme) !== false) {
            return true;
        }

        // Recherche dans la spécialité
        if (strpos(strtolower($this->specialite), $terme) !== false) {
            return true;
        }

        // Recherche dans le grade
        if (strpos(strtolower($this->grade), $terme) !== false) {
            return true;
        }

        // Recherche dans l'email
        if (!empty($this->getEmail()) && strpos(strtolower($this->getEmail()), $terme) !== false) {
            return true;
        }

        return false;
    }

    // Export pour les rapports
    public function toRapportArray(): array {
        return [
            'ID' => $this->idEnseignant,
            'Nom' => $this->getNom(),
            'Prénom' => $this->getPrenom(),
            'Abréviation' => $this->getAbreviation(),
            'Sexe' => $this->getGenre(),
            'Grade' => $this->getGradeLibelle(),
            'Spécialité' => $this->specialite,
            'Téléphone' => $this->getTelephone(),
            'Email' => $this->getEmail(),
            'Statut' => $this->getStatut(),
            'Date d\'embauche' => $this->dateEmbauche,
            'Ancienneté' => $this->getAnciennete() . ' ans'
        ];
    }

    // Calcul de l'expérience
    public function getExperience(): array {
        $aujourdHui = new DateTime();
        $dateEmbauche = new DateTime($this->dateEmbauche);
        
        $difference = $aujourdHui->diff($dateEmbauche);
        
        return [
            'annees' => $difference->y,
            'mois' => $difference->m,
            'jours' => $difference->d,
            'total_mois' => $this->getAncienneteMois(),
            'total_jours' => $difference->days,
            'texte_complet' => $difference->y . ' an(s), ' . $difference->m . ' mois et ' . $difference->d . ' jour(s)'
        ];
    }

    // Éligibilité aux fonctions
    public function getFonctionsPossibles(): array {
        $fonctions = [];
        
        if ($this->peutEncadrer()) {
            $fonctions[] = 'Encadrement pédagogique';
        }
        
        if ($this->peutEtreDirecteur()) {
            $fonctions[] = 'Direction d\'établissement';
        }
        
        if ($this->peutEtreProviseur()) {
            $fonctions[] = 'Proviseur';
        }
        
        if ($this->estActif()) {
            $fonctions[] = 'Enseignement';
        }
        
        return $fonctions;
    }

    // Statistiques de performance
    public function getIndicateursPerformance(): array {
        return [
            'anciennete' => $this->getAnciennete(),
            'niveau_grade' => $this->getGradeNiveau(),
            'experience_mois' => $this->getAncienneteMois(),
            'eligible_promotion' => $this->peutEtrePromu(),
            'prochaine_promotion' => $this->getProchainePromotion(),
            'fonctions_possibles' => $this->getFonctionsPossibles(),
            'stabilite' => $this->getAnciennete() >= 5 ? 'Stable' : 'En période d\'essai'
        ];
    }

    /*public function hydrate(array $data){
        parent::hydrate($data); // Hydrate les propriétés de Utilisateur
            
        $mapping = [
                'id_enseignant'=>'id_enseignant',
        ];
        foreach($mapping as $dbkey => $property){
            if(isset($dat[$dbkey])){
                $this->$property = $data[$dbkey];
            }
        }
        
    return $this;*/
    }

