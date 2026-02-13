<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\Financiere;
class FraisScolaire
{
    private $idFrais;
    private $libelle;
    private $montant;
    private $obligatoire;
    private $idClasse;
    private $idAnnee;

    public function __construct(
        $idFrais = null,
        $libelle = null,
        $montant = null,
        $obligatoire = true,
        $idClasse = null,
        $idAnnee = null
    ) {
        $this->idFrais = $idFrais;
        $this->libelle = $libelle;
        $this->montant = $montant;
        $this->obligatoire = $obligatoire;
        $this->idClasse = $idClasse;
        $this->idAnnee = $idAnnee;
    }

    // Getters
    public function getIdFrais() { return $this->idFrais; }
    public function getLibelle() { return $this->libelle; }
    public function getMontant() { return $this->montant; }
    public function getObligatoire() { return $this->obligatoire; }
    public function getIdClasse() { return $this->idClasse; }
    public function getIdAnnee() { return $this->idAnnee; }

    // Setters
    public function setIdFrais($idFrais) { $this->idFrais = $idFrais; }
    public function setLibelle($libelle) { $this->libelle = $libelle; }
    public function setMontant($montant) { $this->montant = $montant; }
    public function setObligatoire($obligatoire) { $this->obligatoire = $obligatoire; }
    public function setIdClasse($idClasse) { $this->idClasse = $idClasse; }
    public function setIdAnnee($idAnnee) { $this->idAnnee = $idAnnee; }

    // Méthodes utilitaires
    public function getMontantFormate(): string {
        return number_format($this->montant, 2, ',', ' ') . ' $';
    }

