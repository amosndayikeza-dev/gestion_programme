<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\academique;
use DateTime;
class Etablissement
{
    private $idEcole;
    private $nomEcole;
    private $typeEcole;
    private $ministereTutelle;
    private $province;
    private $territoireCommune;
    private $adresse;
    private $telephone;
    private $email;
    private $codeEcole;
    private $dateCreation;
    private $statut;

    public function __construct(
        $idEcole = null,
        $nomEcole = null,
        $typeEcole = 'Publique',
        $ministereTutelle = 'MINISTERE DE L\'EDUCATION NATIONALE',
        $province = null,
        $territoireCommune = null,
        $adresse = null,
        $telephone = null,
        $email = null,
        $codeEcole = null,
        $dateCreation = null,
        $statut = 'Active'
    ) {
        $this->idEcole = $idEcole;
        $this->nomEcole = $nomEcole;
        $this->typeEcole = $typeEcole;
        $this->ministereTutelle = $ministereTutelle;
        $this->province = $province;
        $this->territoireCommune = $territoireCommune;
        $this->adresse = $adresse;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->codeEcole = $codeEcole;
        $this->dateCreation = $dateCreation ?? date('Y-m-d');
        $this->statut = $statut;
    }

    // Getters
    public function getIdEcole() { return $this->idEcole; }
    public function getNomEcole() { return $this->nomEcole; }
    public function getTypeEcole() { return $this->typeEcole; }
    public function getMinistereTutelle() { return $this->ministereTutelle; }
    public function getProvince() { return $this->province; }
    public function getTerritoireCommune() { return $this->territoireCommune; }
    public function getAdresse() { return $this->adresse; }
    public function getTelephone() { return $this->telephone; }
    public function getEmail() { return $this->email; }
    public function getCodeEcole() { return $this->codeEcole; }
    public function getDateCreation() { return $this->dateCreation; }
    public function getStatut() { return $this->statut; }

    // Setters
    public function setIdEcole($idEcole) { $this->idEcole = $idEcole; }
    public function setNomEcole($nomEcole) { $this->nomEcole = $nomEcole; }
    public function setTypeEcole($typeEcole) { $this->typeEcole = $typeEcole; }
    public function setMinistereTutelle($ministereTutelle) { $this->ministereTutelle = $ministereTutelle; }
    public function setProvince($province) { $this->province = $province; }
    public function setTerritoireCommune($territoireCommune) { $this->territoireCommune = $territoireCommune; }
    public function setAdresse($adresse) { $this->adresse = $adresse; }
    public function setTelephone($telephone) { $this->telephone = $telephone; }
    public function setEmail($email) { $this->email = $email; }
    public function setCodeEcole($codeEcole) { $this->codeEcole = $codeEcole; }
    public function setDateCreation($dateCreation) { $this->dateCreation = $dateCreation; }
    public function setStatut($statut) { $this->statut = $statut; }

    // Méthodes utilitaires
    public function getAnciennete(): int {
        $dateCreation = new DateTime($this->dateCreation);
        $aujourdHui = new DateTime();
        
        return $aujourdHui->diff($dateCreation)->y;
    }

    public function estActive(): bool {
        return $this->statut === 'Active';
    }

    public function estSuspendue(): bool {
        return $this->statut === 'Suspendue';
    }

    public function estFermee(): bool {
        return $this->statut === 'Fermée';
    }

    public function estPublique(): bool {
        return $this->typeEcole === 'Publique';
    }

    public function estPrivee(): bool {
        return $this->typeEcole === 'Privée';
    }

    public function estConfessionnelle(): bool {
        return $this->typeEcole === 'Confessionnelle';
    }

    public function getNomComplet(): string {
        return $this->nomEcole . ' - ' . $this->territoireCommune . ', ' . $this->province;
    }

    public function getCoordonneesComplet(): string {
        $coordonnees = [];
        
        if (!empty($this->adresse)) {
            $coordonnees[] = $this->adresse;
        }
        
        if (!empty($this->telephone)) {
            $coordonnees[] = 'Tél: ' . $this->telephone;
        }
        
        if (!empty($this->email)) {
            $coordonnees[] = 'Email: ' . $this->email;
        }
        
        return implode(' | ', $coordonnees);
    }

    public function getLocalisationComplete(): string {
        return $this->adresse . ', ' . $this->territoireCommune . ', ' . $this->province;
    }

