<?php

namespace App\Models\Historique;
use DateTime;
use DateInterval;
use PDO;
use Exception;

class Activites{
    private $id_activite;
    private $id_utilisateur;
    private $nom_utilisateur;
    private $action;
    private $details;
    private $date_activite;
    private $statut;

    public function __construct(
        $id_activite,
        $id_utilisateur,
        $nom_utilisateur,
        $action,
        $details,
        $date_activite,
        $statut
    ) {
        $this->id_activite = $id_activite;
        $this->id_utilisateur = $id_utilisateur;
        $this->nom_utilisateur = $nom_utilisateur;
        $this->action = $action;
        $this->details = $details;
        $this->date_activite = date('Y-m-d H:i:s', strtotime($date_activite));
        $this->statut = ($statut === null) ? 'Succès' : 'Échec';
    }
    public function getIdActivite(){ 
        return $this->id_activite;
    }
    public function setIdActivite( int $id_activite): void { 
        $this->id_activite = $id_activite; 
    }
    public function getIdUtilisateur(){ 
        return $this->id_utilisateur; 
    }
     public function setIdUtilisateur( int $id_utilisateur): void{ 
        $this->id_utilisateur = $id_utilisateur;
    }
    public function getNomUtilisateur(){ 
        return $this->nom_utilisateur; 
    }
    public function setNomUtilisateur( string $nom_utilisateur): void { 
        $this->nom_utilisateur = $nom_utilisateur; 
    }
    public function getAction(){ 
        return $this->action;
    }
    public function setAction( string $action): void {
         $this->action = $action; 
    }
    public function getDetails(){ 
        return $this->details; 
    }
    public function setDetails( string $details): void {
         $this->details = $details;
    }
    public function getDateActivite(){ 
        return $this->date_activite;
    }
    public function setDateActivite( string $date_activite): void {
         $this->date_activite = $date_activite; 
    }

}
?>