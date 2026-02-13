<?php
namespace App\Service\Academique;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Dao\Academique\MatiereDAO;
use App\Models\Academique\Matiere;
use Exception;
use PDOException;
use PDO;
//require_once __DIR__ . "/../../dao/Academique/MatiereDAO.php";

class MatiereService {
    private MatiereDAO $matiere_dao;
    public function __construct()
    {
       $this->matiere_dao = new MatiereDAO();
    }
    /**
     * NETTOYER LES DONNES PROVENANT DU CONTROLLEUR
     */
    private function cleanData($data){
        return htmlspecialchars(trim($data));
    }   
    /**
     * AJOUTER et modifier matiere
     */
    public function ajouterMatiere(Matiere $matiere){
        $matiere->setNomMatiere($this->cleanData($matiere->getNomMatiere()));
        $matiere->setCoefficient($this->cleanData($matiere->getCoefficient()));
        $matiere->setDescription($this->cleanData($matiere->getDescription()));

        if(empty($matiere->getNomMatiere()) || empty($matiere->getCoefficient()) || empty($matiere->getDescription())){
            throw new Exception("Tous les champs sont obligatoire");
        }
        if($matiere->getIdMatiere()){
            return $this->matiere_dao->UpdateMatiere($matiere);
        }
        return $this->matiere_dao->CreateMatiere($matiere);
    }
    /**
     * modifier matiere
     */
    public function modifierMatiere(Matiere $matiere){
        return $this->matiere_dao->UpdateMatiere($matiere);
    }
    /**
     * AFFICHER UNE MATIERE
     */
    public function afficherUneMatiere($id_matiere){
        return $this->matiere_dao->GetoneMatiere($id_matiere);
    }
    /**
     * afficher totes les matires
     */
    public function afficherToutesLesMatieres(){
        return $this->matiere_dao->AfficherToutesLesMatiere();
    }

    /**
     * SUPPRIMER UNE MATIERE
     */
    public function supprimerMatiere($id_matiere){
        return $this->matiere_dao->DeleteMatiere($id_matiere);
    }
}










?>