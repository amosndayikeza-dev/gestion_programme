<?php
namespace App\Service\Academique;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Dao\Academique\CoursDAO;
use App\Models\Academique\Cours;
//require_once __DIR__ . "/../../dao/Academique/CoursDAO.php";

class CoursService{
    private CoursDAO $cours_dao;

    public function __construct()
    {
       $this->cours_dao = new CoursDAO();
    }
    /**
     * netoyer les donnees drpovenant d'un formulaire
     */
    private function cleanData($data){
        return htmlspecialchars(trim($data));
    }
    /**
     * Ajouter cours
     */
    public function ajouterCours(Cours $cours){
        $cours->setTitre($this->cleanData($cours->getTitre()));
        $cours->setDescription($this->cleanData($cours->getDescription()));
        $cours->setDureeEstimee($this->cleanData($cours->getDureeEstimee()));
        $cours->setOrdreProgression($this->cleanData($cours->getOrdreProgression()));
        $cours->setNiveauDifficulte($this->cleanData($cours->getNiveauDifficulte()));
        $cours->setTypeCours($this->cleanData($cours->getTypeCours()));
        $cours->setObjectifApprentissage($this->cleanData($cours->getObjectifApprentissage()));
        $cours->setPrerequis($this->cleanData($cours->getPrerequis()));
        $cours->setRessourcesExternes($this->cleanData($cours->getRessourcesExternes()));
        $cours->setNbVues($this->cleanData($cours->getNbVues()));
        $cours->setTauxReussite($this->cleanData($cours->getTauxReussite()));
        $cours->setSeuilReussite($this->cleanData($cours->getSeuilReussite()));
        $cours->setCreateurId($this->cleanData($cours->getCreateurId()));
        $cours->setVisible($this->cleanData($cours->getVisible()));

        if($cours->getIdCours()){
            return $this->cours_dao->UpdateCours($cours);
        }
        return $this->cours_dao->CreateCours($cours);

    }
    /**
     * afficher tout les courrs
     */
    public function afficherCours(){
        return $this->cours_dao->AfficherAllCours();
    }
    
    /**
     * Afficher un cours
     */
    public function afficherOneCours($id_cours){
        return $this->cours_dao->ReadCours($id_cours);
    }
    /**
     * Supprimer un cours
     */
    public function supprimerCours($id_cours){
        return $this->cours_dao->DeleteCours($id_cours);
    }


}











?>