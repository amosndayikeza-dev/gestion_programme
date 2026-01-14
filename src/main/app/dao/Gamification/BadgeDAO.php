<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../config/Database.php";
require_once __DIR__ ."../../../model/Gamification/Badge.php";
class BadgeDAO{
    private static $db;

    public function __construct()
    {
        $pdo = new Database();
        self::$db = $pdo->getConnexion();
    }

    //Ajouter un bage
    public static function CreateBadge(Badge $badge){
        $sql = "INSERT INTO badge(id_badge,nom_badge,description_badge,image_badge) VALUES(:id_badge,:nom_badge,:description_badge,:image_badge)";
        $stmt = self::$db->prepare($sql);
         return $stmt->execute(
            [
                ":id_badge" =>$badge->getIdBadge(),
                ":nom_badge" =>$badge->getNomBadge(),
                ":condition_obtention" =>$badge->getDateObtention(),
            ]
            );
    }
    //Afficher un badge
    public static function getOneBadge($id_badge){
        $sql = "SELECT * FROM badge WHERE id_badge = :id_badge";
        $stmt = self::$db->prepare($sql);
        $stmt->exeute(["id_badge" => $id_badge]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return NULL;
        }else{
            return new Badge(
            $row['id_badge'],
            $row['nom_badge'],
            $row['date_obtention']);
        }
    }
    //Afficher tout les badges
    public static function AfficherToutBadge(){
        $sql = "SELECT * FROM badge";
        $stmt = self::$db->query($sql);
        $listeBadge = [];
        while($row = $stmt->fetchall(PDO::FETCH_CLASS)){
            $listeBadge [] = new Badge(
                $row['id_badge'],
                $row['nom_badge'],
                $row['date_obtention']
            );
        }
        return $listeBadge;
    }
    //Modidfier Badge
    public static function UpateBadge(Badge $badge){
        $sql = "UPDATE badge SET nom_badge = :nom_badge,date_obtention = :date_obtention WHERE id_badge = :id_badge";
        $stmt = self::$db->prpare($sql);
        return $stmt->execute([
            ":nom_badge" =>$badge->getNomBadge(),
            ":date_obtention"=>$badge->getDateObtention()
        ]);
    }
    //SUPPRIMER LE BADGE
    public static function DeleteBadge($id_badge){
        $sql = "DELETE FROM badge WHERE id_badge = :id_badge";
        $stmt = self::$db->prepare($sql);
        $stmt->bindValue(":id_badge",$id_badge,PDO::PARAM_STR);
        return $stmt->execute();
    }
}










?>