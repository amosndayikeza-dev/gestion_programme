<?php

namespace App\Models\Discipline;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use DateTime;
use DateInterval;

class Discipline
{
    // === ATTRIBUTS CORRESPONDANT À LA TABLE discipline ===
    private $idDiscipline;
    private $idEleve;
    private $typeInfraction;        // Remplacé typeFaute par typeInfraction
    private $description;
    private $dateInfraction;        // Remplacé dateIncident par dateInfraction
    private $lieu;                  // Remplacé lieuIncident par lieu
    private $temoins;
    private $sanction;              // NOUVEAU
    private $dureeSanction;         // NOUVEAU
    private $idPersonnelRapport;    // Remplacé signalePar par idPersonnelRapport
    private $idParentInforme;       // NOUVEAU
    private $statut;                // NOUVEAU
    private $dateRapport;           // NOUVEAU

    public function __construct(
        $idDiscipline = null,
        $idEleve = null,
        $typeInfraction = null,
        $description = null,
        $dateInfraction = null,
        $lieu = null,
        $temoins = null,
        $sanction = null,
        $dureeSanction = null,
        $idPersonnelRapport = null,
        $idParentInforme = null,
        $statut = 'en_attente',
        $dateRapport = null
    ) {
        $this->idDiscipline = $idDiscipline;
        $this->idEleve = $idEleve;
        $this->typeInfraction = $typeInfraction;
        $this->description = $description;
        $this->dateInfraction = $dateInfraction ?? date('Y-m-d H:i:s');
        $this->lieu = $lieu;
        $this->temoins = $temoins;
        $this->sanction = $sanction;
        $this->dureeSanction = $dureeSanction;
        $this->idPersonnelRapport = $idPersonnelRapport;
        $this->idParentInforme = $idParentInforme;
        $this->statut = $statut;
        $this->dateRapport = $dateRapport ?? date('Y-m-d H:i:s');
    }

    // === GETTERS (adaptés) ===
    public function getIdDiscipline() { return $this->idDiscipline; }
    public function getIdEleve() { return $this->idEleve; }
    public function getTypeInfraction() { return $this->typeInfraction; }
    public function getDescription() { return $this->description; }
    public function getDateInfraction() { return $this->dateInfraction; }
    public function getLieu() { return $this->lieu; }
    public function getTemoins() { return $this->temoins; }
    public function getSanction() { return $this->sanction; }
    public function getDureeSanction() { return $this->dureeSanction; }
    public function getIdPersonnelRapport() { return $this->idPersonnelRapport; }
    public function getIdParentInforme() { return $this->idParentInforme; }
    public function getStatut() { return $this->statut; }
    public function getDateRapport() { return $this->dateRapport; }

    // === SETTERS (adaptés) ===
    public function setIdDiscipline($idDiscipline) { $this->idDiscipline = $idDiscipline; return $this; }
    public function setIdEleve($idEleve) { $this->idEleve = $idEleve; return $this; }
    public function setTypeInfraction($typeInfraction) { $this->typeInfraction = $typeInfraction; return $this; }
    public function setDescription($description) { $this->description = $description; return $this; }
    public function setDateInfraction($dateInfraction) { $this->dateInfraction = $dateInfraction; return $this; }
    public function setLieu($lieu) { $this->lieu = $lieu; return $this; }
    public function setTemoins($temoins) { $this->temoins = $temoins; return $this; }
    public function setSanction($sanction) { $this->sanction = $sanction; return $this; }
    public function setDureeSanction($dureeSanction) { $this->dureeSanction = $dureeSanction; return $this; }
    public function setIdPersonnelRapport($idPersonnelRapport) { $this->idPersonnelRapport = $idPersonnelRapport; return $this; }
    public function setIdParentInforme($idParentInforme) { $this->idParentInforme = $idParentInforme; return $this; }
    public function setStatut($statut) { $this->statut = $statut; return $this; }
    public function setDateRapport($dateRapport) { $this->dateRapport = $dateRapport; return $this; }

    // === MÉTHODES D'ADAPTATION (pour compatibilité avec votre code existant) ===
    
    /**
     * Méthodes de compatibilité avec l'ancien code
     * (pour ne pas casser les appels à getTypeFaute(), getDateIncident(), etc.)
     */
    public function getTypeFaute() { return $this->typeInfraction; }
    public function setTypeFaute($typeFaute) { $this->typeInfraction = $typeFaute; return $this; }
    public function getDateIncident() { return $this->dateInfraction; }
    public function setDateIncident($dateIncident) { $this->dateInfraction = $dateIncident; return $this; }
    public function getLieuIncident() { return $this->lieu; }
    public function setLieuIncident($lieuIncident) { $this->lieu = $lieuIncident; return $this; }
    public function getSignalePar() { return $this->idPersonnelRapport; }
    public function setSignalePar($signalePar) { $this->idPersonnelRapport = $signalePar; return $this; }

