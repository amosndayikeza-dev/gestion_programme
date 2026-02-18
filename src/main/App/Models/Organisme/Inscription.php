<?php
namespace App\Models\Organisme;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use DateTime;
use DateInterval;
use PDO;
use Exception;

class Inscription
{
    private $idInscription;
    private $idEleve;
    private $idClasse;
    private $idAnnee;
    private $dateInscription;
    private $typeInscription;
    private $statut;

    public function __construct(
        $idInscription = null,
        $idEleve = null,
        $idClasse = null,
        $idAnnee = null,
        $dateInscription = null,
        $typeInscription = null,
        $statut = 'Confirmée'
    ) {
        $this->idInscription = $idInscription;
        $this->idEleve = $idEleve;
        $this->idClasse = $idClasse;
        $this->idAnnee = $idAnnee;
        $this->dateInscription = $dateInscription ?? date('Y-m-d');
        $this->typeInscription = $typeInscription;
        $this->statut = $statut;
    }

    // Getters
    public function getIdInscription() { return $this->idInscription; }
    public function getIdEleve() { return $this->idEleve; }
    public function getIdClasse() { return $this->idClasse; }
    public function getIdAnnee() { return $this->idAnnee; }
    public function getDateInscription() { return $this->dateInscription; }
    public function getTypeInscription() { return $this->typeInscription; }
    public function getStatut() { return $this->statut; }

    // Setters
    public function setIdInscription($idInscription) { $this->idInscription = $idInscription; }
    public function setIdEleve($idEleve) { $this->idEleve = $idEleve; }
    public function setIdClasse($idClasse) { $this->idClasse = $idClasse; }
    public function setIdAnnee($idAnnee) { $this->idAnnee = $idAnnee; }
    public function setDateInscription($dateInscription) { $this->dateInscription = $dateInscription; }
    public function setTypeInscription($typeInscription) { $this->typeInscription = $typeInscription; }
    public function setStatut($statut) { $this->statut = $statut; }

    // Méthodes utilitaires
    public function getDateInscriptionFormatee(): string {
        $date = new DateTime($this->dateInscription);
        return $date->format('d/m/Y');
    }

    public function getDateInscriptionComplete(): string {
        $date = new DateTime($this->dateInscription);
        return $date->format('d/m/Y à H:i');
    }

    public function getAgeInscription(): int {
        return (new DateTime())->diff(new DateTime($this->dateInscription))->days;
    }

    public function estRecente(): bool {
        return $this->getAgeInscription() <= 30;
    }

    public function estAncienne(): bool {
        return $this->getAgeInscription() > 90;
    }

    public function estNouvelle(): bool {
        return $this->typeInscription === 'Nouvelle';
    }

    public function estReinscription(): bool {
        return $this->typeInscription === 'Réinscription';
    }

    public function estTransfert(): bool {
        return $this->typeInscription === 'Transfert';
    }

    public function getTypeInscriptionCouleur(): string {
        $couleurs = [
            'Nouvelle' => 'primary',
            'Réinscription' => 'success',
            'Transfert' => 'info'
        ];
        
        return $couleurs[$this->typeInscription] ?? 'secondary';
    }

    public function getTypeInscriptionIcone(): string {
        $icones = [
            'Nouvelle' => 'fa-user-plus',
            'Réinscription' => 'fa-redo',
            'Transfert' => 'fa-exchange-alt'
        ];
        
        return $icones[$this->typeInscription] ?? 'fa-question-circle';
    }

    public function getTypesInscriptionDisponibles(): array {
        return ['Nouvelle', 'Réinscription', 'Transfert'];
    }

    public function estConfirmee(): bool {
        return $this->statut === 'Confirmée';
    }

    public function estEnAttente(): bool {
        return $this->statut === 'En attente';
    }

    public function estAnnulee(): bool {
        return $this->statut === 'Annulée';
    }

    public function getStatutCouleur(): string {
        $couleurs = [
            'Confirmée' => 'success',
            'En attente' => 'warning',
            'Annulée' => 'danger'
        ];
        
        return $couleurs[$this->statut] ?? 'secondary';
    }

