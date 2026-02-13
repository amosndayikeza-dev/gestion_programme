<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


namespace App\Models\Financiere;
use DateTime;
use DateInterval;

class Paiement
{
    private $idPaiement;
    private $idEleve;
    private $idFrais;
    private $montantPaye;
    private $datePaiement;
    private $modePaiement;
    private $reference;
    private $statut;

    public function __construct(
        $idPaiement = null,
        $idEleve = null,
        $idFrais = null,
        $montantPaye = null,
        $datePaiement = null,
        $modePaiement = null,
        $reference = null,
        $statut = 'Partiel'
    ) {
        $this->idPaiement = $idPaiement;
        $this->idEleve = $idEleve;
        $this->idFrais = $idFrais;
        $this->montantPaye = $montantPaye;
        $this->datePaiement = $datePaiement ?? date('Y-m-d');
        $this->modePaiement = $modePaiement;
        $this->reference = $reference;
        $this->statut = $statut;
    }

    // Getters
    public function getIdPaiement() { return $this->idPaiement; }
    public function getIdEleve() { return $this->idEleve; }
    public function getIdFrais() { return $this->idFrais; }
    public function getMontantPaye() { return $this->montantPaye; }
    public function getDatePaiement() { return $this->datePaiement; }
    public function getModePaiement() { return $this->modePaiement; }
    public function getReference() { return $this->reference; }
    public function getStatut() { return $this->statut; }

    // Setters
    public function setIdPaiement($idPaiement) { $this->idPaiement = $idPaiement; }
    public function setIdEleve($idEleve) { $this->idEleve = $idEleve; }
    public function setIdFrais($idFrais) { $this->idFrais = $idFrais; }
    public function setMontantPaye($montantPaye) { $this->montantPaye = $montantPaye; }
    public function setDatePaiement($datePaiement) { $this->datePaiement = $datePaiement; }
    public function setModePaiement($modePaiement) { $this->modePaiement = $modePaiement; }
    public function setReference($reference) { $this->reference = $reference; }
    public function setStatut($statut) { $this->statut = $statut; }

    // Méthodes utilitaires
    public function estComplet(): bool {
        return $this->statut === 'Complet';
    }

    public function estPartiel(): bool {
        return $this->statut === 'Partiel';
    }

    public function estEnRetard(): bool {
        return $this->statut === 'En retard';
    }

    public function estRecent(): bool {
        $jours = (new DateTime())->diff(new DateTime($this->datePaiement))->days;
        return $jours <= 7;
    }

    public function getStatutCouleur(): string {
        $couleurs = [
            'Complet' => 'success',
            'Partiel' => 'warning',
            'En retard' => 'danger'
        ];
        
        return $couleurs[$this->statut] ?? 'secondary';
    }

    public function getStatutIcone(): string {
        $icones = [
            'Complet' => 'fa-check-circle',
            'Partiel' => 'fa-exclamation-triangle',
            'En retard' => 'fa-clock'
        ];
        
        return $icones[$this->statut] ?? 'fa-question-circle';
    }

    public function getModePaiementCouleur(): string {
        $couleurs = [
            'Espèces' => 'success',
            'Banque' => 'info',
            'Mobile Money' => 'primary',
            'Virement' => 'warning'
        ];
        
        return $couleurs[$this->modePaiement] ?? 'secondary';
    }

    public function getModePaiementIcone(): string {
        $icones = [
            'Espèces' => 'fa-money-bill-wave',
            'Banque' => 'fa-university',
            'Mobile Money' => 'fa-mobile-alt',
            'Virement' => 'fa-exchange-alt'
        ];
        
        return $icones[$this->modePaiement] ?? 'fa-credit-card';
    }

    public function getModesPaiementDisponibles(): array {
        return ['Espèces', 'Banque', 'Mobile Money', 'Virement'];
    }

    public function getStatutsDisponibles(): array {
        return ['Complet', 'Partiel', 'En retard'];
    }

    public function getMontantFormate(): string {
        return number_format($this->montantPaye, 2, ',', ' ') . ' $';
    }

    public function getDatePaiementFormatee(): string {
        $date = new DateTime($this->datePaiement);
        return $date->format('d/m/Y');
    }

    public function getDatePaiementComplete(): string {
        $date = new DateTime($this->datePaiement);
        return $date->format('d/m/Y à H:i');
    }

    public function getAgePaiement(): int {
        return (new DateTime())->diff(new DateTime($this->datePaiement))->days;
    }

    public function estDansMois(string $moisAnnee): bool {
        $datePaiement = new DateTime($this->datePaiement);
        return $datePaiement->format('Y-m') === $moisAnnee;
    }

