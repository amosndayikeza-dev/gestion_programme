<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Academique/ActiviteDAO.php";

class ActiviteService{
    private ActiviteDAO $activitedao;
    public function __construct()
    {
       $activitedao = new ActiviteDAO();
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
     * 
     */
















}











?>