<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\academique;
class Section
{
    private $idSection;
    private $nomSection;
    private $description;

    public function __construct(
        $idSection = null,
        $nomSection = null,
        $description = null
    ) {
        $this->idSection = $idSection;
        $this->nomSection = $nomSection;
        $this->description = $description;
    }

    // Getters
    public function getIdSection() { return $this->idSection; }
    public function getNomSection() { return $this->nomSection; }
    public function getDescription() { return $this->description; }

    // Setters
    public function setIdSection($idSection) { $this->idSection = $idSection; }
    public function setNomSection($nomSection) { $this->nomSection = $nomSection; }
    public function setDescription($description) { $this->description = $description; }

    // Méthodes utilitaires
    public function getNomFormate(): string {
        return ucwords(strtolower($this->nomSection));
    }

    public function getCodeSection(): string {
        return strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $this->nomSection), 0, 4));
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
        
        if (!empty($this->nomSection)) {
            $mots = array_merge($mots, preg_split('/[\s-]+/', $this->nomSection));
        }
        
        if (!empty($this->description)) {
            $mots = array_merge($mots, preg_split('/[\s,.;:]+/', $this->description));
        }
        
        return array_filter(array_unique(array_map('strtolower', $mots)));
    }

    public function estSectionScientifique(): bool {
        return strpos(strtolower($this->nomSection), 'math') !== false ||
               strpos(strtolower($this->nomSection), 'phys') !== false ||
               strpos(strtolower($this->nomSection), 'chim') !== false ||
               strpos(strtolower($this->nomSection), 'bio') !== false;
    }

    public function estSectionLitteraire(): bool {
        return strpos(strtolower($this->nomSection), 'latin') !== false ||
               strpos(strtolower($this->nomSection), 'philosoph') !== false ||
               strpos(strtolower($this->nomSection), 'lett') !== false ||
               strpos(strtolower($this->nomSection), 'histoir') !== false;
    }

    public function estSectionEconomique(): bool {
        return strpos(strtolower($this->nomSection), 'écono') !== false ||
               strpos(strtolower($this->nomSection), 'gestion') !== false ||
               strpos(strtolower($this->nomSection), 'compt') !== false;
    }

    public function estSectionLinguistique(): bool {
        return strpos(strtolower($this->nomSection), 'anglais') !== false ||
               strpos(strtolower($this->nomSection), 'lang') !== false ||
               strpos(strtolower($this->nomSection), 'littér') !== false;
    }

    public function getCategorie(): string {
        if ($this->estSectionScientifique()) return 'Scientifique';
        if ($this->estSectionLitteraire()) return 'Littéraire';
        if ($this->estSectionEconomique()) return 'Économique';
        if ($this->estSectionLinguistique()) return 'Linguistique';
        
        return 'Autre';
    }

    public function getCategorieCouleur(): string {
        $couleurs = [
            'Scientifique' => 'primary',
            'Littéraire' => 'success',
            'Économique' => 'info',
            'Linguistique' => 'warning',
            'Autre' => 'secondary'
        ];
        
        return $couleurs[$this->getCategorie()] ?? 'secondary';
    }

    public function getCategorieIcone(): string {
        $icones = [
            'Scientifique' => 'fa-flask',
            'Littéraire' => 'fa-book',
            'Économique' => 'fa-chart-line',
            'Linguistique' => 'fa-language',
            'Autre' => 'fa-question-circle'
        ];
        
        return $icones[$this->getCategorie()] ?? 'fa-question-circle';
    }

    public function getMatieresPrincipales(): array {
        $matieres = [];
        
        switch ($this->getCategorie()) {
            case 'Scientifique':
                if (strpos(strtolower($this->nomSection), 'math') !== false) {
                    $matieres = ['Mathématiques', 'Physique', 'Sciences'];
                } elseif (strpos(strtolower($this->nomSection), 'phys') !== false) {
                    $matieres = ['Physique', 'Mathématiques', 'Chimie'];
                } elseif (strpos(strtolower($this->nomSection), 'chim') !== false) {
                    $matieres = ['Chimie', 'Biologie', 'Physique'];
                } elseif (strpos(strtolower($this->nomSection), 'bio') !== false) {
                    $matieres = ['Biologie', 'Chimie', 'Sciences naturelles'];
                }
                break;
                
            case 'Littéraire':
                if (strpos(strtolower($this->nomSection), 'latin') !== false) {
                    $matieres = ['Latin', 'Français', 'Philosophie'];
                } elseif (strpos(strtolower($this->nomSection), 'philosoph') !== false) {
                    $matieres = ['Philosophie', 'Français', 'Histoire'];
                } elseif (strpos(strtolower($this->nomSection), 'lett') !== false) {
                    $matieres = ['Littérature', 'Français', 'Philosophie'];
                } elseif (strpos(strtolower($this->nomSection), 'histoir') !== false) {
                    $matieres = ['Histoire', 'Géographie', 'Éducation civique'];
                }
                break;
                
            case 'Économique':
                $matieres = ['Économie', 'Comptabilité', 'Gestion', 'Droit'];
                break;
                
            case 'Linguistique':
                if (strpos(strtolower($this->nomSection), 'anglais') !== false) {
                    $matieres = ['Anglais', 'Littérature anglaise', 'Français'];
                } else {
                    $matieres = ['Langues', 'Littérature', 'Communication'];
                }
                break;
        }
        
        return $matieres;
    }

    public function getNiveauxConcernes(): array {
        // Les sections sont généralement disponibles pour les niveaux supérieurs
        return ['3ème', '4ème', '5ème', '6ème'];
    }

    public function getOptionsCompatibles(): array {
        $options = [];
        
        switch ($this->getCategorie()) {
            case 'Scientifique':
                $options = ['Scientifique', 'Technique'];
                break;
            case 'Littéraire':
                $options = ['Littéraire', 'Pédagogique'];
                break;
            case 'Économique':
                $options = ['Commerciale'];
                break;
            case 'Linguistique':
                $options = ['Littéraire', 'Artistique'];
                break;
        }
        
        return $options;
    }

    public function getDebouches(): array {
        $debouches = [];
        
        switch ($this->getCategorie()) {
            case 'Scientifique':
                $debouches = ['Études supérieures scientifiques', 'Ingénierie', 'Médecine', 'Recherche'];
                break;
            case 'Littéraire':
                $debouches = ['Études supérieures littéraires', 'Droit', 'Journalisme', 'Enseignement'];
                break;
            case 'Économique':
                $debouches = ['Études en gestion', 'Commerce', 'Banque', 'Administration'];
                break;
            case 'Linguistique':
                $debouches = ['Traduction', 'Relations internationales', 'Tourisme', 'Communication'];
                break;
        }
        
        return $debouches;
    }

    public function getNiveauExigence(): string {
        $niveaux = [
            'Scientifique' => 'Très élevé',
            'Littéraire' => 'Élevé',
            'Économique' => 'Élevé',
            'Linguistique' => 'Élevé',
            'Autre' => 'Moyen'
        ];
        
        return $niveaux[$this->getCategorie()] ?? 'Moyen';
    }

    public function getNiveauExigenceCouleur(): string {
        $couleurs = [
            'Très élevé' => 'danger',
            'Élevé' => 'warning',
            'Moyen' => 'info',
            'Faible' => 'success'
        ];
        
        return $couleurs[$this->getNiveauExigence()] ?? 'secondary';
    }

    public function getCapaciteAccueil(): int {
        // Capacité moyenne par section
        return 40;
    }

    public function getNombreHeuresSemaine(): int {
        // Nombre d'heures de cours spécifiques à la section
        return 25;
    }

    public function toArray(): array {
        return [
            'id_section' => $this->idSection,
            'nom_section' => $this->nomSection,
            'nom_formate' => $this->getNomFormate(),
            'code_section' => $this->getCodeSection(),
            'description' => $this->description,
            'description_resumee' => $this->getDescriptionResumee(),
            'a_description' => $this->aDescription(),
            'categorie' => $this->getCategorie(),
            'categorie_couleur' => $this->getCategorieCouleur(),
            'categorie_icone' => $this->getCategorieIcone(),
            'matieres_principales' => $this->getMatieresPrincipales(),
            'niveaux_concernes' => $this->getNiveauxConcernes(),
            'options_compatibles' => $this->getOptionsCompatibles(),
            'debouches' => $this->getDebouches(),
            'niveau_exigence' => $this->getNiveauExigence(),
            'niveau_exigence_couleur' => $this->getNiveauExigenceCouleur(),
            'capacite_accueil' => $this->getCapaciteAccueil(),
            'nombre_heures_semaine' => $this->getNombreHeuresSemaine(),
            'mots_cles' => $this->getMotsCles()
        ];
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->nomSection) && strlen(trim($this->nomSection)) >= 2;
    }

    // Validation du nom
    public function validerNom(): array {
        $erreurs = [];
        
        if (empty($this->nomSection)) {
            $erreurs[] = 'Le nom de la section est obligatoire';
        } elseif (strlen(trim($this->nomSection)) < 2) {
            $erreurs[] = 'Le nom de la section doit contenir au moins 2 caractères';
        } elseif (strlen($this->nomSection) > 100) {
            $erreurs[] = 'Le nom de la section ne peut pas dépasser 100 caractères';
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
        if (strpos(strtolower($this->nomSection), $terme) !== false) {
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
            'ID' => $this->idSection,
            'Nom Section' => $this->getNomFormate(),
            'Code' => $this->getCodeSection(),
            'Catégorie' => $this->getCategorie(),
            'Description' => $this->getDescriptionResumee(),
            'Niveau Exigence' => $this->getNiveauExigence(),
            'Capacité Accueil' => $this->getCapaciteAccueil(),
            'Heures/Semaine' => $this->getNombreHeuresSemaine(),
            'Matières Principales' => implode(', ', $this->getMatieresPrincipales()),
            'Niveaux' => implode(', ', $this->getNiveauxConcernes())
        ];
    }

    // Clonage
    public function copier(): Section {
        return new Section(
            null, // Nouvel ID
            $this->nomSection,
            $this->description
        );
    }
}
?>
