<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Academique/MatiereDAO.php";

class MatiereService {
    private MatiereDAO $matiere_dao;
    public function __construct()
    {
       $matiere_dao = new MatierEDAO();
    }
}










?>