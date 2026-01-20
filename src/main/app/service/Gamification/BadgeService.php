<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."../../../dao/Gamification/BadgeDAO.php";

class BadgeService{
    private BadgeDAO $badge_dao;
    private BadgetObtenuDAO $badge_obtenu_dao;

    public function __construct()
    {
        $badge_dao = new BadgeDAO();
        $badge_obtenu_dao = new BadgetObtenuDAO();
    }

    /**
     * Creer un nouveaux badge
     */
    public function creerNouveauBadge($nom_badge,$description,$seuil){
        //creation de l'objet metier
        $badge = new Badge(
            null,
            $nom_badge,
            $description,
            $seuil
        );

        //ajouter a la base des donnees
        $this->badge_dao->CreateBadge($badge);
    }
    /**
     * vierifier si l'utulisateur rempli les conditions d'obtention du badge
     */
    public function verifierAttributionBadge($id_utilisateur,$badge,$valeur_actuelle){
        //seuil atteint
        return $valeur_actuelle >= $badge->getSeuil();
    }
    /**
     * badget service
     */
    public function attribuerBadge($id_utilisateur, $id_badge){
        //verifier si l'utilisateur n'a pas dejade badge
        if($this->badge_obtenu_dao->existsBadge($id_utilisateur,$id_badge)){
            return ;
        }

        //attribution
        $this->badge_obtenu_dao->createBadgeObtenu($id_utilisateur,$id_badge,date('Y-m-d H:s:i'));

    }

    public function listerBadgesUtilisateur($id_utilisateur){
        return $this->badge_obtenu_dao->getBadgesObtenusByUserId($id_utilisateur);
    }

    public function listerTousLesBadges(){
        return $this->badge_dao->AfficherToutBadge();
    }

    public function getBadgeById($id_badge){
        return $this->badge_dao->getBadgeById($id_badge);
    }

    public function supprimerBadgeObtenu($id_badge_obtenu){
        return $this->badge_obtenu_dao->deleteBadgeObtenu($id_badge_obtenu);
    }

    public function creerBadge($nom_badge){
        $badge = new Badge(
            null,
            $nom_badge,
            null
        );

        $this->badge_dao->CreateBadge($badge);
    }   

    
}










?>