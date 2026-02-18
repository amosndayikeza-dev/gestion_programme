<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\Organisme;
use DateTime;
use DateInterval;
use PDO;
use Exception;

class Eleve
{
    private $idEleve;
    private $matricule;
    private $nom;
    private $postnom;
    private $prenom;
    private $sexe;
    private $dateNaissance;
    private $lieuNaissance;
    private $nationalite;
    private $adresse;
    private $photo;
    private $statut;

    public function __construct(
        $idEleve = null,
        $matricule = null,
        $nom = null,
        $postnom = null,
        $prenom = null,
        $sexe = null,
        $dateNaissance = null,
        $lieuNaissance = null,
        $nationalite = 'Congolaise',
        $adresse = null,
        $photo = null,
        $statut = 'Actif'
    ) {
        $this->idEleve = $idEleve;
        $this->matricule = $matricule;
        $this->nom = $nom;
        $this->postnom = $postnom;
        $this->prenom = $prenom;
        $this->sexe = $sexe;
        $this->dateNaissance = $dateNaissance;
        $this->lieuNaissance = $lieuNaissance;
        $this->nationalite = $nationalite;
        $this->adresse = $adresse;
        $this->photo = $photo;
        $this->statut = $statut;
    }

    // Getters
    public function getIdEleve() { return $this->idEleve; }
    public function getMatricule() { return $this->matricule; }
    public function getNom() { return $this->nom; }
    public function getPostnom() { return $this->postnom; }
    public function getPrenom() { return $this->prenom; }
    public function getSexe() { return $this->sexe; }
    public function getDateNaissance() { return $this->dateNaissance; }
    public function getLieuNaissance() { return $this->lieuNaissance; }
    public function getNationalite() { return $this->nationalite; }
    public function getAdresse() { return $this->adresse; }
    public function getPhoto() { return $this->photo; }
    public function getStatut() { return $this->statut; }

