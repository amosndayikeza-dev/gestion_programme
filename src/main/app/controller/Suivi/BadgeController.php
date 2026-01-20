<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../service/suivi/BadgeService.php";

class BadgeController{
    private BadgeService $badge_service;

    public function __construct()
    {
       $badge_service = new BadgeService();
    }

    public function consulter(){
        $badge = $this->badge_service->listerBadgesUtilisateur(
            $_SESSION['utilisateur']->getId(),
        
        );

        require __DIR__ ."/../../views/badge/liste.php";
    }
}










?>