    // === MÉTHODES DE TYPE DE FAUTE (conservées) ===
    public function estFauteMineure(): bool {
        return $this->typeInfraction === 'Mineure';
    }

    public function estFauteMoyenne(): bool {
        return $this->typeInfraction === 'Moyenne';
    }

    public function estFauteGrave(): bool {
        return $this->typeInfraction === 'Grave';
    }

    public function estFauteTresGrave(): bool {
        return $this->typeInfraction === 'Très grave';
    }

    public function getTypeFauteCouleur(): string {
        $couleurs = [
            'Mineure' => 'warning',
            'Moyenne' => 'info',
            'Grave' => 'danger',
            'Très grave' => 'dark'
        ];
        
        return $couleurs[$this->typeInfraction] ?? 'secondary';
    }

    public function getTypeFauteIcone(): string {
        $icones = [
            'Mineure' => 'fa-exclamation-triangle',
            'Moyenne' => 'fa-exclamation-circle',
            'Grave' => 'fa-exclamation',
            'Très grave' => 'fa-times-circle'
        ];
        
        return $icones[$this->typeInfraction] ?? 'fa-question-circle';
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
        
        return $niveaux[$this->typeInfraction] ?? 0;
    }

    // === MÉTHODES DE DATE (adaptées) ===
    public function getDateIncidentFormatee(): string {
        $date = new DateTime($this->dateInfraction);
        return $date->format('d/m/Y');
    }

    public function getDateIncidentComplete(): string {
        $date = new DateTime($this->dateInfraction);
        return $date->format('d/m/Y à H:i');
    }

    public function getAgeIncident(): int {
        return (new DateTime())->diff(new DateTime($this->dateInfraction))->days;
    }

    public function estRecent(): bool {
        return $this->getAgeIncident() <= 7;
    }

    public function estAncien(): bool {
        return $this->getAgeIncident() > 30;
    }

