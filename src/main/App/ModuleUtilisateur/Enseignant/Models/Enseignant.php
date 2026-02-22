<?php

namespace App\ModuleUtilisateur\Enseignant\Models;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Models\Utilisateur\Utilisateur;
use DateTime;
use DateInterval;
use PDO;
use Exception;
class Enseignant extends Utilisateur 
{
    private $idEnseignant;
    private $nomComplet;
    private $sexe;
    private $grade;
    private $specialite;
    private $telephone;
    private $email;
    private $statut;
    private $dateEmbauche;

    public function __construct(
        $idEnseignant = null,
        $nomComplet = null,
        $sexe = null,
        $grade = null,
        $specialite = null,
        $telephone = null,
        $email = null,
        $statut = 'Actif',
        $dateEmbauche = null
    ) {
        $this->idEnseignant = $idEnseignant;
        $this->nomComplet = $nomComplet;
        $this->sexe = $sexe;
        $this->grade = $grade;
        $this->specialite = $specialite;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->statut = $statut;
        $this->dateEmbauche = $dateEmbauche ?? date('Y-m-d');
    }

    // Getters
    public function getIdEnseignant() { return $this->idEnseignant; }
    public function getNomComplet() { return $this->nomComplet; }
    public function getSexe() { return $this->sexe; }
    public function getGrade() { return $this->grade; }
    public function getSpecialite() { return $this->specialite; }
    public function getTelephone() { return $this->telephone; }
    public function getEmail() { return $this->email; }
    public function getStatut() { return $this->statut; }
    public function getDateEmbauche() { return $this->dateEmbauche; }

    // Setters
    public function setIdEnseignant($idEnseignant) { $this->idEnseignant = $idEnseignant; }
    public function setNomComplet($nomComplet) { $this->nomComplet = $nomComplet; }
    public function setSexe($sexe) { $this->sexe = $sexe; }
    public function setGrade($grade) { $this->grade = $grade; }
    public function setSpecialite($specialite) { $this->specialite = $specialite; }
    public function setTelephone($telephone) { $this->telephone = $telephone; }
    public function setEmail($email) { $this->email = $email; }
    public function setStatut($statut) { $this->statut = $statut; }
    public function setDateEmbauche($dateEmbauche) { $this->dateEmbauche = $dateEmbauche; }

    // Méthodes utilitaires
    public function getPrenom(): string {
        $noms = explode(' ', $this->nomComplet);
        return end($noms);
    }

    public function getNom(): string {
        $noms = explode(' ', $this->nomComplet);
        return $noms[0] ?? '';
    }

    public function getNomAffichage(): string {
        return ucwords(strtolower($this->nomComplet));
    }

    public function getAbreviation(): string {
        $noms = explode(' ', $this->nomComplet);
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
        return $this->statut === 'Actif';
    }

    public function estEnConge(): bool {
        return $this->statut === 'En congé';
    }

    public function estRetraite(): bool {
        return $this->statut === 'Retraité';
    }

    public function estSuspendu(): bool {
        return $this->statut === 'Suspendu';
    }

    public function getStatutCouleur(): string {
        $couleurs = [
            'Actif' => 'success',
            'En congé' => 'info',
            'Retraité' => 'secondary',
            'Suspendu' => 'danger'
        ];
        
        return $couleurs[$this->statut] ?? 'secondary';
    }

    public function getStatutIcone(): string {
        $icones = [
            'Actif' => 'fa-chalkboard-teacher',
            'En congé' => 'fa-calendar-alt',
            'Retraité' => 'fa-user-clock',
            'Suspendu' => 'fa-user-slash'
        ];
        
        return $icones[$this->statut] ?? 'fa-chalkboard-teacher';
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
        return ['Actif', 'En congé', 'Retraité', 'Suspendu'];
    }

    public function getInformationsProfessionnelles(): array {
        return [
            'grade' => $this->grade,
            'grade_libelle' => $this->getGradeLibelle(),
            'grade_niveau' => $this->getGradeNiveau(),
            'grade_couleur' => $this->getGradeCouleur(),
            'specialite' => $this->specialite,
            'statut' => $this->statut,
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
            'telephone' => $this->telephone,
            'email' => $this->email,
            'telephone_valide' => $this->validerTelephone(),
            'email_valide' => $this->validerEmail()
        ];
    }

    public function getInformationsPersonnelles(): array {
        return [
            'nom_complet' => $this->nomComplet,
            'nom_affichage' => $this->getNomAffichage(),
            'prenom' => $this->getPrenom(),
            'nom' => $this->getNom(),
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
        
        $this->statut = 'En congé';
        return true;
    }

    public function reprendreService(): bool {
        if (!$this->estEnConge()) {
            return false;
        }
        
        $this->statut = 'Actif';
        return true;
    }

    public function suspendre(): bool {
        if (!$this->estActif()) {
            return false;
        }
        
        $this->statut = 'Suspendu';
        return true;
    }

    public function leverSuspension(): bool {
        if (!$this->estSuspendu()) {
            return false;
        }
        
        $this->statut = 'Actif';
        return true;
    }

    public function mettreEnRetraite(): bool {
        if ($this->estRetraite()) {
            return false;
        }
        
        $this->statut = 'Retraité';
        return true;
    }

    public function validerTelephone(): bool {
        if (empty($this->telephone)) {
            return true; // Téléphone non obligatoire
        }
        
        // Validation du format téléphonique congolais
        $pattern = '/^(\+243|0)[1-9][0-9]{8}$/';
        return preg_match($pattern, $this->telephone);
    }

    public function validerEmail(): bool {
        if (empty($this->email)) {
            return true; // Email non obligatoire
        }
        
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
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
                'nom_complet' => $this->nomComplet,
                'sexe' => $this->sexe,
                'grade' => $this->grade,
                'specialite' => $this->specialite,
                'telephone' => $this->telephone,
                'email' => $this->email,
                'statut' => $this->statut,
                'date_embauche' => $this->dateEmbauche
            ],
            $this->getInformationsPersonnelles(),
            $this->getInformationsContact(),
            $this->getInformationsProfessionnelles()
        );
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->nomComplet) &&
               in_array($this->sexe, ['M', 'F']) &&
               $this->validerGrade() &&
               $this->validerSpecialite() &&
               in_array($this->statut, $this->getStatutsDisponibles()) &&
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
        if (strpos(strtolower($this->nomComplet), $terme) !== false) {
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
        if (!empty($this->email) && strpos(strtolower($this->email), $terme) !== false) {
            return true;
        }
        
        return false;
    }

    // Export pour les rapports
    public function toRapportArray(): array {
        return [
            'ID' => $this->idEnseignant,
            'Nom Complet' => $this->getNomAffichage(),
            'Sexe' => $this->getGenre(),
            'Grade' => $this->getGradeLibelle(),
            'Spécialité' => $this->specialite,
            'Téléphone' => $this->telephone,
            'Email' => $this->email,
            'Statut' => $this->statut,
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
}
?>
