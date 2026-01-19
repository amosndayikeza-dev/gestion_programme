<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../dao/Evaluation/resultatDAO.php";

class ResultatService{
    private resultatDAO $resultat_dao;

    public function __construct()
    {
       $resultat_dao = new resultatDAO();
    }

    /**
     * enregistrer un resultat
     */
    public function enregistrerResultat(Resultat $resultat){
        $this->resultat_dao->CreateResultat($resultat);
    }
    /**
     * consulter un resulatat
     */
    public function consulterResultat($id_utilisateur,$id_evaluation){
        return $this->resultat_dao->getOneResultat(,$id_utilisateur$id_evaluation);
    }
    /**
     * Lister les resultat d'un utilisateur
     */
    public function ListerResultatUtilisateur($id_utilisateur){
        return $this->resultat_dao->findByUtilisateur($id_utilisateur);
    }
}










?>