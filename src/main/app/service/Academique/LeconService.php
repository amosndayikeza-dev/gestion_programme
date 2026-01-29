<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Academique/LeconDAO.php";
class LeconService{
    private LeconDAO $lecon_dao;

    public function __construct()
    {
      $this->lecon_dao = new LeconDAO();
    }
    /**
     * AJOUTER UNE LECON
     */
    public function ajouterLecon(Lecon $lecon){
      return $this->lecon_dao->CreateLecon($lecon);
    }
    /**
     * MODIFIER UNE LECON
     */
    public function modifierLecon(Lecon $lecon){
      return $this->lecon_dao->UpdateLecon($lecon);
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