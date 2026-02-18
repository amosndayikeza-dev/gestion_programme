<?php

namespace App\Models\Organisme;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use DateTime;
use DateInterval;
use PDO;
use Exception;
class Tuteur
{
    private $idTuteur;
    private $nomComplet;
    private $lienParental;
    private $telephone;
    private $email;
    private $profession;
    private $adresse;
    private $eleves = [];

    public function __construct(
        $idTuteur = null,
        $nomComplet = null,
        $lienParental = null,
        $telephone = null,
        $email = null,
        $profession = null,
        $adresse = null
    ) {
        $this->idTuteur = $idTuteur;
        $this->nomComplet = $nomComplet;
        $this->lienParental = $lienParental;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->profession = $profession;
        $this->adresse = $adresse;
    }

    // Getters
    public function getIdTuteur() { return $this->idTuteur; }
    public function getNomComplet() { return $this->nomComplet; }
    public function getLienParental() { return $this->lienParental; }
    public function getTelephone() { return $this->telephone; }
    public function getEmail() { return $this->email; }
    public function getProfession() { return $this->profession; }
    public function getAdresse() { return $this->adresse; }
    public function getEleves() { return $this->eleves; }

    // Setters
    public function setIdTuteur($idTuteur) { $this->idTuteur = $this->idTuteur; }
    public function setNomComplet($nomComplet) { $this->nomComplet = $nomComplet; }
    public function setLienParental($lienParental) { $this->lienParental = $lienParental; }
    public function setTelephone($telephone) { $this->telephone = $telephone; }
    public function setEmail($email) { $this->email = $email; }
    public function setProfession($profession) { $this->profession = $profession; }
    public function setAdresse($adresse) { $this->adresse = $adresse; }
    public function setEleves($eleves) { $this->eleves = $eleves; }
    
    // Méthodes utilitaires
    public function getNomFormate(): string {
        return ucwords(strtolower($this->nomComplet));
    }

    public function getPrenom(): string {
        $noms = explode(' ', $this->nomComplet);
        return end($noms);
    }

    public function getNom(): string {
        $noms = explode(' ', $this->nomComplet);
        return $noms[0] ?? '';
    }

    public function getAbreviation(): string {
        $noms = explode(' ', $this->nomComplet);
        $abreviation = '';
        
        foreach ($noms as $nom) {
            if (!empty($nom)) {
                $abreviation .= strtoupper(substr($nom, 0, 1));
            }
        }
        
        return $abreviation;
    }

    public function estPere(): bool {
        return $this->lienParental === 'Père';
    }

    public function estMere(): bool {
        return $this->lienParental === 'Mère';
    }

    public function estTuteurLegal(): bool {
        return $this->lienParental === 'Tuteur';
    }

    public function estOncle(): bool {
        return $this->lienParental === 'Oncle';
    }

    public function estTante(): bool {
        return $this->lienParental === 'Tante';
    }

    public function estGrandParent(): bool {
        return $this->lienParental === 'Grand-parent';
    }

    public function estParentDirect(): bool {
        return in_array($this->lienParental, ['Père', 'Mère']);
    }

    public function estParentProche(): bool {
        return in_array($this->lienParental, ['Père', 'Mère', 'Tuteur', 'Oncle', 'Tante']);
    }

    public function getLienParentalCouleur(): string {
        $couleurs = [
            'Père' => 'primary',
            'Mère' => 'danger',
            'Tuteur' => 'success',
            'Oncle' => 'info',
            'Tante' => 'warning',
            'Grand-parent' => 'secondary',
            'Autre' => 'dark'
        ];
        
        return $couleurs[$this->lienParental] ?? 'secondary';
    }

    public function getLienParentalIcone(): string {
        $icones = [
            'Père' => 'fa-male',
            'Mère' => 'fa-female',
            'Tuteur' => 'fa-user-shield',
            'Oncle' => 'fa-user-tie',
            'Tante' => 'fa-user',
            'Grand-parent' => 'fa-user-clock',
            'Autre' => 'fa-user'
        ];
        
        return $icones[$this->lienParental] ?? 'fa-user';
    }

