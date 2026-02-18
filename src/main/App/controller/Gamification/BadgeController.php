<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../service/Gamification/BadgeService.php";

class BadgeController{
    private BadgeService $badge_service;

    public function __construct()
    {
        $this->badge_service = new BadgeService();
    }

    public function creerBadge(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //recuper les donnees
        $nom_badge = $_POST['nom_badge'];;
        $date_obtention = $_POST['date_obtention'];

        //creer un objet badge
        $badge = new Badge();
        if(!empty($_POST['id_badge'])){
            $badge->setIdBadge($_POST['id_bdge']);
        }
        $badge->setNomBadge($nom_badge);
        $badge->setDateObtention($date_obtention);

        //appeler un service
        $success = $this->badge_service->creerNouveauBadge($badge);
        if($success){
            header("location: /badge");
        }else{
            header("location: /badge");
            exit;
        }
        }else{
            require __DIR__ ."/../../views/badge/creer.php";
        }
    }
    //afficher un badge
    public function afficherBadge($id_badge){
        $badge = $this->badge_service->listerBadgesUtilisateur($id_badge);
        require __DIR__."/../../views/badge/liste.php";
    }
    //afficher touts les badges
    public function afficherTousLesBadges(){
        $badge = $this->badge_service->listerTousLesBadges();
        require __DIR__ ."/../../views/badge/liste.php";
    }
    //public function supprimer un bdge
    public function supprimerBadge($id_badge){
        $this->badge_service->supprimerBadgeObtenu($id_badge);
        header("location: /badge");


    }


}

















?>