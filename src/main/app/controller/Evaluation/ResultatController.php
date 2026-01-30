<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../service/Evaluation/ResultatService.php";
require_once __DIR__ . "/../../model/Evaluation/Resultat.php";

class ResultatController{
    private ResultatService $resultat_service;

    public function __construct()
    {
       $this->resultat_service = new ResultatService();
    }
    public function TraiterFormulaireResultat(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //recuperer les donnes depuis un formulaire
            $id_utilisateur = $_POST['id_utilisateur'];
            $id_exercice = $_POST['id_exercice'];
            $score = $_POST['score'];
            $date_resultat = $_POST['date_resultat'];

            //creer l'objet resultat
            $resultat = new Resultat();

            // C'est cet ID qui dira au Service de faire un UPDATE et non un CREATE
            if(!empty($_POST['id_resultat'])){
                $resultat->setIdResultat($_POST['id_resultat']);
            }
            $resultat->setIdUtilisateur($id_utilisateur);
            $resultat->setIdExercice($id_exercice);
            $resultat->setScore($score);
            $resultat->setDateResultat($date_resultat);

            //APPELER LE SERVICE        
            $success = $this->resultat_service->enregistrerResultat($resultat);
            if($success){
                header("location: /resultat");
            }else{
                    header("location: /resultat");  
            }
        }else{
            require __DIR__ ."/../../views/resultat/creer.php";
    }
}

 // afficher un resulatat
     public function afficherResultat($id_resultat){
        $resultat = $this->resultat_service->afficherResultat($id_resultat);
        require __DIR__ ."/../../views/resultat/detail.php";
    }

    ///afficher tout le resulatat
    public function afficherResultats(){
        $resultats = $this->resultat_service->afficherTousLesResultats();
        require __DIR__ ."/../../views/resultat/liste.php";
    }
    public function supprimerResultat($id_resultat){
        $this->resultat_service->supprimerResultat($id_resultat);
        header("location: /resultat");
        exit;
    }





}


?>