    public function getLiensParentauxDisponibles(): array {
        return ['Père', 'Mère', 'Tuteur', 'Oncle', 'Tante', 'Grand-parent', 'Autre'];
    }

    public function getGenre(): string {
        if ($this->estPere() || $this->estOncle()) {
            return 'Masculin';
        } elseif ($this->estMere() || $this->estTante()) {
            return 'Féminin';
        } else {
            return 'Non spécifié';
        }
    }

    public function getGenrePronom(): string {
        $genre = $this->getGenre();
        
        switch ($genre) {
            case 'Masculin':
                return 'il';
            case 'Féminin':
                return 'elle';
            default:
                return 'il/elle';
        }
    }

    public function aTelephone(): bool {
        return !empty($this->telephone);
    }

    public function aEmail(): bool {
        return !empty($this->email);
    }

    public function aProfession(): bool {
        return !empty($this->profession);
    }

    public function aAdresse(): bool {
        return !empty($this->adresse);
    }

    public function estContactable(): bool {
        return $this->aTelephone() || $this->aEmail();
    }

    public function getMoyenContactPrincipal(): string {
        if ($this->aTelephone()) {
            return 'Téléphone';
        } elseif ($this->aEmail()) {
            return 'Email';
        } else {
            return 'Aucun';
        }
    }

    public function getMoyenContactPrincipalCouleur(): string {
        $moyen = $this->getMoyenContactPrincipal();
        
        $couleurs = [
            'Téléphone' => 'success',
            'Email' => 'info',
            'Aucun' => 'danger'
        ];
        
        return $couleurs[$moyen] ?? 'secondary';
    }

    public function validerTelephone(): bool {
        if (empty($this->telephone)) {
            return true; // Téléphone non obligatoire
        }
        
        // Validation du format téléphonique congolais
        $pattern = '/^(\+243|0)[1-9][0-9]{8}$/';
        return preg_match($pattern, $this->telephone);
    }

