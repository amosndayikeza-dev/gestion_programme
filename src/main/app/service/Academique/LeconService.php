<?php
namespace App\Service\Academique;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Dao\Academique\LeconDAO;
use App\Models\Academique\Lecon;

//require_once __DIR__ . "/../../dao/Academique/LeconDAO.php";
class LeconService{
    private LeconDAO $lecon_dao;

    public function __construct()
    {
      $this->lecon_dao = new LeconDAO();
    }
    /**
     * NETTOYER LES DONNES
     */
    private function cleanData($data){
      return htmlspecialchars(trim($data));
    }
    /**
     * create and update
     */
    public function ajouterLecon(Lecon $lecon){
      $lecon->setIdCours($this->cleanData($lecon->getIdCours()));
      $lecon->setTitre($this->cleanData($lecon->getTitre()));
      $lecon->setDescription($this->cleanData($lecon->getDescription()));
      $lecon->setOrdre($this->cleanData($lecon->getOrdre()));
      $lecon->setAnneeEstime($this->cleanData($lecon->getAnneeEstime()));
      $lecon->setStatut($this->cleanData($lecon->getStatut()));
     
      if($lecon->getIdLecon()){
        return $this->lecon_dao->UpdateLecon($lecon);
      }
      return $this->lecon_dao->CreateLecon($lecon);

    }
    
    /**
     * AFFICHER UNE LECON
     */
    public function afficherLecon($id_lecon){
      return $this->lecon_dao->getOneLecon($id_lecon);
    }
    /**
     * SUPPRIMER UNE LECON
     */
    public function supprimerLecon($id_lecon){
      return $this->lecon_dao->DeleteLecon($id_lecon);
    }
    /**
     * AFFICHER TOUTES LES LECON
     */
    public function afficherToutesLesLecons(){
      return $this->lecon_dao->getAllLecon();
    }
}















?>