    public function getMontantEnLettres(): string {
        // Conversion simple du montant en lettres (français)
        $unites = ['zéro', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix'];
        
        if ($this->montant < 1000) {
            return $unites[intval($this->montant)] . ' dollars';
        } elseif ($this->montant < 100000) {
            $milliers = intval($this->montant / 1000);
            $reste = $this->montant % 1000;
            
            $texte = $unites[$milliers] . ' mille';
            if ($reste > 0) {
                $texte .= ' ' . $unites[intval($reste)];
            }
            return $texte . ' dollars';
        } else {
            return number_format($this->montant, 2, ',', ' ') . ' dollars';
        }
    }

    public function estObligatoire(): bool {
        return $this->obligatoire === true;
    }

    public function estOptionnel(): bool {
        return $this->obligatoire === false;
    }

    public function getNature(): string {
        return $this->estObligatoire() ? 'Obligatoire' : 'Optionnel';
    }

    public function getNatureCouleur(): string {
        return $this->estObligatoire() ? 'danger' : 'info';
    }

    public function getNatureIcone(): string {
        return $this->estObligatoire() ? 'fa-exclamation-circle' : 'fa-optional';
    }

    public function getCategorie(): string {
        $libelle = strtolower($this->libelle);
        
        if (strpos($libelle, 'inscription') !== false) {
            return 'Inscription';
        } elseif (strpos($libelle, 'scolarité') !== false || strpos($libelle, 'mensualité') !== false) {
            return 'Scolarité';
        } elseif (strpos($libelle, 'cantine') !== false || strpos($libelle, 'repas') !== false) {
            return 'Cantine';
        } elseif (strpos($libelle, 'transport') !== false || strpos($libelle, 'bus') !== false) {
            return 'Transport';
        } elseif (strpos($libelle, 'uniforme') !== false || strpos($libelle, 'tenue') !== false) {
            return 'Uniforme';
        } elseif (strpos($libelle, 'livre') !== false || strpos($libelle, 'fourniture') !== false) {
            return 'Fourniture';
        } elseif (strpos($libelle, 'assurance') !== false) {
            return 'Assurance';
        } elseif (strpos($libitre, 'examen') !== false || strpos($libelle, 'certificat') !== false) {
            return 'Examen';
        } else {
            return 'Autre';
        }
    }

    public function getCategorieCouleur(): string {
        $couleurs = [
            'Inscription' => 'primary',
            'Scolarité' => 'success',
            'Cantine' => 'info',
            'Transport' => 'warning',
            'Uniforme' => 'secondary',
            'Fourniture' => 'dark',
            'Assurance' => 'danger',
            'Examen' => 'primary',
            'Autre' => 'secondary'
        ];
        
        return $couleurs[$this->getCategorie()] ?? 'secondary';
    }

    public function getCategorieIcone(): string {
        $icones = [
            'Inscription' => 'fa-user-plus',
            'Scolarité' => 'fa-graduation-cap',
            'Cantine' => 'fa-utensils',
            'Transport' => 'fa-bus',
            'Uniforme' => 'fa-tshirt',
            'Fourniture' => 'fa-book',
            'Assurance' => 'fa-shield-alt',
            'Examen' => 'fa-file-alt',
            'Autre' => 'fa-question-circle'
        ];
        
        return $icones[$this->getCategorie()] ?? 'fa-question-circle';
    }

    public function getFrequence(): string {
        $libelle = strtolower($this->libelle);
        
        if (strpos($libelle, 'mensuel') !== false || strpos($libelle, 'mensualité') !== false) {
            return 'Mensuel';
        } elseif (strpos($libelle, 'trimestriel') !== false) {
            return 'Trimestriel';
        } elseif (strpos($libelle, 'annuel') !== false) {
            return 'Annuel';
        } elseif (strpos($libelle, 'inscription') !== false) {
            return 'Unique';
        } else {
            return 'Non défini';
        }
    }

    public function getFrequenceCouleur(): string {
        $couleurs = [
            'Mensuel' => 'primary',
            'Trimestriel' => 'success',
            'Annuel' => 'info',
            'Unique' => 'warning',
            'Non défini' => 'secondary'
        ];
        
        return $couleurs[$this->getFrequence()] ?? 'secondary';
    }

    public function getMontantMensuel(): float {
        switch ($this->getFrequence()) {
            case 'Mensuel':
                return $this->montant;
            case 'Trimestriel':
                return $this->montant / 3;
            case 'Annuel':
                return $this->montant / 12;
            case 'Unique':
                return 0; // Pas de montant mensuel
            default:
                return $this->montant;
        }
    }

    public function getMontantTrimestriel(): float {
        switch ($this->getFrequence()) {
            case 'Mensuel':
                return $this->montant * 3;
            case 'Trimestriel':
                return $this->montant;
            case 'Annuel':
                return $this->montant / 4;
            case 'Unique':
                return 0;
            default:
                return $this->montant;
        }
    }

    public function getMontantAnnuel(): float {
        switch ($this->getFrequence()) {
            case 'Mensuel':
                return $this->montant * 12;
            case 'Trimestriel':
                return $this->montant * 4;
            case 'Annuel':
                return $this->montant;
            case 'Unique':
                return $this->montant;
            default:
                return $this->montant;
        }
    }

    public function estElevable(): bool {
        return $this->getFrequence() !== 'Unique';
    }

    public function peutEtrePayeParTranche(): bool {
        return $this->montant > 100 && $this->estElevable();
    }

    public function getNombreTranchesSuggerees(): int {
        if (!$this->peutEtrePayeParTranche()) {
            return 1;
        }
        
        if ($this->montant <= 500) {
            return 2;
        } elseif ($this->montant <= 1000) {
            return 3;
        } elseif ($this->montant <= 2000) {
            return 4;
        } else {
            return 6;
        }
    }

    public function getMontantParTranche(): float {
        $tranches = $this->getNombreTranchesSuggerees();
        return $this->montant / $tranches;
    }

    public function getDelaiPaiement(): string {
        switch ($this->getCategorie()) {
            case 'Inscription':
                return 'Avant le début des cours';
            case 'Scolarité':
                return 'Mensuel (5 premiers jours)';
            case 'Cantine':
                return 'Mensuel';
            case 'Transport':
                return 'Mensuel';
            case 'Uniforme':
                return 'Début d\'année';
            case 'Fourniture':
                return 'Début d\'année';
            case 'Assurance':
                return 'Début d\'année';
            case 'Examen':
                return 'Avant l\'examen';
            default:
                return 'Non défini';
        }
    }

    public function getPriorite(): string {
        $priorites = [
            'Inscription' => 'Urgente',
            'Scolarité' => 'Élevée',
            'Cantine' => 'Moyenne',
            'Transport' => 'Moyenne',
            'Uniforme' => 'Élevée',
            'Fourniture' => 'Élevée',
            'Assurance' => 'Élevée',
            'Examen' => 'Urgente',
            'Autre' => 'Moyenne'
        ];
        
        return $priorites[$this->getCategorie()] ?? 'Moyenne';
    }

    public function getPrioriteCouleur(): string {
        $couleurs = [
            'Urgente' => 'danger',
            'Élevée' => 'warning',
            'Moyenne' => 'info',
            'Faible' => 'success'
        ];
        
        return $couleurs[$this->getPriorite()] ?? 'secondary';
    }

    public function getReductionPossible(): float {
        // Réduction possible en pourcentage selon la catégorie
        $reductions = [
            'Inscription' => 0,      // Pas de réduction
            'Scolarité' => 10,       // 10% max
            'Cantine' => 5,           // 5% max
            'Transport' => 10,       // 10% max
            'Uniforme' => 15,        // 15% max
            'Fourniture' => 5,       // 5% max
            'Assurance' => 0,        // Pas de réduction
            'Examen' => 0,           // Pas de réduction
            'Autre' => 5             // 5% max
        ];
        
        return $reductions[$this->getCategorie()] ?? 0;
    }

    public function getMontantAvecReduction(float $pourcentage): float {
        $pourcentage = min($pourcentage, $this->getReductionPossible());
        return $this->montant * (1 - $pourcentage / 100);
    }

    public function getPenaliteRetard(int $joursRetard): float {
        if ($joursRetard <= 0) {
            return 0.0;
        }
        
        // 5% par mois de retard (environ 0.17% par jour)
        $tauxJournalier = 0.17 / 100;
        return $this->montant * $tauxJournalier * $joursRetard;
    }

    public function getInformationsFinancieres(): array {
        return [
            'montant_formate' => $this->getMontantFormate(),
            'montant_lettres' => $this->getMontantEnLettres(),
            'montant_mensuel' => $this->getMontantMensuel(),
            'montant_trimestriel' => $this->getMontantTrimestriel(),
            'montant_annuel' => $this->getMontantAnnuel(),
            'est_elevable' => $this->estElevable(),
            'peut_etre_paye_par_tranche' => $this->peutEtrePayeParTranche(),
            'nombre_tranches_suggerees' => $this->getNombreTranchesSuggerees(),
            'montant_par_tranche' => $this->getMontantParTranche(),
            'reduction_possible' => $this->getReductionPossible(),
            'penalite_retard' => $this->getPenaliteRetard(30) // 30 jours de retard
        ];
    }

    public function getInformationsGestion(): array {
        return [
            'categorie' => $this->getCategorie(),
            'categorie_couleur' => $this->getCategorieCouleur(),
            'categorie_icone' => $this->getCategorieIcone(),
            'frequence' => $this->getFrequence(),
            'frequence_couleur' => $this->getFrequenceCouleur(),
            'nature' => $this->getNature(),
            'nature_couleur' => $this->getNatureCouleur(),
            'nature_icone' => $this->getNatureIcone(),
            'delai_paiement' => $this->getDelaiPaiement(),
            'priorite' => $this->getPriorite(),
            'priorite_couleur' => $this->getPrioriteCouleur()
        ];
    }

    public function toArray(): array {
        return array_merge(
            [
                'id_frais' => $this->idFrais,
                'libelle' => $this->libelle,
                'montant' => $this->montant,
                'obligatoire' => $this->obligatoire,
                'id_classe' => $this->idClasse,
                'id_annee' => $this->idAnnee
            ],
            $this->getInformationsFinancieres(),
            $this->getInformationsGestion()
        );
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->libelle) &&
               $this->montant > 0 &&
               is_bool($this->obligatoire) &&
               !empty($this->idAnnee);
    }

