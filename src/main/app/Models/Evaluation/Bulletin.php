<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\Evaluation;
use DateTime;
class Bulletin
{
    private $idBulletin;
    private $idEleve;
    private $idClasse;
    private $idAnnee;
    private $trimestre;
    private $moyenneGenerale;
    private $rang;
    private $nombreEleves;
    private $decision;
    private $appreciationGenerale;
    private $dateEmission;

    public function __construct(
        $idBulletin = null,
        $idEleve = null,
        $idClasse = null,
        $idAnnee = null,
        $trimestre = null,
        $moyenneGenerale = null,
        $rang = null,
        $nombreEleves = null,
        $decision = null,
        $appreciationGenerale = null,
        $dateEmission = null
    ) {
        $this->idBulletin = $idBulletin;
        $this->idEleve = $idEleve;
        $this->idClasse = $idClasse;
        $this->idAnnee = $idAnnee;
        $this->trimestre = $trimestre;
        $this->moyenneGenerale = $moyenneGenerale;
        $this->rang = $rang;
        $this->nombreEleves = $nombreEleves;
        $this->decision = $decision;
        $this->appreciationGenerale = $appreciationGenerale;
        $this->dateEmission = $dateEmission ?? date('Y-m-d');
    }

    // Getters
    public function getIdBulletin() { return $this->idBulletin; }
    public function getIdEleve() { return $this->idEleve; }
    public function getIdClasse() { return $this->idClasse; }
    public function getIdAnnee() { return $this->idAnnee; }
    public function getTrimestre() { return $this->trimestre; }
    public function getMoyenneGenerale() { return $this->moyenneGenerale; }
    public function getRang() { return $this->rang; }
    public function getNombreEleves() { return $this->nombreEleves; }
    public function getDecision() { return $this->decision; }
    public function getAppreciationGenerale() { return $this->appreciationGenerale; }
    public function getDateEmission() { return $this->dateEmission; }

    // Setters
    public function setIdBulletin($idBulletin) { $this->idBulletin = $idBulletin; }
    public function setIdEleve($idEleve) { $this->idEleve = $idEleve; }
    public function setIdClasse($idClasse) { $this->idClasse = $idClasse; }
    public function setIdAnnee($idAnnee) { $this->idAnnee = $idAnnee; }
    public function setTrimestre($trimestre) { $this->trimestre = $trimestre; }
    public function setMoyenneGenerale($moyenneGenerale) { $this->moyenneGenerale = $moyenneGenerale; }
    public function setRang($rang) { $this->rang = $rang; }
    public function setNombreEleves($nombreEleves) { $this->nombreEleves = $nombreEleves; }
    public function setDecision($decision) { $this->decision = $decision; }
    public function setAppreciationGenerale($appreciationGenerale) { $this->appreciationGenerale = $appreciationGenerale; }
    public function setDateEmission($dateEmission) { $this->dateEmission = $dateEmission; }

    // Méthodes utilitaires
    public function estAdmis(): bool {
        return in_array($this->decision, ['Admis', 'Passable', 'Assez bien', 'Bien', 'Très bien']);
    }

    public function estAjourne(): bool {
        return $this->decision === 'Ajourné';
    }

    public function estExclu(): bool {
        return $this->decision === 'Exclu';
    }

    public function aReussi(): bool {
        return $this->moyenneGenerale >= 10;
    }

    public function aEchoue(): bool {
        return $this->moyenneGenerale < 10;
    }

    public function getMention(): string {
        if ($this->moyenneGenerale >= 16) {
            return 'Très bien';
        } elseif ($this->moyenneGenerale >= 14) {
            return 'Bien';
        } elseif ($this->moyenneGenerale >= 12) {
            return 'Assez bien';
        } elseif ($this->moyenneGenerale >= 10) {
            return 'Passable';
        } else {
            return 'Ajourné';
        }
    }

