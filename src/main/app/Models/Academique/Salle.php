<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\academique;
class Salle
{
    private $idSalle;
    private $nomSalle;
    private $typeSalle;
    private $capacite;
    private $etat;
    private $idEcole;

    public function __construct(
        $idSalle = null,
        $nomSalle = null,
        $typeSalle = 'Classe',
        $capacite = 40,
        $etat = 'Bon',
        $idEcole = null
    ) {
        $this->idSalle = $idSalle;
        $this->nomSalle = $nomSalle;
        $this->typeSalle = $typeSalle;
        $this->capacite = $capacite;
        $this->etat = $etat;
        $this->idEcole = $idEcole;
    }

    // Getters
    public function getIdSalle() { return $this->idSalle; }
    public function getNomSalle() { return $this->nomSalle; }
    public function getTypeSalle() { return $this->typeSalle; }
    public function getCapacite() { return $this->capacite; }
    public function getEtat() { return $this->etat; }
    public function getIdEcole() { return $this->idEcole; }

    // Setters
    public function setIdSalle($idSalle) { $this->idSalle = $idSalle; }
    public function setNomSalle($nomSalle) { $this->nomSalle = $nomSalle; }
    public function setTypeSalle($typeSalle) { $this->typeSalle = $typeSalle; }
    public function setCapacite($capacite) { $this->capacite = $capacite; }
    public function setEtat($etat) { $this->etat = $etat; }
    public function setIdEcole($idEcole) { $this->idEcole = $idEcole; }

    // Méthodes utilitaires
    public function getNomFormate(): string {
        return strtoupper($this->nomSalle);
    }

    public function getCodeSalle(): string {
        return strtoupper(preg_replace('/[^A-Z0-9]/', '', $this->nomSalle));
    }

    public function estSalleClasse(): bool {
        return $this->typeSalle === 'Classe';
    }

    public function estLaboratoire(): bool {
        return $this->typeSalle === 'Laboratoire';
    }

    public function estBibliotheque(): bool {
        return $this->typeSalle === 'Bibliothèque';
    }

    public function estSalleInformatique(): bool {
        return $this->typeSalle === 'Salle informatique';
    }

    public function estSalleSport(): bool {
        return $this->typeSalle === 'Salle de sport';
    }

    public function getTypeSalleCouleur(): string {
        $couleurs = [
            'Classe' => 'primary',
            'Laboratoire' => 'success',
            'Bibliothèque' => 'info',
            'Salle informatique' => 'warning',
            'Salle de sport' => 'danger'
        ];
        
        return $couleurs[$this->typeSalle] ?? 'secondary';
    }

    public function getTypeSalleIcone(): string {
        $icones = [
            'Classe' => 'fa-chalkboard',
            'Laboratoire' => 'fa-flask',
            'Bibliothèque' => 'fa-book',
            'Salle informatique' => 'fa-desktop',
            'Salle de sport' => 'fa-dumbbell'
        ];
        
        return $icones[$this->typeSalle] ?? 'fa-door-open';
    }

    public function getTypesSalleDisponibles(): array {
        return ['Classe', 'Laboratoire', 'Bibliothèque', 'Salle informatique', 'Salle de sport'];
    }

    public function estBonEtat(): bool {
        return $this->etat === 'Bon';
    }

    public function estEtatMoyen(): bool {
        return $this->etat === 'Moyen';
    }

    public function estMauvaisEtat(): bool {
        return $this->etat === 'Mauvais';
    }

    public function estEnReparation(): bool {
        return $this->etat === 'En réparation';
    }

    public function getEtatCouleur(): string {
        $couleurs = [
            'Bon' => 'success',
            'Moyen' => 'warning',
            'Mauvais' => 'danger',
            'En réparation' => 'info'
        ];
        
        return $couleurs[$this->etat] ?? 'secondary';
    }

    public function getEtatIcone(): string {
        $icones = [
            'Bon' => 'fa-check-circle',
            'Moyen' => 'fa-exclamation-triangle',
            'Mauvais' => 'fa-times-circle',
            'En réparation' => 'fa-tools'
        ];
        
        return $icones[$this->etat] ?? 'fa-question-circle';
    }

    public function getEtatsDisponibles(): array {
        return ['Bon', 'Moyen', 'Mauvais', 'En réparation'];
    }

    public function estFonctionnel(): bool {
        return in_array($this->etat, ['Bon', 'Moyen']);
    }

    public function estIndisponible(): bool {
        return in_array($this->etat, ['Mauvais', 'En réparation']);
    }

    public function peutAccueillirClasse(int $nombreEleves): bool {
        return $this->estFonctionnel() && $this->capacite >= $nombreEleves;
    }