    public function getStatutIcone(): string {
        $icones = [
            'Confirmée' => 'fa-check-circle',
            'En attente' => 'fa-clock',
            'Annulée' => 'fa-times-circle'
        ];
        
        return $icones[$this->statut] ?? 'fa-question-circle';
    }

    public function getStatutsDisponibles(): array {
        return ['Confirmée', 'En attente', 'Annulée'];
    }

    public function estActive(): bool {
        return $this->estConfirmée();
    }

    public function estEnCours(): bool {
        return $this->estConfirmée() && !$this->estAncienne();
    }

    public function peutEtreModifiee(): bool {
        return $this->estEnAttente() || $this->estRecente();
    }

    public function peutEtreAnnulee(): bool {
        return $this->estEnAttente() || $this->estRecente();
    }

    public function peutEtreConfirmee(): bool {
        return $this->estEnAttente();
    }

    public function getPeriodeInscription(): string {
        $date = new DateTime($this->dateInscription);
        $mois = (int)$date->format('m');
        
        if ($mois >= 8 && $mois <= 10) {
            return 'Pré-rentrée';
        } elseif ($mois >= 11 || $mois <= 1) {
            return 'Premier trimestre';
        } elseif ($mois >= 2 && $mois <= 4) {
            return 'Deuxième trimestre';
        } elseif ($mois >= 5 && $mois <= 7) {
            return 'Troisième trimestre';
        } else {
            return 'Non définie';
        }
    }

    public function getPeriodeInscriptionCouleur(): string {
        $couleurs = [
            'Pré-rentrée' => 'primary',
            'Premier trimestre' => 'success',
            'Deuxième trimestre' => 'info',
            'Troisième trimestre' => 'warning',
            'Non définie' => 'secondary'
        ];
        
        return $couleurs[$this->getPeriodeInscription()] ?? 'secondary';
    }

    public function getAnneeScolaire(): string {
        // Supposons que l'année scolaire est dans l'année de l'inscription
        $date = new DateTime($this->dateInscription);
        $annee = (int)$date->format('Y');
        $mois = (int)$date->format('m');
        
        if ($mois >= 8) {
            return $annee . '-' . ($annee + 1);
        } else {
            return ($annee - 1) . '-' . $annee;
        }
    }

    public function getTrimestreInscription(): string {
        $date = new DateTime($this->dateInscription);
        $mois = (int)$date->format('m');
        
        if ($mois >= 9 && $mois <= 11) {
            return '1er trimestre';
        } elseif ($mois >= 12 || $mois <= 2) {
            return '2ème trimestre';
        } elseif ($mois >= 3 && $mois <= 5) {
            return '3ème trimestre';
        } else {
            return 'Vacances';
        }
    }

    public function getPriorite(): string {
        $priorites = [
            'Nouvelle' => 'Haute',
            'Réinscription' => 'Moyenne',
            'Transfert' => 'Haute'
        ];
        
        return $priorites[$this->typeInscription] ?? 'Moyenne';
    }

    public function getPrioriteCouleur(): string {
        $couleurs = [
            'Haute' => 'danger',
            'Moyenne' => 'warning',
            'Faible' => 'success'
        ];
        
        return $couleurs[$this->getPriorite()] ?? 'secondary';
    }

    public function getDocumentsRequis(): array {
        $documents = [
            'Acte de naissance',
            'Certificat de scolarité précédent',
            'Bulletin du dernier trimestre'
        ];
        
        if ($this->estTransfert()) {
            $documents[] = 'Certificat de transfert';
            $documents[] = 'Attestation de radiation';
        }
        
        if ($this->estNouvelle()) {
            $documents[] = 'Photo d\'identité';
            $documents[] = 'Fiche d\'inscription';
        }
        
        return $documents;
    }

    public function getFraisInscription(): array {
        $frais = [
            'Frais d\'inscription' => 50,
            'Frais de dossier' => 25
        ];
        
        if ($this->estTransfert()) {
            $frais['Frais de transfert'] = 30;
        }
        
        if ($this->estNouvelle()) {
            $frais['Frais de première inscription'] = 40;
        }
        
        return $frais;
    }

