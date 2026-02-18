<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
namespace App\Models\academique;
class OptionEtude
{
    private $idOption;
    private $nomOption;
    private $description;

    public function __construct(
        $idOption = null,
        $nomOption = null,
        $description = null
    ) {
        $this->idOption = $idOption;
        $this->nomOption = $nomOption;
        $this->description = $description;
    }

    // Getters
    public function getIdOption() { return $this->idOption; }
    public function getNomOption() { return $this->nomOption; }
    public function getDescription() { return $this->description; }

    // Setters
    public function setIdOption($idOption) { $this->idOption = $idOption; }
    public function setNomOption($nomOption) { $this->nomOption = $nomOption; }
    public function setDescription($description) { $this->description = $description; }

    // Méthodes utilitaires
    public function getNomFormate(): string {
        return ucfirst(strtolower($this->nomOption));
    }

    public function getCodeOption(): string {
        return strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $this->nomOption), 0, 3));
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

    public function aDescription(): bool {
        return !empty($this->description);
    }

    public function getMotsCles(): array {
        $mots = [];
        
        if (!empty($this->nomOption)) {
            $mots = array_merge($mots, preg_split('/[\s-]+/', $this->nomOption));
        }
        
        if (!empty($this->description)) {
            $mots = array_merge($mots, preg_split('/[\s,.;:]+/', $this->description));
        }
        
        return array_filter(array_unique(array_map('strtolower', $mots)));
    }

    public function estOptionScientifique(): bool {
        return strpos(strtolower($this->nomOption), 'scientif') !== false;
    }

    public function estOptionLitteraire(): bool {
        return strpos(strtolower($this->nomOption), 'littér') !== false;
    }

    public function estOptionCommerciale(): bool {
        return strpos(strtolower($this->nomOption), 'commerci') !== false;
    }

    public function estOptionPedagogique(): bool {
        return strpos(strtolower($this->nomOption), 'pédagog') !== false;
    }

    public function estOptionArtistique(): bool {
        return strpos(strtolower($this->nomOption), 'artist') !== false;
    }

    public function estOptionTechnique(): bool {
        return strpos(strtolower($this->nomOption), 'techn') !== false;
    }

    public function getCategorie(): string {
        if ($this->estOptionScientifique()) return 'Scientifique';
        if ($this->estOptionLitteraire()) return 'Littéraire';
        if ($this->estOptionCommerciale()) return 'Commerciale';
        if ($this->estOptionPedagogique()) return 'Pédagogique';
        if ($this->estOptionArtistique()) return 'Artistique';
        if ($this->estOptionTechnique()) return 'Technique';
        
        return 'Autre';
    }

    public function getCategorieCouleur(): string {
        $couleurs = [
            'Scientifique' => 'primary',
            'Littéraire' => 'success',
            'Commerciale' => 'info',
            'Pédagogique' => 'warning',
            'Artistique' => 'danger',
            'Technique' => 'dark',
            'Autre' => 'secondary'
        ];
        
        return $couleurs[$this->getCategorie()] ?? 'secondary';
    }

    public function getCategorieIcone(): string {
        $icones = [
            'Scientifique' => 'fa-flask',
            'Littéraire' => 'fa-book',
            'Commerciale' => 'fa-chart-line',
            'Pédagogique' => 'fa-graduation-cap',
            'Artistique' => 'fa-palette',
            'Technique' => 'fa-cogs',
            'Autre' => 'fa-question-circle'
        ];
        
        return $icones[$this->getCategorie()] ?? 'fa-question-circle';
    }

    public function getMatieresPrincipales(): array {
        $matieres = [];
        
        switch ($this->getCategorie()) {
            case 'Scientifique':
                $matieres = ['Mathématiques', 'Physique', 'Chimie', 'Biologie'];
                break;
            case 'Littéraire':
                $matieres = ['Français', 'Latin', 'Philosophie', 'Histoire'];
                break;
            case 'Commerciale':
                $matieres = ['Comptabilité', 'Économie', 'Droit', 'Gestion'];
                break;
            case 'Pédagogique':
                $matieres = ['Pédagogie', 'Psychologie', 'Didactique', 'Éducation'];
                break;
            case 'Artistique':
                $matieres = ['Arts plastiques', 'Musique', 'Théâtre', 'Design'];
                break;
            case 'Technique':
                $matieres = ['Technologie', 'Informatique', 'Électronique', 'Mécanique'];
                break;
        }
        
        return $matieres;
    }

    public function getDebouches(): array {
        $debouches = [];
        
        switch ($this->getCategorie()) {
            case 'Scientifique':
                $debouches = ['Médecine', 'Ingénierie', 'Recherche', 'Pharmacie'];
                break;
            case 'Littéraire':
                $debouches = ['Droit', 'Journalisme', 'Enseignement', 'Traduction'];
                break;
            case 'Commerciale':
                $debouches = ['Gestion', 'Commerce', 'Banque', 'Marketing'];
                break;
            case 'Pédagogique':
                $debouches = ['Enseignement', 'Conseil pédagogique', 'Formation', 'Éducation'];
                break;
            case 'Artistique':
                $debouches = ['Arts', 'Design', 'Communication', 'Culture'];
                break;
            case 'Technique':
                $debouches = ['Industrie', 'Informatique', 'Maintenance', 'Production'];
                break;
        }
        
        return $debouches;
    }

    public function getNiveauDifficulte(): string {
        $niveaux = [
            'Scientifique' => 'Élevé',
            'Littéraire' => 'Moyen',
            'Commerciale' => 'Moyen',
            'Pédagogique' => 'Moyen',
            'Artistique' => 'Variable',
            'Technique' => 'Élevé'
        ];
        
        return $niveaux[$this->getCategorie()] ?? 'Moyen';
    }

    public function getNiveauDifficulteCouleur(): string {
        $couleurs = [
            'Élevé' => 'danger',
            'Moyen' => 'warning',
            'Variable' => 'info',
            'Faible' => 'success'
        ];
        
        return $couleurs[$this->getNiveauDifficulte()] ?? 'secondary';
    }

    public function getDureeEtudes(): string {
        return '6 ans'; // Standard pour l'école secondaire congolaise
    }

    public function toArray(): array {
        return [
            'id_option' => $this->idOption,
            'nom_option' => $this->nomOption,
            'nom_formate' => $this->getNomFormate(),
            'code_option' => $this->getCodeOption(),
            'description' => $this->description,
            'description_resumee' => $this->getDescriptionResumee(),
            'a_description' => $this->aDescription(),
            'categorie' => $this->getCategorie(),
            'categorie_couleur' => $this->getCategorieCouleur(),
            'categorie_icone' => $this->getCategorieIcone(),
            'matieres_principales' => $this->getMatieresPrincipales(),
            'debouches' => $this->getDebouches(),
            'niveau_difficulte' => $this->getNiveauDifficulte(),
            'niveau_difficulte_couleur' => $this->getNiveauDifficulteCouleur(),
            'duree_etudes' => $this->getDureeEtudes(),
            'mots_cles' => $this->getMotsCles()
        ];
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->nomOption) && strlen(trim($this->nomOption)) >= 2;
    }

    // Validation du nom
    public function validerNom(): array {
        $erreurs = [];
        
        if (empty($this->nomOption)) {
            $erreurs[] = 'Le nom de l\'option est obligatoire';
        } elseif (strlen(trim($this->nomOption)) < 2) {
            $erreurs[] = 'Le nom de l\'option doit contenir au moins 2 caractères';
        } elseif (strlen($this->nomOption) > 100) {
            $erreurs[] = 'Le nom de l\'option ne peut pas dépasser 100 caractères';
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
        if (strpos(strtolower($this->nomOption), $terme) !== false) {
            return true;
        }
        
        // Recherche dans la description
        if (!empty($this->description) && strpos(strtolower($this->description), $terme) !== false) {
            return true;
        }
        
        // Recherche dans les mots-clés
        return in_array($terme, $this->getMotsCles());
    }

    // Export pour les rapports
    public function toRapportArray(): array {
        return [
            'ID' => $this->idOption,
            'Nom Option' => $this->getNomFormate(),
            'Code' => $this->getCodeOption(),
            'Catégorie' => $this->getCategorie(),
            'Description' => $this->getDescriptionResumee(),
            'Niveau Difficulté' => $this->getNiveauDifficulte(),
            'Durée Études' => $this->getDureeEtudes(),
            'Matières Principales' => implode(', ', $this->getMatieresPrincipales()),
            'Débouchés' => implode(', ', array_slice($this->getDebouches(), 0, 3))
        ];
    }

    // Clonage
    public function copier(): OptionEtude {
        return new OptionEtude(
            null, // Nouvel ID
            $this->nomOption,
            $this->description
        );
    }
}
?>
