<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


namespace App\Models\Evaluation;

class Note
{
    private $idNote;
    private $idEleve;
    private $idCours;
    private $idExamen;
    private $valeur;
    private $observation;

    public function __construct(
        $idNote = null,
        $idEleve = null,
        $idCours = null,
        $idExamen = null,
        $valeur = null,
        $observation = null
    ) {
        $this->idNote = $idNote;
        $this->idEleve = $idEleve;
        $this->idCours = $idCours;
        $this->idExamen = $idExamen;
        $this->valeur = $valeur;
        $this->observation = $observation;
    }

    // Getters
    public function getIdNote() { return $this->idNote; }
    public function getIdEleve() { return $this->idEleve; }
    public function getIdCours() { return $this->idCours; }
    public function getIdExamen() { return $this->idExamen; }
    public function getValeur() { return $this->valeur; }
    public function getObservation() { return $this->observation; }

    // Setters
    public function setIdNote($idNote) { $this->idNote = $idNote; }
    public function setIdEleve($idEleve) { $this->idEleve = $idEleve; }
    public function setIdCours($idCours) { $this->idCours = $idCours; }
    public function setIdExamen($idExamen) { $this->idExamen = $idExamen; }
    public function setValeur($valeur) { $this->valeur = $valeur; }
    public function setObservation($observation) { $this->observation = $observation; }

    // Méthodes utilitaires
    public function estValide(): bool {
        return $this->valeur >= 0 && $this->valeur <= 20;
    }

    public function getAppreciation(): string {
        if ($this->valeur >= 16) {
            return 'Excellent';
        } elseif ($this->valeur >= 14) {
            return 'Très bien';
        } elseif ($this->valeur >= 12) {
            return 'Bien';
        } elseif ($this->valeur >= 10) {
            return 'Passable';
        } elseif ($this->valeur >= 8) {
            return 'Insuffisant';
        } else {
            return 'Très insuffisant';
        }
    }

    public function getAppreciationCouleur(): string {
        if ($this->valeur >= 16) {
            return 'success';
        } elseif ($this->valeur >= 14) {
            return 'info';
        } elseif ($this->valeur >= 12) {
            return 'primary';
        } elseif ($this->valeur >= 10) {
            return 'warning';
        } elseif ($this->valeur >= 8) {
            return 'danger';
        } else {
            return 'dark';
        }
    }

    public function estReussi(): bool {
        return $this->valeur >= 10;
    }

    public function getMention(): string {
        if ($this->valeur >= 16) {
            return 'Félicitations';
        } elseif ($this->valeur >= 14) {
            return 'Tableau d\'honneur';
        } elseif ($this->valeur >= 12) {
            return 'Encouragements';
        } elseif ($this->valeur >= 10) {
            return 'Admis';
        } else {
            return 'Ajourné';
        }
    }

    public function getPointsBonus(): float {
        if ($this->valeur >= 18) {
            return 2.0;
        } elseif ($this->valeur >= 16) {
            return 1.5;
        } elseif ($this->valeur >= 14) {
            return 1.0;
        } else {
            return 0.0;
        }
    }

    public function getNoteCoefficient(float $coefficient = 1.0): float {
        return $this->valeur * $coefficient;
    }

    public function getNoteArrondie(int $decimales = 2): float {
        return round($this->valeur, $decimales);
    }

    public function getNoteSur100(): float {
        return ($this->valeur / 20) * 100;
    }

    public function getPourcentageReussite(): float {
        return ($this->valeur / 20) * 100;
    }

    public function getEcartParRapportALaMoyenne(float $moyenneClasse): float {
        return $this->valeur - $moyenneClasse;
    }

    public function getRangEstime(float $moyenneClasse, float $ecartType): float {
        if ($ecartType == 0) {
            return 50.0; // Moyenne si pas de variation
        }
        
        // Calcul du Z-score
        $zScore = ($this->valeur - $moyenneClasse) / $ecartType;
        
        // Conversion en percentile approximatif
        $percentile = 50 + ($zScore * 15); // Approximation
        
        return max(0, min(100, $percentile));
    }

    public function estAuDessusDeLaMoyenne(float $moyenneClasse): bool {
        return $this->valeur > $moyenneClasse;
    }

    public function estDansLaMoyenne(float $moyenneClasse, float $tolerance = 0.5): bool {
        return abs($this->valeur - $moyenneClasse) <= $tolerance;
    }

    public function estEnDessousDeLaMoyenne(float $moyenneClasse): bool {
        return $this->valeur < $moyenneClasse;
    }

    public function getNiveauPerformance(): string {
        if ($this->valeur >= 16) {
            return 'Excellence';
        } elseif ($this->valeur >= 14) {
            return 'Haute performance';
        } elseif ($this->valeur >= 12) {
            return 'Bon niveau';
        } elseif ($this->valeur >= 10) {
            return 'Niveau moyen';
        } elseif ($this->valeur >= 8) {
            return 'Niveau faible';
        } else {
            return 'Niveau très faible';
        }
    }

