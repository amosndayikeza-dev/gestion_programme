<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Organisation/EtablissementDAO.php";

class EtablissementService{
    private EtablissementDAO $etablissement_dao;

    public function __construct()
    {
        $etablissement_dao = new EtablissementDAO();
    }
}










?>