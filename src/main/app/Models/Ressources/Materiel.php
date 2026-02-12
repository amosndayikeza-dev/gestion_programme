<?php

namespace App\Models\Ressources;
use DateTime;
use DateInterval;
use PDO;
use Exception;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Materiel
{
    private $idMateriel;
    private $designation;
    private $categorie;
    private $quantite;
    private $etat;
    private $dateAcquisition;
    private $valeurUnitaire;
    private $localisation;

    public function __construct(
        $idMateriel = null,
        $designation = null,
        $categorie = 'Autre',
        $quantite = 1,
        $etat = 'Bon',
        $dateAcquisition = null,
        $valeurUnitaire = 0.0,
        $localisation = null
    ) {
        $this->idMateriel = $idMateriel;
        $this->designation = $designation;
        $this->categorie = $categorie;
        $this->quantite = $quantite;
        $this->etat = $etat;
        $this->dateAcquisition = $dateAcquisition ?? date('Y-m-d');
        $this->valeurUnitaire = $valeurUnitaire;
        $this->localisation = $localisation;
    }

    // Getters
    public function getIdMateriel() { return $this->idMateriel; }
    public function getDesignation() { return $this->designation; }
    public function getCategorie() { return $this->categorie; }
    public function getQuantite() { return $this->quantite; }
    public function getEtat() { return $this->etat; }
    public function getDateAcquisition() { return $this->dateAcquisition; }
    public function getValeurUnitaire() { return $this->valeurUnitaire; }
    public function getLocalisation() { return $this->localisation; }

    // Setters
    public function setIdMateriel($idMateriel) { $this->idMateriel = $idMateriel; }
    public function setDesignation($designation) { $this->designation = $designation; }
    public function setCategorie($categorie) { $this->categorie = $categorie; }
    public function setQuantite($quantite) { $this->quantite = $quantite; }
    public function setEtat($etat) { $this->etat = $etat; }
    public function setDateAcquisition($dateAcquisition) { $this->dateAcquisition = $dateAcquisition; }
    public function setValeurUnitaire($valeurUnitaire) { $this->valeurUnitaire = $valeurUnitaire; }
    public function setLocalisation($localisation) { $this->localisation = $localisation; }

    // Méthodes utilitaires
    public function getValeurTotale(): float {
        return $this->quantite * $this->valeurUnitaire;
    }

    public function getAnciennete(): int {
        $dateAcquisition = new DateTime($this->dateAcquisition);
        $aujourdHui = new DateTime();
        
        return $aujourdHui->diff($dateAcquisition)->y; // années
    }

    public function estFonctionnel(): bool {
        return in_array($this->etat, ['Bon', 'Moyen']);
    }

    public function estHorsService(): bool {
        return $this->etat === 'Hors service';
    }

    public function necessiteMaintenance(): bool {
        return $this->etat === 'Mauvais';
    }

    public function ajouterQuantite(int $quantite): bool {
        if ($quantite <= 0) {
            return false;
        }
        
        $this->quantite += $quantite;
        return true;
    }

    public function retirerQuantite(int $quantite): bool {
        if ($quantite <= 0 || $quantite > $this->quantite) {
            return false;
        }
        
        $this->quantite -= $quantite;
        return true;
    }

    public function changerEtat(string $nouvelEtat): bool {
        $etatsValides = ['Bon', 'Moyen', 'Mauvais', 'Hors service'];
        
        if (!in_array($nouvelEtat, $etatsValides)) {
            return false;
        }
        
        $ancienEtat = $this->etat;
        $this->etat = $nouvelEtat;
        
        // Journaliser le changement d'état
        $this->journaliserChangementEtat($ancienEtat, $nouvelEtat);
        
        return true;
    }

    public function deplacer(string $nouvelleLocalisation): bool {
        if (empty($nouvelleLocalisation)) {
            return false;
        }
        
        $ancienneLocalisation = $this->localisation;
        $this->localisation = $nouvelleLocalisation;
        
        // Journaliser le déplacement
        $this->journaliserDeplacement($ancienneLocalisation, $nouvelleLocalisation);
        
        return true;
    }

    public function calculerAmortissement(int $dureeVie = 10): float {
        if ($this->valeurUnitaire <= 0) {
            return 0.0;
        }
        
        $anciennete = $this->getAnciennete();
        
        if ($anciennete >= $dureeVie) {
            return 0.0; // Totalement amorti
        }
        
        $tauxAmortissement = $anciennete / $dureeVie;
        return $this->valeurUnitaire * (1 - $tauxAmortissement);
    }

    public function getValeurResiduelle(): float {
        return $this->quantite * $this->calculerAmortissement();
    }

    public function estEnStock(): bool {
        return !empty($this->localisation) && 
               strtolower($this->localisation) !== 'sorti' &&
               strtolower($this->localisation) !== 'en réparation';
    }

    public function getCategorieIcone(): string {
        $icones = [
            'Mobilier' => 'fa-chair',
            'Informatique' => 'fa-laptop',
            'Laboratoire' => 'fa-flask',
            'Sport' => 'fa-football-ball',
            'Bureau' => 'fa-desktop',
            'Autre' => 'fa-box'
        ];
        
        return $icones[$this->categorie] ?? 'fa-box';
    }

    public function getCategorieCouleur(): string {
        $couleurs = [
            'Mobilier' => 'primary',
            'Informatique' => 'info',
            'Laboratoire' => 'success',
            'Sport' => 'warning',
            'Bureau' => 'secondary',
            'Autre' => 'dark'
        ];
        
        return $couleurs[$this->categorie] ?? 'dark';
    }

    public function getEtatCouleur(): string {
        $couleurs = [
            'Bon' => 'success',
            'Moyen' => 'warning',
            'Mauvais' => 'danger',
            'Hors service' => 'secondary'
        ];
        
        return $couleurs[$this->etat] ?? 'secondary';
    }

    public function toArray(): array {
        return [
            'id_materiel' => $this->idMateriel,
            'designation' => $this->designation,
            'categorie' => $this->categorie,
            'quantite' => $this->quantite,
            'etat' => $this->etat,
            'date_acquisition' => $this->dateAcquisition,
            'valeur_unitaire' => $this->valeurUnitaire,
            'valeur_totale' => $this->getValeurTotale(),
            'localisation' => $this->localisation,
            'anciennete' => $this->getAnciennete(),
            'valeur_residuelle' => $this->getValeurResiduelle(),
            'est_fonctionnel' => $this->estFonctionnel(),
            'necessite_maintenance' => $this->necessiteMaintenance(),
            'en_stock' => $this->estEnStock(),
            'categorie_icone' => $this->getCategorieIcone(),
            'categorie_couleur' => $this->getCategorieCouleur(),
            'etat_couleur' => $this->getEtatCouleur()
        ];
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->designation) &&
               in_array($this->categorie, ['Mobilier', 'Informatique', 'Laboratoire', 'Sport', 'Bureau', 'Autre']) &&
               $this->quantite > 0 &&
               in_array($this->etat, ['Bon', 'Moyen', 'Mauvais', 'Hors service']) &&
               $this->valeurUnitaire >= 0;
    }

    // Méthodes privées pour la journalisation
    private function journaliserChangementEtat(string $ancienEtat, string $nouvelEtat): void {
        // Implémentation à connecter avec le système de journalisation
        error_log("Changement d'état matériel #{$this->idMateriel}: {$ancienEtat} -> {$nouvelEtat}");
    }

    private function journaliserDeplacement(string $ancienneLocalisation, string $nouvelleLocalisation): void {
        // Implémentation à connecter avec le système de journalisation
        error_log("Déplacement matériel #{$this->idMateriel}: {$ancienneLocalisation} -> {$nouvelleLocalisation}");
    }
}
?>
