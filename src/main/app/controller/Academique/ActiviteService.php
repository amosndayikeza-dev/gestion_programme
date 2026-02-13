<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../service/Academique/ActiviteService.php';
require_once __DIR__ . '/../../model/Academique/Activite.php';

class ActiviteController{
    private ActiviteService $activite_service;

    public function __construct()
    {
       $this->activite_service = new ActiviteService();
    }
    /**
     * afficher totes les activites
     */
    public function index(){
        $activites = $this->activite_service->afficherToutesActivites();
        require __DIR__ ."/../../views/activite/liste.php";
    }

    public function creerActivite(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
            //recuperer les donnes depuis un formulaire
                $nom_activite = $_POST['nom_activite'] ?? "";
                $type = $_POST['type'] ?? "";
                $instruction = $_POST['instruction'] ?? "";
                //creer l'objet activite
                $activite = new Activite(); 
                if(!empty($_POST['id_activite'])){
                    $activite->setIdActivite($_POST['id_activite']);
                }
                $activite->setNomActivite($nom_activite);
                $activite->setType($type);
                $activite->setInstruction($instruction);

                //appeler un service
                $sucess = $this->activite_service->enregistrerActivite($activite);
                if($sucess){
                    header("location: /activites");
                }else{
                    header("location: /activites");
                    exit;
                }
            }else{
                require __DIR__ ."/../../views/activite/creer.php";
            }
        
        }
        /**
         * supprimer une activite
         */
        public function supprimerActivite($id_activite){
            $this->activite_service->supprimerActivite($id_activite);
            header("location: /activites");
            exit;
        }

    }

















?>