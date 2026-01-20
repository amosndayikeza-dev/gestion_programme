<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../service/Organisation/ClasseService.php";

class ClasseController{
    private ClasseService $classe_service;

    public function __construct()
    {
        $classe_service = new ClasseService();
    }

    public function creer(){
        $this->classe_service->CreateClasse($_POST['nom']);
        header("location: /classes");
        exit;
    }

    public function assignerEleve(){
        $this->classe_service->assignerEleve(
            $_POST['id_classe'],
            $_POST['id_eleve']
        );

        header("location: /classe?id=".$_POST['id_classe']);
        exit;
    }


}











?>