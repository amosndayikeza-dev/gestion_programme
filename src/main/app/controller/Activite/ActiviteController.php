<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../service/Academique/ActiviteService.php";

class ActiviteController{
    private ActiviteService $activite_service;

    public function __construct()
    {
       $this->activite_service = new ActiviteService();
    }

    public function Lister(){
       $activite = $this->activite_service->ListerActiviteUtilisateur($_SESSION["utilisateur"]->getId());
       require __DIR__."/../../views/activite/liste.php";
    }
 
}














?>