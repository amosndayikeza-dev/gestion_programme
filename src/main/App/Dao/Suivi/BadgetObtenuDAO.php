<?php
namespace App\Dao\Academique;
use App\Config\Database;
use App\Models\Suivi\BadgeObtenu;
use PDO;
use PDOException;

//require_once __DIR__ ."../../../model/Suivi/badgeObtenu.php";
//require_once __DIR__ ."../../../config/Database.php";

class BadgetObtenuDAO{
    private $db;

    public function __construct()
    {
       $conn = new Database();
       self::$db = $conn->getConnexion();
    }
    public function createBadgeObtenu(BadgeObtenu $badge_obtenu){
        try{
            $sql = "INSERT INTO badge_obtenu(id_utilisateur, id_badge, date_obtention) VALUES(:id_utilisateur, :id_badge, :date_obtention)";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute([
                ":id_utilisateur" => $badge_obtenu->getIdUtilisateur(),
                ":id_badge" => $badge_obtenu->getIdBadge(),
                ":date_obtention" => $badge_obtenu->getDateObtention()
            ]);
        }catch(PDOException $e){
            echo "Erreur : insertion a echoue" .$e->getMessage();
        }
    }
    public function getBadgesObtenusByUserId($id_utilisateur){
        try{
            $sql = "SELECT * FROM badge_obtenu WHERE id_utilisateur = :id_utilisateur";
            $stmt = self::$db->prepare($sql);
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
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    }
    public function getOneBadgeObtenu($id_badge_obtenu){
        try{
            $sql = "SELECT * FROM badge_obtenu WHERE id_badge_obtenu = :id_badge_obtenu";
            $stmt = self::$db->prepare($sql);
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
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }

    }
    public function updateBadgeObtenu(BadgeObtenu $badge_obtenu){
       try{
            $sql = "UPDATE badge_obtenu SET id_utilisateur = :id_utilisateur, id_badge = :id_badge, date_obtention = :date_obtention WHERE id_badge_obtenu = :id_badge_obtenu";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute([
                ":id_utilisateur" => $badge_obtenu->getIdUtilisateur(),
                ":id_badge" => $badge_obtenu->getIdBadge(),
                ":date_obtention" => $badge_obtenu->getDateObtention()
            ]);
       }catch(PDOException $e){
        echo "Erreur : modification a echoue" .$e->getMessage();
       }
    }

    public static function AfficherToutBadgeObtenu(){
        try{
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
            return $ListeBadgeObtenu;
        }catch(PDOException $e){
            echo "Erreur : lecture a echoue" .$e->getMessage();
        }
    
    }
    public function deleteBadgeObtenu($id_badge_obtenu){
       try{
         $sql = "DELETE FROM badge_obtenu WHERE id_badge_obtenu = :id_badge_obtenu";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([":id_badge_obtenu" => $id_badge_obtenu]);
       }catch(PDOException $e){
        echo "Erreur : suppression a echoue" .$e->getMessage();
       }
    }

    //verifier attribution badge
    public function existsBadge($id_badge,$id_utilisateur){
        try{
            $sql = "SELECT COUNT(*) FROM badge WHERE id_badge = :id_badge OR id_utilisateur = :id_utilisateur";
            $stmt = self::$db->prepare($sql);
            $stmt->bindValue(":id_badge",$id_badge);
            $stmt->bindValue(":id_utilisateur",$id_utilisateur);
            return $stmt->execute();
        }catch(PDOException $e){
            echo "Erreur : verification a echoue" .$e->getMessage();
        }
    }
}














?>