<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\Bibliotheque;
class Livre
{
    private $idLivre;
    private $titre;
    private $auteur;
    private $edition;
    private $annee;
    private $isbn;
    private $quantiteTotal;
    private $quantiteDisponible;
    private $categorie;

    public function __construct(
        $idLivre = null,
        $titre = null,
        $auteur = null,
        $edition = null,
        $annee = null,
        $isbn = null,
        $quantiteTotal = 1,
        $quantiteDisponible = 1,
        $categorie = null
    ) {
        $this->idLivre = $idLivre;
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->edition = $edition;
        $this->annee = $annee;
        $this->isbn = $isbn;
        $this->quantiteTotal = $quantiteTotal;
        $this->quantiteDisponible = $quantiteDisponible;
        $this->categorie = $categorie;
    }

    // Getters
    public function getIdLivre() { return $this->idLivre; }
    public function getTitre() { return $this->titre; }
    public function getAuteur() { return $this->auteur; }
    public function getEdition() { return $this->edition; }
    public function getAnnee() { return $this->annee; }
    public function getIsbn() { return $this->isbn; }
    public function getQuantiteTotal() { return $this->quantiteTotal; }
    public function getQuantiteDisponible() { return $this->quantiteDisponible; }
    public function getCategorie() { return $this->categorie; }

    // Setters
    public function setIdLivre($idLivre) { $this->idLivre = $idLivre; }
    public function setTitre($titre) { $this->titre = $titre; }
    public function setAuteur($auteur) { $this->auteur = $auteur; }
    public function setEdition($edition) { $this->edition = $edition; }
    public function setAnnee($annee) { $this->annee = $annee; }
    public function setIsbn($isbn) { $this->isbn = $isbn; }
    public function setQuantiteTotal($quantiteTotal) { $this->quantiteTotal = $quantiteTotal; }
    public function setQuantiteDisponible($quantiteDisponible) { $this->quantiteDisponible = $quantiteDisponible; }
    public function setCategorie($categorie) { $this->categorie = $categorie; }

    // Méthodes utilitaires
    public function getQuantiteEmpruntee(): int {
        return $this->quantiteTotal - $this->quantiteDisponible;
    }

    public function getTauxDisponibilite(): float {
        if ($this->quantiteTotal == 0) {
            return 0.0;
        }
        
        return ($this->quantiteDisponible / $this->quantiteTotal) * 100;
    }

    public function estDisponible(): bool {
        return $this->quantiteDisponible > 0;
    }

    public function estCompletmentEmprunte(): bool {
        return $this->quantiteDisponible === 0;
    }

    public function emprunterExemplaire(): bool {
        if (!$this->estDisponible()) {
            return false;
        }
        
        $this->quantiteDisponible--;
        return true;
    }

    public function retournerExemplaire(): bool {
        if ($this->quantiteDisponible >= $this->quantiteTotal) {
            return false;
        }
        
        $this->quantiteDisponible++;
        return true;
    }

    public function ajouterExemplaires(int $quantite): bool {
        if ($quantite <= 0) {
            return false;
        }
        
        $this->quantiteTotal += $quantite;
        $this->quantiteDisponible += $quantite;
        
        return true;
    }

    public function retirerExemplaires(int $quantite): bool {
        if ($quantite <= 0 || $quantite > $this->quantiteTotal) {
            return false;
        }
        
        $this->quantiteTotal -= $quantite;
        $this->quantiteDisponible = max(0, $this->quantiteDisponible - $quantite);
        
        return true;
    }

    public function getStatut(): string {
        if ($this->quantiteTotal === 0) {
            return 'Indisponible';
        }
        
        $tauxDisponibilite = $this->getTauxDisponibilite();
        
        if ($tauxDisponibilite === 100) {
            return 'Disponible';
        } elseif ($tauxDisponibilite >= 50) {
            return 'Partiellement disponible';
        } elseif ($tauxDisponibilite > 0) {
            return 'Limite';
        } else {
            return 'Indisponible';
        }
    }

    public function getStatutCouleur(): string {
        $statut = $this->getStatut();
        
        $couleurs = [
            'Disponible' => 'success',
            'Partiellement disponible' => 'info',
            'Limite' => 'warning',
            'Indisponible' => 'danger'
        ];
        
        return $couleurs[$statut] ?? 'secondary';
    }

    public function getAge(): int {
        if (empty($this->annee)) {
            return 0;
        }
        
        return date('Y') - $this->annee;
    }

    public function estRecent(): bool {
        return $this->getAge() <= 5;
    }

    public function estAncien(): bool {
        return $this->getAge() >= 20;
    }

