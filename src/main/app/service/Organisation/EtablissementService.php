<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Organisation/EtablissementDAO.php";

class EtablissementService{
    private EtablissementDAO $etablissement_dao;

    public function __construct()
    {
        $this->etablissement_dao = new EtablissementDAO();
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
    public function AjouterEtablissement(Etablissement $etablissement){
        $etablissement->setNom($this->cleanData($etablissement->getNom()));
        $etablissement->setType($this->cleanData($etablissement->getType()));
        $etablissement->setLocalisation($this->cleanData($etablissement->getLocalisation()));
        //verifier les donnees
        if(empty($etablissement->getNom()) || empty($etablissement->getType()) || empty($etablissement->getLocalisation())){
            throw new Exception("Tous les champs sont obligatoires");
        }

        if($etablissement->setIdEtablissement($etablissement->getIdEtablissement())){
            return $this->etablissement_dao->UpdateEtablissement($etablissement);
        }else{
            return $this->etablissement_dao->AjouterEtablissement($etablissement);
        }


    }
    /**
     * modifier etablissement
     */
    public function modifierEtablissement(Etablissement $etablissement){
        return $this->etablissement_dao->UpdateEtablissement($etablissement);
    }
    /**
     * afficher un etablissement
     */
    public function afficherEtablissement($id_etablissement){
        return $this->etablissement_dao->getOneEtalissement($id_etablissement);
    }
    /**
     * afficher touts les etablissement
     */
    public function afficherTousLesEtablissement(){
        return $this->etablissement_dao->AfficherToutEtalissement();
    }
    /**
     * supprimer etablissement
     */
    public function supprimerEtablissement($id_etablissement){
        return $this->etablissement_dao->DeleteEtablissement($id_etablissement);
    }

}












?>