    public function getMentionCouleur(): string {
        if ($this->moyenneGenerale >= 16) {
            return 'success';
        } elseif ($this->moyenneGenerale >= 14) {
            return 'info';
        } elseif ($this->moyenneGenerale >= 12) {
            return 'primary';
        } elseif ($this->moyenneGenerale >= 10) {
            return 'warning';
        } else {
            return 'danger';
        }
    }

    public function getDecisionCouleur(): string {
        $couleurs = [
            'Admis' => 'success',
            'Ajourné' => 'danger',
            'Exclu' => 'dark',
            'Passable' => 'warning',
            'Assez bien' => 'info',
            'Bien' => 'primary',
            'Très bien' => 'success'
        ];
        
        return $couleurs[$this->decision] ?? 'secondary';
    }

    public function getPourcentageClasse(): float {
        if ($this->nombreEleves == 0) {
            return 0.0;
        }
        
        return (($this->nombreEleves - $this->rang + 1) / $this->nombreEleves) * 100;
    }

    public function estDansLesPremiers(int $nombre = 10): bool {
        return $this->rang <= $nombre;
    }

    public function estDansLesDerniers(int $nombre = 10): bool {
        return $this->rang > ($this->nombreEleves - $nombre);
    }

    public function estDansLaMoyenne(): bool {
        return $this->rang >= ($this->nombreEleves * 0.3) && $this->rang <= ($this->nombreEleves * 0.7);
    }

    public function getNiveauPerformance(): string {
        if ($this->moyenneGenerale >= 16) {
            return 'Excellence';
        } elseif ($this->moyenneGenerale >= 14) {
            return 'Haute performance';
        } elseif ($this->moyenneGenerale >= 12) {
            return 'Bon niveau';
        } elseif ($this->moyenneGenerale >= 10) {
            return 'Niveau moyen';
        } else {
            return 'Niveau insuffisant';
        }
    }

    public function getEvolutionRang(Bulletin $bulletinPrecedent = null): array {
        if ($bulletinPrecedent === null) {
            return [
                'evolution' => 0,
                'tendance' => 'Stable',
                'appreciation' => 'Première évaluation'
            ];
        }
        
        $evolution = $bulletinPrecedent->getRang() - $this->rang;
        
        if ($evolution > 5) {
            $tendance = 'Forte progression';
        } elseif ($evolution > 2) {
            $tendance = 'Progression';
        } elseif ($evolution > -2) {
            $tendance = 'Stable';
        } elseif ($evolution > -5) {
            $tendance = 'Régression';
        } else {
            $tendance = 'Forte régression';
        }
        
        return [
            'evolution' => $evolution,
            'tendance' => $tendance,
            'appreciation' => $this->getAppreciationEvolution($evolution)
        ];
    }

    private function getAppreciationEvolution(int $evolution): string {
        if ($evolution > 10) {
            return 'Progression exceptionnelle ! Félicitations !';
        } elseif ($evolution > 5) {
            return 'Excellente progression du classement';
        } elseif ($evolution > 2) {
            return 'Bonne progression, continuez vos efforts';
        } elseif ($evolution > -2) {
            return 'Classement stable, maintenez vos efforts';
        } elseif ($evolution > -5) {
            return 'Légère baisse, redoublez d\'efforts';
        } else {
            return 'Baisse significative, une remise en question est nécessaire';
        }
    }

    public function getEvolutionMoyenne(Bulletin $bulletinPrecedent = null): array {
        if ($bulletinPrecedent === null) {
            return [
                'evolution' => 0,
                'pourcentage' => 0,
                'tendance' => 'Stable'
            ];
        }
        
        $evolution = $this->moyenneGenerale - $bulletinPrecedent->getMoyenneGenerale();
        $pourcentage = $bulletinPrecedent->getMoyenneGenerale() > 0 ? 
            ($evolution / $bulletinPrecedent->getMoyenneGenerale()) * 100 : 0;
        
        if ($evolution > 1) {
            $tendance = 'En hausse';
        } elseif ($evolution > -1) {
            $tendance = 'Stable';
        } else {
            $tendance = 'En baisse';
        }
        
        return [
            'evolution' => round($evolution, 2),
            'pourcentage' => round($pourcentage, 2),
            'tendance' => $tendance
        ];
    }