    public function validerEmail(): bool {
        if (empty($this->email)) {
            return true; // Email non obligatoire
        }
        
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function getTelephoneFormate(): string {
        if (empty($this->telephone)) {
            return 'Non renseigné';
        }
        
        return $this->telephone;
    }

    public function getEmailFormate(): string {
        if (empty($this->email)) {
            return 'Non renseigné';
        }
        
        return $this->email;
    }

    public function getProfessionFormatee(): string {
        if (empty($this->profession)) {
            return 'Non renseignée';
        }
        
        return ucfirst(strtolower($this->profession));
    }

    public function getCategorieProfessionnelle(): string {
        if (empty($this->profession)) {
            return 'Non spécifiée';
        }
        
        $profession = strtolower($this->profession);
        
        if (strpos($profession, 'enseignant') !== false || strpos($profession, 'professeur') !== false) {
            return 'Éducation';
        } elseif (strpos($profession, 'médecin') !== false || strpos($profession, 'infirmier') !== false) {
            return 'Santé';
        } elseif (strpos($profession, 'ingénieur') !== false || strpos($profession, 'technicien') !== false) {
            return 'Technique';
        } elseif (strpos($profession, 'comptable') !== false || strpos($profession, 'banque') !== false) {
            return 'Finance';
        } elseif (strpos($profession, 'commerçant') !== false || strpos($profession, 'marchand') !== false) {
            return 'Commerce';
        } elseif (strpos($profession, 'fonctionnaire') !== false || strpos($profession, 'administratif') !== false) {
            return 'Administration';
        } elseif (strpos($profession, 'agriculteur') !== false) {
            return 'Agriculture';
        } else {
            return 'Autre';
        }
    }

    public function getCategorieProfessionnelleCouleur(): string {
        $couleurs = [
            'Éducation' => 'primary',
            'Santé' => 'success',
            'Technique' => 'info',
            'Finance' => 'warning',
            'Commerce' => 'success',
            'Administration' => 'secondary',
            'Agriculture' => 'success',
            'Autre' => 'dark'
        ];
        
        return $couleurs[$this->getCategorieProfessionnelle()] ?? 'secondary';
    }

    public function getNiveauSocioEconomique(): string {
        $profession = strtolower($this->profession ?? '');
        
        if (strpos($profession, 'directeur') !== false || strpos($profession, 'ministre') !== false || strpos($profession, 'président') !== false) {
            return 'Élevé';
        } elseif (strpos($profession, 'ingénieur') !== false || strpos($profession, 'médecin') !== false || strpos($profession, 'avocat') !== false) {
            return 'Moyen-Élevé';
        } elseif (strpos($profession, 'enseignant') !== false || strpos($profession, 'fonctionnaire') !== false || strpos($profession, 'comptable') !== false) {
            return 'Moyen';
        } elseif (strpos($profession, 'commerçant') !== false || strpos($profession, 'agriculteur') !== false) {
            return 'Moyen';
        } else {
            return 'Non spécifié';
        }
    }

    public function getNiveauSocioEconomiqueCouleur(): string {
        $couleurs = [
            'Élevé' => 'success',
            'Moyen-Élevé' => 'info',
            'Moyen' => 'warning',
            'Faible' => 'danger',
            'Non spécifié' => 'secondary'
        ];
        
        return $couleurs[$this->getNiveauSocioEconomique()] ?? 'secondary';
    }

    public function getAdresseComplete(): string {
        if (empty($this->adresse)) {
            return 'Non renseignée';
        }
        
        return $this->adresse;
    }

    public function getInformationsContact(): array {
        return [
            'telephone' => $this->telephone,
            'telephone_formate' => $this->getTelephoneFormate(),
            'email' => $this->email,
            'email_formate' => $this->getEmailFormate(),
            'a_telephone' => $this->aTelephone(),
            'a_email' => $this->aEmail(),
            'telephone_valide' => $this->validerTelephone(),
            'email_valide' => $this->validerEmail(),
            'est_contactable' => $this->estContactable(),
            'moyen_contact_principal' => $this->getMoyenContactPrincipal(),
            'moyen_contact_principal_couleur' => $this->getMoyenContactPrincipalCouleur()
        ];
    }

    public function getInformationsProfessionnelles(): array {
        return [
            'profession' => $this->profession,
            'profession_formatee' => $this->getProfessionFormatee(),
            'a_profession' => $this->aProfession(),
            'categorie_professionnelle' => $this->getCategorieProfessionnelle(),
            'categorie_professionnelle_couleur' => $this->getCategorieProfessionnelleCouleur(),
            'niveau_socio_economique' => $this->getNiveauSocioEconomique(),
            'niveau_socio_economique_couleur' => $this->getNiveauSocioEconomiqueCouleur()
        ];
    }

    public function getInformationsPersonnelles(): array {
        return [
            'nom_complet' => $this->nomComplet,
            'nom_formate' => $this->getNomFormate(),
            'prenom' => $this->getPrenom(),
            'nom' => $this->getNom(),
            'abreviation' => $this->getAbreviation(),
            'lien_parental' => $this->lienParental,
            'lien_parental_couleur' => $this->getLienParentalCouleur(),
            'lien_parental_icone' => $this->getLienParentalIcone(),
            'genre' => $this->getGenre(),
            'genre_pronom' => $this->getGenrePronom(),
            'est_parent_direct' => $this->estParentDirect(),
            'est_parent_proche' => $this->estParentProche()
        ];
    }

    public function getInformationsLocalisation(): array {
        return [
            'adresse' => $this->adresse,
            'adresse_complete' => $this->getAdresseComplete(),
            'a_adresse' => $this->aAdresse()
        ];
    }

    public function toArray(): array {
        return array_merge(
            [
                'id_tuteur' => $this->idTuteur,
                'nom_complet' => $this->nomComplet,
                'lien_parental' => $this->lienParental,
                'telephone' => $this->telephone,
                'email' => $this->email,
                'profession' => $this->profession,
                'adresse' => $this->adresse
            ],
            $this->getInformationsPersonnelles(),
            $this->getInformationsContact(),
            $this->getInformationsProfessionnelles(),
            $this->getInformationsLocalisation()
        );
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->nomComplet) &&
               !empty($this->lienParental) &&
               in_array($this->lienParental, $this->getLiensParentauxDisponibles()) &&
               $this->validerTelephone() &&
               $this->validerEmail();
    }

