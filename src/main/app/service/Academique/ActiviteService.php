<?php
namespace App\Service\Academique;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Dao\Academique\ActiviteDAO;
use App\Models\Academique\Activite;

//require_once __DIR__ . "/../../dao/Academique/ActiviteDAO.php";

class ActiviteService{
    private ActiviteDAO $activitedao;
    public function __construct()
    {
       $this->activitedao = new ActiviteDAO();
    }
   
    /**
     * NETTOYER LES DONNES PROVENANT DU CONTROLLEUR
     */
    private function cleanData(String $data){
        return htmlspecialchars(trim($data));
    }

     /**
     * CREATE AND UPDATE (methode de netoyage commune)
     */
    public function enregistrerActivite(Activite $activite):bool{
        $activite->setNomActivite($this->cleanData($activite->getNomActivite()));
        $activite->setInstruction($this->cleanData($activite->getInstruction()));
        $activite->setType($this->cleanData($activite->getType()));

        if($activite->getIdActivite()){
            return $this->activitedao->UpdateActivite($activite);
        }else{
            return $this->activitedao->CreateActivite($activite);
        }
        
    
    }

    /**
     * Lister les activites d'un utilisateur
     */
    public function ListerActiviteUtilisateur($id_utilisateur){
        return $this->activitedao->findByUtilisateur($id_utilisateur);  
    }

    /**
     * Upadate actiivite
     */
    public function changeActivite($activite){
       return  $this->activitedao->UpdateActivite($activite);
    }

    /**
     * Supprimer une activite
     */
    public function supprimerActivite($id_activite){
        return $this->activitedao->DeleteActivite($id_activite);
    }
    /**
     * afficher une activite
     */
    public function afficherActivite($id_activite){
        return $this->activitedao->getOneActivite($id_activite);
    }
    /**
     * trouver une activite par utilisateur
     */
    public function trouverActiviteUtilisateur($activite){
        return $this->activitedao->findByUtilisateur($activite);
    }
    /**
     * afficher toutes les activites
     */
    public function afficherToutesActivites(){
        return $this->activitedao->getAllActivites();
    }
















}











?>