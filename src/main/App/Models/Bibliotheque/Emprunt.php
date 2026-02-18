<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

namespace App\Models\Bibliotheque;
use DateTime;
use DateInterval;
class Emprunt
{
    private $idEmprunt;
    private $idLivre;
    private $idEleve;
    private $dateEmprunt;
    private $dateRetourPrevue;
    private $dateRetourEffective;
    private $etat;
    private $penalite;

    public function __construct(
        $idEmprunt = null,
        $idLivre = null,
        $idEleve = null,
        $dateEmprunt = null,
        $dateRetourPrevue = null,
        $dateRetourEffective = null,
        $etat = 'En cours',
        $penalite = 0.0
    ) {
        $this->idEmprunt = $idEmprunt;
        $this->idLivre = $idLivre;
        $this->idEleve = $idEleve;
        $this->dateEmprunt = $dateEmprunt ?? date('Y-m-d');
        $this->dateRetourPrevue = $dateRetourPrevue;
        $this->dateRetourEffective = $dateRetourEffective;
        $this->etat = $etat;
        $this->penalite = $penalite;
    }

    // Getters
    public function getIdEmprunt() { return $this->idEmprunt; }
    public function getIdLivre() { return $this->idLivre; }
    public function getIdEleve() { return $this->idEleve; }
    public function getDateEmprunt() { return $this->dateEmprunt; }
    public function getDateRetourPrevue() { return $this->dateRetourPrevue; }
    public function getDateRetourEffective() { return $this->dateRetourEffective; }
    public function getEtat() { return $this->etat; }
    public function getPenalite() { return $this->penalite; }

    // Setters
    public function setIdEmprunt($idEmprunt) { $this->idEmprunt = $idEmprunt; }
    public function setIdLivre($idLivre) { $this->idLivre = $idLivre; }
    public function setIdEleve($idEleve) { $this->idEleve = $idEleve; }
    public function setDateEmprunt($dateEmprunt) { $this->dateEmprunt = $dateEmprunt; }
    public function setDateRetourPrevue($dateRetourPrevue) { $this->dateRetourPrevue = $dateRetourPrevue; }
    public function setDateRetourEffective($dateRetourEffective) { $this->dateRetourEffective = $dateRetourEffective; }
    public function setEtat($etat) { $this->etat = $etat; }
    public function setPenalite($penalite) { $this->penalite = $penalite; }

    // Méthodes utilitaires
    public function estEnRetard(): bool {
        if ($this->etat === 'Retourné' || $this->etat === 'Perdu') {
            return false;
        }
        
        $aujourdHui = new DateTime();
        $dateRetour = new DateTime($this->dateRetourPrevue);
        
        return $aujourdHui > $dateRetour;
    }

    public function getJoursRetard(): int {
        if (!$this->estEnRetard()) {
            return 0;
        }
        
        $aujourdHui = new DateTime();
        $dateRetour = new DateTime($this->dateRetourPrevue);
        
        return $aujourdHui->diff($dateRetour)->days;
    }

    public function calculerPenalite(float $tarifJournalier = 0.50): float {
        if (!$this->estEnRetard()) {
            return 0.0;
        }
        
        $joursRetard = $this->getJoursRetard();
        return $joursRetard * $tarifJournalier;
    }

    public function prolongerEmprunt(int $joursSupplementaires): bool {
        if ($this->etat !== 'En cours') {
            return false;
        }
        
        $dateRetour = new DateTime($this->dateRetourPrevue);
        $dateRetour->add(new DateInterval("P{$joursSupplementaires}D"));
        $this->dateRetourPrevue = $dateRetour->format('Y-m-d');
        
        return true;
    }

    public function retournerLivre(): bool {
        if ($this->etat !== 'En cours' && $this->etat !== 'En retard') {
            return false;
        }
        
        $this->dateRetourEffective = date('Y-m-d');
        
        if ($this->estEnRetard()) {
            $this->etat = 'En retard';
            $this->penalite = $this->calculerPenalite();
        } else {
            $this->etat = 'Retourné';
            $this->penalite = 0.0;
        }
        
        return true;
    }

    public function marquerCommePerdu(): bool {
        if ($this->etat !== 'En cours' && $this->etat !== 'En retard') {
            return false;
        }
        
        $this->etat = 'Perdu';
        $this->penalite = $this->calculerPenalite(5.0); // Pénalité plus élevée pour perte
        
        return true;
    }

    public function getDureeEmprunt(): int {
        $dateDebut = new DateTime($this->dateEmprunt);
        $dateFin = $this->dateRetourEffective ? 
            new DateTime($this->dateRetourEffective) : 
            new DateTime();
        
        return $dateFin->diff($dateDebut)->days;
    }

    public function toArray(): array {
        return [
            'id_emprunt' => $this->idEmprunt,
            'id_livre' => $this->idLivre,
            'id_eleve' => $this->idEleve,
            'date_emprunt' => $this->dateEmprunt,
            'date_retour_prevue' => $this->dateRetourPrevue,
            'date_retour_effective' => $this->dateRetourEffective,
            'etat' => $this->etat,
            'penalite' => $this->penalite,
            'en_retard' => $this->estEnRetard(),
            'jours_retard' => $this->getJoursRetard(),
            'duree_emprunt' => $this->getDureeEmprunt()
        ];
    }

    // Validation
    public function isValid(): bool {
        return !empty($this->idLivre) && 
               !empty($this->idEleve) && 
               !empty($this->dateRetourPrevue) &&
               in_array($this->etat, ['En cours', 'Retourné', 'En retard', 'Perdu']);
    }
}
?>
