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

}











?>