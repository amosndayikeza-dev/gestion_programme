<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


namespace App\Models\Organisation;
use DateTime;
use DateInterval;
use PDO;
use Exception;

class Inscription
{
    private  $id_inscription;
    private  $id_utilisateur;
    private  $id_classe;
    private  $date_inscription;
    private  $statut;

    public function __construct(
         $id_inscription = null,
         $id_utilisateur = null,
         $id_classe = null,
         $date_inscription = null,
         $statut = null,
    ) {
        $this->id_inscription = $id_inscription;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_classe = $id_classe;
        $this->date_inscription = $date_inscription;
        $this->statut = $statut;
    }

    //getters functions
    public function getIdInscription()  { return $this->id_inscription; }
    public function getIdUtilisateur() { return $this->id_utilisateur; }
    
    public function getIdClasse()  { return $this->id_classe; }
    public function getDateInscription()  { return $this->date_inscription; }

    public function getStatut()  { return $this->statut; }

    //setters functions
    public function setIdInscription($id_inscription)  {  $this->id_inscription = $id_inscription; }
    public function setIdUtilisateur($id_utilisateur) {  $this->id_utilisateur = $id_utilisateur; }

    public function setIdClasse($id_classe)  {  $this->id_classe = $id_classe; }
    public function setDateInscription($date_inscription)  {  $this->date_inscription = $date_inscription; }
    
    public function setStatut($statut)  {  $this->statut = $statut; }
}
