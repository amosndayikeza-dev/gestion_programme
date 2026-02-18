<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\Evaluation;
use DateTime;
use DateInterval;
use PDO;
use Exception;
class Examen
{
    private $idExamen;
    private $typeExamen;
    private $periode;
    private $dateExamen;
    private $idClasse;
    private $nom;
    private $coeff;
    private $matiere;
    private $enseignant;
    private $eleves = [];
    private $heureDebut;
    private $heureFin;
    private $dateCreation;
    private $dateModification;
    private $idSalle;
    private $images = [];
    private $questions = [];
    private $reponses = [];
    private $anneeScolaire;
    private $nombreDeParticipants;

    public function __construct(
        $idExamen = null,
        $typeExamen = null,
        $periode = null,
        $dateExamen = null,
        $idClasse = null,
        $nom = null,
        $coeff = 1.0,
        $matiere = null,
        $enseignant = null,
        $eleves = [],
        $heureDebut = null,
        $heureFin = null,
        $dateCreation = null,
        $dateModification = null,
        $idSalle = null,
        $anneeScolaire = null,
        $nombreDeParticipants = 0
    ) {
        $this->idExamen = $idExamen;
        $this->typeExamen = $typeExamen;
        $this->periode = $periode;
        $this->dateExamen = $dateExamen;
        $this->idClasse = $idClasse;
        $this->nom = $nom;
        $this->coeff = $coeff;
        $this->matiere = $matiere;
        $this->enseignant = $enseignant;
        $this->eleves = $eleves;
        $this->heureDebut = $heureDebut;
        $this->heureFin = $heureFin;
        $this->dateCreation = $dateCreation ?? date('Y-m-d H:i:s');
        $this->dateModification = $dateModification ?? date('Y-m-d H:i:s');
        $this->idSalle = $idSalle;
        $this->images = [];
        $this->questions = [];
        $this->reponses = [];
        $this->anneeScolaire = $anneeScolaire;
        $this->nombreDeParticipants = $nombreDeParticipants;
    }

    // Getters
    public function getIdExamen() { return $this->idExamen; }
    public function getTypeExamen() { return $this->typeExamen; }
    public function getPeriode() { return $this->periode; }
    public function getDateExamen() { return $this->dateExamen; }
    public function getIdClasse() { return $this->idClasse; }
    public function getNom() { return $this->nom; }
    public function getCoeff() { return $this->coeff; }
    public function getMatiere() { return $this->matiere; }
    public function getEnseignant() { return $this->enseignant; }
    public function getEleves() { return $this->eleves; }
    public function getHeureDebut() { return $this->heureDebut; }
    public function getHeureFin() { return $this->heureFin; }
    public function getDateCreation() { return $this->dateCreation; }
    public function getDateModification() { return $this->dateModification; }
    public function getIdSalle() { return $this->idSalle; }
    public function getImages() { return $this->images; }
    public function getQuestions() { return $this->questions; }
    public function getReponses() { return $this->reponses; }
    public function getAnneeScolaire() { return $this->anneeScolaire; }
    public function getNombreDeParticipants() { return $this->nombreDeParticipants; }

