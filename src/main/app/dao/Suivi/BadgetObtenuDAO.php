<?php

require_once __DIR__ ."../../../model/Suivi/badgeObtenu.php";
require_once __DIR__ ."../../../config/Database.php";

class BadgetObtenuDAO{
    private $db;

    public function __construct()
    {
       $conn = new Database();
       $this->db = $conn->getConnexion();
    }
    public function createBadgeObtenu(BadgeObtenu $badge_obtenu){
        $sql = "INSERT INTO badge_obtenu(id_utilisateur, id_badge, date_obtention) VALUES(:id_utilisateur, :id_badge, :date_obtention)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":id_utilisateur" => $badge_obtenu->getIdUtilisateur(),
            ":id_badge" => $badge_obtenu->getIdBadge(),
            ":date_obtention" => $badge_obtenu->getDateObtention()
        ]);
    }
    public function getBadgesObtenusByUserId($id_utilisateur){
        $sql = "SELECT * FROM badge_obtenu WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_utilisateur" => $id_utilisateur]);
        $badgesObtenus = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $badgesObtenus[] = new BadgeObtenu(
                $row['id_badge_obtenu'],
                $row['id_utilisateur'],
                $row['id_badge'],
                $row['date_obtention']
            );
        }
        return $badgesObtenus;
    }
    public function getOneBadgeObtenu($id_badge_obtenu){
        $sql = "SELECT * FROM badge_obtenu WHERE id_badge_obtenu = :id_badge_obtenu";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id_badge_obtenu" => $id_badge_obtenu]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            return new BadgeObtenu(
                $row['id_badge_obtenu'],
                $row['id_utilisateur'],
                $row['id_badge'],
                $row['date_obtention']
            );
        }else{
            return NULL;
        }
    }
    public function updateBadgeObtenu(BadgeObtenu $badge_obtenu){
        $sql = "UPDATE badge_obtenu SET id_utilisateur = :id_utilisateur, id_badge = :id_badge, date_obtention = :date_obtention WHERE id_badge_obtenu = :id_badge_obtenu";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":id_utilisateur" => $badge_obtenu->getIdUtilisateur(),
            ":id_badge" => $badge_obtenu->getIdBadge(),
            ":date_obtention" => $badge_obtenu->getDateObtention()
        ]);
    }
    public static function AfficherToutBadgeObtenu(){
        $sql = "SELECT *FROM badge_obtenu";
        $stmt = self::$db->query($sql);
        $ListeBadgeObtenu = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $ListeBadgeObtenu [] = new BadgeObtenu(
                $row['id_badge_obtenu'],
                $row['id_utilisateur'],
                $row['id_badge'],
                $row['date_obtention']
            );
        }
    }
    public function deleteBadgeObtenu($id_badge_obtenu){
        $sql = "DELETE FROM badge_obtenu WHERE id_badge_obtenu = :id_badge_obtenu";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([":id_badge_obtenu" => $id_badge_obtenu]);
    }

    //verifier attribution badge
    public function existsBadge($id_badge,$id_utilisateur){
        $sql = "SELECT COUNT(*) FROM badge WHERE id_badge = :id_badge OR id_utilisateur = :id_utilisateur";
        $stmt = self::$db->prepare($sql);
        $stmt->bindValue(":id_badge",$id_badge);
        $stmt->bindValue(":id_utilisateur",$id_utilisateur);
        return $stmt->execute();
    }
}














?>