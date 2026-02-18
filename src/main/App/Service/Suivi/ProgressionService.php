<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Suivi/ProgressionDAO.php";
Class ProgressionService{
    private ProgressionDAO $progressionDAO;

    public function __construct()
    {
        $this->progressionDAO = new ProgressionDAO();
    }

    /*
     * initialiser la progression au depart
     
    public function initialiserProgression($id_utilisateur,$id_cours){
        if($this->progressionDAO->exists($id_utilisateur,$id_cours)){
            return;
        }
    $this->progressionDAO->CreateProgression($id_utilisateur,$id_cours,0);


    }**/

    /**
     * Mettre a jours pourcentage
     */
    public function mettreAjourProgression($id_utilisateur,$id_cours,$pourcentage){
        if($pourcentage < 0 OR $pourcentage >100){
            throw new Exception("Pourcentage invalide");
        }
        $this->progressionDAO->UpdateProgression($id_utilisateur,$id_cours,$pourcentage);
    }
    /**
     * Claculer a progression cours
     */
    public function CalculerProgressionCours($id_utilisateur,$id_cours){
        $TotalLeocons = $this->progressionDAO->countLecon($id_cours); 
        $TotalLeoconsCompletes = $this->progressionDAO->countLeconComplete($id_utilisateur,$id_cours);
        if($TotalLeocons === 0){
            return 0;
        }

        return round(($TotalLeoconsCompletes / $TotalLeocons) * 100,2);
    }
    /**
     * calculer progression programme
     */
    public function CalculerProgressionProgramme($id_utilisateur,$id_programme){
        $cours = $this->progressionDAO->getCoursByProhramme($id_programme);
        if(count($cours)){
            return 0;
        }
        $total = 0;
        foreach($cours as $coursItem){
            $total += $this->progressionDAO->CalculerProgressionCours($id_utilisateur,$coursItem['id_cours']);
        }
        return round($total / count($cours),2);
    }
    /**
     * supprimer lecon coplet
     */
    public function supprimerLeconComplet($id_utilisateur,$id_cours){
        $this->progressionDAO->DeleteProgression($id_utilisateur,$id_cours);
    }
    /**
     * modifier la progression
     */
    public function modifierProgression($progression){
        $this->progressionDAO->UpdateProgression($progression);
    }
    /**
     * afficher la progression
     */
    public function afficherProgression($id_utilisateur){
        return $this->progressionDAO->getOneProgresion($id_utilisateur);
    }
    /**
     * AFFICHER TOUT PROGRESSION
     */
    public function afficherToutesLesProgressions(){
        return $this->progressionDAO->AfficherToutLesProgression();
    }

}











?>