    public function getPointsHonorable(): array {
        $points = [];
        
        if ($this->moyenneGenerale >= 18) {
            $points[] = 'Mention d\'excellence';
        }
        
        if ($this->estDansLesPremiers(5)) {
            $points[] = 'Tableau d\'honneur (Top 5)';
        } elseif ($this->estDansLesPremiers(10)) {
            $points[] = 'Tableau d\'honneur (Top 10)';
        }
        
        if ($this->moyenneGenerale >= 16 && $this->estDansLesPremiers(3)) {
            $points[] = 'Félicitations du jury';
        }
        
        return $points;
    }

    public function getSuggestionsConseil(): array {
        $suggestions = [];
        
        if ($this->moyenneGenerale < 8) {
            $suggestions[] = 'Soutien scolaire obligatoire';
            $suggestions[] = 'Rencontre avec les parents';
            $suggestions[] = 'Plan de remédiation personnalisé';
        } elseif ($this->moyenneGenerale < 10) {
            $suggestions[] = 'Soutien scolaire recommandé';
            $suggestions[] = 'Renforcement dans les matières faibles';
        } elseif ($this->moyenneGenerale < 12) {
            $suggestions[] = 'Encourager à viser l\'excellence';
            $suggestions[] = 'Participation à des activités pédagogiques';
        } else {
            $suggestions[] = 'Maintenir le niveau d\'excellence';
            $suggestions[] = 'Participer à des concours académiques';
            $suggestions[] = 'Aider les camarades en difficulté';
        }
        
        if ($this->getEvolutionRang()['evolution'] < -5) {
            $suggestions[] = 'Analyser les causes de la baisse de performance';
        }
        
        return $suggestions;
    }

    public function getStatutTrimestre(): string {
        if ($this->trimestre === '1er') {
            return 'Premier trimestre';
        } elseif ($this->trimestre === '2ème') {
            return 'Deuxième trimestre';
        } elseif ($this->trimestre === '3ème') {
            return 'Troisième trimestre';
        } else {
            return 'Trimestre inconnu';
        }
    }

    public function getPeriodeEvaluation(): string {
        return $this->getStatutTrimestre() . ' - Année ' . substr($this->dateEmission, 0, 4);
    }

    public function estRecent(): bool {
        $jours = (new DateTime())->diff(new DateTime($this->dateEmission))->days;
        return $jours <= 30;
    }

    public function getAgeBulletin(): int {
        return (new DateTime())->diff(new DateTime($this->dateEmission))->days;
    }

    public function peutEtreModifie(): bool {
        // Un bulletin peut être modifié dans les 15 jours après émission
        return $this->getAgeBulletin() <= 15;
    }

    public function getStatutModification(): string {
        if ($this->peutEtreModifie()) {
            return 'Modifiable';
        } else {
            return 'Archivé';
        }
    }

    public function getStatutModificationCouleur(): string {
        return $this->peutEtreModifie() ? 'warning' : 'secondary';
    }

