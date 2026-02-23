<?php
namespace App\ModuleUtilisateur\Prefet\Dao;

use App\ModuleUtilisateur\Prefet\Models\PrefetEnseignant;
use App\core\Config\Model;
use PDO;
use Exception;


class PrefetEnseignantDAO extends Model
{
    protected $table = "prefet_enseignant";
    protected $primaryKey = "id_prefet";
    private $userTable = "utilisateur";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Créer un objet PrefetEnseignant à partir d'un tableau
     */
    public function createEntity($row)
    {
        $prefet = new PrefetEnseignant();
        return $prefet->hydrate($row);
    }

    /**
     * Sauvegarder un préfet (création ou mise à jour)
     */public function save(PrefetEnseignant $prefet)
{ 
    try{
        // 1. Insertion dans utilisateur
        $stmt = $this->db->prepare("INSERT INTO utilisateur 
            (nom, prenom, email, mot_de_passe, role, statut, telephone, date_creation) 
            VALUES 
            (:nom, :prenom, :email, :mot_de_passe, :role, :statut, :telephone, :date_creation)");
        
        $result = $stmt->execute([
            ':nom' => $prefet->getNom(),
            ':prenom' => $prefet->getPrenom(),
            ':email' => $prefet->getEmail(),
            ':mot_de_passe' => $prefet->getMotDePasse(),
            ':role' => $prefet->getRole(),
            ':statut' => $prefet->getStatut(),
            ':telephone' => $prefet->getTelephone(),
            ':date_creation' => $prefet->getDateCreation()
        ]);
        
        if (!$result) {
            $error = $stmt->errorInfo();
            throw new \Exception("Erreur insertion utilisateur: " . $error[2]);
        }
        
        $userId = $this->db->lastInsertId();
        $prefet->setIdUtilisateur($userId);
        $prefet->setIdPrefet($userId);
        
        // 2. Insertion dans prefet_enseignant
        $stmt = $this->db->prepare("INSERT INTO prefet_enseignant 
            (id_prefet, departement, specialite, echelle_traitement) 
            VALUES 
            (:id_prefet, :departement, :specialite, :echelle_traitement)");
        
        $result2 = $stmt->execute([  // ← VÉRIFIER AUSSI !
            ':id_prefet' => $userId,
            ':departement' => $prefet->getDepartement(),
            ':specialite' => $prefet->getSpecialite(),
            ':echelle_traitement' => $prefet->getEchelleTraitement()
        ]);
        
        if (!$result2) {
            $error = $stmt->errorInfo();
            throw new \Exception("Erreur insertion prefet: " . $error[2]);
        }
        
        return true;
        
    } catch (\Exception $e) {
        error_log("Erreur save PrefetEnseignant: " . $e->getMessage());
        return false;  // ← Retourne false en cas d'erreur
    }
}
    /**
     * mettre a jour un préfet
     */
    public function updatePrefet(PrefetEnseignant $prefet)
    {   
        $id = $prefet->getIdPrefet();
        if (!$this->find($id)) {
            throw new \Exception("Préfet avec ID $id non trouvé.");
        }

        try {
            // Mise à jour de l'utilisateur
            $stmt = $this->db->prepare("UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, statut = :statut, telephone = :telephone WHERE id_utilisateur = :id_utilisateur");
            $stmt->execute([
                ':nom' => $prefet->getNom(),
                ':prenom' => $prefet->getPrenom(),
                ':email' => $prefet->getEmail(),
                ':mot_de_passe' => $prefet->getMotDePasse(),
                ':statut' => $prefet->getStatut(),
                ':telephone' => $prefet->getTelephone(),
                ':id_utilisateur' => $prefet->getIdPrefet()
            ]);
            
            // Mise à jour du préfet
            $stmt = $this->db->prepare("UPDATE prefet_enseignant SET departement = :departement, specialite = :specialite, echelle_traitement = :echelle_traitement WHERE id_prefet = :id_prefet");
            $stmt->execute([
                ':departement' => $prefet->getDepartement(),
                ':specialite' => $prefet->getSpecialite(),
                ':echelle_traitement' => $prefet->getEchelleTraitement(),
                ':id_prefet' => $id
            ]);
            
            return true;
        } catch (\Exception $e) {
            error_log("Erreur update PrefetEnseignant: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Trouver un préfet par ID (avec jointure)
     */
    public function find($id)
    {
        $sql = "SELECT u.*, p.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} p ON u.id_utilisateur = p.id_prefet
                WHERE p.{$this->primaryKey} = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createEntity($row) : null;
    }

    /**
     * Trouver tous les préfets (avec jointure)
     */
    public function all($columns = ['*'])
    {
        $sql = "SELECT u.*, p.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} p ON u.id_utilisateur = p.id_prefet
                ORDER BY p.departement, u.nom, u.prenom";
        
        $stmt = $this->db->query($sql);
        
        $prefets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prefets[] = $this->createEntity($row);
        }
        
        return $prefets;
    }

    /**
     * Trouver par email (avec jointure)
     */
    public function findByEmail($email)
    {
        $sql = "SELECT u.*, p.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} p ON u.id_utilisateur = p.id_prefet
                WHERE u.email = :email";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createEntity($row) : null;
    }

    /**
     * Supprimer un préfet
     */
    public function delete($id)
    {
        return parent::delete($id);
    }

    // === MÉTHODES SPÉCIFIQUES ===

    /**
     * Trouver par département
     */
    public function findByDepartement($departement)
    {
        $sql = "SELECT u.*, p.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} p ON u.id_utilisateur = p.id_prefet
                WHERE p.departement = :departement
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['departement' => $departement]);
        
        $prefets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prefets[] = $this->createEntity($row);
        }
        
        return $prefets;
    }

    /**
     * Trouver par échelle de traitement
     */
    public function findByEchelle($echelle)
    {
        $sql = "SELECT u.*, p.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} p ON u.id_utilisateur = p.id_prefet
                WHERE p.echelle_traitement = :echelle
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['echelle' => $echelle]);
        
        $prefets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prefets[] = $this->createEntity($row);
        }
        
        return $prefets;
    }