    public function estDansAnnee(int $annee): bool {
        $datePaiement = new DateTime($this->datePaiement);
        return (int)$datePaiement->format('Y') === $annee;
    }

    public function estDansTrimestre(string $trimestre, int $annee): bool {
        $datePaiement = new DateTime($this->datePaiement);
        $mois = (int)$datePaiement->format('m');
        
        switch ($trimestre) {
            case '1er':
                return $mois >= 9 && $mois <= 11 && (int)$datePaiement->format('Y') === $annee;
            case '2ème':
                return $mois >= 12 || ($mois <= 2 && (int)$datePaiement->format('Y') === $annee + 1);
            case '3ème':
                return $mois >= 3 && $mois <= 5 && (int)$datePaiement->format('Y') === $annee + 1;
            default:
                return false;
        }
    }

    public function genererReference(): string {
        if (!empty($this->reference)) {
            return $this->reference;
        }
        
        $date = new DateTime($this->datePaiement);
        $prefixe = 'PAY';
        
        switch ($this->modePaiement) {
            case 'Espèces':
                $prefixe .= 'ESP';
                break;
            case 'Banque':
                $prefixe .= 'BAN';
                break;
            case 'Mobile Money':
                $prefixe .= 'MM';
                break;
            case 'Virement':
                $prefixe .= 'VIR';
                break;
        }
        
        return $prefixe . '-' . $date->format('Ymd') . '-' . str_pad($this->idEleve, 4, '0', STR_PAD_LEFT);
    }

    public function validerReference(): bool {
        if (empty($this->reference)) {
            return true; // Référence non obligatoire
        }
        
        // Format: MODE-YYYYMMDD-ID (ex: MM-20240115-1234)
        $pattern = '/^(ESP|BAN|MM|VIR)-\d{8}-\d{4}$/';
        return preg_match($pattern, $this->reference);
    }

    public function estModePaiementMobile(): bool {
        return $this->modePaiement === 'Mobile Money';
    }

    public function estModePaiementBancaire(): bool {
        return in_array($this->modePaiement, ['Banque', 'Virement']);
    }

    public function estModePaiementEspece(): bool {
        return $this->modePaiement === 'Espèces';
    }

    public function getDetailsModePaiement(): array {
        return [
            'mode' => $this->modePaiement,
            'icone' => $this->getModePaiementIcone(),
            'couleur' => $this->getModePaiementCouleur(),
            'est_mobile' => $this->estModePaiementMobile(),
            'est_bancaire' => $this->estModePaiementBancaire(),
            'est_espece' => $this->estModePaiementEspece()
        ];
    }

    public function getInformationsPaiement(): array {
        return [
            'montant_paye' => $this->montantPaye,
            'montant_formate' => $this->getMontantFormate(),
            'date_paiement' => $this->datePaiement,
            'date_formatee' => $this->getDatePaiementFormatee(),
            'date_complete' => $this->getDatePaiementComplete(),
            'reference' => $this->reference,
            'reference_generee' => $this->genererReference(),
            'reference_valide' => $this->validerReference(),
            'age_paiement' => $this->getAgePaiement(),
            'est_recent' => $this->estRecent()
        ];
    }

    public function getStatutDetails(): array {
        return [
            'statut' => $this->statut,
            'icone' => $this->getStatutIcone(),
            'couleur' => $this->getStatutCouleur(),
            'est_complet' => $this->estComplet(),
            'est_partiel' => $this->estPartiel(),
            'est_en_retard' => $this->estEnRetard()
        ];
    }

    public function peutEtreRembourse(): bool {
        return $this->estRecent() && !$this->estEnRetard();
    }

    public function peutEtreModifie(): bool {
        return $this->estRecent();
    }

    public function peutEtreAnnule(): bool {
        return $this->estRecent();
    }

    public function getPériodePaiement(): string {
        $date = new DateTime($this->datePaiement);
        $mois = (int)$date->format('m');
        
        if ($mois >= 9 && $mois <= 11) {
            return '1er Trimestre';
        } elseif ($mois >= 12 || $mois <= 2) {
            return '2ème Trimestre';
        } elseif ($mois >= 3 && $mois <= 5) {
            return '3ème Trimestre';
        } else {
            return 'Vacances';
        }
    }

    public function getAnneeScolaire(): string {
        $date = new DateTime($this->datePaiement);
        $annee = (int)$date->format('Y');
        $mois = (int)$date->format('m');
        
        if ($mois >= 9) {
            return $annee . '-' . ($annee + 1);
        } else {
            return ($annee - 1) . '-' . $annee;
        }
    }

    public function getInformationsPeriodiques(): array {
        return [
            'periode_paiement' => $this->getPériodePaiement(),
            'annee_scolaire' => $this->getAnneeScolaire(),
            'mois' => (new DateTime($this->datePaiement))->format('F'),
            'trimestre' => $this->getPériodePaiement()
        ];
    }