    // Setters
    public function setIdExamen($idExamen) { $this->idExamen = $idExamen; }
    public function setTypeExamen($typeExamen) { $this->typeExamen = $typeExamen; }
    public function setPeriode($periode) { $this->periode = $periode; }
    public function setDateExamen($dateExamen) { $this->dateExamen = $dateExamen; }
    public function setIdClasse($idClasse) { $this->idClasse = $idClasse; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setCoeff($coeff) { $this->coeff = $coeff; }
    public function setMatiere($matiere) { $this->matiere = $matiere; }
    public function setEnseignant($enseignant) { $this->enseignant = $enseignant; }
    public function setEleves($eleves) { $this->eleves = $eleves; }
    public function setHeureDebut($heureDebut) { $this->heureDebut = $heureDebut; }
    public function setHeureFin($heureFin) { $this->heureFin = $heureFin; }
    public function setDateCreation($dateCreation) { $this->dateCreation = $dateCreation; }
    public function setDateModification($dateModification) { $this->dateModification = $dateModification; }
    public function setIdSalle($idSalle) { $this->idSalle = $idSalle; }
    public function setImages($images) { $this->images = $images; }
    public function setQuestions($questions) { $this->questions = $questions; }
    public function setReponses($reponses) { $this->reponses = $reponses; }
    public function setAnneeScolaire($anneeScolaire) { $this->anneeScolaire = $anneeScolaire; }
    public function setNombreDeParticipants($nombreDeParticipants) { $this->nombreDeParticipants = $nombreDeParticipants; }

    // Méthodes utilitaires
    public function getDateExamenFormatee(): string {
        if (empty($this->dateExamen)) {
            return 'Non définie';
        }
        
        $date = new DateTime($this->dateExamen);
        return $date->format('d/m/Y');
    }

    public function getHeureDebutFormatee(): string {
        if (empty($this->heureDebut)) {
            return 'Non définie';
        }
        
        $heure = new DateTime($this->heureDebut);
        return $heure->format('H:i');
    }

    public function getHeureFinFormatee(): string {
        if (empty($this->heureFin)) {
            return 'Non définie';
        }
        
        $heure = new DateTime($this->heureFin);
        return $heure->format('H:i');
    }

    public function getDuree(): string {
        if (empty($this->heureDebut) || empty($this->heureFin)) {
            return 'Non définie';
        }
        
        $debut = new DateTime($this->heureDebut);
        $fin = new DateTime($this->heureFin);
        $diff = $debut->diff($fin);
        
        return $diff->format('%h h %i min');
    }

    public function getDureeMinutes(): int {
        if (empty($this->heureDebut) || empty($this->heureFin)) {
            return 0;
        }
        
        $debut = new DateTime($this->heureDebut);
        $fin = new DateTime($this->heureFin);
        $diff = $debut->diff($fin);
        
        return ($diff->h * 60) + $diff->i;
    }

    public function estInterrogation(): bool {
        return $this->typeExamen === 'Interrogation';
    }

    public function estDevoir(): bool {
        return $this->typeExamen === 'Devoir';
    }

    public function estComposition(): bool {
        return $this->typeExamen === 'Composition';
    }

    public function estExamenFinal(): bool {
        return $this->typeExamen === 'Examen final';
    }

    public function getTypeExamenCouleur(): string {
        $couleurs = [
            'Interrogation' => 'info',
            'Devoir' => 'primary',
            'Composition' => 'warning',
            'Examen final' => 'danger'
        ];
        
        return $couleurs[$this->typeExamen] ?? 'secondary';
    }

    public function getTypeExamenIcone(): string {
        $icones = [
            'Interrogation' => 'fa-question-circle',
            'Devoir' => 'fa-file-alt',
            'Composition' => 'fa-file-contract',
            'Examen final' => 'fa-graduation-cap'
        ];
        
        return $icones[$this->typeExamen] ?? 'fa-question-circle';
    }

    public function getTypesExamenDisponibles(): array {
        return ['Interrogation', 'Devoir', 'Composition', 'Examen final'];
    }

    public function getPeriodeTrimestre(): string {
        if (empty($this->periode)) {
            return 'Non définie';
        }
        
        if (strpos($this->periode, '1er') !== false) {
            return '1er trimestre';
        } elseif (strpos($this->periode, '2ème') !== false) {
            return '2ème trimestre';
        } elseif (strpos($this->periode, '3ème') !== false) {
            return '3ème trimestre';
        }
        
        return $this->periode;
    }

    public function getPeriodeCouleur(): string {
        $periode = $this->getPeriodeTrimestre();
        
        $couleurs = [
            '1er trimestre' => 'primary',
            '2ème trimestre' => 'success',
            '3ème trimestre' => 'warning',
            'Non définie' => 'secondary'
        ];
        
        return $couleurs[$periode] ?? 'secondary';
    }

    public function estAVenir(): bool {
        if (empty($this->dateExamen)) {
            return false;
        }
        
        return new DateTime($this->dateExamen) > new DateTime();
    }

    public function estAujourdhui(): bool {
        if (empty($this->dateExamen)) {
            return false;
        }
        
        $aujourdHui = new DateTime();
        $dateExamen = new DateTime($this->dateExamen);
        
        return $aujourdHui->format('Y-m-d') === $dateExamen->format('Y-m-d');
    }

    public function estPasse(): bool {
        if (empty($this->dateExamen)) {
            return false;
        }
        
        return new DateTime($this->dateExamen) < new DateTime();
    }

    public function getStatut(): string {
        if ($this->estAVenir()) {
            return 'À venir';
        } elseif ($this->estAujourdhui()) {
            return 'Aujourd\'hui';
        } else {
            return 'Passé';
        }
    }

    public function getStatutCouleur(): string {
        $statut = $this->getStatut();
        
        $couleurs = [
            'À venir' => 'info',
            'Aujourd\'hui' => 'warning',
            'Passé' => 'success'
        ];
        
        return $couleurs[$statut] ?? 'secondary';
    }

    public function getStatutIcone(): string {
        $statut = $this->getStatut();
        
        $icones = [
            'À venir' => 'fa-clock',
            'Aujourd\'hui' => 'fa-calendar-day',
            'Passé' => 'fa-check-circle'
        ];
        
        return $icones[$statut] ?? 'fa-question-circle';
    }

    public function getPriorite(): string {
        $priorites = [
            'Interrogation' => 'Faible',
            'Devoir' => 'Moyenne',
            'Composition' => 'Élevée',
            'Examen final' => 'Urgente'
        ];
        
        return $priorites[$this->typeExamen] ?? 'Moyenne';
    }

    public function getPrioriteCouleur(): string {
        $priorite = $this->getPriorite();
        
        $couleurs = [
            'Faible' => 'success',
            'Moyenne' => 'info',
            'Élevée' => 'warning',
            'Urgente' => 'danger'
        ];
        
        return $couleurs[$priorite] ?? 'secondary';
    }

    public function getCoefficientFormate(): string {
        return number_format($this->coeff, 1, ',', ' ');
    }

    public function estCoefficientEleve(): bool {
        return $this->coeff > 2.0;
    }

    public function getCoefficientCouleur(): string {
        if ($this->coeff <= 1.0) {
            return 'info';
        } elseif ($this->coeff <= 2.0) {
            return 'warning';
        } else {
            return 'danger';
        }
    }

    public function aDesQuestions(): bool {
        return !empty($this->questions) && count($this->questions) > 0;
    }

    public function getNombreQuestions(): int {
        return count($this->questions);
    }

    public function aDesImages(): bool {
        return !empty($this->images) && count($this->images) > 0;
    }

    public function getNombreImages(): int {
        return count($this->images);
    }

    public function aDesParticipants(): bool {
        return !empty($this->eleves) && count($this->eleves) > 0;
    }

    public function getNombreParticipants(): int {
        return count($this->eleves);
    }

    public function ajouterEleve($eleveId): void {
        if (!in_array($eleveId, $this->eleves)) {
            $this->eleves[] = $eleveId;
            $this->nombreDeParticipants = count($this->eleves);
        }
    }

    public function retirerEleve($eleveId): void {
        $key = array_search($eleveId, $this->eleves);
        if ($key !== false) {
            unset($this->eleves[$key]);
            $this->eleves = array_values($this->eleves); // Réindexer
            $this->nombreDeParticipants = count($this->eleves);
        }
    }

    public function ajouterQuestion($question): void {
        $this->questions[] = $question;
    }

    public function ajouterImage($image): void {
        $this->images[] = $image;
    }

    public function getInformationsGenerales(): array {
        return [
            'id_examen' => $this->idExamen,
            'nom' => $this->nom,
            'type_examen' => $this->typeExamen,
            'type_examen_couleur' => $this->getTypeExamenCouleur(),
            'type_examen_icone' => $this->getTypeExamenIcone(),
            'periode' => $this->periode,
            'periode_trimestre' => $this->getPeriodeTrimestre(),
            'periode_couleur' => $this->getPeriodeCouleur(),
            'coeff' => $this->coeff,
            'coeff_formate' => $this->getCoefficientFormate(),
            'coeff_couleur' => $this->getCoefficientCouleur(),
            'matiere' => $this->matiere,
            'enseignant' => $this->enseignant,
            'id_classe' => $this->idClasse,
            'annee_scolaire' => $this->anneeScolaire
        ];
    }

    public function getInformationsTemporelles(): array {
        return [
            'date_examen' => $this->dateExamen,
            'date_formatee' => $this->getDateExamenFormatee(),
            'heure_debut' => $this->heureDebut,
            'heure_debut_formatee' => $this->getHeureDebutFormatee(),
            'heure_fin' => $this->heureFin,
            'heure_fin_formatee' => $this->getHeureFinFormatee(),
            'duree' => $this->getDuree(),
            'duree_minutes' => $this->getDureeMinutes(),
            'statut' => $this->getStatut(),
            'statut_couleur' => $this->getStatutCouleur(),
            'statut_icone' => $this->getStatutIcone(),
            'est_a_venir' => $this->estAVenir(),
            'est_aujourd_hui' => $this->estAujourdhui(),
            'est_passe' => $this->estPasse()
        ];
    }

    public function getInformationsContenu(): array {
        return [
            'nombre_questions' => $this->getNombreQuestions(),
            'a_des_questions' => $this->aDesQuestions(),
            'nombre_images' => $this->getNombreImages(),
            'a_des_images' => $this->aDesImages(),
            'nombre_participants' => $this->getNombreParticipants(),
            'a_des_participants' => $this->aDesParticipants(),
            'questions' => $this->questions,
            'images' => $this->images,
            'eleves' => $this->eleves
        ];
    }

    public function getInformationsSysteme(): array {
        return [
            'date_creation' => $this->dateCreation,
            'date_modification' => $this->dateModification,
            'id_salle' => $this->idSalle,
            'priorite' => $this->getPriorite(),
            'priorite_couleur' => $this->getPrioriteCouleur()
        ];
    }

    public function toArray(): array {
        return array_merge(
            $this->getInformationsGenerales(),
            $this->getInformationsTemporelles(),
            $this->getInformationsContenu(),
            $this->getInformationsSysteme()
        );
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->typeExamen) &&
               in_array($this->typeExamen, $this->getTypesExamenDisponibles()) &&
               !empty($this->periode) &&
               !empty($this->dateExamen) &&
               !empty($this->idClasse) &&
               $this->coeff > 0;
    }

