<?php
namespace App\ModuleUtilisateur\Admin\Dao;

use App\ModuleUtilisateur\Models\Admin\Administrateur;
use App\core\Config\Model;
use PDO;
use Exception;

class AdminDAO extends Model
{
    protected $table = "administrateurs";
    protected $primaryKey = "id_administrateur";


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Sauvegarder un admin (création ou mise à jour)
     */
    public function save($administrateur)
    {
        try {
            // 1. D'abord insérer dans utilisateurs
            $sqlUser = "INSERT INTO utilisateur (
                nom, prenom, email, mot_de_passe, role, statut, 
                telephone, date_creation, photo_profil
            ) VALUES (
                :nom, :prenom, :email, :mot_de_passe, :role, :statut,
                :telephone, :date_creation, :photo_profil
            )";
            
            $stmtUser = $this->db->prepare($sqlUser);
            $resultUser = $stmtUser->execute([
                ':nom' => $administrateur->getNom(),
                ':prenom' => $administrateur->getPrenom(),
                ':email' => $administrateur->getEmail(),
                ':mot_de_passe' => $administrateur->getMotDePasse(),
                ':role' => $administrateur->getRole(),
                ':statut' => $administrateur->getStatut(),
                ':telephone' => $administrateur->getTelephone(),
                ':date_creation' => date('Y-m-d H:i:s'),
                ':photo_profil' => $administrateur->getPhotoProfil()
            ]);
            
            if (!$resultUser) {
                return false;
            }
            
            // Récupérer l'ID généré
            $idUtilisateur = $this->db->lastInsertId();
            $administrateur->setIdUtilisateur($idUtilisateur);
            $administrateur->setIdAdministrateur($idUtilisateur);
            
            // 2. Ensuite insérer dans administrateurs
            $sqlAdmin = "INSERT INTO administrateurs (
                id_administrateur, niveau_acces, departement, 
                date_prise_fonction, date_fin_fonction, permissions_speciales,
                dernier_audit, adresse_ip_autorisees, authentification_2facteurs,
                cle_2fa, niveau_audit, zone_intervention, superviseur
            ) VALUES (
                :id_administrateur, :niveau_acces, :departement,
                :date_prise_fonction, :date_fin_fonction, :permissions_speciales,
                :dernier_audit, :adresse_ip_autorisees, :authentification_2facteurs,
                :cle_2fa, :niveau_audit, :zone_intervention, :superviseur
            )";
            
            $stmtAdmin = $this->db->prepare($sqlAdmin);
            $resultAdmin = $stmtAdmin->execute([
                ':id_administrateur' => $idUtilisateur,
                ':niveau_acces' => $administrateur->getNiveauAcces(),
                ':departement' => $administrateur->getDepartement(),
                ':date_prise_fonction' => $administrateur->getDatePriseFonction(),
                ':date_fin_fonction' => $administrateur->getDateFinFonction(),
                ':permissions_speciales' => $administrateur->getPermissionsSpeciales(),
                ':dernier_audit' => $administrateur->getDernierAudit(),
                ':adresse_ip_autorisees' => $administrateur->getAdresseIpAutorisees(),
                ':authentification_2facteurs' => $administrateur->getAuthentification2Facteurs() ? 1 : 0,
                ':cle_2fa' => $administrateur->getCle2FA(),
                ':niveau_audit' => $administrateur->getNiveauAudit(),
                ':zone_intervention' => $administrateur->getZoneIntervention(),
                ':superviseur' => $administrateur->getSuperviseur()
            ]);
            
