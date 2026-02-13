<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\academique;

use DateTime;
use DateInterval;

class AnneeScolaire
{
    private $idAnnee;
    private $libelle;
    private $dateDebut;
    private $dateFin;
    private $active;

    public function __construct(
        $idAnnee = null,
        $libelle = null,
        $dateDebut = null,
        $dateFin = null,
        $active = false
    ) {
        $this->idAnnee = $idAnnee;
        $this->libelle = $libelle;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->active = $active;
    }

    // Getters
    public function getIdAnnee() { return $this->idAnnee; }
    public function getLibelle() { return $this->libelle; }
    public function getDateDebut() { return $this->dateDebut; }
    public function getDateFin() { return $this->dateFin; }
    public function getActive() { return $this->active; }

    // Setters
    public function setIdAnnee($idAnnee) { $this->idAnnee = $idAnnee; }
    public function setLibelle($libelle) { $this->libelle = $libelle; }
    public function setDateDebut($dateDebut) { $this->dateDebut = $dateDebut; }
    public function setDateFin($dateFin) { $this->dateFin = $date->fin; }
    public function setActive($active) { $this->active = $active; }

    // Méthodes utilitaires
    public function getAnneeDebut(): int {
        return (int)substr($this->libelle, 0, 4);
    }

    public function getAnneeFin(): int {
        return (int)substr($this->libelle, 5, 4);
    }

    public function estActive(): bool {
        return $this->active === true;
    }

    public function estEnCours(): bool {
        $aujourdHui = new DateTime();
        $dateDebut = new DateTime($this->dateDebut);
        $dateFin = new DateTime($this->dateFin);
        
        return $aujourdHui >= $dateDebut && $aujourdHui <= $dateFin;
    }

    public function estTerminee(): bool {
        $aujourdHui = new DateTime();
        $dateFin = new DateTime($this->dateFin);
        
        return $aujourdHui > $dateFin;
    }

    public function estAVenir(): bool {
        $aujourdHui = new DateTime();
        $dateDebut = new DateTime($this->dateDebut);
        
        return $aujourdHui < $dateDebut;
    }

    public function getDuree(): int {
        $dateDebut = new DateTime($this->dateDebut);
        $dateFin = new DateTime($this->dateFin);
        
        return $dateFin->diff($dateDebut)->days;
    }

    public function getDureeMois(): int {
        $dateDebut = new DateTime($this->dateDebut);
        $dateFin = new DateTime($this->dateFin);
        
        return $dateFin->diff($dateDebut)->m + ($dateFin->diff($dateDebut)->y * 12);
    }

    public function getTrimestres(): array {
        $trimestres = [];
        $dateDebut = new DateTime($this->dateDebut);
        
        for ($i = 1; $i <= 3; $i++) {
            $debut = clone $dateDebut;
            $debut->add(new DateInterval('P' . (($i - 1) * 4) . 'M'));
            
            $fin = clone $debut;
            $fin->add(new DateInterval('P4M'));
            $fin->sub(new DateInterval('P1D'));
            
            $trimestres[] = [
                'numero' => $i,
                'libelle' => $i . 'er Trimestre',
                'date_debut' => $debut->format('Y-m-d'),
                'date_fin' => $fin->format('Y-m-d'),
                'jours' => $fin->diff($debut)->days
            ];
        }
        
        return $trimestres;
    }

    public function getTrimestreActuel(): ?array {
        $aujourdHui = new DateTime();
        $trimestres = $this->getTrimestres();
        
        foreach ($trimestres as $trimestre) {
            $debut = new DateTime($trimestre['date_debut']);
            $fin = new DateTime($trimestre['date_fin']);
            
            if ($aujourdHui >= $debut && $aujourdHui <= $fin) {
                return $trimestre;
            }
        }
        
        return null;
    }

    public function getNumeroTrimestreActuel(): ?int {
        $trimestreActuel = $this->getTrimestreActuel();
        return $trimestreActuel ? $trimestreActuel['numero'] : null;
    }

