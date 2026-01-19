<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Academique/LeconDAO.php";
class LeconService{
    private LeconDAO $lecon_dao;

    public function __construct()
    {
      $lecon_dao = new LeconDAO();
    }
    
}













?>