    public function getTotalFrais(): float {
        return array_sum($this->getFraisInscription());
    }

    public function getTotalFraisFormate(): string {
        return number_format($this->getTotalFrais(), 2, ',', ' ') . ' $';
    }

    public function getEtapesValidation(): array {
        $etapes = [
            'Réception de la demande',
            'Vérification des documents',
            'Validation administrative',
            'Confirmation de l\'inscription'
        ];
        
        if ($this->estTransfert()) {
            array_unshift($etapes, 'Contact avec l\'établissement d\'origine');
        }
        
        return $etapes;
    }

    public function getEtapeActuelle(): int {
        if ($this->estAnnulee()) {
            return 0; // Annulée
        } elseif ($this->estConfirmee()) {
            return count($this->getEtapesValidation()); // Terminée
        } elseif ($this->estEnAttente()) {
            return 2; // En cours de validation
        }
        
        return 1; // Début
    }

    public function getProgression(): float {
        $totalEtapes = count($this->getEtapesValidation());
        $etapeActuelle = $this->getEtapeActuelle();
        
        if ($this->estAnnulee()) {
            return 0.0;
        }
        
        return ($etapeActuelle / $totalEtapes) * 100;
    }

    public function getProgressionCouleur(): string {
        $progression = $this->getProgression();
        
        if ($progression === 0) {
            return 'danger';
        } elseif ($progression < 50) {
            return 'warning';
        } elseif ($progression < 100) {
            return 'info';
        } else {
            return 'success';
        }
    }

    public function getInformationsAdministratives(): array {
        return [
            'date_inscription' => $this->dateInscription,
            'date_formatee' => $this->getDateInscriptionFormatee(),
            'date_complete' => $this->getDateInscriptionComplete(),
            'age_inscription' => $this->getAgeInscription(),
            'periode_inscription' => $this->getPeriodeInscription(),
            'periode_inscription_couleur' => $this->getPeriodeInscriptionCouleur(),
            'annee_scolaire' => $this->getAnneeScolaire(),
            'trimestre_inscription' => $this->getTrimestreInscription(),
            'est_recente' => $this->estRecente(),
            'est_ancienne' => $this->estAncienne()
        ];
    }

    public function getInformationsType(): array {
        return [
            'type_inscription' => $this->typeInscription,
            'type_inscription_couleur' => $this->getTypeInscriptionCouleur(),
            'type_inscription_icone' => $this->getTypeInscriptionIcone(),
            'est_nouvelle' => $this->estNouvelle(),
            'est_reinscription' => $this->estReinscription(),
            'est_transfert' => $this->estTransfert(),
            'priorite' => $this->getPriorite(),
            'priorite_couleur' => $this->getPrioriteCouleur()
        ];
    }

    public function getInformationsStatut(): array {
        return [
            'statut' => $this->statut,
            'statut_couleur' => $this->getStatutCouleur(),
            'statut_icone' => $this->getStatutIcone(),
            'est_confirmee' => $this->estConfirmée(),
            'est_en_attente' => $this->estEnAttente(),
            'est_annulee' => $this->estAnnulee(),
            'est_active' => $this->estActive(),
            'est_en_cours' => $this->estEnCours(),
            'peut_etre_modifiee' => $this->peutEtreModifiee(),
            'peut_etre_annulee' => $this->peutEtreAnnulee(),
            'peut_etre_confirmee' => $this->peutEtreConfirmee()
        ];
    }

    public function getInformationsFinancieres(): array {
        return [
            'frais_inscription' => $this->getFraisInscription(),
            'total_frais' => $this->getTotalFrais(),
            'total_frais_formate' => $this->getTotalFraisFormate()
        ];
    }

    public function getInformationsProcedure(): array {
        return [
            'documents_requis' => $this->getDocumentsRequis(),
            'etapes_validation' => $this->getEtapesValidation(),
            'etape_actuelle' => $this->getEtapeActuelle(),
            'progression' => $this->getProgression(),
            'progression_couleur' => $this->getProgressionCouleur()
        ];
    }

