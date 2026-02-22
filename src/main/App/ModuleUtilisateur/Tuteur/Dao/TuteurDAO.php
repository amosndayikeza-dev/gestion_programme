<?php
namespace App\Dao\Utilisateur;

use App\Models\Utilisateur\Tuteur;
use App\Config\Model;
use PDO;

class TuteurDAO extends Model
{
    // Propriétés spécifiques au DAO Tuteur
    protected $table = "tuteur";           // Table spécifique
    protected $primaryKey = "id_tuteur";    // Clé primaire spécifique
    private $userTable = "utilisateur";     // Table parent
    
    /**
     * Créer un objet Tuteur à partir d'une ligne de résultat
     */
    public function createEntity($row)
    {
        $tuteur = new Tuteur();
        return $tuteur->hydrate($row);
    }
    
    /**
     * Sauvegarder un tuteur (création ou mise à jour)
     */
    public function save(Tuteur $tuteur)
    {
        try {
            $this->db->beginTransaction();
            
            // Préparer les données
            $userData = [
                'nom' => $tuteur->getNom(),
                'prenom' => $tuteur->getPrenom(),
                'email' => $tuteur->getEmail(),
                'telephone' => $tuteur->getTelephone(),
                'mot_de_passe' => $tuteur->getMotDePasse(),
                'role' => 'parent',
                'statut' => $tuteur->getStatut() ?? 'actif',
                'photo_profil' => $tuteur->getPhotoProfil(),
                'date_creation' => $tuteur->getDateCreation() ?? date('Y-m-d H:i:s')
            ];
            
            $tuteurData = [
                'profession' => $tuteur->getProfession(),
                'adresse' => $tuteur->getAdresse(),
                'lien_parental' => $tuteur->getLienParental(),
                'piece_identite' => $tuteur->getPieceIdentite()
            ];
            
            // CAS MISE À JOUR
            if ($tuteur->getIdTuteur()) {
                // Mettre à jour utilisateur (requête manuelle car pas dans Model)
                $this->updateUser($tuteur->getIdUtilisateur(), $userData);
                
                // Mettre à jour tuteur (utilise la méthode update du parent)
                $this->update($tuteur->getIdTuteur(), $tuteurData);
                
                $this->db->commit();
                return true;
            }
            
            // CAS CRÉATION
            // 1. Créer l'utilisateur d'abord
            $userId = $this->createUser($userData);
            if (!$userId) {
                throw new \Exception("Erreur création utilisateur");
            }
            
            // 2. Ajouter l'id_utilisateur aux données tuteur
            $tuteurData['id_tuteur'] = $userId;
            
            // 3. Créer le tuteur (utilise la méthode create du parent)
            $tuteurId = $this->create($tuteurData);
            if (!$tuteurId) {
                throw new \Exception("Erreur création tuteur");
            }
            
            // 4. Mettre à jour l'objet avec les IDs
            $tuteur->setIdUtilisateur($userId);
            $tuteur->setIdTuteur($userId);
            
            $this->db->commit();
            return true;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Erreur save Tuteur: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Trouver un tuteur par son ID (avec jointure)
     */
    public function find($id)
    {
        $sql = "SELECT u.*, t.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} t ON u.id_utilisateur = t.id_tuteur
                WHERE t.{$this->primaryKey} = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createEntity($row) : null;
    }
    
    /**
     * Trouver tous les tuteurs (avec jointure)
     */
    public function all($columns = ['*'])
    {
        // On ignore $columns car on fait une jointure
        $sql = "SELECT u.*, t.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} t ON u.id_utilisateur = t.id_tuteur
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->query($sql);
        
        $tuteurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tuteurs[] = $this->createEntity($row);
        }
        
        return $tuteurs;
    }
    
    /**
     * Trouver un tuteur par email (avec jointure)
     */
    public function findByEmail($email)
    {
        $sql = "SELECT u.*, t.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} t ON u.id_utilisateur = t.id_tuteur
                WHERE u.email = :email";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createEntity($row) : null;
    }
    
    /**
     * Supprimer un tuteur (des deux tables)
     */
    public function delete($id)
    {
        try {
            $this->db->beginTransaction();
            
            // Récupérer le tuteur pour avoir l'id_utilisateur
            $tuteur = $this->find($id);
            if (!$tuteur) {
                return false;
            }
            
            $userId = $tuteur->getIdUtilisateur();
            
            // Supprimer d'abord de la table tuteur (utilise la méthode delete du parent)
            $result = parent::delete($id);
            
            // Puis supprimer de la table utilisateur (requête manuelle)
            if ($result) {
                $sqlUser = "DELETE FROM {$this->userTable} WHERE id_utilisateur = ?";
                $stmtUser = $this->db->prepare($sqlUser);
                $result = $stmtUser->execute([$userId]);
            }
            
            $this->db->commit();
            return $result;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Erreur delete Tuteur: " . $e->getMessage());
            return false;
        }
    }
    
    // === MÉTHODES SPÉCIFIQUES À TUTEUR ===
    
    /**
     * Trouver les tuteurs par lien parental
     */
    public function findByLienParental($lien)
    {
        $sql = "SELECT u.*, t.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} t ON u.id_utilisateur = t.id_tuteur
                WHERE t.lien_parental = :lien
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['lien' => $lien]);
        
        $tuteurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tuteurs[] = $this->createEntity($row);
        }
        
        return $tuteurs;
    }
    
    /**
     * Rechercher des tuteurs par nom ou prénom
     */
    public function search($keyword)
    {
        $sql = "SELECT u.*, t.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} t ON u.id_utilisateur = t.id_tuteur
                WHERE u.nom LIKE :keyword OR u.prenom LIKE :keyword
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => "%{$keyword}%"]);
        
        $tuteurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tuteurs[] = $this->createEntity($row);
        }
        
        return $tuteurs;
    }
    
    /**
     * Compter le nombre de tuteurs
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        return $this->db->query($sql)->fetchColumn();
    }
    
    /**
     * Vérifier si un email existe déjà
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
    
    // === MÉTHODES PRIVÉES POUR LA TABLE UTILISATEUR ===
    
    /**
     * Créer un utilisateur
     */
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
    
    /**
     * Mettre à jour un utilisateur
     */
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