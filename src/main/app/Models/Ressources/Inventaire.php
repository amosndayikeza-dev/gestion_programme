<?php

namespace App\Models\Ressources;
use DateTime;
use DateInterval;
use PDO;
use Exception;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Inventaire
{
    private $idInventaire;
    private $idMateriel;
    private $dateInventaire;
    private $quantiteConstatee;
    private $quantiteTheorique;
    private $observation;
    private $responsable;

    public function __construct(
        $idInventaire = null,
        $idMateriel = null,
        $dateInventaire = null,
        $quantiteConstatee = null,
        $quantiteTheorique = null,
        $observation = null,
        $responsable = null
    ) {
        $this->idInventaire = $idInventaire;
        $this->idMateriel = $idMateriel;
        $this->dateInventaire = $dateInventaire ?? date('Y-m-d');
        $this->quantiteConstatee = $quantiteConstatee;
        $this->quantiteTheorique = $quantiteTheorique;
        $this->observation = $observation;
        $this->responsable = $responsable;
    }

    // Getters
    public function getIdInventaire() { return $this->idInventaire; }
    public function getIdMateriel() { return $this->idMateriel; }
    public function getDateInventaire() { return $this->dateInventaire; }
    public function getQuantiteConstatee() { return $this->quantiteConstatee; }
    public function getQuantiteTheorique() { return $this->quantiteTheorique; }
    public function getObservation() { return $this->observation; }
    public function getResponsable() { return $this->responsable; }

    // Setters
    public function setIdInventaire($idInventaire) { $this->idInventaire = $idInventaire; }
    public function setIdMateriel($idMateriel) { $this->idMateriel = $idMateriel; }
    public function setDateInventaire($dateInventaire) { $this->dateInventaire = $dateInventaire; }
    public function setQuantiteConstatee($quantiteConstatee) { $this->quantiteConstatee = $quantiteConstatee; }
    public function setQuantiteTheorique($quantiteTheorique) { $this->quantiteTheorique = $quantiteTheorique; }
    public function setObservation($observation) { $this->observation = $observation; }
    public function setResponsable($responsable) { $this->responsable = $responsable; }

    // Méthodes utilitaires
    public function getDifference(): int {
        return $this->quantiteConstatee - $this->quantiteTheorique;
    }

    public function getTauxDifference(): float {
        if ($this->quantiteTheorique == 0) {
            return 0.0;
        }
        
        return ($this->getDifference() / $this->quantiteTheorique) * 100;
    }

    public function estConforme(): bool {
        return $this->quantiteConstatee === $this->quantiteTheorique;
    }

    public function aExcedent(): bool {
        return $this->quantiteConstatee > $this->quantiteTheorique;
    }

    public function aManque(): bool {
        return $this->quantiteConstatee < $this->quantiteTheorique;
    }

    public function getStatut(): string {
        if ($this->estConforme()) {
            return 'Conforme';
        } elseif ($this->aExcedent()) {
            return 'Excédent';
        } else {
            return 'Manquant';
        }
    }

    public function getStatutCouleur(): string {
        $statut = $this->getStatut();
        
        $couleurs = [
            'Conforme' => 'success',
            'Excédent' => 'info',
            'Manquant' => 'danger'
        ];
        
        return $couleurs[$statut] ?? 'secondary';
    }

    public function getGravite(): string {
        $difference = abs($this->getDifference());
        $tauxDifference = abs($this->getTauxDifference());
        
        if ($difference === 0) {
            return 'Aucune';
        } elseif ($difference <= 1 && $tauxDifference <= 5) {
            return 'Mineure';
        } elseif ($difference <= 3 && $tauxDifference <= 15) {
            return 'Modérée';
        } elseif ($difference <= 5 && $tauxDifference <= 25) {
            return 'Significative';
        } else {
            return 'Critique';
        }
    }

    public function getGraviteCouleur(): string {
        $gravite = $this->getGravite();
        
        $couleurs = [
            'Aucune' => 'success',
            'Mineure' => 'info',
            'Modérée' => 'warning',
            'Significative' => 'danger',
            'Critique' => 'dark'
        ];
        
        return $couleurs[$gravite] ?? 'secondary';
    }

    public function necessiteAction(): bool {
        return !$this->estConforme();
    }

    public function necessiteEnquete(): bool {
        $gravite = $this->getGravite();
        return in_array($gravite, ['Significative', 'Critique']);
    }

    public function genererRapport(): array {
        return [
            'id_inventaire' => $this->idInventaire,
            'id_materiel' => $this->idMateriel,
            'date_inventaire' => $this->dateInventaire,
            'quantite_theorique' => $this->quantiteTheorique,
            'quantite_constatee' => $this->quantiteConstatee,
            'difference' => $this->getDifference(),
            'taux_difference' => $this->getTauxDifference(),
            'statut' => $this->getStatut(),
            'statut_couleur' => $this->getStatutCouleur(),
            'gravite' => $this->getGravite(),
            'gravite_couleur' => $this->getGraviteCouleur(),
            'observation' => $this->observation,
            'responsable' => $this->responsable,
            'necessite_action' => $this->necessiteAction(),
            'necessite_enquete' => $this->necessiteEnquete()
        ];
    }

    public function getSuggestions(): array {
        $suggestions = [];
        
        if ($this->aManque()) {
            $manque = abs($this->getDifference());
            $suggestions[] = "Commander {$manque} unité(s) pour combler le manque";
            
            if ($this->necessiteEnquete()) {
                $suggestions[] = "Lancer une enquête sur la disparition de {$manque} unité(s)";
            }
        }
        
        if ($this->aExcedent()) {
            $excedent = $this->getDifference();
            $suggestions[] = "Vérifier si l'excédent de {$excedent} unité(s) peut être réaffecté";
            
            if ($excedent > 5) {
                $suggestions[] = "Mettre à jour le stock théorique dans le système";
            }
        }
        
        if ($this->getGravite() === 'Critique') {
            $suggestions[] = "Bloquer temporairement l'utilisation du matériel";
            $suggestions[] = "Informer immédiatement la direction";
        }
        
        if (empty($this->observation)) {
            $suggestions[] = "Ajouter une observation détaillée pour justifier la différence";
        }
        
        return $suggestions;
    }

    public function calculerImpactFinancier(float $valeurUnitaire): array {
        $difference = $this->getDifference();
        $impact = $difference * $valeurUnitaire;
        
        return [
            'valeur_unitaire' => $valeurUnitaire,
            'difference_quantite' => $difference,
            'impact_financier' => $impact,
            'type_impact' => $impact >= 0 ? 'Gain' : 'Perte',
            'impact_absolu' => abs($impact)
        ];
    }

    public function getPeriodicite(): string {
        $dateInventaire = new DateTime($this->dateInventaire);
        $aujourdHui = new DateTime();
        
        $jours = $aujourdHui->diff($dateInventaire)->days;
        
        if ($jours <= 7) {
            return 'Hebdomadaire';
        } elseif ($jours <= 30) {
            return 'Mensuelle';
        } elseif ($jours <= 90) {
            return 'Trimestrielle';
        } elseif ($jours <= 365) {
            return 'Annuelle';
        } else {
            return 'Exceptionnelle';
        }
    }

    public function estRecent(): bool {
        $jours = (new DateTime())->diff(new DateTime($this->dateInventaire))->days;
        return $jours <= 30;
    }

    public function toArray(): array {
        return [
            'id_inventaire' => $this->idInventaire,
            'id_materiel' => $this->idMateriel,
            'date_inventaire' => $this->dateInventaire,
            'quantite_theorique' => $this->quantiteTheorique,
            'quantite_constatee' => $this->quantiteConstatee,
            'difference' => $this->getDifference(),
            'taux_difference' => $this->getTauxDifference(),
            'observation' => $this->observation,
            'responsable' => $this->responsable,
            'statut' => $this->getStatut(),
            'statut_couleur' => $this->getStatutCouleur(),
            'gravite' => $this->getGravite(),
            'gravite_couleur' => $this->getGraviteCouleur(),
            'est_conforme' => $this->estConforme(),
            'a_excedent' => $this->aExcedent(),
            'a_manque' => $this->aManque(),
            'necessite_action' => $this->necessiteAction(),
            'necessite_enquete' => $this->necessiteEnquete(),
            'suggestions' => $this->getSuggestions(),
            'periodicite' => $this->getPeriodicite(),
            'est_recent' => $this->estRecent()
        ];
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->idMateriel) &&
               !empty($this->dateInventaire) &&
               $this->quantiteConstatee >= 0 &&
               $this->quantiteTheorique >= 0 &&
               !empty($this->responsable);
    }

    // Validation des quantités
    public function validerQuantites(): array {
        $erreurs = [];
        
        if ($this->quantiteConstatee < 0) {
            $erreurs[] = "La quantité constatée ne peut pas être négative";
        }
        
        if ($this->quantiteTheorique < 0) {
            $erreurs[] = "La quantité théorique ne peut pas être négative";
        }
        
        if ($this->quantiteConstatee > 10000) {
            $erreurs[] = "La quantité constatée semble excessivement élevée";
        }
        
        if ($this->quantiteTheorique > 10000) {
            $erreurs[] = "La quantité théorique semble excessivement élevée";
        }
        
        return $erreurs;
    }

    // Clonage pour nouvel inventaire
    public function creerNouveauInventaire(): Inventaire {
        return new self(
            null, // Nouvel ID
            $this->idMateriel,
            date('Y-m-d'), // Date du jour
            null, // Quantité à constater
            $this->quantiteConstatee, // La quantité constatée précédente devient théorique
            null,
            $this->responsable
        );
    }
}
?>
