<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../dao/Organisation/EtablissementDAO.php";

class EtablissementController{
    private EtablissementDAO $etablissement_dao;

    public function __construct()
    {
        $this->etablissement_dao = new EtablissementDAO();
    }

    //ajouter d'un etablissment
    public function ajouterEtablissement(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //recupere
            $nom = $_POST['nom'];
            $type = $_POST['type'];
            $localisation = $_POST['localisation'];

            //creer un objet
            $etablissement = new Etablissement(); 
            if(!empty($_POST['id_etablissment'])){
                $etablissement->setIdEtablissement($_POST['id_etablissement']);
            }
            
            $etablissement->setNom($nom);
            $etablissement->setType($type);
            $etablissement->setLocalisation($localisation);

            //appeler un service
            $this->etablissement_dao->ajouterEtablissement($etablissement);
            header("location: /etablissement");
            exit;
        }else{
            require __DIR__ ."/../../views/etablissement/creer.php";
        }
    }
    //afficher touts les etablissement
    public function afficherTousLesEtablissement(){
    {
        $etablissement = $this->etablissement_dao->AfficherToutEtalissement();
        require __DIR__ ."/../../views/etablissement/liste.php";
    }


}
}








?>