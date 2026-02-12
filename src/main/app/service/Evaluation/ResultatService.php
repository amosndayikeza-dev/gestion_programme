<?php
namespace App\Service\Evaluation;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use App\Dao\Evaluation\ResultatDAO;
use App\Models\Evaluation\Resultat;
use Exception;
//require_once __DIR__ . "/../../dao/Evaluation/resultatDAO.php";

class ResultatService{
    private ResultatDAO $resultat_dao;

    public function __construct()
    {
       $this->resultat_dao = new ResultatDAO();
    }

    /**
     * netoyer les donnees
     */
    private function cleanData($data){
        return htmlspecialchars(trim($data));
    }
    /**
     * create and update
     */
    public function enregistrerResultat(Resultat $resultat){
       $resultat->setIdUtilisateur($this->cleanData($resultat->getIdUtilisateur()));
       $resultat->setIdExercice($this->cleanData($resultat->getIdExercice()));
       $resultat->setScore($this->cleanData($resultat->getScore()));
       $resultat->setDateResultat($this->cleanData($resultat->getDateResultat()));

       //verifier les donnees
        if(empty($resultat->getIdUtilisateur()) || empty($resultat->getIdExercice()) || empty($resultat->getScore()) || empty($resultat->getDateResultat())){
            throw new Exception("Tous les champs sont obligatoires");
        }
        
       if($resultat->getIdResultat()){
           return $this->resultat_dao->UpdateResultat($resultat);
       }
       return $this->resultat_dao->CreateResultat($resultat);



    }
    /**
     * consulter un resulatat
     */
    public function consulterResultat($id_utilisateur,$id_evaluation){
        return $this->resultat_dao->getOneResultat($id_utilisateur,$id_evaluation);
    }
    /**
     * Lister les resultat d'un utilisateur
     */
    public function ListerResultatUtilisateur($id_utilisateur){
        return $this->resultat_dao->findByUtilisateur($id_utilisateur);
    }
    /**
     * modifier Resultat
     */
    public function modifierResultat($resultat){
        return $this->resultat_dao->UpdateResultat($resultat);
    }
    /**
     * afficher un resulatat
     */
    public function afficherResultat($id_resultat){
        return $this->resultat_dao->getOneResultat($id_resultat);
    }
    /**
     * afficher touts les resultat
     */
    public function afficherTousLesResultats(){
        return $this->resultat_dao->getAllResultat();
    }
    /**
     * supprimer un resultat
     */
    public function supprimerResultat($id_resultat){
        return $this->resultat_dao->DeleteResultat($id_resultat);
    }



}










?>