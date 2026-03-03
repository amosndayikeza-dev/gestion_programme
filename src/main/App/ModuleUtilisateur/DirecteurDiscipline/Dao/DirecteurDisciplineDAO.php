<?php

namespace App\ModuleUtilisateur\DirecteurDiscipline\Dao;
use App\ModuleUtilisateur\DirecteurDiscipline\Models\DirecteurDiscipline;
use App\core\config\Model;
use PDO;
use Exception;
use PDOException;

class DirecteurDisciplineDAO extends Model
{
    protected $table = "directeur_discipline";
    protected $primaryKey = "id_directeur";
    
    private $userTable = "utilisateur";


    public function __construct()
    {
        parent::__construct();
    }

    public function createEntity($row)
    {
        $directeur = new DirecteurDiscipline();
        return $directeur->hydrate($row);
    }

    public function save($directeur)
{
    $this->db->beginTransaction();
    try {
        // 1. INSÉRER DANS UTILISATEUR D'ABORD !
        $sqlUser = "INSERT INTO utilisateur (
            nom, prenom, email, mot_de_passe, role, statut, telephone, date_creation
        ) VALUES (
            :nom, :prenom, :email, :mot_de_passe, :role, :statut, :telephone, :date_creation
        )";
        
        $stmtUser = $this->db->prepare($sqlUser);
        $resultUser = $stmtUser->execute([
            ':nom' => $directeur->getNom(),
            ':prenom' => $directeur->getPrenom(),
            ':email' => $directeur->getEmail(),
            ':mot_de_passe' => $directeur->getMotDePasse(),
            ':role' => 'directeur_discipline',  // Important !
            ':statut' => $directeur->getStatut(),
            ':telephone' => $directeur->getTelephone(),
            ':date_creation' => date('Y-m-d H:i:s')
        ]);
        
        if (!$resultUser) {
            $this->db->rollBack();
            return false;
        }
        
        // Récupérer l'ID généré
        $idUtilisateur = $this->db->lastInsertId();
        $directeur->setIdUtilisateur($idUtilisateur);
        
        // 2. MAINTENANT insérer dans directeur_discipline
        $sqlDir = "INSERT INTO directeur_discipline (
                id_directeur, bureau, telephone_pro, plages_disponibilite,
                date_debut, date_fin
            ) VALUES (
                :id_directeur, :bureau, :telephone_pro, :plages_disponibilite,
                :date_debut, :date_fin
            )";
            
            $stmtDir = $this->db->prepare($sqlDir);
            $resultDir = $stmtDir->execute([
                ':id_directeur' => $idUtilisateur,
                ':bureau' => $directeur->getBureau(),
                ':telephone_pro' => $directeur->getTelephonePro(),
                ':plages_disponibilite' => $directeur->getPlagesDisponibilite(),
                ':date_debut' => $directeur->getDateDebut() ?: date('Y-m-d'), // Obligatoire !
                ':date_fin' => $directeur->getDateFin()
            ]);