            return $resultAdmin;
            
        } catch (Exception $e) {
            // Log l'erreur
            error_log("Erreur save admin: " . $e->getMessage());
            return false;
        }
    }
    /**
     * Mettre à jour un administrateur existant
     */
    public function update($administrateur)
    {
        try {
            $id = $administrateur->getIdUtilisateur();
            
            if (!$id) {
                return false; // Pas d'ID = pas de mise à jour
            }
            
            // 1. Mettre à jour utilisateurs
            $sqlUser = "UPDATE utilisateur SET
                nom = :nom,
                prenom = :prenom,
                email = :email,
                telephone = :telephone,
                statut = :statut,
                photo_profil = :photo_profil
                WHERE id_utilisateur = :id";
            
            $stmtUser = $this->db->prepare($sqlUser);
            $resultUser = $stmtUser->execute([
                ':nom' => $administrateur->getNom(),
                ':prenom' => $administrateur->getPrenom(),
                ':email' => $administrateur->getEmail(),
                ':telephone' => $administrateur->getTelephone(),
                ':statut' => $administrateur->getStatut(),
                ':photo_profil' => $administrateur->getPhotoProfil(),
                ':id' => $id
            ]);
            
            if (!$resultUser) {
                return false;
            }
            
            // 2. Mettre à jour administrateurs
            $sqlAdmin = "UPDATE administrateurs SET
                niveau_acces = :niveau_acces,
                departement = :departement,
                date_prise_fonction = :date_prise_fonction,
                date_fin_fonction = :date_fin_fonction,
                permissions_speciales = :permissions_speciales,
                dernier_audit = :dernier_audit,
                adresse_ip_autorisees = :adresse_ip_autorisees,
                authentification_2facteurs = :authentification_2facteurs,
                cle_2fa = :cle_2fa,
                niveau_audit = :niveau_audit,
                zone_intervention = :zone_intervention,
                superviseur = :superviseur
                WHERE id_administrateur = :id";
            
            $stmtAdmin = $this->db->prepare($sqlAdmin);
            $resultAdmin = $stmtAdmin->execute([
                ':id' => $id,
                ':niveau_acces' => $administrateur->getNiveauAcces(),
                ':departement' => $administrateur->getDepartement(),
                ':date_prise_fonction' => $administrateur->getDatePriseFonction(),
                ':date_fin_fonction' => $administrateur->getDateFinFonction(),
                ':permissions_speciales' => $administrateur->getPermissionsSpeciales(),
                ':dernier_audit' => $administrateur->getDernierAudit(),
                ':adresse_ip_autorisees' => $administrateur->getAdresseIpAutorisees(),
                ':authentification_2facteurs' => $administrateur->getAuthentification2Facteurs() ? 1 : 0,
                ':cle_2fa' => $administrateur->getCle2FA(),
                ':niveau_audit' => $administrateur->getNiveauAudit(),
                ':zone_intervention' => $administrateur->getZoneIntervention(),
                ':superviseur' => $administrateur->getSuperviseur()
            ]);
            
            return $resultAdmin;
            
        } catch (Exception $e) {
            error_log("Erreur update admin: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Trouver un admin avec ses infos utilisateur
     */
    public function findWithUser($id)
    {
        $sql = "SELECT u.*, a.* 
                FROM utilisateur u
                LEFT JOIN administrateurs a ON u.id_utilisateur = a.id_administrateur
                WHERE u.id_utilisateur = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Convertir un tableau en objet
     */
    public function createEntity(array $data)
    {
        $administrateur = new Administrateur();
        return $administrateur->hydrate($data);
    }

    
    // ============================================
    // MÉTHODES SIMPLES (qui utilisent le parent)
    // ============================================
    
    /**
     * Trouver un administrateur par son ID (table administrateurs seulement)
     */
    public function find($id)
    {
        $resultat = parent::find($id);
        
        // Si rien trouvé
        if (!$resultat) {
            return null;
        }
        
        // Convertir en objet Administrateur
        return $this->createEntity($resultat);
    }

    /**
     * Récupérer tous les administrateurs (table administrateurs seulement)
     */
     /**
     * Récupérer tous les admins AVEC leurs infos utilisateur
     */
    public function all($columns = ['*'])
    {
        // Requête avec JOINTURE pour avoir les deux tables
        $sql = "SELECT u.*, a.* 
                FROM utilisateur u
                INNER JOIN administrateurs a ON u.id_utilisateur = a.id_administrateur
                WHERE u.role = 'administrateur'
                ORDER BY u.nom, u.prenom";
        
        $stmt = $this->db->query($sql);
        $admins = [];
        
        while ($data = $stmt->fetch()) {
            $admins[] = $this->createEntity($data);
        }
        
        return $admins;
    }
    /**
     * selectionner seulement les elemenents de la table administrateurs
     */
    public function AllAdmin($columns = ['*'])
        {
            $resultats = parent::all($columns);
            $admins = [];
            
            foreach ($resultats as $data) {
                $admins[] = $this->createEntity($data);
            }
            
            return $admins;
        }

    /**
     * Supprimer un administrateur par ID
     */
    public function delete($id)
    {
        return parent::delete($id);
    }

    /**
     * Compter le nombre d'administrateurs
     */
    public function count()
    {
        return parent::count();
    }

    /**
     * Compter avec condition WHERE
     */
    public function countWhere($condition, $params = [])
    {
        return parent::countWhere($condition, $params);
    }

    /**
     * Vérifier si un administrateur existe
     */
    public function exists($id)
    {
        return $this->find($id) !== null;
    }

    

}