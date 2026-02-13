<?php
namespace App\Models\Suivi;
use DateTime;
use DateInterval;
use PDO;
use Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Progression
{
    private  $id_progression;
    private  $id_utilisateur;
    private  $id_cours;
    private  $pourcentage;
    private  $derniere_mise_a_jour;

    public function __construct(
         $id_progression,
         $id_utilisateur,
         $id_cours,
         $pourcentage,
         $derniere_mise_a_jour
    ) {
        $this->id_progression = $id_progression;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_cours = $id_cours;
        $this->pourcentage = $pourcentage;
        $this->derniere_mise_a_jour = $derniere_mise_a_jour;
    }

    public function getIdProgression() { return $this->id_progression; }
    public function setIdProgression( $id) { $this->id_progression = $id; }

    public function getIdUtilisateur() { return $this->id_utilisateur; }
    public function setIdUtilisateur( $id) { $this->id_utilisateur = $id; }
    
    public function getIdCours() { return $this->id_cours; }
    public function setIdCours( $id) { $this->id_cours = $id; }

    public function getPourcentage() { return $this->pourcentage; }
    public function setPourcentage( $p) { $this->pourcentage = $p; }

    public function getDerniereMiseAJour() { return $this->derniere_mise_a_jour; }
    public function setDerniereMiseAJour( $date) { $this->derniere_mise_a_jour = $date; }
}
