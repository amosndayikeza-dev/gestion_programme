<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Academique/CoursDAO.php";

class coursService{
    private CoursDAO $cours_dao;

    public function __construct()
    {
       $cours_dao = new CoursDAO();
    }
}











?>