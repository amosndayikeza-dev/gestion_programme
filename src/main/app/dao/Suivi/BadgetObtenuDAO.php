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
    public function createBadgeObtenu(BadgeObtenu $badgeObtenu){
        $sql = "INSERT INTO badge_obtenu(id_utilisateur, id_badge, date_obtention) VALUES(:id_utilisateur, :id_badge, :date_obtention)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":id_utilisateur" => $badgeObtenu->getIdUtilisateur(),
            ":id_badge" => $badgeObtenu->getIdBadge(),
            ":date_obtention" => $badgeObtenu->getDateObtention()
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
    public function updateBadgeObtenu(BadgeObtenu $badgeObtenu){
        $sql = "UPDATE badge_obtenu SET id_utilisateur = :id_utilisateur, id_badge = :id_badge, date_obtention = :date_obtention WHERE id_badge_obtenu = :id_badge_obtenu";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":id_badge_obtenu" => $badgeObtenu->getIdBadgeObtenu(),
            ":id_utilisateur" => $badgeObtenu->getIdUtilisateur(),
            ":id_badge" => $badgeObtenu->getIdBadge(),
            ":date_obtention" => $badgeObtenu->getDateObtention()
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
}














?>