    public function genererCodeEcole(): string {
        if (!empty($this->codeEcole)) {
            return $this->codeEcole;
        }
        
        // Générer un code basé sur le nom, la province et le territoire
        $nom = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $this->nomEcole), 0, 4));
        $province = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $this->province), 0, 3));
        $territoire = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $this->territoireCommune), 0, 3));
        $annee = date('Y');
        
        return $nom . '-' . $province . '-' . $territoire . '-' . $annee;
    }

    public function getStatutCouleur(): string {
        $couleurs = [
            'Active' => 'success',
            'Suspendue' => 'warning',
            'Fermée' => 'danger'
        ];
        
        return $couleurs[$this->statut] ?? 'secondary';
    }

    public function getTypeCouleur(): string {
        $couleurs = [
            'Publique' => 'primary',
            'Privée' => 'info',
            'Confessionnelle' => 'success'
        ];
        
        return $couleurs[$this->typeEcole] ?? 'secondary';
    }

    public function getTypeIcone(): string {
        $icones = [
            'Publique' => 'fa-building',
            'Privée' => 'fa-graduation-cap',
            'Confessionnelle' => 'fa-church'
        ];
        
        return $icones[$this->typeEcole] ?? 'fa-school';
    }

    public function getMinistereAbreviation(): string {
        $abreviations = [
            'MINISTERE DE L\'EDUCATION NATIONALE' => 'MINEDUC',
            'MINISTERE DE L\'ENSEIGNEMENT PRIMAIRE, SECONDAIRE ET PROFESSIONNEL' => 'MINETERP',
            'MINISTERE DE L\'ENSEIGNEMENT SUPERIEUR ET UNIVERSITAIRE' => 'MINESU'
        ];
        
        return $abreviations[$this->ministereTutelle] ?? substr($this->ministereTutelle, 0, 8);
    }

    public function getProvincesDisponibles(): array {
        return [
            'Kinshasa', 'Bandundu', 'Bas-Congo', 'Équateur', 'Kasai-Occidental',
            'Kasai-Oriental', 'Katanga', 'Maniema', 'Nord-Kivu', 'Orientale',
            'Sankuru', 'Sud-Kivu'
        ];
    }

    public function getMinisteresDisponibles(): array {
        return [
            'MINISTERE DE L\'EDUCATION NATIONALE',
            'MINISTERE DE L\'ENSEIGNEMENT PRIMAIRE, SECONDAIRE ET PROFESSIONNEL',
            'MINISTERE DE L\'ENSEIGNEMENT SUPERIEUR ET UNIVERSITAIRE'
        ];
    }

    public function getTypesEcoleDisponibles(): array {
        return ['Publique', 'Privée', 'Confessionnelle'];
    }

    public function validerEmail(): bool {
        if (empty($this->email)) {
            return true; // Email non obligatoire
        }
        
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function validerTelephone(): bool {
        if (empty($this->telephone)) {
            return true; // Téléphone non obligatoire
        }
        
        // Validation du format téléphonique congolais
        $pattern = '/^(\+243|0)[1-9][0-9]{8}$/';
        return preg_match($pattern, $this->telephone);
    }

    public function validerCodeEcole(): bool {
        if (empty($this->codeEcole)) {
            return true; // Code non obligatoire
        }
        
        // Le code doit être unique et suivre un format spécifique
        $pattern = '/^[A-Z]{4}-[A-Z]{3}-[A-Z]{3}-\d{4}$/';
        return preg_match($pattern, $this->codeEcole);
    }

    public function getInformationsAdministratives(): array {
        return [
            'nom_ecole' => $this->nomEcole,
            'code_ecole' => $this->codeEcole,
            'type_ecole' => $this->typeEcole,
            'ministere_tutelle' => $this->ministereTutelle,
            'ministere_abreviation' => $this->getMinistereAbreviation(),
            'statut' => $this->statut,
            'date_creation' => $this->dateCreation,
            'anciennete' => $this->getAnciennete()
        ];
    }

    public function getInformationsGeographiques(): array {
        return [
            'province' => $this->province,
            'territoire_commune' => $this->territoireCommune,
            'adresse' => $this->adresse,
            'localisation_complete' => $this->getLocalisationComplete(),
            'coordonnees_complet' => $this->getCoordonneesComplet()
        ];
    }

    public function getInformationsContact(): array {
        return [
            'telephone' => $this->telephone,
            'email' => $this->email,
            'telephone_valide' => $this->validerTelephone(),
            'email_valide' => $this->validerEmail()
        ];
    }

    public function toArray(): array {
        return array_merge(
            [
                'id_ecole' => $this->idEcole,
                'nom_ecole' => $this->nomEcole,
                'type_ecole' => $this->typeEcole,
                'ministere_tutelle' => $this->ministereTutelle,
                'province' => $this->province,
                'territoire_commune' => $this->territoireCommune,
                'adresse' => $this->adresse,
                'telephone' => $this->telephone,
                'email' => $this->email,
                'code_ecole' => $this->codeEcole,
                'date_creation' => $this->dateCreation,
                'statut' => $this->statut,
                'nom_complet' => $this->getNomComplet(),
                'statut_couleur' => $this->getStatutCouleur(),
                'type_couleur' => $this->getTypeCouleur(),
                'type_icone' => $this->getTypeIcone(),
                'est_active' => $this->estActive(),
                'anciennete' => $this->getAnciennete(),
                'ministere_abreviation' => $this->getMinistereAbreviation()
            ],
            $this->getInformationsAdministratives(),
            $this->getInformationsGeographiques(),
            $this->getInformationsContact()
        );
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->nomEcole) &&
               !empty($this->province) &&
               !empty($this->territoireCommune) &&
               in_array($this->typeEcole, $this->getTypesEcoleDisponibles()) &&
               in_array($this->ministereTutelle, $this->getMinisteresDisponibles()) &&
               in_array($this->statut, ['Active', 'Suspendue', 'Fermée']) &&
               $this->validerEmail() &&
               $this->validerTelephone() &&
               $this->validerCodeEcole();
    }

    // Activation/Désactivation
    public function activer(): bool {
        if ($this->estFermee()) {
            return false; // Ne peut pas réactiver une école fermée
        }
        
        $this->statut = 'Active';
        return true;
    }

    public function suspendre(): bool {
        if ($this->estFermee()) {
            return false; // Ne peut pas suspendre une école fermée
        }
        
        $this->statut = 'Suspendue';
        return true;
    }

    public function fermer(): bool {
        $this->statut = 'Fermée';
        return true;
    }
}
?>