    public function getProgression(): float {
        if (!$this->estEnCours()) {
            return $this->estTerminee() ? 100.0 : 0.0;
        }
        
        $aujourdHui = new DateTime();
        $dateDebut = new DateTime($this->dateDebut);
        $dateFin = new DateTime($this->dateFin);
        
        $total = $dateFin->diff($dateDebut)->days;
        $ecoule = $aujourdHui->diff($dateDebut)->days;
        
        return $total > 0 ? ($ecoule / $total) * 100 : 0.0;
    }

    public function getJoursRestants(): int {
        if ($this->estTerminee()) {
            return 0;
        }
        
        $aujourdHui = new DateTime();
        $dateFin = new DateTime($this->dateFin);
        
        return $aujourdHui <= $dateFin ? $aujourdHui->diff($dateFin)->days : 0;
    }

    public function getJoursEcoules(): int {
        if ($this->estAVenir()) {
            return 0;
        }
        
        $aujourdHui = new DateTime();
        $dateDebut = new DateTime($this->dateDebut);
        
        return $aujourdHui >= $dateDebut ? $aujourdHui->diff($dateDebut)->days : 0;
    }

    public function getStatut(): string {
        if ($this->active) {
            return 'Active';
        } elseif ($this->estEnCours()) {
            return 'En cours';
        } elseif ($this->estTerminee()) {
            return 'Terminée';
        } elseif ($this->estAVenir()) {
            return 'À venir';
        } else {
            return 'Inconnue';
        }
    }

    public function getStatutCouleur(): string {
        $statut = $this->getStatut();
        
        $couleurs = [
            'Active' => 'success',
            'En cours' => 'primary',
            'Terminée' => 'secondary',
            'À venir' => 'info',
            'Inconnue' => 'warning'
        ];
        
        return $couleurs[$statut] ?? 'secondary';
    }

    public function getStatutIcone(): string {
        $statut = $this->getStatut();
        
        $icones = [
            'Active' => 'fa-play-circle',
            'En cours' => 'fa-clock',
            'Terminée' => 'fa-check-circle',
            'À venir' => 'fa-calendar-alt',
            'Inconnue' => 'fa-question-circle'
        ];
        
        return $icones[$statut] ?? 'fa-question-circle';
    }

    public function peutEtreActivee(): bool {
        return !$this->estTerminee() && !$this->active;
    }

    public function peutEtreDesactivee(): bool {
        return $this->active;
    }

    public function activer(): bool {
        if (!$this->peutEtreActivee()) {
            return false;
        }
        
        $this->active = true;
        return true;
    }

    public function desactiver(): bool {
        if (!$this->peutEtreDesactivee()) {
            return false;
        }
        
        $this->active = false;
        return true;
    }

    public function getMoisDisponibles(): array {
        $dateDebut = new DateTime($this->dateDebut);
        $dateFin = new DateTime($this->dateFin);
        
        $mois = [];
        $current = clone $dateDebut;
        
        while ($current <= $dateFin) {
            $mois[] = [
                'numero' => (int)$current->format('m'),
                'nom' => $current->format('F'),
                'annee' => (int)$current->format('Y'),
                'libelle' => $current->format('F Y')
            ];
            
            $current->add(new DateInterval('P1M'));
        }
        
        return $mois;
    }

    public function getMoisActuel(): ?array {
        $aujourdHui = new DateTime();
        
        if (!$this->estEnCours()) {
            return null;
        }
        
        $moisDisponibles = $this->getMoisDisponibles();
        
        foreach ($moisDisponibles as $mois) {
            $dateMois = new DateTime($mois['annee'] . '-' . str_pad($mois['numero'], 2, '0', STR_PAD_LEFT) . '-01');
            
            if ($aujourdHui->format('Y-m') === $dateMois->format('Y-m')) {
                return $mois;
            }
        }
        
        return null;
    }