    public function getTauxOccupation(int $nombreEleves): float {
        if ($this->capacite == 0) {
            return 0.0;
        }
        
        return ($nombreEleves / $this->capacite) * 100;
    }

    public function getPlacesDisponibles(int $nombreEleves): int {
        return max(0, $this->capacite - $nombreEleves);
    }

    public function estPleine(int $nombreEleves): bool {
        return $nombreEleves >= $this->capacite;
    }

    public function estSousUtilisee(int $nombreEleves, float $seuil = 0.5): bool {
        return $this->getTauxOccupation($nombreEleves) < ($seuil * 100);
    }

    public function getCapaciteOptimale(): int {
        $capacites = [
            'Classe' => 40,
            'Laboratoire' => 25,
            'Bibliothèque' => 30,
            'Salle informatique' => 20,
            'Salle de sport' => 50
        ];
        
        return $capacites[$this->typeSalle] ?? 40;
    }

    public function estCapaciteAdaptee(): bool {
        $capaciteOptimale = $this->getCapaciteOptimale();
        $marge = $capaciteOptimale * 0.2; // 20% de marge
        
        return abs($this->capacite - $capaciteOptimale) <= $marge;
    }

    public function getEquipementsSpecifiques(): array {
        $equipements = [];
        
        switch ($this->typeSalle) {
            case 'Classe':
                $equipements = ['Tableau noir/blanc', 'Chaises', 'Tables', 'Éclairage'];
                break;
            case 'Laboratoire':
                $equipements = ['Paillasse', 'Évier', 'Armoires de rangement', 'Hotte', 'Gaz'];
                break;
            case 'Bibliothèque':
                $equipements = ['Étagères', 'Bureaux', 'Ordinateurs', 'Système de climatisation'];
                break;
            case 'Salle informatique':
                $equipements = ['Ordinateurs', 'Tableau interactif', 'Connexion internet', 'Serveur'];
                break;
            case 'Salle de sport':
                $equipements = ['Sol adapté', 'Paniers', 'Vestiaires', 'Douches', 'Matériel sportif'];
                break;
        }
        
        return $equipements;
    }

    public function getNiveauSecurite(): string {
        $niveaux = [
            'Laboratoire' => 'Élevé',
            'Salle informatique' => 'Moyen',
            'Salle de sport' => 'Moyen',
            'Classe' => 'Standard',
            'Bibliothèque' => 'Standard'
        ];
        
        return $niveaux[$this->typeSalle] ?? 'Standard';
    }

    public function getNiveauSecuriteCouleur(): string {
        $couleurs = [
            'Élevé' => 'danger',
            'Moyen' => 'warning',
            'Standard' => 'info'
        ];
        
        return $couleurs[$this->getNiveauSecurite()] ?? 'secondary';
    }

    public function getMaintenanceRequise(): array {
        $maintenances = [];
        
        switch ($this->etat) {
            case 'Bon':
                $maintenances = ['Maintenance préventive annuelle'];
                break;
            case 'Moyen':
                $maintenances = ['Maintenance préventive semestrielle', 'Petites réparations'];
                break;
            case 'Mauvais':
                $maintenances = ['Maintenance corrective urgente', 'Réparations majeures'];
                break;
            case 'En réparation':
                $maintenances = ['En cours de réparation', 'Inspection post-réparation'];
                break;
        }
        
        return $maintenances;
    }

    public function getCoutMaintenanceEstime(): float {
        $couts = [
            'Bon' => 50,      // Maintenance préventive
            'Moyen' => 200,    // Petites réparations
            'Mauvais' => 1000, // Réparations majeures
            'En réparation' => 0 // En cours
        ];
        
        return $couts[$this->etat] ?? 100;
    }

    public function getPrioriteMaintenance(): string {
        $priorites = [
            'Bon' => 'Faible',
            'Moyen' => 'Moyenne',
            'Mauvais' => 'Urgente',
            'En réparation' => 'En cours'
        ];
        
        return $priorites[$this->etat] ?? 'Moyenne';
    }

    public function getPrioriteMaintenanceCouleur(): string {
        $couleurs = [
            'Faible' => 'success',
            'Moyenne' => 'warning',
            'Urgente' => 'danger',
            'En cours' => 'info'
        ];
        
        return $couleurs[$this->getPrioriteMaintenance()] ?? 'secondary';
    }

    public function getInformationsTechniques(): array {
        return [
            'capacite_optimale' => $this->getCapaciteOptimale(),
            'est_capacite_adaptee' => $this->estCapaciteAdaptee(),
            'equipements_specifiques' => $this->getEquipementsSpecifiques(),
            'niveau_securite' => $this->getNiveauSecurite(),
            'niveau_securite_couleur' => $this->getNiveauSecuriteCouleur(),
            'maintenance_requise' => $this->getMaintenanceRequise(),
            'cout_maintenance_estime' => $this->getCoutMaintenanceEstime(),
            'priorite_maintenance' => $this->getPrioriteMaintenance(),
            'priorite_maintenance_couleur' => $this->getPrioriteMaintenanceCouleur()
        ];
    }

