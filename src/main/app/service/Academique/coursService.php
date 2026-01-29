<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Academique/CoursDAO.php";

class coursService{
    private CoursDAO $cours_dao;

    public function __construct()
    {
       $this->cours_dao = new CoursDAO();
    }
    /**
     * Ajouter cours
     */
    public function ajouterCours(Cours $cours){
        return $this->cours_dao->create($cours);
    }
    /**
     * Modifier cours
     */
    public function modifierCours(Cours $cours){
        return $this->cours_dao->updateCours($cours);
    }
    /**
     * Afficher un cours
     */
    public function afficherCours($idcours){
        return $this->cours_dao->Read($idcours);
    }
    /**
     * Supprimer un cours
     */
    public function supprimerCours($id_cours){
        return $this->cours_dao->DeleteCours($id_cours);
    }


}











?>