    // Validation des dates
    public function validerDates(): array {
        $erreurs = [];
        
        if (empty($this->dateExamen)) {
            $erreurs[] = 'La date de l\'examen est obligatoire';
        } else {
            try {
                $date = new DateTime($this->dateExamen);
                $aujourdHui = new DateTime();
                
                if ($date < $aujourdHui->sub(new DateInterval('P1Y'))) {
                    $erreurs[] = 'La date de l\'examen est trop ancienne';
                }
                
                if ($date > $aujourdHui->add(new DateInterval('P2Y'))) {
                    $erreurs[] = 'La date de l\'examen est trop lointaine';
                }
            } catch (Exception $e) {
                $erreurs[] = 'La date de l\'examen n\'est pas valide';
            }
        }
        
        if (!empty($this->heureDebut) && !empty($this->heureFin)) {
            try {
                $debut = new DateTime($this->heureDebut);
                $fin = new DateTime($this->heureFin);
                
                if ($fin <= $debut) {
                    $erreurs[] = 'L\'heure de fin doit être après l\'heure de début';
                }
                
                $duree = $debut->diff($fin);
                if ($duree->h > 6) {
                    $erreurs[] = 'La durée de l\'examen semble excessive (plus de 6 heures)';
                }
            } catch (Exception $e) {
                $erreurs[] = 'Les heures ne sont pas valides';
            }
        }
        
        return $erreurs;
    }