    public function getTitreComplet(): string {
        $titre = $this->titre;
        
        if (!empty($this->edition)) {
            $titre .= " ({$this->edition})";
        }
        
        if (!empty($this->annee)) {
            $titre .= " - {$this->annee}";
        }
        
        return $titre;
    }

    public function getReferenceBibliographique(): string {
        $reference = $this->auteur . '. ' . $this->titre;
        
        if (!empty($this->edition)) {
            $reference .= '. ' . $this->edition;
        }
        
        if (!empty($this->annee)) {
            $reference .= ', ' . $this->annee;
        }
        
        if (!empty($this->isbn)) {
            $reference .= '. ISBN: ' . $this->isbn;
        }
        
        return $reference;
    }

    public function getMotsCles(): array {
        $mots = [];
        
        // Extraire les mots du titre
        if (!empty($this->titre)) {
            $titreMots = preg_split('/[\s,\-:;.!]+/', $this->titre);
            $mots = array_merge($mots, array_filter($titreMots));
        }
        
        // Extraire les mots de l'auteur
        if (!empty($this->auteur)) {
            $auteurMots = preg_split('/[\s,\-:;.!]+/', $this->auteur);
            $mots = array_merge($mots, array_filter($auteurMots));
        }
        
        // Ajouter la catégorie
        if (!empty($this->categorie)) {
            $mots[] = $this->categorie;
        }
        
        // Filtrer les mots courts et normaliser
        $mots = array_filter($mots, function($mot) {
            return strlen($mot) >= 3;
        });
        
        return array_unique(array_map('strtolower', $mots));
    }

    public function rechercher(string $terme): bool {
        $terme = strtolower(trim($terme));
        
        if (empty($terme)) {
            return false;
        }
        
        // Recherche dans le titre
        if (!empty($this->titre) && strpos(strtolower($this->titre), $terme) !== false) {
            return true;
        }
        
        // Recherche dans l'auteur
        if (!empty($this->auteur) && strpos(strtolower($this->auteur), $terme) !== false) {
            return true;
        }
        
        // Recherche dans la catégorie
        if (!empty($this->categorie) && strpos(strtolower($this->categorie), $terme) !== false) {
            return true;
        }
        
        // Recherche dans l'ISBN
        if (!empty($this->isbn) && strpos($this->isbn, $terme) !== false) {
            return true;
        }
        
        // Recherche dans les mots-clés
        $motsCles = $this->getMotsCles();
        return in_array($terme, $motsCles);
    }

    public function toArray(): array {
        return [
            'id_livre' => $this->idLivre,
            'titre' => $this->titre,
            'auteur' => $this->auteur,
            'edition' => $this->edition,
            'annee' => $this->annee,
            'isbn' => $this->isbn,
            'quantite_total' => $this->quantiteTotal,
            'quantite_disponible' => $this->quantiteDisponible,
            'quantite_empruntee' => $this->getQuantiteEmpruntee(),
            'taux_disponibilite' => $this->getTauxDisponibilite(),
            'categorie' => $this->categorie,
            'statut' => $this->getStatut(),
            'statut_couleur' => $this->getStatutCouleur(),
            'est_disponible' => $this->estDisponible(),
            'age' => $this->getAge(),
            'est_recent' => $this->estRecent(),
            'est_ancien' => $this->estAncien(),
            'titre_complet' => $this->getTitreComplet(),
            'reference_bibliographique' => $this->getReferenceBibliographique(),
            'mots_cles' => $this->getMotsCles()
        ];
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->titre) && 
               !empty($this->auteur) &&
               $this->quantiteTotal > 0 &&
               $this->quantiteDisponible >= 0 &&
               $this->quantiteDisponible <= $this->quantiteTotal;
    }

    // Validation ISBN
    public function isValidISBN(): bool {
        if (empty($this->isbn)) {
            return true; // ISBN non obligatoire
        }
        
        $isbn = preg_replace('/[^0-9X]/i', '', $this->isbn);
        
        if (strlen($isbn) === 10) {
            return $this->validateISBN10($isbn);
        } elseif (strlen($isbn) === 13) {
            return $this->validateISBN13($isbn);
        }
        
        return false;
    }

    private function validateISBN10(string $isbn): bool {
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int)$isbn[$i] * (10 - $i);
        }
        
        $checksum = $isbn[9] === 'X' ? 10 : (int)$isbn[9];
        $sum += $checksum;
        
        return $sum % 11 === 0;
    }

    private function validateISBN13(string $isbn): bool {
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += (int)$isbn[$i] * ($i % 2 === 0 ? 1 : 3);
        }
        
        $checksum = (10 - ($sum % 10)) % 10;
        
        return $checksum === (int)$isbn[12];
    }
}
?>