            if (!$resultDir) {
                $this->db->rollBack();
                return false;
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Erreur save directeur: " . $e->getMessage());
            return false;
        }
    }
 
    public function update(DirecteurDiscipline $directeur)
    {
        try {
            $id = $directeur->getIdUtilisateur();
            
            if (!$id) {
                throw new \Exception("ID utilisateur manquant pour la mise à jour");
            }
            
            // 1. Mettre à jour la table utilisateur
            $stmt = $this->db->prepare("UPDATE utilisateur SET
                nom = ?,
                prenom = ?,
                email = ?,
                telephone = ?,
                mot_de_passe = ?,
                statut = ?
                WHERE id_utilisateur = ?");
            
            $stmt->execute([
                $directeur->getNom(),
                $directeur->getPrenom(),
                $directeur->getEmail(),
                $directeur->getTelephone(),
                $directeur->getMotDePasse(),
                $directeur->getStatut(),
                $id
            ]);
            
            // 2. Mettre à jour la table directeur_discipline
            $stmt = $this->db->prepare("UPDATE directeur_discipline SET
                bureau = ?,
                telephone_pro = ?,
                plages_disponibilite = ?,
                date_debut = ?,
                date_fin = ?
                WHERE id_directeur = ?");
            
            $stmt->execute([
                $directeur->getBureau(),
                $directeur->getTelephonePro(),
                $directeur->getPlagesDisponibilite() ?: '{}',
                $directeur->getDateDebut() ?: date('Y-m-d'),
                $directeur->getDateFin(),
                $id
            ]);
            
            return true;
            
        } catch (PDOException $e) {
            die("Erreur update: " . $e->getMessage());
        }
    }

    public function find($id)
    {
        $resultat = parent::find($id);
        return $resultat ? $this->createEntity($resultat) : null;
    }

   
    public function all($columns = ['*'])
    {
        $resultats = parent::all($columns);
        $directeurs = [];
        
        foreach ($resultats as $data) {
            $directeurs[] = $this->createEntity($data);
        }
        
        return $directeurs;
    }

    public function delete($id)
    {
        return parent::delete($id);
    }

    public function count()
    {
        return parent::count();
    }


    public function exists($id)
    {
        return $this->find($id) !== null;
    }

    
public function findWithUser($id)
{
    $sql = "SELECT u.*, d.* 
            FROM utilisateur u
            INNER JOIN directeur_discipline d ON u.id_utilisateur = d.id_directeur
            WHERE u.id_utilisateur = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    
    return $data ? $this->createEntity($data) : null;
}

public function findAllWithUser()
{
    $sql = "SELECT u.*, d.* 
            FROM utilisateur u
            INNER JOIN directeur_discipline d ON u.id_utilisateur = d.id_directeur
            WHERE u.role = 'directeur_discipline'
            ORDER BY u.nom, u.prenom";
    
    $stmt = $this->db->query($sql);
    $directeurs = [];
    
    while ($data = $stmt->fetch()) {
        $directeurs[] = $this->createEntity($data);
    }
    
    return $directeurs;
}
    public function findByEmail($email)
    {
        $sql = "SELECT u.*, d.* 
                FROM utilisateur u
                LEFT JOIN directeur_discipline d ON u.id_utilisateur = d.id_utilisateur
                WHERE u.email = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetch();
        
        return $data ? $this->createEntity($data) : null;
    }


    public function findByBureau($bureau)
    {
        $sql = "SELECT u.*, d.* 
                FROM utilisateur u
                INNER JOIN directeur_discipline d ON u.id_utilisateur = d.id_utilisateur
                WHERE d.bureau = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bureau]);
        $directeurs = [];
        
        while ($data = $stmt->fetch()) {
            $directeurs[] = $this->createEntity($data);
        }
        
        return $directeurs;
    }

 
    public function emailExists($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM utilisateur WHERE email = ?";
        $params = [$email];
        
        if ($excludeId) {
            $sql .= " AND id_utilisateur != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchColumn() > 0;
    }

    public function countByStatut($statut)
    {
        $sql = "SELECT COUNT(*) FROM utilisateur u
                INNER JOIN directeur_discipline d ON u.id_utilisateur = d.id_utilisateur
                WHERE u.statut = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$statut]);
        
        return (int) $stmt->fetchColumn();
    }

    public function findActifs()
    {
        return $this->findByStatut('actif');
    }

    public function findInactifs()
    {
        return $this->findByStatut('inactif');
    }

    private function findByStatut($statut)
    {
        $sql = "SELECT u.*, d.* 
                FROM utilisateur u
                INNER JOIN directeur_discipline d ON u.id_utilisateur = d.id_utilisateur
                WHERE u.statut = ?
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$statut]);
        $directeurs = [];
        
        while ($data = $stmt->fetch()) {
            $directeurs[] = $this->createEntity($data);
        }
        
        return $directeurs;
    }

    public function getLastId()
    {
        $sql = "SELECT MAX(id_utilisateur) FROM utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    } 
    public function setDateFin($id, $dateFin)
    {
        $sql = "UPDATE directeur_discipline SET date_fin = ? WHERE id_directeur = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$dateFin, $id]);
    }
    public function setDateDebut($id, $dateDebut)
    {
        $sql = "UPDATE directeur_discipline SET date_debut = ? WHERE id_directeur = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$dateDebut, $id]);
    }
    public function setPlageDisponibilite($id, $plageDisponibilite)
    {
        $sql = "UPDATE directeur_discipline SET plages_disponibilite = ? WHERE id_directeur = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$plageDisponibilite, $id]);
    }

}

