<?php
namespace App\Models\Utilisateur;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
use DateTime;
use DateInterval;
class Eleve{
    private $id_eleve;
    private $id_utilisateur;
    private $id_classe;
    private $id_tuteur;
    private $date_naissance;
    private $lieu_naissance;
    private $sexe;
    private $adresse;
    private $date_inscription;
    private $matricule;
    private $utilisateur; // Association avec la classe Utilisateur

    /**
     * Le constructeur n'est pas nécessaire car hydrate() fait le travail d'initialisation.
     */
    
    //getters . oN UTILISE PEU DE GETTERS DONC CEUX QUI SONT UTILILE PARCE QUE LES AUTRES HDRATE LES APPELS AUTOMATIQUEMENT.
    public function getIdEleve() { return $this->id_eleve; }
    public function getIdUtilisateur() { return $this->id_utilisateur; }    
    public function getIdClasse() { return $this->id_classe; }  
    public function getMatricule() { return $this->matricule; }

    //setters
    public function setUtilisateur(Utilisateur $utilisateur){
        $this->utilisateur = $utilisateur;
        $this->id_utilisateur = $utilisateur->getIdUtilisateur();
        return $this;
    }
    public function getUtilisateur(){
        return $this->utilisateur;
    }

    //methode metier
    public function getAge(){
        if(!$this->date_naissance ) return null;
        $birthDate = new \DateTime($this->date_naissance);
        $today = new \DateTime();
        $age = $today->diff($birthDate);
        return $age->y;
    }
    public function isAdult(){
        return $this->getAge()>= 18;
    }

}












?>