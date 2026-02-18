<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Academique/NiveauDAO.php";

class NiveauService{
    private NiveauDAO $niveau_dao;

    public function __construct()
    {
        $this->niveau_dao = new NiveauDAO();
    }
    /**
     * Ajouter un niveau
     */
    public function ajouterNiveau(Niveau $niveau){
        return $this->niveau_dao->CreateNiveau($niveau);
    }
    /**
     * Modifier un niveau
     */
    public function modifierNiveau(Niveau $niveau){
        return $this->niveau_dao->UpdateNiveau($niveau);
    }
    /**
     * Afficher un niveau
     */
    public function afficherNiveau($id_niveau){
        return $this->niveau_dao->getOneNiveau($id_niveau);
    }
    /**
     * afficher touts les niveaux
     */
    public function afficherTousLesNiveaux(){
        return $this->niveau_dao->AfficherToutLesNiveau();
    }
    /**
     * supprimer un niveau
     */
    public function supprimerNiveau($id_niveau){
        return $this->niveau_dao->DeleteNiveau($id_niveau);
    }
}










?>