    public function getStatutUtilisation(int $nombreEleves): array {
        return [
            'est_fonctionnel' => $this->estFonctionnel(),
            'est_indisponible' => $this->estIndisponible(),
            'peut_accueillir_classe' => $this->peutAccueillirClasse($nombreEleves),
            'taux_occupation' => $this->getTauxOccupation($nombreEleves),
            'places_disponibles' => $this->getPlacesDisponibles($nombreEleves),
            'est_pleine' => $this->estPleine($nombreEleves),
            'est_sous_utilisee' => $this->estSousUtilisee($nombreEleves)
        ];
    }

    public function toArray(): array {
        return array_merge(
            [
                'id_salle' => $this->idSalle,
                'nom_salle' => $this->nomSalle,
                'nom_formate' => $this->getNomFormate(),
                'code_salle' => $this->getCodeSalle(),
                'type_salle' => $this->typeSalle,
                'capacite' => $this->capacite,
                'etat' => $this->etat,
                'id_ecole' => $this->idEcole
            ],
            [
                'type_salle_couleur' => $this->getTypeSalleCouleur(),
                'type_salle_icone' => $this->getTypeSalleIcone(),
                'etat_couleur' => $this->getEtatCouleur(),
                'etat_icone' => $this->getEtatIcone(),
                'est_fonctionnel' => $this->estFonctionnel(),
                'est_indisponible' => $this->estIndisponible()
            ],
            $this->getInformationsTechniques()
        );
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->nomSalle) &&
               in_array($this->typeSalle, $this->getTypesSalleDisponibles()) &&
               in_array($this->etat, $this->getEtatsDisponibles()) &&
               $this->capacite > 0 &&
               !empty($this->idEcole);
    }

    // Validation de la capacité
    public function validerCapacite(): array {
        $erreurs = [];
        
        if ($this->capacite <= 0) {
            $erreurs[] = 'La capacité doit être supérieure à 0';
        } elseif ($this->capacite > 200) {
            $erreurs[] = 'La capacité semble excessivement élevée';
        }
        
        $capaciteOptimale = $this->getCapaciteOptimale();
        if (abs($this->capacite - $capaciteOptimale) > ($capaciteOptimale * 0.5)) {
            $erreurs[] = 'La capacité est très différente de la capacité optimale (' . $capaciteOptimale . ')';
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
        if (strpos(strtolower($this->nomSalle), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le type
        if (strpos(strtolower($this->typeSalle), $terme) !== false) {
            return true;
        }
        
        // Recherche dans l'état
        if (strpos(strtolower($this->etat), $terme) !== false) {
            return true;
        }
        
        return false;
    }

    // Export pour les rapports
    public function toRapportArray(): array {
        return [
            'ID' => $this->idSalle,
            'Nom Salle' => $this->getNomFormate(),
            'Type' => $this->typeSalle,
            'Capacité' => $this->capacite,
            'État' => $this->etat,
            'Fonctionnel' => $this->estFonctionnel() ? 'Oui' : 'Non',
            'Capacité Optimale' => $this->getCapaciteOptimale(),
            'Niveau Sécurité' => $this->getNiveauSecurite(),
            'Priorité Maintenance' => $this->getPrioriteMaintenance(),
            'Coût Maintenance' => $this->getCoutMaintenanceEstime() . ' $'
        ];
    }

    // Clonage
    public function copier(): Salle {
        return new Salle(
            null, // Nouvel ID
            $this->nomSalle,
            $this->typeSalle,
            $this->capacite,
            $this->etat,
            $this->idEcole
        );
    }

    // Gestion de l'état
    public function mettreEnReparation(): bool {
        if ($this->etat === 'En réparation') {
            return false;
        }
        
        $this->etat = 'En réparation';
        return true;
    }

    public function terminerReparation(string $nouvelEtat = 'Bon'): bool {
        if ($this->etat !== 'En réparation') {
            return false;
        }
        
        if (!in_array($nouvelEtat, ['Bon', 'Moyen', 'Mauvais'])) {
            return false;
        }
        
        $this->etat = $nouvelEtat;
        return true;
    }

    public function changerEtat(string $nouvelEtat): bool {
        if (!in_array($nouvelEtat, $this->getEtatsDisponibles())) {
            return false;
        }
        
        $ancienEtat = $this->etat;
        $this->etat = $nouvelEtat;
        
        return true;
    }
}
?>
