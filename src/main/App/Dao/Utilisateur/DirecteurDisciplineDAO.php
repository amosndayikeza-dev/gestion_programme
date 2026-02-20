<?php
namespace App\Dao\Utilisateur;

use App\Models\Utilisateur\DirecteurDiscipline;
use App\config\Model;
use PDO;

class DirecteurDisciplineDAO extends Model
{
    protected $table = "directeur_discipline";
    protected $primaryKey = "id_directeur";
    
    private $userTable = "utilisateur";


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Créer un objet DirecteurDiscipline à partir d'un tableau
     */
    public function createEntity($row)
    {
        $directeur = new DirecteurDiscipline();
        return $directeur->hydrate($row);
    }

    /**
     * Sauvegarder un directeur (création ou mise à jour)
     */
    public function save(DirecteurDiscipline $directeur)
{
    try {
        $this->db->beginTransaction();
        echo "🔍 Transaction démarrée\n";
        
        // Données utilisateur
        $userData = [
            'nom' => $directeur->getNom(),
            'prenom' => $directeur->getPrenom(),
            'email' => $directeur->getEmail(),
            'telephone' => $directeur->getTelephone(),
            'mot_de_passe' => $directeur->getMotDePasse(),
            'role' => 'directeur_discipline',
            'statut' => $directeur->getStatut(),
            'photo_profil' => $directeur->getPhotoProfil()
        ];
        echo "📦 Données utilisateur préparées\n";
        
        // Données spécifiques
        $directeurData = [
            'bureau' => $directeur->getBureau(),
            'telephone_pro' => $directeur->getTelephonePro(),
            'plages_disponibilite' => $directeur->getPlagesDisponibilite(),
            'date_debut' => $directeur->getDateDebut(),
            'date_fin' => $directeur->getDateFin()
        ];
        echo "📦 Données directeur préparées\n";

        // Cas création
        echo "   Création utilisateur...\n";
        $userId = $this->createUser($userData);
        if (!$userId) {
            throw new \Exception("Erreur création utilisateur");
        }
        echo "   ✅ Utilisateur créé ID: $userId\n";
        
        $directeurData['id_directeur'] = $userId;
        
        echo "   Création directeur...\n";
        $directeurId = $this->create($directeurData);
        if (!$directeurId) {
            throw new \Exception("Erreur création directeur");
        }
        echo "   ✅ Directeur créé ID: $directeurId\n";
        
        $directeur->setIdUtilisateur($userId);
        $directeur->setIdDirecteur($userId);
        
        $this->db->commit();
        echo "✅ COMMIT réussi\n";
        return true;
        
    } catch (\Exception $e) {
        $this->db->rollBack();
        echo "❌ EXCEPTION: " . $e->getMessage() . "\n";
        return false;
    }
}
    /**
     * Trouver un directeur par son ID
     */
    public function find($id)
    {
        $sql = "SELECT u.*, d.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} d ON u.id_utilisateur = d.id_directeur
                WHERE d.{$this->primaryKey} = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createEntity($row) : null;
    }

    /**
     * Trouver tous les directeurs
     */
    public function findAll()
    {
        $sql = "SELECT u.*, d.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} d ON u.id_utilisateur = d.id_directeur
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->query($sql);
        
        $directeurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $directeurs[] = $this->createEntity($row);
        }
        
        return $directeurs;
    }

    /**
     * Trouver les directeurs actuellement en fonction
     */
    public function findEnFonction()
    {
        $sql = "SELECT u.*, d.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} d ON u.id_utilisateur = d.id_directeur
                WHERE (d.date_fin IS NULL OR d.date_fin >= CURDATE())
                AND u.statut = 'actif'
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->query($sql);
        
        $directeurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $directeurs[] = $this->createEntity($row);
        }
        
        return $directeurs;
    }

    /**
     * Trouver un directeur par email
     */
    public function findByEmail($email)
    {
        $sql = "SELECT u.*, d.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} d ON u.id_utilisateur = d.id_directeur
                WHERE u.email = :email";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createEntity($row) : null;
    }

    /**
     * Rechercher des directeurs par critères
     */
    public function search($criteria = [])
    {   // Construire la requête de recherche dynamiquement en fonction des critères fournis
        $sql = "SELECT u.*, d.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} d ON u.id_utilisateur = d.id_directeur
                WHERE 1=1";
        
        $params = [];
        // Ajouter des conditions en fonction des critères
        if (!empty($criteria['nom'])) {
            $sql .= " AND u.nom LIKE :nom";
            $params['nom'] = '%' . $criteria['nom'] . '%';
        }
        
        // Ajouter des conditions en fonction des critères
        if (!empty($criteria['bureau'])) {
            $sql .= " AND d.bureau LIKE :bureau";
            $params['bureau'] = '%' . $criteria['bureau'] . '%';
        }
        
        if (!empty($criteria['en_fonction'])) {
            $sql .= " AND (d.date_fin IS NULL OR d.date_fin >= CURDATE())";
        }
        
        $sql .= " ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        $directeurs = [];
        // Parcourir les résultats et créer des objets DirecteurDiscipline
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $directeurs[] = $this->createEntity($row);
        }
        
        return $directeurs;
    }

    /**
     * Compter le nombre de directeurs
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        return $this->db->query($sql)->fetchColumn();
    }

    /**
     * Compter les directeurs en fonction
     */
    public function countEnFonction()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} 
                WHERE date_fin IS NULL OR date_fin >= CURDATE()";
        return $this->db->query($sql)->fetchColumn();
    }

    /**
     * Supprimer un directeur
     */
    public function delete($id)
    {
        try {
            $this->db->beginTransaction();
            
            $directeur = $this->find($id);
            if (!$directeur) {
                return false;
            }
            
            $userId = $directeur->getIdUtilisateur();
            
            // Supprimer d'abord de la table spécifique
            parent::delete($id);
            
            // Puis de la table utilisateur
            $sqlUser = "DELETE FROM {$this->userTable} WHERE id_utilisateur = ?";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute([$userId]);
            
            $this->db->commit();
            return true;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Erreur delete DirecteurDiscipline: " . $e->getMessage());
            return false;
        }
    }

    // === MÉTHODES PRIVÉES ===

    private function createUser($data)
{
    $columns = implode(',', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    
    $sql = "INSERT INTO {$this->userTable} ({$columns}) VALUES ({$placeholders})";
    $stmt = $this->db->prepare($sql);
    
    foreach ($data as $key => $value) {
        $stmt->bindValue(":{$key}", $value);
    }
    
    return $stmt->execute() ? $this->db->lastInsertId() : false;
}

    private function updateUser($id, $data)
{
    $sets = [];
    foreach (array_keys($data) as $key) {
        $sets[] = "{$key} = :{$key}";
    }
    $sets = implode(', ', $sets);
    
    $sql = "UPDATE {$this->userTable} SET {$sets} WHERE id_utilisateur = :id_utilisateur";
    $stmt = $this->db->prepare($sql);
    
    foreach ($data as $key => $value) {
        $stmt->bindValue(":{$key}", $value);
    }
    $stmt->bindValue(":id_utilisateur", $id);
    
    return $stmt->execute();
}
}

