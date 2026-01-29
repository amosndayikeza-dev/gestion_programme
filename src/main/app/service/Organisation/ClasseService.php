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
    /**
     * creer une nouvelle classe
     */
    public function creerClasse(Classe $classe){
        return $this->classe_dao->CreateClasse($classe);
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