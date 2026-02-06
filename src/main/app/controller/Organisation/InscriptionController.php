<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../service/Organisation/Inscription.php";

class InscriptionController{
    private InscriptionService $inscription_service;

    public function __construct()
    {
       $this->inscription_service = new InscriptionService();
    }

    public function Inscrire(){
       if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //recuperer les donnees
            $id_utilisateur = $_POST['id_utilisateur'];
            $id_classe = $_POST['id_classe'];
            $statut = $_POST['statut'];

            //creer l'objet inscription
            $inscription = new Inscription();
            if(!empty($_POST['id_inscription'])){
                $inscription->setIdInscription($_POST['id_inscription']);
            }
            $inscription->setIdUtilisateur($id_utilisateur);
            $inscription->setIdClasse($id_classe);
            $inscription->setStatut($statut);
        }else{
            require __DIR__ ."/../../views/inscription/creer.php";
        }


       //appeler un service
       $success = $this->inscription_service->InscrirEleve($inscription);
       if($success){
           header("location: /inscription");
       }else{
           header("location: /inscription");
           exit;
       }
    }
    //afficher touts les inscriptions
    public function afficherToutesLesInscriptions(){
        $inscriptions = $this->inscription_service->afficherToutesLesInscriptions();
        require __DIR__ ."/../../views/inscription/liste.php";
    }
    //afficher une inscription
    public function afficherInscription($id_inscription){
        $inscription = $this->inscription_service->afficherInscription($id_inscription);
        require __DIR__ ."/../../views/inscription/detail.php";
    }
    //supprimer une inscription
    public function supprimerInscription($id_inscription){
        $this->inscription_service->supprimerInscription($id_inscription);
        header("location: /inscription");
        exit;
    }
    

}


















?>