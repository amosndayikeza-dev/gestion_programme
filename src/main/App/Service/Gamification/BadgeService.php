<?php
namespace App\Service\Gamification;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use App\Dao\Gamification\BadgeDAO;;
use App\Models\Evaluation\Resultat;
use Exception;

//require_once __DIR__."../../../dao/Gamification/BadgeDAO.php";
//require_once __DIR__."../../../dao/Gamification/BadgetObtenuDAO.php";

class BadgeService{
    private BadgeDAO $badge_dao;
    private BadgetObtenuDAO $badge_obtenu_dao;

    public function __construct()
    {
        $this->badge_dao = new BadgeDAO();
        $this->badge_obtenu_dao = new BadgeObtenuDAO();
    }

    /**
     * nettoyer les donnees
     */
    private function cleanData($data){
        return htmlspecialchars(trim($data));
    }
    /**
     * Creer un nouveaux badge
     */
    public function creerNouveauBadge($badge){
        $badge->setNomBadge($this->cleanData($badge->getNomBadge()));
        $badge->setDateObtention($this->cleanData($badge->getDateObtention()));
       // verifier les donnees
       if(empty($badge->getNom()) || empty($badge->getDateObtention())){
           throw new Exception("Tous les champs sont obligatoires");
       }

       if($badge->getBadgeById()){
         $this->badge_dao->UpateBadge($badge);
       }else{
         $this->badge_dao->CreateBadge($badge);
       }

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

    /**
     * afficher badge par son ID
     */
    public function getBadgeById($id_badge){
        return $this->badge_dao->getBadgeById($id_badge);
    }

    /***
     * SUPPRIMER LE BADGET OBTENU
     */
    public function supprimerBadgeObtenu($id_badge_obtenu){
        return $this->badge_obtenu_dao->deleteBadgeObtenu($id_badge_obtenu);
    }


    
}










?>