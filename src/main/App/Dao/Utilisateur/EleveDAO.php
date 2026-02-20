<?php
namespace App\Dao\Utilisateur;

use App\Models\Utilisateur\Eleve;
use App\Config\Model;
use PDO;

class EleveDAO extends Model
{
    protected $table = "eleve";
    protected $primaryKey = "id_eleve";
    private $userTable = "utilisateur";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Créer un objet Eleve à partir d'un tableau (avec jointure)
     */
    public function createEntity($row)
    {
        $eleve = new Eleve();
        return $eleve->hydrate($row);
    }

    /**
     * Sauvegarder un élève (dans les 2 tables)
     */
    public function save(Eleve $eleve)
    {
        try {
            $this->db->beginTransaction();
            
            // === 1. PRÉPARER LES DONNÉES ===
            // Données pour la table utilisateur
            $userData = [
                'nom' => $eleve->getNom(),
                'prenom' => $eleve->getPrenom(),
                'email' => $eleve->getEmail(),
                'telephone' => $eleve->getTelephone(),
                'mot_de_passe' => $eleve->getMotDePasse(),
                'role' => 'eleve',
                'statut' => $eleve->getStatut(),
                'photo_profil' => $eleve->getPhotoProfil(),
                'date_creation' => date('Y-m-d H:i:s')
            ];
            
            // Données pour la table eleve
            $eleveData = [
                'matricule' => $eleve->getMatricule(),
                'date_naissance' => $eleve->getDateNaissance(),
                'lieu_naissance' => $eleve->getLieuNaissance(),
                'sexe' => $eleve->getSexe(),
                'adresse' => $eleve->getAdresse(),
                'id_classe_actuelle' => $eleve->getIdClasse(),
                'id_tuteur' => $eleve->getIdTuteur(),
                'date_inscription' => $eleve->getDateInscription() ?? date('Y-m-d H:i:s')
            ];

            // === 2. CAS MISE À JOUR ===
            if ($eleve->getIdEleve()) {
                // Mettre à jour utilisateur
                $this->updateUser($eleve->getIdUtilisateur(), $userData);
                
                // Mettre à jour élève
                $this->update($eleve->getIdEleve(), $eleveData);
                
                $this->db->commit();
                return true;
            }

            // === 3. CAS CRÉATION ===
            // Créer l'utilisateur d'abord
            $userId = $this->createUser($userData);
            if (!$userId) {
                throw new \Exception("Erreur création utilisateur");
            }
            
            // Ajouter l'id_utilisateur aux données élève
            $eleveData['id_utilisateur'] = $userId;
            
            // Créer l'élève
            $eleveId = $this->create($eleveData);
            if (!$eleveId) {
                throw new \Exception("Erreur création élève");
            }
            
            // Générer matricule si nécessaire
            if (empty($eleve->getMatricule())) {
                $matricule = $this->genererMatricule($eleveId);
                $this->update($eleveId, ['matricule' => $matricule]);
                $eleve->setMatricule($matricule);
            }
            
            // Mettre à jour l'objet avec les IDs
            $eleve->setIdUtilisateur($userId);
            $eleve->setIdEleve($eleveId);
            
            $this->db->commit();
            return true;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Erreur save Eleve: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Trouver un élève par son ID (avec jointure)
     */
    public function find($id)
    {
        $sql = "SELECT u.*, e.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} e ON u.id_utilisateur = e.id_utilisateur
                WHERE e.{$this->primaryKey} = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createEntity($row) : null;
    }

    /**
     * Trouver tous les élèves
     */
    public function findAll()
    {
        $sql = "SELECT u.*, e.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} e ON u.id_utilisateur = e.id_utilisateur
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->query($sql);
        
        $eleves = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eleves[] = $this->createEntity($row);
        }
        
        return $eleves;
    }

    /**
     * Trouver un élève par email
     */
    public function findByEmail($email)
    {
        $sql = "SELECT u.*, e.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} e ON u.id_utilisateur = e.id_utilisateur
                WHERE u.email = :email";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $this->createEntity($row) : null;
    }

    /**
     * Trouver les élèves par classe
     */
    public function findByClasse($classeId)
    {
        $sql = "SELECT u.*, e.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} e ON u.id_utilisateur = e.id_utilisateur
                WHERE e.id_classe_actuelle = :classe_id
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['classe_id' => $classeId]);
        
        $eleves = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eleves[] = $this->createEntity($row);
        }
        
        return $eleves;
    }

    /**
     * Trouver les élèves par tuteur
     */
    public function findByTuteur($tuteurId)
    {
        $sql = "SELECT u.*, e.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} e ON u.id_utilisateur = e.id_utilisateur
                WHERE e.id_tuteur = :tuteur_id
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['tuteur_id' => $tuteurId]);
        
        $eleves = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eleves[] = $this->createEntity($row);
        }
        
        return $eleves;
    }

    /**
     * Rechercher des élèves par mot-clé
     */
    public function search($keyword)
    {
        $sql = "SELECT u.*, e.* 
                FROM {$this->userTable} u
                INNER JOIN {$this->table} e ON u.id_utilisateur = e.id_utilisateur
                WHERE u.nom LIKE :keyword OR u.prenom LIKE :keyword
                ORDER BY u.nom, u.prenom";
        
        $keyword = "%{$keyword}%";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => $keyword]);
        
        $eleves = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eleves[] = $this->createEntity($row);
        }
        
        return $eleves;
    }

    /**
     * Compter les élèves actifs
     */
    public function countActiveEleve()
    {
        $sql = "SELECT COUNT(*) FROM {$this->userTable} WHERE role = 'eleve' AND statut = 'actif'";
        return $this->db->query($sql)->fetchColumn();
    }

    /**
     * Supprimer un élève (des 2 tables)
     */
    public function delete($id)
    {
        try {
            $this->db->beginTransaction();
            
            $eleve = $this->find($id);
            if (!$eleve) {
                return false;
            }
            
            $userId = $eleve->getIdUtilisateur();
            
            // Supprimer l'élève d'abord
            parent::delete($id);
            
            // Supprimer l'utilisateur
            $sqlUser = "DELETE FROM {$this->userTable} WHERE id_utilisateur = ?";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute([$userId]);
            
            $this->db->commit();
            return true;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
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

    private function genererMatricule($id)
    {
        $annee = date('Y');
        $prefixe = 'EL';
        $numero = str_pad($id, 4, '0', STR_PAD_LEFT);
        
        return $prefixe . $annee . $numero;
    }
}