    public function toArray(): array {
        return [
            'id_bulletin' => $this->idBulletin,
            'id_eleve' => $this->idEleve,
            'id_classe' => $this->idClasse,
            'id_annee' => $this->idAnnee,
            'trimestre' => $this->trimestre,
            'moyenne_generale' => $this->moyenneGenerale,
            'rang' => $this->rang,
            'nombre_eleves' => $this->nombreEleves,
            'decision' => $this->decision,
            'appreciation_generale' => $this->appreciationGenerale,
            'date_emission' => $this->dateEmission,
            'mention' => $this->getMention(),
            'mention_couleur' => $this->getMentionCouleur(),
            'decision_couleur' => $this->getDecisionCouleur(),
            'est_admis' => $this->estAdmis(),
            'est_ajourne' => $this->estAjourne(),
            'est_exclu' => $this->estExclu(),
            'a_reussi' => $this->aReussi(),
            'pourcentage_classe' => $this->getPourcentageClasse(),
            'est_dans_les_premiers' => $this->estDansLesPremiers(10),
            'est_dans_les_derniers' => $this->estDansLesDerniers(10),
            'est_dans_la_moyenne' => $this->estDansLaMoyenne(),
            'niveau_performance' => $this->getNiveauPerformance(),
            'points_honorable' => $this->getPointsHonorable(),
            'suggestions_conseil' => $this->getSuggestionsConseil(),
            'statut_trimestre' => $this->getStatutTrimestre(),
            'periode_evaluation' => $this->getPeriodeEvaluation(),
            'est_recent' => $this->estRecent(),
            'peut_etre_modifie' => $this->peutEtreModifie(),
            'statut_modification' => $this->getStatutModification(),
            'statut_modification_couleur' => $this->getStatutModificationCouleur()
        ];
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->idEleve) &&
               !empty($this->idClasse) &&
               !empty($this->idAnnee) &&
               !empty($this->trimestre) &&
               in_array($this->trimestre, ['1er', '2ème', '3ème']) &&
               $this->moyenneGenerale !== null &&
               $this->moyenneGenerale >= 0 &&
               $this->moyenneGenerale <= 20 &&
               !empty($this->decision) &&
               in_array($this->decision, ['Admis', 'Ajourné', 'Exclu', 'Passable', 'Assez bien', 'Bien', 'Très bien']);
    }

    // Validation de la cohérence
    public function validerCoherence(): array {
        $erreurs = [];
        
        if ($this->rang < 1 || $this->rang > $this->nombreEleves) {
            $erreurs[] = 'Le rang doit être compris entre 1 et le nombre total d\'élèves';
        }
        
        if ($this->moyenneGenerale < 0 || $this->moyenneGenerale > 20) {
            $erreurs[] = 'La moyenne générale doit être comprise entre 0 et 20';
        }
        
        if ($this->moyenneGenerale < 10 && $this->estAdmis()) {
            $erreurs[] = 'Incohérence : moyenne < 10 mais décision d\'admission';
        }
        
        if ($this->moyenneGenerale >= 10 && $this->estAjourne()) {
            $erreurs[] = 'Incohérence : moyenne >= 10 mais décision d\'ajournement';
        }
        
        return $erreurs;
    }

    // Calcul automatique de la décision basée sur la moyenne
    public function calculerDecision(): string {
        if ($this->moyenneGenerale >= 16) {
            return 'Très bien';
        } elseif ($this->moyenneGenerale >= 14) {
            return 'Bien';
        } elseif ($this->moyenneGenerale >= 12) {
            return 'Assez bien';
        } elseif ($this->moyenneGenerale >= 10) {
            return 'Passable';
        } else {
            return 'Ajourné';
        }
    }

    // Génération automatique de l'appréciation
    public function genererAppreciation(): string {
        $appreciation = '';
        
        // Basée sur la moyenne
        if ($this->moyenneGenerale >= 16) {
            $appreciation = 'Excellent travail, élève brillant et très studieux. ';
        } elseif ($this->moyenneGenerale >= 14) {
            $appreciation = 'Très bon niveau, élève sérieux et régulier dans son travail. ';
        } elseif ($this->moyenneGenerale >= 12) {
            $appreciation = 'Bon niveau général, des efforts sont encore possibles. ';
        } elseif ($this->moyenneGenerale >= 10) {
            $appreciation = 'Niveau satisfaisant, doit persévérer pour s\'améliorer. ';
        } else {
            $appreciation = 'Niveau insuffisant, un effort particulier est nécessaire. ';
        }
        
        // Basée sur le rang
        if ($this->estDansLesPremiers(5)) {
            $appreciation .= 'Excellente position dans la classe. ';
        } elseif ($this->estDansLesDerniers(10)) {
            $appreciation .= 'Doit améliorer sa position dans la classe. ';
        }
        
        return $appreciation;
    }
}
?>
