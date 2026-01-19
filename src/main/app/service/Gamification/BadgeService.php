<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../dao/Gamification/BadgeDAO.php";

class BadgeService{
    private BadgeDAO $badge_dao;
    private BadgetObtenuDAO $badget_obtenu_dao;

    public function __construct()
    {
        $badge_dao = new BadgeDAO();
        $badget_obtenu_dao = new BadgetObtenuDAO();
    }

    /**
     * badget service
     */
    public function attribuerBadge($id_utilisateur, $id_badge){
        $date_obtention = date('Y-m-d H:i:s');

        $badget_obtenu = new BadgetObtenu(
            null,
            $id_utilisateur,
            $id_badge,
            $date_obtention
        );

        $this->badget_obtenu_dao->create($badget_obtenu);
    }

    public function listerBadgesUtilisateur($id_utilisateur){
        return $this->badget_obtenu_dao->findByUtilisateur($id_utilisateur);
    }

    public function listerTousLesBadges(){
        return $this->badge_dao->findAll();
    }

    public function getBadgeParId($id_badge){
        return $this->badge_dao->getOneById($id_badge);
    }

    public function supprimerBadgeObtenu($id_badge_obtenu){
        return $this->badget_obtenu_dao->delete($id_badge_obtenu);
    }

    public function creerBadge($nom_badge){
        $badge = new Badge(
            null,
            $nom_badge,
            null
        );

        $this->badge_dao->create($badge);
    }   

    public function verifierAttributionBadge($id_utilisateur, $id_badge){
        return $this->badget_obtenu_dao->exists($id_utilisateur, $id_badge);
    }
}










?>