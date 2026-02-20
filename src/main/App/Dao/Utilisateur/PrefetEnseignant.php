<?php
namespace App\Dao\Utilisateur;

use App\Models\Utilisateur\PrefetEnseignant;
use App\Config\Model;
use PDO;

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
     */
    public function save(PrefetEnseignant $prefet)
    {
        try {
            $this->db->beginTransaction();
            
            $data = $prefet->toArrayForDb();
            
            // CAS MISE À JOUR
            if ($prefet->getIdPrefet()) {
                // Mettre à jour utilisateur
                $this->updateUser($prefet->getIdUtilisateur(), $data['user']);
                
                // Mettre à jour préfet (utilise update du parent)
                $this->update($prefet->getIdPrefet(), $data['prefet']);
                
                $this->db->commit();
                return true;
            }
            
            // CAS CRÉATION
            // 1. Créer l'utilisateur
            $userId = $this->createUser($data['user']);
            if (!$userId) {
                throw new \Exception("Erreur création utilisateur");
            }
            
            // 2. Ajouter l'id_utilisateur
            $data['prefet']['id_prefet'] = $userId;
            
            // 3. Créer le préfet (utilise create du parent)
            $prefetId = $this->create($data['prefet']);
            if (!$prefetId) {
                throw new \Exception("Erreur création préfet");
            }
            
            // 4. Mettre à jour l'objet
            $prefet->setIdUtilisateur($userId);
            $prefet->setIdPrefet($userId);
            
            $this->db->commit();
            return true;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Erreur save PrefetEnseignant: " . $e->getMessage());
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
        try {
            $this->db->beginTransaction();
            
            $prefet = $this->find($id);
            if (!$prefet) {
                return false;
            }
            
            $userId = $prefet->getIdUtilisateur();
            
            // Supprimer préfet (utilise delete du parent)
            $result = parent::delete($id);
            
            // Supprimer utilisateur
            if ($result) {
                $sqlUser = "DELETE FROM {$this->userTable} WHERE id_utilisateur = ?";
                $stmtUser = $this->db->prepare($sqlUser);
                $result = $stmtUser->execute([$userId]);
            }
            
            $this->db->commit();
            return $result;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Erreur delete PrefetEnseignant: " . $e->getMessage());
            return false;
        }
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