    public function getPeriodesEvaluation(): array {
        return [
            [
                'type' => 'Interrogation',
                'periode' => '1er Trimestre',
                'date_debut' => $this->getTrimestres()[0]['date_debut'],
                'date_fin' => $this->getTrimestres()[0]['date_fin']
            ],
            [
                'type' => 'Devoir',
                'periode' => '1er Trimestre',
                'date_debut' => $this->getTrimestres()[0]['date_debut'],
                'date_fin' => $this->getTrimestres()[0]['date_fin']
            ],
            [
                'type' => 'Composition',
                'periode' => '1er Trimestre',
                'date_debut' => $this->getTrimestres()[0]['date_debut'],
                'date_fin' => $this->getTrimestres()[0]['date_fin']
            ],
            // Répéter pour 2ème et 3ème trimestres
        ];
    }

    public function toArray(): array {
        return [
            'id_annee' => $this->idAnnee,
            'libelle' => $this->libelle,
            'annee_debut' => $this->getAnneeDebut(),
            'annee_fin' => $this->getAnneeFin(),
            'date_debut' => $this->dateDebut,
            'date_fin' => $this->dateFin,
            'active' => $this->active,
            'statut' => $this->getStatut(),
            'statut_couleur' => $this->getStatutCouleur(),
            'statut_icone' => $this->getStatutIcone(),
            'duree_jours' => $this->getDuree(),
            'duree_mois' => $this->getDureeMois(),
            'progression' => $this->getProgression(),
            'jours_ecoules' => $this->getJoursEcoules(),
            'jours_restants' => $this->getJoursRestants(),
            'trimestres' => $this->getTrimestres(),
            'trimestre_actuel' => $this->getTrimestreActuel(),
            'numero_trimestre_actuel' => $this->getNumeroTrimestreActuel(),
            'mois_disponibles' => $this->getMoisDisponibles(),
            'mois_actuel' => $this->getMoisActuel(),
            'est_en_cours' => $this->estEnCours(),
            'est_terminee' => $this->estTerminee(),
            'est_a_venir' => $this->estAVenir(),
            'peut_etre_activee' => $this->peutEtreActivee(),
            'peut_etre_desactivee' => $this->peutEtreDesactivee()
        ];
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->libelle) &&
               !empty($this->dateDebut) &&
               !empty($this->dateFin) &&
               $this->dateDebut < $this->dateFin &&
               preg_match('/^\d{4}-\d{4}$/', $this->libelle);
    }

    // Validation du format du libellé
    public function validerLibelle(): bool {
        return preg_match('/^\d{4}-\d{4}$/', $this->libelle);
    }

    // Validation de la cohérence des dates
    public function validerDates(): bool {
        if (empty($this->dateDebut) || empty($this->dateFin)) {
            return false;
        }
        
        $dateDebut = new DateTime($this->dateDebut);
        $dateFin = new DateTime($this->dateFin);
        
        // Vérifier que la date de fin est après la date de début
        if ($dateFin <= $dateDebut) {
            return false;
        }
        
        // Vérifier la cohérence avec le libellé
        $anneeDebut = (int)substr($this->libelle, 0, 4);
        $anneeFin = (int)substr($this->libelle, 5, 4);
        
        return $dateDebut->format('Y') == $anneeDebut && $dateFin->format('Y') == $anneeFin;
    }

    // Création automatique du libellé à partir des dates
    public static function creerLibelle(DateTime $dateDebut, DateTime $dateFin): string {
        return $dateDebut->format('Y') . '-' . $dateFin->format('Y');
    }

    // Création d'une année scolaire standard
    public static function creerAnneeStandard(int $annee): self {
        $dateDebut = new DateTime("{$annee}-09-01"); // Début en septembre
        $dateFin = new DateTime(($annee + 1) . "-07-31"); // Fin en juillet de l'année suivante
        
        return new self(
            null,
            self::creerLibelle($dateDebut, $dateFin),
            $dateDebut->format('Y-m-d'),
            $dateFin->format('Y-m-d'),
            false
        );
    }
}
?>
