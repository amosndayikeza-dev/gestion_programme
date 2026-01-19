<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__. "../../../dao/Organisation/ClasseDAO.php";

class ClasseService{
    private ClasseDAO $classe_dao;

    public function __construct()
    {
        $classe_dao = new ClasseDAO();
    }
}










?>