    public function toArray(): array {
        return array_merge(
            [
                'id_inscription' => $this->idInscription,
                'id_eleve' => $this->idEleve,
                'id_classe' => $this->idClasse,
                'id_annee' => $this->idAnnee
            ],
            $this->getInformationsAdministratives(),
            $this->getInformationsType(),
            $this->getInformationsStatut(),
            $this->getInformationsFinancieres(),
            $this->getInformationsProcedure()
        );
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->idEleve) &&
               !empty($this->idClasse) &&
               !empty($this->idAnnee) &&
               !empty($this->dateInscription) &&
               in_array($this->typeInscription, $this->getTypesInscriptionDisponibles()) &&
               in_array($this->statut, $this->getStatutsDisponibles());
    }

    // Validation de la date
    public function validerDate(): array {
        $erreurs = [];
        
        if (empty($this->dateInscription)) {
            $erreurs[] = 'La date d\'inscription est obligatoire';
        } else {
            try {
                $date = new DateTime($this->dateInscription);
                $aujourdHui = new DateTime();
                
                if ($date > $aujourdHui) {
                    $erreurs[] = 'La date d\'inscription ne peut pas être dans le futur';
                }
                
                if ($date < $aujourdHui->sub(new DateInterval('P2Y'))) {
                    $erreurs[] = 'La date d\'inscription est trop ancienne';
                }
            } catch (Exception $e) {
                $erreurs[] = 'La date d\'inscription n\'est pas valide';
            }
        }
        
        return $erreurs;
    }

    // Validation de la cohérence
    public function validerCoherence(): array {
        $erreurs = array_merge($this->validerDate());
        
        // Vérification de la cohérence entre le type et le statut
        if ($this->estAnnulee() && $this->estConfirmee()) {
            $erreurs[] = 'Incohérence : inscription à la fois confirmée et annulée';
        }
        
        return $erreurs;
    }

    // Gestion du statut
    public function confirmer(): bool {
        if (!$this->peutEtreConfirmee()) {
            return false;
        }
        
        $this->statut = 'Confirmée';
        return true;
    }

    public function annuler(): bool {
        if (!$this->peutEtreAnnulee()) {
            return false;
        }
        
        $this->statut = 'Annulée';
        return true;
    }

    public function mettreEnAttente(): bool {
        if ($this->estConfirmée()) {
            return false;
        }
        
        $this->statut = 'En attente';
        return true;
    }

    // Export pour les rapports
    public function toRapportArray(): array {
        return [
            'ID' => $this->idInscription,
            'ID Élève' => $this->idEleve,
            'ID Classe' => $this->idClasse,
            'ID Année' => $this->idAnnee,
            'Date Inscription' => $this->getDateInscriptionFormatee(),
            'Type Inscription' => $this->typeInscription,
            'Statut' => $this->statut,
            'Période' => $this->getPeriodeInscription(),
            'Année Scolaire' => $this->getAnneeScolaire(),
            'Priorité' => $this->getPriorite(),
            'Total Frais' => $this->getTotalFraisFormate(),
            'Progression' => round($this->getProgression(), 1) . '%',
            'Documents Requis' => count($this->getDocumentsRequis())
        ];
    }

    // Clonage
    public function copier(): Inscription {
        return new Inscription(
            null, // Nouvel ID
            $this->idEleve,
            $this->idClasse,
            $this->idAnnee,
            $this->dateInscription,
            $this->typeInscription,
            $this->statut
        );
    }

    // Statistiques
    public function getIndicateurs(): array {
        return [
            'date_inscription' => $this->getDateInscriptionFormatee(),
            'type_inscription' => $this->typeInscription,
            'statut' => $this->statut,
            'periode_inscription' => $this->getPeriodeInscription(),
            'annee_scolaire' => $this->getAnneeScolaire(),
            'est_active' => $this->estActive(),
            'est_recente' => $this->estRecente(),
            'priorite' => $this->getPriorite(),
            'progression' => round($this->getProgression(), 1),
            'total_frais' => $this->getTotalFrais(),
            'nombre_documents' => count($this->getDocumentsRequis())
        ];
    }
}
?>