    // Validation du montant
    public function validerMontant(): array {
        $erreurs = [];
        
        if ($this->montant <= 0) {
            $erreurs[] = 'Le montant doit être supérieur à 0';
        } elseif ($this->montant > 100000) {
            $erreurs[] = 'Le montant semble excessivement élevé';
        }
        
        // Vérification des montants selon la catégorie
        switch ($this->getCategorie()) {
            case 'Inscription':
                if ($this->montant > 500) {
                    $erreurs[] = 'Les frais d\'inscription ne devraient pas dépasser 500$';
                }
                break;
            case 'Scolarité':
                if ($this->montant < 10 || $this->montant > 500) {
                    $erreurs[] = 'La scolarité mensuelle devrait être entre 10$ et 500$';
                }
                break;
        }
        
        return $erreurs;
    }

    // Validation du libellé
    public function validerLibelle(): array {
        $erreurs = [];
        
        if (empty($this->libelle)) {
            $erreurs[] = 'Le libellé est obligatoire';
        } elseif (strlen(trim($this->libelle)) < 3) {
            $erreurs[] = 'Le libellé doit contenir au moins 3 caractères';
        } elseif (strlen($this->libelle) > 100) {
            $erreurs[] = 'Le libellé ne peut pas dépasser 100 caractères';
        }
        
        return $erreurs;
    }