    // === MÉTHODES DE LIEU ===
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
        return $this->lieu ?? 'Non spécifié';
    }

    // === MÉTHODES DE TÉMOINS ===
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

    // === MÉTHODES DE DESCRIPTION ===
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

    // === NOUVELLES MÉTHODES POUR LES ATTRIBUTS AJOUTÉS ===

    /**
     * Méthodes pour la sanction
     */
    public function aSanction(): bool {
        return !empty($this->sanction);
    }

    public function getSanctionFormatee(): string {
        if (!$this->sanction) return 'Aucune sanction';
        if ($this->dureeSanction) {
            return $this->sanction . ' (' . $this->dureeSanction . ' jours)';
        }
        return $this->sanction;
    }

    /**
     * Méthodes pour le statut
     */
    public function estEnAttente(): bool {
        return $this->statut === 'en_attente';
    }

    public function estEnCours(): bool {
        return $this->statut === 'en_cours';
    }

    public function estTraite(): bool {
        return in_array($this->statut, ['traite', 'sanctionne', 'classe']);
    }

    public function estSanctionne(): bool {
        return $this->statut === 'sanctionne';
    }

    public function estClasse(): bool {
        return $this->statut === 'classe';
    }

    public function getStatutsDisponibles(): array {
        return [
            'en_attente' => 'En attente',
            'en_cours' => 'En cours de traitement',
            'traite' => 'Traité',
            'sanctionne' => 'Sanctionné',
            'classe' => 'Classé sans suite',
            'parent_informe' => 'Parent informé'
        ];
    }

    public function getStatutLibelle(): string {
        $libelles = $this->getStatutsDisponibles();
        return $libelles[$this->statut] ?? $this->statut;
    }

    public function getStatutCouleur(): string {
        $couleurs = [
            'en_attente' => 'warning',
            'en_cours' => 'info',
            'traite' => 'success',
            'sanctionne' => 'danger',
            'classe' => 'secondary',
            'parent_informe' => 'primary'
        ];
        
        return $couleurs[$this->statut] ?? 'secondary';
    }

    public function getStatutIcone(): string {
        $icones = [
            'en_attente' => 'fa-hourglass-half',
            'en_cours' => 'fa-spinner',
            'traite' => 'fa-check-circle',
            'sanctionne' => 'fa-gavel',
            'classe' => 'fa-folder',
            'parent_informe' => 'fa-user-check'
        ];
        
        return $icones[$this->statut] ?? 'fa-question-circle';
    }

    /**
     * Méthodes pour les parents
     */
    public function aPrevenuParent(): bool {
        return !empty($this->idParentInforme);
    }

    /**
     * Méthodes pour le personnel rapporteur
     */
    public function getSignaleParFormate(): string {
        return $this->idPersonnelRapport ?? 'Non spécifié';
    }

    // === MÉTHODES DE SANCTIONS SUGGÉRÉES (adaptées) ===
    public function getSanctionsSuggerees(): array {
        $sanctions = [];
        
        switch ($this->typeInfraction) {
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
        switch ($this->typeInfraction) {
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
        
        switch ($this->typeInfraction) {
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

    // === MÉTHODES DE PÉRIODE ===
    public function estDansPeriodeScolaire(string $periode): bool {
        $date = new DateTime($this->dateInfraction);
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
        $date = new DateTime($this->dateInfraction);
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
        if (empty($this->dateInfraction)) {
            return 'Inconnue';
        }
        
        $date = new DateTime($this->dateInfraction);
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

    // === MÉTHODES D'INFORMATIONS GROUPÉES ===
    public function getInformationsIncident(): array {
        return [
            'date_incident' => $this->dateInfraction,
            'date_formatee' => $this->getDateIncidentFormatee(),
            'date_complete' => $this->getDateIncidentComplete(),
            'lieu_incident' => $this->lieu,
            'lieu_formate' => $this->getLieuIncidentFormate(),
            'age_incident' => $this->getAgeIncident(),
            'est_recent' => $this->estRecent(),
            'est_ancien' => $this->estAncien(),
            'signale_par' => $this->idPersonnelRapport,
            'signale_par_formate' => $this->getSignaleParFormate()
        ];
    }

    public function getInformationsFaute(): array {
        return [
            'type_faute' => $this->typeInfraction,
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

    public function getInformationsSanction(): array {
        return [
            'sanction' => $this->sanction,
            'duree_sanction' => $this->dureeSanction,
            'sanction_formatee' => $this->getSanctionFormatee(),
            'a_sanction' => $this->aSanction()
        ];
    }

    public function getInformationsTraitement(): array {
        return [
            'statut' => $this->statut,
            'statut_libelle' => $this->getStatutLibelle(),
            'statut_couleur' => $this->getStatutCouleur(),
            'statut_icone' => $this->getStatutIcone(),
            'id_parent_informe' => $this->idParentInforme,
            'parent_prevenu' => $this->aPrevenuParent(),
            'date_rapport' => $this->dateRapport
        ];
    }

    // === TOARRAY (adapté) ===
    public function toArray(): array {
        return array_merge(
            [
                'id_discipline' => $this->idDiscipline,
                'id_eleve' => $this->idEleve
            ],
            $this->getInformationsIncident(),
            $this->getInformationsFaute(),
            $this->getInformationsPreuve(),
            $this->getInformationsSanction(),
            $this->getInformationsTraitement(),
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

    // === VALIDATION (adaptée) ===
    public function isValid(): bool {
        return !empty($this->idEleve) &&
               !empty($this->typeInfraction) &&
               in_array($this->typeInfraction, $this->getTypesFauteDisponibles()) &&
               !empty($this->description) &&
               !empty($this->dateInfraction) &&
               !empty($this->idPersonnelRapport);
    }

    public function validerCoherence(): array {
        $erreurs = [];
        
        if (empty($this->description) || strlen($this->description) < 10) {
            $erreurs[] = 'La description doit contenir au moins 10 caractères';
        }
        
        if (!empty($this->dateInfraction)) {
            $date = new DateTime($this->dateInfraction);
            $aujourdHui = new DateTime();
            
            if ($date > $aujourdHui) {
                $erreurs[] = 'La date de l\'incident ne peut pas être dans le futur';
            }
            
            if ($date < $aujourdHui->sub(new DateInterval('P1Y'))) {
                $erreurs[] = 'La date de l\'incident est trop ancienne';
            }
        }
        
        if (!empty($this->lieu) && !in_array($this->lieu, $this->getLieuxIncidentsDisponibles())) {
            $erreurs[] = 'Le lieu de l\'incident n\'est pas valide';
        }
        
        if (empty($this->idPersonnelRapport)) {
            $erreurs[] = 'Le personnel rapporteur doit être spécifié';
        }
        
        return $erreurs;
    }

    // === RECHERCHE ===
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
        if (strpos(strtolower($this->typeInfraction), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le lieu
        if (!empty($this->lieu) && strpos(strtolower($this->lieu), $terme) !== false) {
            return true;
        }
        
        // Recherche dans les témoins
        if (!empty($this->temoins) && strpos(strtolower($this->temoins), $terme) !== false) {
            return true;
        }
        
        // Recherche dans la sanction
        if (!empty($this->sanction) && strpos(strtolower($this->sanction), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le statut
        if (strpos(strtolower($this->getStatutLibelle()), $terme) !== false) {
            return true;
        }
        
        return false;
    }

    // === EXPORT POUR RAPPORT ===
    public function toRapportArray(): array {
        return [
            'ID Discipline' => $this->idDiscipline,
            'ID Élève' => $this->idEleve,
            'Type Faute' => $this->typeInfraction,
            'Date Incident' => $this->getDateIncidentFormatee(),
            'Lieu Incident' => $this->getLieuIncidentFormate(),
            'Description' => $this->getDescriptionResumee(),
            'Témoins' => $this->getNombreTemoins() . ' témoin(s)',
            'Signalé par' => $this->getSignaleParFormate(),
            'Sanction' => $this->getSanctionFormatee(),
            'Statut' => $this->getStatutLibelle(),
            'Parent informé' => $this->aPrevenuParent() ? 'Oui' : 'Non',
            'Date rapport' => (new DateTime($this->dateRapport))->format('d/m/Y'),
            'Période' => $this->getPeriodeIncident(),
            'Niveau Gravité' => $this->getNiveauGravite()
        ];
    }

    // === CLONAGE ===
    public function copier(): Discipline {
        return new Discipline(
            null, // Nouvel ID
            $this->idEleve,
            $this->typeInfraction,
            $this->description,
            $this->dateInfraction,
            $this->lieu,
            $this->temoins,
            $this->sanction,
            $this->dureeSanction,
            $this->idPersonnelRapport,
            $this->idParentInforme,
            $this->statut,
            $this->dateRapport
        );
    }

    // === INDICATEURS ===
    public function getIndicateurs(): array {
        return [
            'niveau_gravite' => $this->getNiveauGravite(),
            'age_incident' => $this->getAgeIncident(),
            'est_recent' => $this->estRecent(),
            'a_temoins' => $this->aDesTemoins(),
            'nombre_temoins' => $this->getNombreTemoins(),
            'a_sanction' => $this->aSanction(),
            'duree_sanction' => $this->dureeSanction,
            'statut' => $this->statut,
            'est_traite' => $this->estTraite(),
            'parent_prevenu' => $this->aPrevenuParent(),
            'periode' => $this->getPeriodeIncident(),
            'necessite_conseil' => $this->necessiteConseilDiscipline(),
            'necessite_parents' => $this->necessiteInterventionParents(),
            'impact_scolaire' => $this->getImpactScolaire(),
            'mesures_preventives' => count($this->getMesuresPreventives())
        ];
    }

    /**
 * Remplir l'objet Discipline à partir d'un tableau de données
 * 
 * @param array $data Tableau associatif (clés = noms des colonnes en BD)
 * @return self Retourne l'objet pour le chaînage
 */
public function hydrate(array $data)
{
    // Mapping entre les noms de colonnes BD et les propriétés de l'objet
    $mapping = [
        'id_discipline' => 'idDiscipline',
        'id_eleve' => 'idEleve',
        'type_infraction' => 'typeInfraction',
        'description' => 'description',
        'date_infraction' => 'dateInfraction',
        'lieu' => 'lieu',
        'temoins' => 'temoins',
        'sanction' => 'sanction',
        'duree_sanction' => 'dureeSanction',
        'id_personnel_rapport' => 'idPersonnelRapport',
        'id_parent_informe' => 'idParentInforme',
        'statut' => 'statut',
        'date_rapport' => 'dateRapport'
    ];
    
    // Parcourir toutes les données reçues
    foreach ($data as $key => $value) {
        // Vérifier si la clé existe dans le mapping
        if (isset($mapping[$key])) {
            $property = $mapping[$key];
            $this->$property = $value;
        } 
        // Si la clé n'est pas dans le mapping, essayer de trouver un setter
        else {
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
            // Ou essayer d'assigner directement si la propriété existe
            elseif (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
    
    return $this;
}

/**
 * Convertir l'objet Discipline en tableau associatif
 * 
 * @return array Tableau avec tous les attributs
 */

}
?>