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
        $this->inscription_service->InscrirEleve(
            $_POST['utilisateur']->getId(),
            $_POST['id_programme']
        );
        header("Location: /mes_programmes");
        exit;
    }
}


















?>