    // Validation de la cohérence
    public function validerCoherence(): array {
        $erreurs = array_merge(
            $this->validerMontant(),
            $this->validerLibelle()
        );
        
        // Vérification de la cohérence entre le montant et la catégorie
        if ($this->getCategorie() === 'Inscription' && $this->getFrequence() === 'Mensuel') {
            $erreurs[] = 'Les frais d\'inscription ne peuvent pas être mensuels';
        }
        
        return $erreurs;
    }

    // Recherche textuelle
    public function rechercher(string $terme): bool {
        $terme = strtolower(trim($terme));
        
        if (empty($terme)) {
            return false;
        }
        
        // Recherche dans le libellé
        if (strpos(strtolower($this->libelle), $terme) !== false) {
            return true;
        }
        
        // Recherche dans la catégorie
        if (strpos(strtolower($this->getCategorie()), $terme) !== false) {
            return true;
        }
        
        // Recherche dans la nature
        if (strpos(strtolower($this->getNature()), $terme) !== false) {
            return true;
        }
        
        // Recherche dans la fréquence
        if (strpos(strtolower($this->getFrequence()), $terme) !== false) {
            return true;
        }
        
        return false;
    }

    // Export pour les rapports
    public function toRapportArray(): array {
        return [
            'ID' => $this->idFrais,
            'Libellé' => $this->libelle,
            'Montant' => $this->getMontantFormate(),
            'Nature' => $this->getNature(),
            'Catégorie' => $this->getCategorie(),
            'Fréquence' => $this->getFrequence(),
            'Obligatoire' => $this->estObligatoire() ? 'Oui' : 'Non',
            'Priorité' => $this->getPriorite(),
            'Réduction possible' => $this->getReductionPossible() . '%',
            'Tranches suggérées' => $this->getNombreTranchesSuggerees(),
            'Montant/tranche' => number_format($this->getMontantParTranche(), 2, ',', ' ') . ' $'
        ];
    }

    // Clonage
    public function copier(): FraisScolaire {
        return new FraisScolaire(
            null, // Nouvel ID
            $this->libelle,
            $this->montant,
            $this->obligatoire,
            $this->idClasse,
            $this->idAnnee
        );
    }

    // Calcul des statistiques
    public function getIndicateurs(): array {
        return [
            'montant' => $this->montant,
            'montant_formate' => $this->getMontantFormate(),
            'categorie' => $this->getCategorie(),
            'nature' => $this->getNature(),
            'frequence' => $this->getFrequence(),
            'priorite' => $this->getPriorite(),
            'est_obligatoire' => $this->estObligatoire(),
            'peut_etre_paye_par_tranche' => $this->peutEtrePayeParTranche(),
            'reduction_possible' => $this->getReductionPossible(),
            'nombre_tranches' => $this->getNombreTranchesSuggerees(),
            'montant_mensuel' => $this->getMontantMensuel(),
            'montant_annuel' => $this->getMontantAnnuel()
        ];
    }
}
?>
