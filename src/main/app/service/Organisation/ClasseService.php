<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__. "../../../dao/Organisation/ClasseDAO.php";

class ClasseService{
    private ClasseDAO $classe_dao;

    public function __construct()
    {
        $this->classe_dao = new ClasseDAO();
    }
    //netoyer les donnees
    private function cleanData($data){
        return htmlspecialchars(trim($data));
    }
    /**
     * create and update
     */
    public function createClasse(Classe $classe){
        $classe->setNomClasse($this->cleanData($classe->getNomClasse()));
        $classe->setNiveau($this->cleanData($classe->getNiveau()));
        $classe->setIdEtablissement($this->cleanData($classe->getIdEtablissement()));
        $classe->setDescription($this->cleanData($classe->getDescription()));
        $classe->setEffectifMaximal($this->cleanData($classe->getEffectifMaximal()));
        $classe->setSalle($this->cleanData($classe->getSalle()));
        $classe->setEffectifActuel($this->cleanData($classe->getEffectifActuel()));
        $classe->setAnneeScolaire($this->cleanData($classe->getAnneeScolaire()));

        //verifier les donnees
        if(empty($classe->getNomClasse()) || empty($classe->getNiveau()) || empty($classe->getIdEtablissement()) || empty($classe->getDescription()) || empty($classe->getEffectifMaximal()) || empty($classe->getSalle()) || empty($classe->getEffectifActuel()) || empty($classe->getAnneeScolaire())){
            throw new Exception("Tous les champs sont obligatoires");
        }

        if($classe->getIdClasse()){
            return $this->classe_dao->UpdateClasse($classe);
        }else{
            return $this->classe_dao->CreateClasse($classe);
        }
    }
    /**
     * modifier une classe
     */
    public function modifierClasse(Classe $classe){
        return $this->classe_dao->UpdateClasse($classe);
    }
    /**
     * afficher une classe par son ID
     */
    public function afficherClasse($id_classe){
        return $this->classe_dao->getOneClasse($id_classe);
    }
    /**
     * afficher toutes les classes
     */
    public function afficherToutesLesClasses(){
        return $this->classe_dao->getAllClasse();
    }
    /**
     * supprimer une classe
     */

    public function supprimerClasse($id_classe){
        return $this->classe_dao->DeleteOneClasse($id_classe);
    }

}










?>