    public function calculerPenaliteRetard(int $joursRetard, float $tauxPenalite = 0.05): float {
        if (!$this->estEnRetard()) {
            return 0.0;
        }
        
        return $this->montantPaye * $tauxPenalite * $joursRetard;
    }

    public function getMontantAvecPenalite(): array {
        $penalite = 0.0;
        
        if ($this->estEnRetard()) {
            // Calcul basé sur le nombre de jours de retard (à adapter selon les règles)
            $joursRetard = $this->getAgePaiement();
            $penalite = $this->calculerPenaliteRetard($joursRetard);
        }
        
        return [
            'montant_original' => $this->montantPaye,
            'penalite' => $penalite,
            'montant_total' => $this->montantPaye + $penalite,
            'penalite_formatee' => number_format($penalite, 2, ',', ' ') . ' $',
            'total_formate' => number_format($this->montantPaye + $penalite, 2, ',', ' ') . ' $'
        ];
    }

    public function toArray(): array {
        return array_merge(
            [
                'id_paiement' => $this->idPaiement,
                'id_eleve' => $this->idEleve,
                'id_frais' => $this->idFrais,
                'mode_paiement' => $this->modePaiement,
                'statut' => $this->statut
            ],
            $this->getInformationsPaiement(),
            $this->getDetailsModePaiement(),
            $this->getStatutDetails(),
            $this->getInformationsPeriodiques()
        );
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->idEleve) &&
               !empty($this->idFrais) &&
               $this->montantPaye > 0 &&
               in_array($this->modePaiement, $this->getModesPaiementDisponibles()) &&
               in_array($this->statut, $this->getStatutsDisponibles()) &&
               $this->validerReference();
    }

    // Validation du montant
    public function validerMontant(): array {
        $erreurs = [];
        
        if ($this->montantPaye <= 0) {
            $erreurs[] = 'Le montant doit être supérieur à 0';
        }
        
        if ($this->montantPaye > 10000000) { // 10 millions maximum
            $erreurs[] = 'Le montant semble excessivement élevé';
        }
        
        return $erreurs;
    }

    // Validation de la cohérence
    public function validerCoherence(): array {
        $erreurs = array_merge($this->validerMontant());
        
        if (!empty($this->datePaiement)) {
            $date = new DateTime($this->datePaiement);
            $aujourdHui = new DateTime();
            
            if ($date > $aujourdHui) {
                $erreurs[] = 'La date de paiement ne peut pas être dans le futur';
            }
            
            if ($date < $aujourdHui->sub(new DateInterval('P1Y'))) {
                $erreurs[] = 'La date de paiement est trop ancienne';
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
        
        // Recherche dans la référence
        if (!empty($this->reference) && strpos(strtolower($this->reference), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le mode de paiement
        if (strpos(strtolower($this->modePaiement), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le statut
        if (strpos(strtolower($this->statut), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le montant
        if (is_numeric($terme) && $this->montantPaye == (float)$terme) {
            return true;
        }
        
        return false;
    }

    // Export pour les rapports
    public function toRapportArray(): array {
        return [
            'ID Paiement' => $this->idPaiement,
            'ID Élève' => $this->idEleve,
            'ID Frais' => $this->idFrais,
            'Montant Payé' => $this->getMontantFormate(),
            'Date Paiement' => $this->getDatePaiementFormatee(),
            'Mode Paiement' => $this->modePaiement,
            'Référence' => $this->reference,
            'Statut' => $this->statut,
            'Période' => $this->getPériodePaiement(),
            'Année Scolaire' => $this->getAnneeScolaire()
        ];
    }

    // Clonage pour copie
    public function copier(): Paiement {
        return new Paiement(
            null, // Nouvel ID
            $this->idEleve,
            $this->idFrais,
            $this->montantPaye,
            $this->datePaiement,
            $this->modePaiement,
            $this->reference,
            $this->statut
        );
    }

    // Statistiques de paiement
    public function getIndicateurs(): array {
        return [
            'montant' => $this->montantPaye,
            'montant_formate' => $this->getMontantFormate(),
            'age_jours' => $this->getAgePaiement(),
            'est_recent' => $this->estRecent(),
            'periode' => $this->getPériodePaiement(),
            'annee_scolaire' => $this->getAnneeScolaire(),
            'statut' => $this->statut,
            'mode' => $this->modePaiement,
            'peut_etre_modifie' => $this->peutEtreModifie(),
            'peut_etre_annule' => $this->peutEtreAnnule(),
            'penalites' => $this->getMontantAvecPenalite()
        ];
    }
}
?>
