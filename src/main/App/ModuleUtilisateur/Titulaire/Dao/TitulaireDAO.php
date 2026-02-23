<?php
namespace App\ModuleUtilisateur\Titulaire\Dao;

use App\ModuleUtilisateur\Models\Utilisateur;
use App\ModuleUtilisateur\Titulaire\Models\Titulaire;
use App\core\Config\Model;
use PDO;
use PDOException;

class TitulaireDAO extends Model
{
    // Propriétés spécifiques au DAO Tuteur
    protected $table = "titulaire";           // Table spécifique
    protected $primaryKey = "id_titulaire";    // Clé primaire spécifique
    private $userTable = "utilisateur";     // Table parent
    
    /**
     * Créer un objet Tuteur à partir d'une ligne de résultat
     */
    public function createEntity($row)
    {
        $titulaire = new Titulaire();
        return $titulaire->hydrate($row);
    }
    
    /**
     * Sauvegarder un titulaire (création ou mise à jour)
     */
    
    public function save(Titulaire $titulaire){
        try{
            //insertion utilisateur
            $stmt = $this->db->prepare("INSERT INTO utilisateur(nom, prenom, email, mot_de_passe, statut, telephone) VALUES (:nom, :prenom, :email, :mot_de_passe, :statut, :telephone)");
            $stmt->execute([
                ':nom' => $titulaire->getNom(),
                ':prenom' => $titulaire->getPrenom(),
                ':email' => $titulaire->getEmail(),
                ':mot_de_passe' => $titulaire->getMotDePasse(),
                ':statut' => $titulaire->getStatut(),
                ':telephone' => $titulaire->getTelephone()
            ]);
            // Récupération de l'ID utilisateur généré
            $idUtilisateur = $this->db->lastInsertId();
            // Mise à jour de l'objet Titulaire avec l'ID utilisateur
            $titulaire->setIdUtilisateur($idUtilisateur);
            
            // Insertion dans la table titulaire
            $stmt = $this->db->prepare("INSERT INTO titulaire(id_utilisateur, matiere_principale, volume_horaire, date_titularisation) VALUES (:id_utilisateur, :matiere_principale, :volume_horaire, :date_titularisation)");
            $stmt->execute([
                ":id_utilisateur" => $titulaire->getIdUtilisateur(),
                ":matiere_principale" => $titulaire->getMatierePrincipale(),
                ":volume_horaire" => $titulaire->getVolumeHoraire(),
                ":date_titularisation" => $titulaire->getDateTitularisation()
            ]);
            return true;
        }catch(PDOException $e){
            // En cas d'erreur, on peut faire un rollback ou gérer l'exception
            die("Erreur lors de la sauvegarde du titulaire : " . $e->getMessage());
        }
    }
    /**
     * Modifier un titulaire (mise à jour des deux tables)
     */
    public function updateTitulaire(Titulaire $titulaire){
        try{
            // verifier si l'ID de l'utilisateur existe
            $id = $titulaire->getIdTitulaire();
            if(!$this->find($id)){
                throw new \Exception("Titulaire with ID $id not found.");
            }

            // mise a jours de l'utilisateur
            $stmt = $this->db->prepare("UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, statut = :statut, telephone = :telephone WHERE id_utilisateur = :id_utilisateur");
            $stmt->execute([
                ':nom' => $titulaire->getNom(),
                ':prenom' => $titulaire->getPrenom(),
                ':email' => $titulaire->getEmail(),
                ':mot_de_passe' => $titulaire->getMotDePasse(),
                ':statut' => $titulaire->getStatut(),
                ':telephone' => $titulaire->getTelephone(),
                ':id_utilisateur' => $titulaire->getIdUtilisateur()
            ]);
            // mise a jours du titulaire
            $stmt = $this->db->prepare("UPDATE titulaire SET matiere_principale = :matiere_principale, volume_horaire = :volume_horaire, date_titularisation = :date_titularisation WHERE id_titulaire = :id_titulaire");
            $stmt->execute([
                ":matiere_principale" => $titulaire->getMatierePrincipale(),
                ":volume_horaire" => $titulaire->getVolumeHoraire(),
                ":date_titularisation" => $titulaire->getDateTitularisation(),
                ":id_titulaire" => $id
            ]);
            return true;
        }catch (\Exception $e) {
            die("Erreur: " . $e->getMessage());
        }
    }

    /**
     * Trouver un titulaire par son ID (avec jointure)
     */
    public function find($id)
    {
        $sql = "SELECT u.*, t.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} t ON u.id_utilisateur = t.id_titulaire
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
     * trouver un utilisateur par son ID
     */
    public function findWithUser($id)
    {
        $sql = "SELECT u.*, t.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} t ON u.id_utilisateur = t.id_titulaire
                WHERE t.{$this->primaryKey} = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createEntity($row) : null;
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