    /**
     * Trouver les préfets par échelle minimum
     */
    public function findByEchelleMin($echelleMin)
    {
        $sql = "SELECT u.*, p.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} p ON u.id_utilisateur = p.id_prefet
                WHERE p.echelle_traitement >= :echelle
                ORDER BY p.echelle_traitement DESC, u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['echelle' => $echelleMin]);
        
        $prefets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prefets[] = $this->createEntity($row);
        }
        
        return $prefets;
    }

    /**
     * Trouver les préfets promouvables
     */
    public function findPromouvables()
    {
        // Préfets avec échelle < 10 et expérience > 2 ans
        $sql = "SELECT u.*, p.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} p ON u.id_utilisateur = p.id_prefet
                WHERE p.echelle_traitement < 10
                AND DATEDIFF(CURDATE(), u.date_creation) > 730  -- 2 ans
                ORDER BY p.echelle_traitement DESC";
        
        $stmt = $this->db->query($sql);
        
        $prefets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prefets[] = $this->createEntity($row);
        }
        
        return $prefets;
    }

    /**
     * Rechercher par nom, département ou spécialité
     */
    public function search($keyword)
    {
        $sql = "SELECT u.*, p.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} p ON u.id_utilisateur = p.id_prefet
                WHERE u.nom LIKE :keyword 
                   OR u.prenom LIKE :keyword
                   OR p.departement LIKE :keyword
                   OR p.specialite LIKE :keyword
                ORDER BY p.departement, u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => "%{$keyword}%"]);
        
        $prefets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prefets[] = $this->createEntity($row);
        }
        
        return $prefets;
    }

    /**
     * Compter par département
     */
    public function countByDepartement()
    {
        $sql = "SELECT departement, COUNT(*) as total 
                FROM {$this->table} 
                GROUP BY departement 
                ORDER BY total DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Compter par échelle
     */
    public function countByEchelle()
    {
        $sql = "SELECT echelle_traitement, COUNT(*) as total 
                FROM {$this->table} 
                GROUP BY echelle_traitement 
                ORDER BY echelle_traitement";
        
        $stmt = $this->db->query($sql);
        
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prefet = new PrefetEnseignant();
            $result[$prefet->getEchelleLibelle()] = $row['total'];
        }
        
        return $result;
    }

    /**
     * Obtenir les statistiques
     */
    public function getStatistiques()
    {
        $stats = [];
        
        // Total
        $stats['total'] = $this->count();
        
        // Par département
        $stats['par_departement'] = $this->countByDepartement();
        
        // Par échelle
        $stats['par_echelle'] = $this->countByEchelle();
        
        // Échelle moyenne
        $sql = "SELECT AVG(echelle_traitement) FROM {$this->table}";
        $stats['echelle_moyenne'] = round($this->db->query($sql)->fetchColumn(), 1);
        
        // Préfets promouvables
        $stats['promouvables'] = count($this->findPromouvables());
        
        // Répartition par niveau
        $sql = "SELECT 
                    SUM(CASE WHEN echelle_traitement <= 3 THEN 1 ELSE 0 END) as debutant,
                    SUM(CASE WHEN echelle_traitement BETWEEN 4 AND 6 THEN 1 ELSE 0 END) as confirme,
                    SUM(CASE WHEN echelle_traitement BETWEEN 7 AND 8 THEN 1 ELSE 0 END) as senior,
                    SUM(CASE WHEN echelle_traitement >= 9 THEN 1 ELSE 0 END) as expert
                FROM {$this->table}";
        
        $stats['niveaux'] = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
        
        return $stats;
    }

    /**
     * Vérifier si email existe déjà
     */
    public function emailExists($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM {$this->userTable} WHERE email = ?";
        $params = [$email];
        
        if ($excludeId) {
            $sql .= " AND id_utilisateur != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchColumn() > 0;
    }

    // === MÉTHODES PRIVÉES ===

    private function createUser($data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->userTable} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute(array_values($data))) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    private function updateUser($id, $data)
    {
        $set = [];
        foreach (array_keys($data) as $column) {
            $set[] = "{$column} = ?";
        }
        $set = implode(',', $set);
        
        $sql = "UPDATE {$this->userTable} SET {$set} WHERE id_utilisateur = ?";
        $stmt = $this->db->prepare($sql);
        
        $values = array_values($data);
        $values[] = $id;
        
        return $stmt->execute($values);
    }
}