<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//require_once __DIR__."../../../dao/Gamification/BadgeDAO.php";
require_once __DIR__."../../../dao/Suivi/BadgetObtenuDAO.php";
class BadgetObtenuService{
    private BadgetObtenuDAO $badge_obtenu_dao;
    public function __construct()
    {
        $this->badge_obtenu_dao = new BadgetObtenuDAO();
    }
    /**
     * creer un badget
     */
    public function creerNouveauBadge($badge_obtenu){
        return $this->badge_obtenu_dao->CreateBadgeObtenu($badge_obtenu);
    }
    /**
     * modifier un badget
     */
    public function modifierBadge($badge_obtenu){
        return $this->badge_obtenu_dao->UpdateBadgeObtenu($badge_obtenu);
    }
    /**
     * supprimer un badget
     */
    public function supprimerBadge($id_badge_obtenu){
        return $this->badge_obtenu_dao->DeleteBadgeObtenu($id_badge_obtenu);
    }

    /**
     * afficher un badget
     */
    public function afficherBadge($id_badge_obtenu){
        return $this->badge_obtenu_dao->getOneBadgeObtenu($id_badge_obtenu);
    }
    /**
     * afficher tous les badges
     */
    public function afficherTousLesBadges(){
        return $this->badge_obtenu_dao->AfficherToutBadgeObtenu();
    }
    /**
     * afficher une badget
     */
    public function afficherBadgeObtenu($id_badge_obtenu){          
        return $this->badge_obtenu_dao->getOneBadgeObtenu($id_badge_obtenu);
    }

}









?>