    // Recherche textuelle
    public function rechercher(string $terme): bool {
        $terme = strtolower(trim($terme));
        
        if (empty($terme)) {
            return false;
        }
        
        // Recherche dans le nom
        if (!empty($this->nom) && strpos(strtolower($this->nom), $terme) !== false) {
            return true;
        }
        
        // Recherche dans la matière
        if (!empty($this->matiere) && strpos(strtolower($this->matiere), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le type
        if (strpos(strtolower($this->typeExamen), $terme) !== false) {
            return true;
        }
        
        // Recherche dans la période
        if (!empty($this->periode) && strpos(strtolower($this->periode), $terme) !== false) {
            return true;
        }
        
        return false;
    }

    // Export pour les rapports
    public function toRapportArray(): array {
        return [
            'ID' => $this->idExamen,
            'Nom' => $this->nom,
            'Type' => $this->typeExamen,
            'Période' => $this->periode,
            'Date' => $this->getDateExamenFormatee(),
            'Heure Début' => $this->getHeureDebutFormatee(),
            'Heure Fin' => $this->getHeureFinFormatee(),
            'Durée' => $this->getDuree(),
            'Coefficient' => $this->getCoefficientFormate(),
            'Matière' => $this->matiere,
            'Enseignant' => $this->enseignant,
            'Classe' => $this->idClasse,
            'Participants' => $this->getNombreParticipants(),
            'Questions' => $this->getNombreQuestions(),
            'Statut' => $this->getStatut(),
            'Priorité' => $this->getPriorite()
        ];
    }

    // Clonage
    public function copier(): Examen {
        return new Examen(
            null, // Nouvel ID
            $this->typeExamen,
            $this->periode,
            $this->dateExamen,
            $this->idClasse,
            $this->nom,
            $this->coeff,
            $this->matiere,
            $this->enseignant,
            $this->eleves,
            $this->heureDebut,
            $this->heureFin,
            null, // Nouvelle date de création
            null, // Nouvelle date de modification
            $this->idSalle,
            $this->anneeScolaire,
            $this->nombreDeParticipants
        );
    }

    // Mise à jour de la date de modification
    public function mettreAJour(): void {
        $this->dateModification = date('Y-m-d H:i:s');
    }
}
?>