    // Validation du nom
    public function validerNom(): array {
        $erreurs = [];
        
        if (empty($this->nomComplet)) {
            $erreurs[] = 'Le nom complet est obligatoire';
        } elseif (strlen(trim($this->nomComplet)) < 3) {
            $erreurs[] = 'Le nom complet doit contenir au moins 3 caractères';
        } elseif (strlen($this->nomComplet) > 200) {
            $erreurs[] = 'Le nom complet ne peut pas dépasser 200 caractères';
        }
        
        return $erreurs;
    }

    // Validation de la cohérence
    public function validerCoherence(): array {
        $erreurs = array_merge($this->validerNom());
        
        // Vérification de la cohérence entre le genre et le lien parental
        if ($this->estPere() && $this->getGenre() === 'Féminin') {
            $erreurs[] = 'Incohérence : lien parental Père mais genre féminin';
        }
        
        if ($this->estMere() && $this->getGenre() === 'Masculin') {
            $erreurs[] = 'Incohérence : lien parental Mère mais genre masculin';
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
        if (strpos(strtolower($this->nomComplet), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le lien parental
        if (strpos(strtolower($this->lienParental), $terme) !== false) {
            return true;
        }
        
        // Recherche dans la profession
        if (!empty($this->profession) && strpos(strtolower($this->profession), $terme) !== false) {
            return true;
        }
        
        // Recherche dans l'adresse
        if (!empty($this->adresse) && strpos(strtolower($this->adresse), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le téléphone
        if (!empty($this->telephone) && strpos($this->telephone, $terme) !== false) {
            return true;
        }
        
        // Recherche dans l'email
        if (!empty($this->email) && strpos(strtolower($this->email), $terme) !== false) {
            return true;
        }
        
        return false;
    }

    // Export pour les rapports
    public function toRapportArray(): array {
        return [
            'ID' => $this->idTuteur,
            'Nom Complet' => $this->getNomFormate(),
            'Lien Parental' => $this->lienParental,
            'Téléphone' => $this->getTelephoneFormate(),
            'Email' => $this->getEmailFormate(),
            'Profession' => $this->getProfessionFormatee(),
            'Catégorie Professionnelle' => $this->getCategorieProfessionnelle(),
            'Niveau Socio-Économique' => $this->getNiveauSocioEconomique(),
            'Adresse' => $this->getAdresseComplete(),
            'Contactable' => $this->estContactable() ? 'Oui' : 'Non',
            'Parent Direct' => $this->estParentDirect() ? 'Oui' : 'Non'
        ];
    }

    // Clonage
    public function copier(): Tuteur {
        return new Tuteur(
            null, // Nouvel ID
            $this->nomComplet,
            $this->lienParental,
            $this->telephone,
            $this->email,
            $this->profession,
            $this->adresse
        );
    }

    // Statistiques
    public function getIndicateurs(): array {
        return [
            'nom_formate' => $this->getNomFormate(),
            'lien_parental' => $this->lienParental,
            'genre' => $this->getGenre(),
            'est_parent_direct' => $this->estParentDirect(),
            'est_contactable' => $this->estContactable(),
            'a_telephone' => $this->aTelephone(),
            'a_email' => $this->aEmail(),
            'a_profession' => $this->aProfession(),
            'categorie_professionnelle' => $this->getCategorieProfessionnelle(),
            'niveau_socio_economique' => $this->getNiveauSocioEconomique(),
            'moyen_contact_principal' => $this->getMoyenContactPrincipal()
        ];
    }
}
?>
