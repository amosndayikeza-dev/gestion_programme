<?php
namespace App\Dao\Utilisateur;

use App\Models\Utilisateur\Inspecteur;
use App\Config\Model;
use PDO;

class InspecteurDAO extends Model
{
    protected $table = "inspecteur";
    protected $primaryKey = "id_inspecteur";
    private $userTable = "utilisateur";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Créer un objet Inspecteur à partir d'un tableau
     */
    public function createEntity($row)
    {
        $inspecteur = new Inspecteur();
        return $inspecteur->hydrate($row);
    }

    /**
     * Sauvegarder un inspecteur (création ou mise à jour)
     */
    public function save(Inspecteur $inspecteur)
    {
        try {
            $this->db->beginTransaction();
            
            $data = $inspecteur->toArrayForDb();
            
            // CAS MISE À JOUR
            if ($inspecteur->getIdInspecteur()) {
                // Mettre à jour utilisateur
                $this->updateUser($inspecteur->getIdUtilisateur(), $data['user']);
                
                // Mettre à jour inspecteur (utilise update du parent)
                $this->update($inspecteur->getIdInspecteur(), $data['inspecteur']);
                
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
            $data['inspecteur']['id_inspecteur'] = $userId;
            
            // 3. Créer l'inspecteur (utilise create du parent)
            $inspecteurId = $this->create($data['inspecteur']);
            if (!$inspecteurId) {
                throw new \Exception("Erreur création inspecteur");
            }
            
            // 4. Mettre à jour l'objet
            $inspecteur->setIdUtilisateur($userId);
            $inspecteur->setIdInspecteur($userId);
            
            $this->db->commit();
            return true;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Erreur save Inspecteur: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Trouver un inspecteur par ID (avec jointure)
     */
    public function find($id)
    {
        $sql = "SELECT u.*, i.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} i ON u.id_utilisateur = i.id_inspecteur
                WHERE i.{$this->primaryKey} = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createEntity($row) : null;
    }

    /**
     * Trouver tous les inspecteurs (avec jointure)
     */
    public function all($columns = ['*'])
    {
        $sql = "SELECT u.*, i.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} i ON u.id_utilisateur = i.id_inspecteur
                ORDER BY i.niveau_habilitation DESC, u.nom, u.prenom";
        
        $stmt = $this->db->query($sql);
        
        $inspecteurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $inspecteurs[] = $this->createEntity($row);
        }
        
        return $inspecteurs;
    }

    /**
     * Trouver par email (avec jointure)
     */
    public function findByEmail($email)
    {
        $sql = "SELECT u.*, i.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} i ON u.id_utilisateur = i.id_inspecteur
                WHERE u.email = :email";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createEntity($row) : null;
    }

    /**
     * Supprimer un inspecteur
     */
    public function delete($id)
    {
        try {
            $this->db->beginTransaction();
            
            $inspecteur = $this->find($id);
            if (!$inspecteur) {
                return false;
            }
            
            $userId = $inspecteur->getIdUtilisateur();
            
            // Supprimer inspecteur (utilise delete du parent)
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
            error_log("Erreur delete Inspecteur: " . $e->getMessage());
            return false;
        }
    }

    // === MÉTHODES SPÉCIFIQUES ===

    /**
     * Trouver par zone d'inspection
     */
    public function findByZone($zone)
    {
        $sql = "SELECT u.*, i.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} i ON u.id_utilisateur = i.id_inspecteur
                WHERE i.zone_inspection = :zone
                ORDER BY i.niveau_habilitation DESC, u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['zone' => $zone]);
        
        $inspecteurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $inspecteurs[] = $this->createEntity($row);
        }
        
        return $inspecteurs;
    }

    /**
     * Trouver par niveau d'habilitation
     */
    public function findByNiveau($niveau)
    {
        $sql = "SELECT u.*, i.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} i ON u.id_utilisateur = i.id_inspecteur
                WHERE i.niveau_habilitation = :niveau
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['niveau' => $niveau]);
        
        $inspecteurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $inspecteurs[] = $this->createEntity($row);
        }
        
        return $inspecteurs;
    }

    /**
     * Trouver les inspecteurs seniors (niveau 3+)
     */
    public function findSeniors()
    {
        $sql = "SELECT u.*, i.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} i ON u.id_utilisateur = i.id_inspecteur
                WHERE i.niveau_habilitation >= 3
                ORDER BY i.niveau_habilitation DESC, u.nom, u.prenom";
        
        $stmt = $this->db->query($sql);
        
        $inspecteurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $inspecteurs[] = $this->createEntity($row);
        }
        
        return $inspecteurs;
    }

    /**
     * Trouver un inspecteur disponible pour une zone
     */
    public function findDisponiblePourZone($zone, $niveauRequis = 1)
    {
        $sql = "SELECT u.*, i.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} i ON u.id_utilisateur = i.id_inspecteur
                WHERE (i.zone_inspection = :zone OR i.zone_inspection = 'National')
                AND i.niveau_habilitation >= :niveau
                AND u.statut = 'actif'
                ORDER BY i.niveau_habilitation DESC
                LIMIT 5";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'zone' => $zone,
            'niveau' => $niveauRequis
        ]);
        
        $inspecteurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $inspecteurs[] = $this->createEntity($row);
        }
        
        return $inspecteurs;
    }

    /**
     * Rechercher par nom ou zone
     */
    public function search($keyword)
    {
        $sql = "SELECT u.*, i.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} i ON u.id_utilisateur = i.id_inspecteur
                WHERE u.nom LIKE :keyword 
                   OR u.prenom LIKE :keyword
                   OR i.zone_inspection LIKE :keyword
                ORDER BY i.niveau_habilitation DESC, u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => "%{$keyword}%"]);
        
        $inspecteurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $inspecteurs[] = $this->createEntity($row);
        }
        
        return $inspecteurs;
    }

    /**
     * Compter par zone
     */
    public function countByZone()
    {
        $sql = "SELECT zone_inspection, COUNT(*) as total 
                FROM {$this->table} 
                GROUP BY zone_inspection 
                ORDER BY total DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Compter par niveau
     */
    public function countByNiveau()
    {
        $sql = "SELECT niveau_habilitation, COUNT(*) as total 
                FROM {$this->table} 
                GROUP BY niveau_habilitation 
                ORDER BY niveau_habilitation";
        
        $stmt = $this->db->query($sql);
        
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $niveau = new Inspecteur();
            $result[$niveau->getNiveauLibelle()] = $row['total'];
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
        
        // Par zone
        $stats['par_zone'] = $this->countByZone();
        
        // Par niveau
        $stats['par_niveau'] = $this->countByNiveau();
        
        // Niveau moyen
        $sql = "SELECT AVG(niveau_habilitation) FROM {$this->table}";
        $stats['niveau_moyen'] = round($this->db->query($sql)->fetchColumn(), 1);
        
        // Répartition géographique
        $sql = "SELECT zone_inspection, COUNT(*) as total 
                FROM {$this->table} 
                WHERE zone_inspection != 'National'
                GROUP BY zone_inspection";
        $stats['repartition_regionale'] = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        
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