    // Setters
    public function setIdEleve($idEleve) { $this->idEleve = $idEleve; }
    public function setMatricule($matricule) { $this->matricule = $matricule; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setPostnom($postnom) { $this->postnom = $postnom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setSexe($sexe) { $this->sexe = $sexe; }
    public function setDateNaissance($dateNaissance) { $this->dateNaissance = $dateNaissance; }
    public function setLieuNaissance($lieuNaissance) { $this->lieuNaissance = $lieuNaissance; }
    public function setNationalite($nationalite) { $this->nationalite = $nationalite; }
    public function setAdresse($adresse) { $this->adresse = $adresse; }
    public function setPhoto($photo) { $this->photo = $photo; }
    public function setStatut($statut) { $this->statut = $statut; }

    // Méthodes utilitaires
    public function getNomComplet(): string {
        $nomComplet = trim($this->nom . ' ' . $this->postnom);
        if (!empty($this->prenom)) {
            $nomComplet .= ' ' . $this->prenom;
        }
        return $nomComplet;
    }

    public function getNomAffichage(): string {
        return strtoupper($this->nom) . ' ' . ucfirst($this->postnom) . ' ' . ucfirst($this->prenom);
    }

    public function getAbreviation(): string {
        return strtoupper(substr($this->nom, 0, 1)) . 
               strtoupper(substr($this->postnom, 0, 1)) . 
               strtoupper(substr($this->prenom ?? '', 0, 1));
    }

    public function getAge(): int {
        if (empty($this->dateNaissance)) {
            return 0;
        }
        
        $dateNaissance = new DateTime($this->dateNaissance);
        $aujourdHui = new DateTime();
        
        return $aujourdHui->diff($dateNaissance)->y;
    }

    public function getAgeMois(): int {
        if (empty($this->dateNaissance)) {
            return 0;
        }
        
        $dateNaissance = new DateTime($this->dateNaissance);
        $aujourdHui = new DateTime();
        
        return $dateNaissance->diff($aujourdHui)->m + ($dateNaissance->diff($aujourdHui)->y * 12);
    }

    public function estMasculin(): bool {
        return $this->sexe === 'M';
    }

    public function estFeminin(): bool {
        return $this->sexe === 'F';
    }

    public function getGenre(): string {
        return $this->estMasculin() ? 'Masculin' : 'Féminin';
    }

    public function getGenrePronom(): string {
        return $this->estMasculin() ? 'il' : 'elle';
    }

    public function getGenreAdjectif(): string {
        return $this->estMasculin() ? 'actif' : 'active';
    }

    public function estCongolais(): bool {
        return $this->nationalite === 'Congolaise';
    }

    public function estActif(): bool {
        return $this->statut === 'Actif';
    }

    public function estTransfere(): bool {
        return $this->statut === 'Transféré';
    }

    public function estDiplome(): bool {
        return $this->statut === 'Diplômé';
    }

    public function estExclu(): bool {
        return $this->statut === 'Exclu';
    }

    public function getStatutCouleur(): string {
        $couleurs = [
            'Actif' => 'success',
            'Transféré' => 'info',
            'Diplômé' => 'primary',
            'Exclu' => 'danger'
        ];
        
        return $couleurs[$this->statut] ?? 'secondary';
    }

    public function getStatutIcone(): string {
        $icones = [
            'Actif' => 'fa-user',
            'Transféré' => 'fa-exchange-alt',
            'Diplômé' => 'fa-graduation-cap',
            'Exclu' => 'fa-user-times'
        ];
        
        return $icones[$this->statut] ?? 'fa-user';
    }

    public function getPhotoUrl(): string {
        if (!empty($this->photo)) {
            return '/uploads/photos/' . $this->photo;
        }
        
        // Photo par défaut selon le sexe
        return $this->estMasculin() ? 
            '/images/default-boy.png' : 
            '/images/default-girl.png';
    }

    public function aPhoto(): bool {
        return !empty($this->photo) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/' . $this->photo);
    }

    public function getAgeScolaireAppropriate(): bool {
        $age = $this->getAge();
        return $age >= 5 && $age <= 25; // Plage raisonnable pour l'école secondaire
    }

    public function getDateNaissanceFormatee(): string {
        if (empty($this->dateNaissance)) {
            return 'Inconnue';
        }
        
        $date = new DateTime($this->dateNaissance);
        return $date->format('d/m/Y');
    }

    public function getDateNaissanceComplete(): string {
        if (empty($this->dateNaissance) || empty($this->lieuNaissance)) {
            return 'Date de naissance inconnue';
        }
        
        $date = new DateTime($this->dateNaissance);
        return 'Né(e) le ' . $date->format('d/m/Y') . ' à ' . $this->lieuNaissance;
    }

    public function getAdresseComplete(): string {
        $adresse = $this->adresse ?? 'Non renseignée';
        
        if (!empty($this->nationalite) && $this->nationalite !== 'Congolaise') {
            $adresse .= ' (' . $this->nationalite . ')';
        }
        
        return $adresse;
    }

    public function getInformationsContact(): array {
        return [
            'adresse' => $this->adresse,
            'nationalite' => $this->nationalite,
            'est_congolais' => $this->estCongolais(),
            'adresse_complete' => $this->getAdresseComplete()
        ];
    }

    public function getInformationsPersonnelles(): array {
        return [
            'matricule' => $this->matricule,
            'nom_complet' => $this->getNomComplet(),
            'nom_affichage' => $this->getNomAffichage(),
            'abreviation' => $this->getAbreviation(),
            'sexe' => $this->sexe,
            'genre' => $this->getGenre(),
            'genre_pronom' => $this->getGenrePronom(),
            'date_naissance' => $this->dateNaissance,
            'date_naissance_formatee' => $this->getDateNaissanceFormatee(),
            'lieu_naissance' => $this->lieuNaissance,
            'date_naissance_complete' => $this->getDateNaissanceComplete(),
            'age' => $this->getAge(),
            'age_mois' => $this->getAgeMois(),
            'age_appropriate' => $this->getAgeScolaireAppropriate()
        ];
    }

    public function getInformationsScolaires(): array {
        return [
            'matricule' => $this->matricule,
            'statut' => $this->statut,
            'statut_couleur' => $this->getStatutCouleur(),
            'statut_icone' => $this->getStatutIcone(),
            'est_actif' => $this->estActif(),
            'est_transfere' => $this->estTransfere(),
            'est_diplome' => $this->estDiplome(),
            'est_exclu' => $this->estExclu(),
            'photo_url' => $this->getPhotoUrl(),
            'a_photo' => $this->aPhoto()
        ];
    }

    public function peutEtreInscrit(): bool {
        return $this->estActif() && $this->getAgeScolaireAppropriate();
    }

    public function peutEtreTransfere(): bool {
        return $this->estActif();
    }

    public function peutEtreExclu(): bool {
        return $this->estActif();
    }

    public function peutEtreDiplome(): bool {
        return $this->estActif() && $this->getAge() >= 16;
    }

    public function transférer(): bool {
        if (!$this->peutEtreTransfere()) {
            return false;
        }
        
        $this->statut = 'Transféré';
        return true;
    }

    public function exclure(): bool {
        if (!$this->peutEtreExclu()) {
            return false;
        }
        
        $this->statut = 'Exclu';
        return true;
    }

    public function diplomer(): bool {
        if (!$this->peutEtreDiplome()) {
            return false;
        }
        
        $this->statut = 'Diplômé';
        return true;
    }

    public function reactiver(): bool {
        if ($this->estActif()) {
            return false;
        }
        
        $this->statut = 'Actif';
        return true;
    }

    public function getNationalitesDisponibles(): array {
        return [
            'Congolaise' => 'Congo-Kinshasa',
            'Rwandaise' => 'Rwanda',
            'Burundaise' => 'Burundi',
            'Ugandaise' => 'Ouganda',
            'Tanzanienne' => 'Tanzanie',
            'Zambienne' => 'Zambie',
            'Angolaise' => 'Angola',
            'Centrafricaine' => 'République Centrafricaine',
            'Camerounaise' => 'Cameroun',
            'Gabonaise' => 'Gabon',
            'Tchadienne' => 'Tchad',
            'Soudanaise' => 'Soudan',
            'Autre' => 'Autre'
        ];
    }

    public function getStatutsDisponibles(): array {
        return ['Actif', 'Transféré', 'Diplômé', 'Exclu'];
    }

    public function toArray(): array {
        return array_merge(
            [
                'id_eleve' => $this->idEleve,
                'matricule' => $this->matricule,
                'nom' => $this->nom,
                'postnom' => $this->postnom,
                'prenom' => $this->prenom,
                'sexe' => $this->sexe,
                'lieu_naissance' => $this->lieuNaissance,
                'nationalite' => $this->nationalite,
                'adresse' => $this->adresse,
                'photo' => $this->photo,
                'statut' => $this->statut
            ],
            $this->getInformationsPersonnelles(),
            $this->getInformationsContact(),
            $this->getInformationsScolaires()
        );
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->matricule) &&
               !empty($this->nom) &&
               !empty($this->postnom) &&
               in_array($this->sexe, ['M', 'F']) &&
               !empty($this->dateNaissance) &&
               !empty($this->nationalite) &&
               in_array($this->statut, $this->getStatutsDisponibles()) &&
               $this->getAgeScolaireAppropriate();
    }

    // Validation du matricule
    public function validerMatricule(): bool {
        if (empty($this->matricule)) {
            return false;
        }
        
        // Format: ANNEE-SEQUENCE-NUMERO (ex: 2024-001-1234)
        $pattern = '/^\d{4}-\d{3}-\d{4}$/';
        return preg_match($pattern, $this->matricule);
    }

    // Validation de la date de naissance
    public function validerDateNaissance(): bool {
        if (empty($this->dateNaissance)) {
            return false;
        }
        
        try {
            $date = new DateTime($this->dateNaissance);
            $aujourdHui = new DateTime();
            
            // La date ne doit pas être dans le futur
            if ($date > $aujourdHui) {
                return false;
            }
            
            // L'âge doit être raisonnable
            $age = $aujourdHui->diff($date)->y;
            return $age >= 5 && $age <= 25;
            
        } catch (Exception $e) {
            return false;
        }
    }

    // Génération automatique du matricule
    public function genererMatricule(int $annee = null, int $sequence = null, int $numero = null): string {
        $annee = $annee ?? date('Y');
        $sequence = $sequence ?? 1;
        $numero = $numero ?? rand(1000, 9999);
        
        return sprintf('%04d-%03d-%04d', $annee, $sequence, $numero);
    }

    // Recherche textuelle
    public function rechercher(string $terme): bool {
        $terme = strtolower(trim($terme));
        
        if (empty($terme)) {
            return false;
        }
        
        // Recherche dans le nom
        if (strpos(strtolower($this->nom), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le postnom
        if (strpos(strtolower($this->postnom), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le prénom
        if (!empty($this->prenom) && strpos(strtolower($this->prenom), $terme) !== false) {
            return true;
        }
        
        // Recherche dans le matricule
        if (strpos(strtolower($this->matricule), $terme) !== false) {
            return true;
        }
        
        return false;
    }

    // Export pour les rapports
    public function toRapportArray(): array {
        return [
            'Matricule' => $this->matricule,
            'Nom' => $this->getNomAffichage(),
            'Sexe' => $this->getGenre(),
            'Date de naissance' => $this->getDateNaissanceFormatee(),
            'Lieu de naissance' => $this->lieuNaissance,
            'Nationalité' => $this->nationalite,
            'Âge' => $this->getAge(),
            'Adresse' => $this->adresse,
            'Statut' => $this->statut
        ];
    }
}
?>