    public function getSuggestionsAmelioration(): array {
        $suggestions = [];
        
        if ($this->valeur < 8) {
            $suggestions[] = 'Nécessite un soutien personnalisé urgent';
            $suggestions[] = 'Revoir les bases fondamentales';
            $suggestions[] = 'Considérer un tutorat régulier';
        } elseif ($this->valeur < 10) {
            $suggestions[] = 'Renforcer les connaissances de base';
            $suggestions[] = 'Plus d\'exercices pratiques';
            $suggestions[] = 'Participer aux groupes d\'étude';
        } elseif ($this->valeur < 12) {
            $suggestions[] = 'Approfondir les points faibles identifiés';
            $suggestions[] = 'Consolider les acquis';
        } elseif ($this->valeur < 14) {
            $suggestions[] = 'Viser l\'excellence';
            $suggestions[] = 'Explorer des sujets avancés';
        } else {
            $suggestions[] = 'Maintenir le niveau d\'excellence';
            $suggestions[] = 'Aider les autres élèves';
            $suggestions[] = 'Participer à des compétitions';
        }
        
        return $suggestions;
    }

    public function getImpactSurMoyenne(float $ancienneMoyenne, int $nombreTotalMatieres): float {
        $nouvelleMoyenne = ($ancienneMoyenne * ($nombreTotalMatieres - 1) + $this->valeur) / $nombreTotalMatieres;
        return $nouvelleMoyenne - $ancienneMoyenne;
    }

    public function getProgression(Note $notePrecedente = null): array {
        if ($notePrecedente === null) {
            return [
                'progression' => 0,
                'pourcentage' => 0,
                'tendance' => 'Stable',
                'appreciation' => 'Première évaluation'
            ];
        }
        
        $difference = $this->valeur - $notePrecedente->getValeur();
        $pourcentage = $notePrecedente->getValeur() > 0 ? 
            ($difference / $notePrecedente->getValeur()) * 100 : 0;
        
        if ($difference > 1) {
            $tendance = 'En forte progression';
        } elseif ($difference > 0.5) {
            $tendance = 'En progression';
        } elseif ($difference > -0.5) {
            $tendance = 'Stable';
        } elseif ($difference > -1) {
            $tendance = 'En régression';
        } else {
            $tendance = 'En forte régression';
        }
        
        return [
            'progression' => $difference,
            'pourcentage' => round($pourcentage, 2),
            'tendance' => $tendance,
            'appreciation' => $this->getAppreciationProgression($difference)
        ];
    }

    private function getAppreciationProgression(float $difference): string {
        if ($difference > 2) {
            return 'Excellente progression ! Continuez comme ça !';
        } elseif ($difference > 1) {
            return 'Bonne progression, continuez vos efforts';
        } elseif ($difference > 0) {
            return 'Légère progression, persévérez';
        } elseif ($difference > -1) {
            return 'Légère baisse, concentrez-vous davantage';
        } elseif ($difference > -2) {
            return 'Baisse significative, reprenez les bases';
        } else {
            return 'Forte baisse, un soutien est nécessaire';
        }
    }

    public function toArray(): array {
        return [
            'id_note' => $this->idNote,
            'id_eleve' => $this->idEleve,
            'id_cours' => $this->idCours,
            'id_examen' => $this->idExamen,
            'valeur' => $this->valeur,
            'observation' => $this->observation,
            'appreciation' => $this->getAppreciation(),
            'appreciation_couleur' => $this->getAppreciationCouleur(),
            'est_reussi' => $this->estReussi(),
            'mention' => $this->getMention(),
            'points_bonus' => $this->getPointsBonus(),
            'note_sur_100' => $this->getNoteSur100(),
            'pourcentage_reussite' => $this->getPourcentageReussite(),
            'niveau_performance' => $this->getNiveauPerformance(),
            'suggestions_amelioration' => $this->getSuggestionsAmelioration()
        ];
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->idEleve) &&
               !empty($this->idCours) &&
               !empty($this->idExamen) &&
               $this->valeur !== null &&
               $this->estValide();
    }

    // Validation de la cohérence
    public function validerCoherence(): array {
        $erreurs = [];
        
        if ($this->valeur < 0 || $this->valeur > 20) {
            $erreurs[] = 'La note doit être comprise entre 0 et 20';
        }
        
        if (strlen($this->observation ?? '') > 500) {
            $erreurs[] = 'L\'observation ne peut pas dépasser 500 caractères';
        }
        
        return $erreurs;
    }

    // Clonage pour copie
    public function copier(): Note {
        return new Note(
            null, // Nouvel ID
            $this->idEleve,
            $this->idCours,
            $this->idExamen,
            $this->valeur,
            $this->observation
        );
    }
}
?>
