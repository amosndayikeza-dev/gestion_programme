<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Academique/ActiviteDAO.php";

class ActiviteService{
    private ActiviteDAO $activitedao;
    public function __construct()
    {
       $this->activitedao = new ActiviteDAO();
    }
    /**
     * enregistrer une activite utilisateur
     */
    public function enregistrerActivite(Activite $activite){
        $this->activitedao->CreateActivite($activite);  
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
    public function supprimerActiviter($id_activite){
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