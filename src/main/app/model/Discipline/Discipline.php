<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Discipline
{
    private $idDiscipline;
    private $idEleve;
    private $typeFaute;
    private $description;
    private $dateIncident;
    private $lieuIncident;
    private $temoins;
    private $signalePar;

    public function __construct(
        $idDiscipline = null,
        $idEleve = null,
        $typeFaute = null,
        $description = null,
        $dateIncident = null,
        $lieuIncident = null,
        $temoins = null,
        $signalePar = null
    ) {
        $this->idDiscipline = $idDiscipline;
        $this->idEleve = $idEleve;
        $this->typeFaute = $typeFaute;
        $this->description = $description;
        $this->dateIncident = $dateIncident ?? date('Y-m-d');
        $this->lieuIncident = $lieuIncident;
        $this->temoins = $temoins;
        $this->signalePar = $signalePar;
    }

    // Getters
    public function getIdDiscipline() { return $this->idDiscipline; }
    public function getIdEleve() { return $this->idEleve; }
    public function getTypeFaute() { return $this->typeFaute; }
    public function getDescription() { return $this->description; }
    public function getDateIncident() { return $this->dateIncident; }
    public function getLieuIncident() { return $this->lieuIncident; }
    public function getTemoins() { return $this->temoins; }
    public function getSignalePar() { return $this->signalePar; }

    // Setters
    public function setIdDiscipline($idDiscipline) { $this->idDiscipline = $idDiscipline; }
    public function setIdEleve($idEleve) { $this->idEleve = $idEleve; }
    public function setTypeFaute($typeFaute) { $this->typeFaute = $typeFaute; }
    public function setDescription($description) { $this->description = $description; }
    public function setDateIncident($dateIncident) { $this->dateIncident = $dateIncident; }
    public function setLieuIncident($lieuIncident) { $this->lieuIncident = $lieuIncident; }
    public function setTemoins($temoins) { $this->temoins = $temoins; }
    public function setSignalePar($signalePar) { $this->signalePar = $signalePar; }

    // Méthodes utilitaires
    public function estFauteMineure(): bool {
        return $this->typeFaute === 'Mineure';
    }

    public function estFauteMoyenne(): bool {
        return $this->typeFaute === 'Moyenne';
    }

    public function estFauteGrave(): bool {
        return $this->typeFaute === 'Grave';
    }

    public function estFauteTresGrave(): bool {
        return $this->typeFaute === 'Très grave';
    }

    public function getTypeFauteCouleur(): string {
        $couleurs = [
            'Mineure' => 'warning',
            'Moyenne' => 'info',
            'Grave' => 'danger',
            'Très grave' => 'dark'
        ];
        
        return $couleurs[$this->typeFaute] ?? 'secondary';
    }

    public function getTypeFauteIcone(): string {
        $icones = [
            'Mineure' => 'fa-exclamation-triangle',
            'Moyenne' => 'fa-exclamation-circle',
            'Grave' => 'fa-exclamation',
            'Très grave' => 'fa-times-circle'
        ];
        
        return $icones[$this->typeFaute] ?? 'fa-question-circle';
    }

    public function getTypesFauteDisponibles(): array {
        return ['Mineure', 'Moyenne', 'Grave', 'Très grave'];
    }

    public function getNiveauGravite(): int {
        $niveaux = [
            'Mineure' => 1,
            'Moyenne' => 2,
            'Grave' => 3,
            'Très grave' => 4
        ];
        
        return $niveaux[$this->typeFaute] ?? 0;
    }

    public function getDateIncidentFormatee(): string {
        $date = new DateTime($this->dateIncident);
        return $date->format('d/m/Y');
    }

    public function getDateIncidentComplete(): string {
        $date = new DateTime($this->dateIncident);
        return $date->format('d/m/Y à H:i');
    }

    public function getAgeIncident(): int {
        return (new DateTime())->diff(new DateTime($this->dateIncident))->days;
    }

    public function estRecent(): bool {
        return $this->getAgeIncident() <= 7;
    }

    public function estAncien(): bool {
        return $this->getAgeIncident() > 30;
    }

    public function getLieuxIncidentsDisponibles(): array {
        return [
            'Salle de classe',
            'Cour de récréation',
            'Cantine',
            'Bibliothèque',
            'Laboratoire',
            'Salle informatique',
            'Salle de sport',
            'Couloirs',
            'Toilettes',
            'Portail d\'entrée',
            'Parking',
            'Autre'
        ];
    }

    public function getLieuIncidentFormate(): string {
        return $this->lieuIncident ?? 'Non spécifié';
    }

    public function aDesTemoins(): bool {
        return !empty($this->temoins);
    }

    public function getTemoinsListe(): array {
        if (empty($this->temoins)) {
            return [];
        }
        
        // Séparer les témoins par virgule ou point-virgule
        $temoins = preg_split('/[;,]/', $this->temoins);
        return array_map('trim', array_filter($temoins));
    }

    public function getNombreTemoins(): int {
        return count($this->getTemoinsListe());
    }

    public function aDescriptionDetaillee(): bool {
        return !empty($this->description) && strlen($this->description) > 20;
    }

    public function getDescriptionResumee(): string {
        if (empty($this->description)) {
            return 'Aucune description';
        }
        
        if (strlen($this->description) <= 50) {
            return $this->description;
        }
        
        return substr($this->description, 0, 47) . '...';
    }

    public function getSignaleParFormate(): string {
        return $this->signalePar ?? 'Non spécifié';
    }

    public function getInformationsIncident(): array {
        return [
            'date_incident' => $this->dateIncident,
            'date_formatee' => $this->getDateIncidentFormatee(),
            'date_complete' => $this->getDateIncidentComplete(),
            'lieu_incident' => $this->lieuIncident,
            'lieu_formate' => $this->getLieuIncidentFormate(),
            'age_incident' => $this->getAgeIncident(),
            'est_recent' => $this->estRecent(),
            'est_ancien' => $this->estAncien(),
            'signale_par' => $this->signalePar,
            'signale_par_formate' => $this->getSignaleParFormate()
        ];
    }

    public function getInformationsFaute(): array {
        return [
            'type_faute' => $this->typeFaute,
            'niveau_gravite' => $this->getNiveauGravite(),
            'couleur' => $this->getTypeFauteCouleur(),
            'icone' => $this->getTypeFauteIcone(),
            'est_mineure' => $this->estFauteMineure(),
            'est_moyenne' => $this->estFauteMoyenne(),
            'est_grave' => $this->estFauteGrave(),
            'est_tres_grave' => $this->estFauteTresGrave()
        ];
    }

    public function getInformationsPreuve(): array {
        return [
            'description' => $this->description,
            'description_resumee' => $this->getDescriptionResumee(),
            'a_description_detaillee' => $this->aDescriptionDetaillee(),
            'temoins' => $this->temoins,
            'a_des_temoins' => $this->aDesTemoins(),
            'temoins_liste' => $this->getTemoinsListe(),
            'nombre_temoins' => $this->getNombreTemoins()
        ];
    }

    public function getSanctionsSuggerees(): array {
        $sanctions = [];
        
        switch ($this->typeFaute) {
            case 'Mineure':
                $sanctions = [
                    'Avertissement oral',
                    'Devoir supplémentaire',
                    'Service scolaire (1 heure)',
                    'Observation sur le carnet'
                ];
                break;
                
            case 'Moyenne':
                $sanctions = [
                    'Avertissement écrit',
                    'Devoir supplémentaire (2x)',
                    'Service scolaire (2 heures)',
                    'Exclusion temporaire (1 jour)',
                    'Rencontre avec les parents'
                ];
                break;
                
            case 'Grave':
                $sanctions = [
                    'Blâme officiel',
                    'Exclusion temporaire (3-5 jours)',
                    'Travail d\'intérêt général',
                    'Conseil de discipline',
                    'Suspension temporaire'
                ];
                break;
                
            case 'Très grave':
                $sanctions = [
                    'Exclusion temporaire (1-2 semaines)',
                    'Conseil de discipline obligatoire',
                    'Suspension prolongée',
                    'Exclusion définitive (en cas de récidive)',
                    'Signalement aux autorités'
                ];
                break;
        }
        
        return $sanctions;
    }

    public function getSanctionMaximale(): string {
        $sanctions = $this->getSanctionsSuggerees();
        return end($sanctions);
    }

    public function getSanctionMinimale(): string {
        $sanctions = $this->getSanctionsSuggerees();
        return $sanctions[0] ?? 'Aucune';
    }

    public function necessiteConseilDiscipline(): bool {
        return $this->estFauteGrave() || $this->estFauteTresGrave();
    }

    public function necessiteInterventionParents(): bool {
        return $this->estFauteMoyenne() || $this->estFauteGrave() || $this->estFauteTresGrave();
    }

    public function peutEtreTraiteInterne(): bool {
        return $this->estFauteMineure();
    }

    public function getNiveauIntervention(): string {
        if ($this->estFauteMineure()) {
            return 'Interne (Enseignant/Surveillance)';
        } elseif ($this->estFauteMoyenne()) {
            return 'Direction (Censeur/Surveillance générale)';
        } elseif ($this->estFauteGrave()) {
            return 'Conseil de discipline';
        } else {
            return 'Direction générale + Autorités';
        }
    }

    public function getDureeTraitementSuggeree(): string {
        switch ($this->typeFaute) {
            case 'Mineure':
                return 'Immédiat - 24h';
            case 'Moyenne':
                return '48h - 72h';
            case 'Grave':
                return '1 semaine';
            case 'Très grave':
                return '2 semaines - 1 mois';
            default:
                return 'À définir';
        }
    }

    public function getImpactScolaire(): array {
        $impacts = [];
        
        if ($this->estFauteMineure()) {
            $impacts[] = 'Léger - Pas d\'impact sur les apprentissages';
        } elseif ($this->estFauteMoyenne()) {
            $impacts[] = 'Modéré - Peut affecter la concentration';
        } elseif ($this->estFauteGrave()) {
            $impacts[] = 'Significatif - Peut perturber la classe';
        } else {
            $impacts[] = 'Majeur - Impact sur tout l\'établissement';
        }
        
        if ($this->necessiteConseilDiscipline()) {
            $impacts[] = 'Suspension possible des cours';
        }
        
        return $impacts;
    }

    public function getMesuresPreventives(): array {
        $mesures = [];
        
        switch ($this->typeFaute) {
            case 'Mineure':
                $mesures = [
                    'Rappel des règles de vie scolaire',
                    'Surveillance renforcée temporaire',
                    'Dialogue avec l\'élève'
                ];
                break;
                
            case 'Moyenne':
                $mesures = [
                    'Plan de comportement',
                    'Suivi régulier',
                    'Implication des parents',
                    'Médiation avec les camarades'
                ];
                break;
                
            case 'Grave':
                $mesures = [
                    'Accompagnement psychologique',
                    'Programme de remédiation',
                    'Contrat de comportement',
                    'Suivi hebdomadaire'
                ];
                break;
                
            case 'Très grave':
                $mesures = [
                    'Prise en charge spécialisée',
                    'Mesures disciplinaires strictes',
                    'Séparation temporaire',
                    'Suivi multidisciplinaire'
                ];
                break;
        }
        
        return $mesures;
    }

    public function estDansPeriodeScolaire(string $periode): bool {
        $date = new DateTime($this->dateIncident);
        $mois = (int)$date->format('m');
        
        switch ($periode) {
            case '1er trimestre':
                return $mois >= 9 && $mois <= 11;
            case '2ème trimestre':
                return $mois >= 12 || $mois <= 2;
            case '3ème trimestre':
                return $mois >= 3 && $mois <= 5;
            default:
                return false;
        }
    }

    public function getPeriodeIncident(): string {
        $date = new DateTime($this->dateIncident);
        $mois = (int)$date->format('m');
        
        if ($mois >= 9 && $mois <= 11) {
            return '1er trimestre';
        } elseif ($mois >= 12 || $mois <= 2) {
            return '2ème trimestre';
        } elseif ($mois >= 3 && $mois <= 5) {
            return '3ème trimestre';
        } else {
            return 'Vacances scolaires';
        }
    }

    public function getHeureIncident(): string {
        if (empty($this->dateIncident)) {
            return 'Inconnue';
        }
        
        $date = new DateTime($this->dateIncident);
        return $date->format('H:i');
    }

    public function estPendantCours(): bool {
        $heure = $this->getHeureIncident();
        $heureInt = (int)str_replace(':', '', $heure);
        
        // Cours typiquement de 7h30 à 12h00 et de 14h00 à 17h30
        return ($heureInt >= 730 && $heureInt <= 1200) || ($heureInt >= 1400 && $heureInt <= 1730);
    }

    public function estPendantRecreation(): bool {
        $heure = $this->getHeureIncident();
        $heureInt = (int)str_replace(':', '', $heure);
        
        // Récréations typiquement de 10h00 à 10h15 et de 15h30 à 15h45
        return ($heureInt >= 1000 && $heureInt <= 1015) || ($heureInt >= 1530 && $heureInt <= 1545);
    }

    public function toArray(): array {
        return array_merge(
            [
                'id_discipline' => $this->idDiscipline,
                'id_eleve' => $this->idEleve
            ],
            $this->getInformationsIncident(),
            $this->getInformationsFaute(),
            $this->getInformationsPreuve(),
            [
                'sanctions_suggerees' => $this->getSanctionsSuggerees(),
                'sanction_minimale' => $this->getSanctionMinimale(),
                'sanction_maximale' => $this->getSanctionMaximale(),
                'necessite_conseil_discipline' => $this->necessiteConseilDiscipline(),
                'necessite_intervention_parents' => $this->necessiteInterventionParents(),
                'peut_etre_traite_interne' => $this->peutEtreTraiteInterne(),
                'niveau_intervention' => $this->getNiveauIntervention(),
                'duree_traitement_suggeree' => $this->getDureeTraitementSuggeree(),
                'impact_scolaire' => $this->getImpactScolaire(),
                'mesures_preventives' => $this->getMesuresPreventives(),
                'periode_incident' => $this->getPeriodeIncident(),
                'heure_incident' => $this->getHeureIncident(),
                'est_pendant_cours' => $this->estPendantCours(),
                'est_pendant_recreation' => $this->estPendantRecreation()
            ]
        );
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->idEleve) &&
               !empty($this->typeFaute) &&
               in_array($this->typeFaute, $this->getTypesFauteDisponibles()) &&
               !empty($this->description) &&
               !empty($this->dateIncident);
    }

    // Validation de la cohérence
    public function validerCoherence(): array {
        $erreurs = [];
        
        if (empty($this->description) || strlen($this->description) < 10) {
            $erreurs[] = 'La description doit contenir au moins 10 caractères';
        }
        
        if (!empty($this->dateIncident)) {
            $date = new DateTime($this->dateIncident);
            $aujourdHui = new DateTime();
            
            if ($date > $aujourdHui) {
                $erreurs[] = 'La date de l\'incident ne peut pas être dans le futur';
            }
            
            if ($date < $aujourdHui->sub(new DateInterval('P1Y'))) {
                $erreurs[] = 'La date de l\'incident est trop ancienne';
            }
        }
        
        if (!empty($this->lieuIncident) && !in_array($this->lieuIncident, $this->getLieuxIncidentsDisponibles())) {
            $erreurs[] = 'Le lieu de l\'incident n\'est pas valide';
        }
        
        return $erreurs;
    }

    // Recherche textuelle
    public function rechercher(string $terme): bool {
        $terme = strtolower(trim($terme));
        
        if (empty($terme)) {
            return false;
        }
        
        // Recherche dans la description
        if (strpos(strtolower($this->description), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le type de faute
        if (strpos(strtolower($this->typeFaute), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le lieu
        if (!empty($this->lieuIncident) && strpos(strtolower($this->lieuIncident), $terme) !== false) {
            return true;
        }
        
        // Recherche dans les témoins
        if (!empty($this->temoins) && strpos(strtolower($this->temoins), $terme) !== false) {
            return true;
        }
        
        // Recherche dans la personne qui a signalé
        if (!empty($this->signalePar) && strpos(strtolower($this->signalePar), $terme) !== false) {
            return true;
        }
        
        return false;
    }

    // Export pour les rapports
    public function toRapportArray(): array {
        return [
            'ID Discipline' => $this->idDiscipline,
            'ID Élève' => $this->idEleve,
            'Type Faute' => $this->typeFaute,
            'Date Incident' => $this->getDateIncidentFormatee(),
            'Lieu Incident' => $this->getLieuIncidentFormate(),
            'Description' => $this->getDescriptionResumee(),
            'Témoins' => $this->getNombreTemoins() . ' témoin(s)',
            'Signalé par' => $this->getSignaleParFormate(),
            'Période' => $this->getPeriodeIncident(),
            'Niveau Gravité' => $this->getNiveauGravite()
        ];
    }

    // Clonage pour copie
    public function copier(): Discipline {
        return new Discipline(
            null, // Nouvel ID
            $this->idEleve,
            $this->typeFaute,
            $this->description,
            $this->dateIncident,
            $this->lieuIncident,
            $this->temoins,
            $this->signalePar
        );
    }

    // Statistiques de discipline
    public function getIndicateurs(): array {
        return [
            'niveau_gravite' => $this->getNiveauGravite(),
            'age_incident' => $this->getAgeIncident(),
            'est_recent' => $this->estRecent(),
            'a_temoins' => $this->aDesTemoins(),
            'nombre_temoins' => $this->getNombreTemoins(),
            'periode' => $this->getPeriodeIncident(),
            'necessite_conseil' => $this->necessiteConseilDiscipline(),
            'necessite_parents' => $this->necessiteInterventionParents(),
            'impact_scolaire' => $this->getImpactScolaire(),
            'mesures_preventives' => count($this->getMesuresPreventives())
        ];
    }
}
?>
