<?php
namespace App\ModuleUtilisateur\Inspecteur\Dao;

use App\ModuleUtilisateur\Models\Utilisateur;
use App\ModuleUtilisateur\Inspcteur\Models\Inspecteur;
use App\core\Config\Model;
use PDO;
use PDOException;


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
    try{
        // 1. Insertion dans utilisateur
        $stmt = $this->db->prepare("INSERT INTO utilisateur 
            (nom, prenom, email, telephone, mot_de_passe, role, statut, photo_profil, date_creation) 
            VALUES (:nom, :prenom, :email, :telephone, :mot_de_passe, :role, :statut, :photo_profil, :date_creation)");
        
        $stmt->execute([
            ':nom' => $inspecteur->getNom(),
            ':prenom' => $inspecteur->getPrenom(),
            ':email' => $inspecteur->getEmail(),
            ':telephone' => $inspecteur->getTelephone(),
            ':mot_de_passe' => $inspecteur->getMotDePasse(),
            ':role' => $inspecteur->getRole(),
            ':statut' => $inspecteur->getStatut(),
            ':photo_profil' => $inspecteur->getPhotoProfil(),
            ':date_creation' => date('Y-m-d H:i:s')
        ]);
        
        $idUtilisateur = $this->db->lastInsertId();
        
        // 2. Insertion dans inspecteur (avec la bonne colonne : id_utilisateur)
        $stmt = $this->db->prepare("INSERT INTO inspecteur 
            (id_utilisateur, zone_inspection, niveau_habilitation) 
            VALUES (:id_utilisateur, :zone_inspection, :niveau_habilitation)");
        
        $stmt->execute([
            ':id_utilisateur' => $idUtilisateur,  // ← La clé étrangère
            ':zone_inspection' => $inspecteur->getZoneInspection(),
            ':niveau_habilitation' => $inspecteur->getNiveauHabilitation()
        ]);
        
        // Optionnel : mettre à jour l'objet
        $inspecteur->setIdUtilisateur($idUtilisateur);
        
        return true;
        
    } catch (PDOException $e) {
        throw new \Exception("Erreur : " . $e->getMessage());
    }
}
    /**
     * mettre a jour l'inspecteur
     */
    public function updateInspecteur(Inspecteur $inspecteur)
    {
        try{
            // Vérifier si l'inspecteur existe
            $id = $inspecteur->getIdInspecteur();
            if (!$this->find($id)) {
                throw new \Exception("Inspecteur with ID $id not found.");
            }
            
            // Mettre à jour l'utilisateur
            $stmt = $this->db->prepare("UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, mot_de_passe = :mot_de_passe, statut = :statut, photo_profil = :photo_profil WHERE id_utilisateur = :id_utilisateur");
            $stmt->execute([
                ':nom' => $inspecteur->getNom(),
                ':prenom' => $inspecteur->getPrenom(),
                ':email' => $inspecteur->getEmail(),
                ':telephone' => $inspecteur->getTelephone(),
                ':mot_de_passe' => $inspecteur->getMotDePasse(),
                ':statut' => $inspecteur->getStatut(),
                ':photo_profil' => $inspecteur->getPhotoProfil(),
                ':id_utilisateur' => $inspecteur->getIdUtilisateur()
            ]);

            // mettre a jours l'inspecteur
            $stmt = $this->db->prepare("UPDATE inspecteur SET zone_inspection = :zone_inspection, niveau_habilitation = :niveau_habilitation WHERE id_inspecteur = :id_inspecteur");
            $stmt->execute([
                ':zone_inspection' => $inspecteur->getZoneInspection(),
                ':niveau_habilitation' => $inspecteur->getNiveauHabilitation(),
                ':id_inspecteur' => $id
            ]);
            return true;

        }catch(PDOException $e){
            throw new \Exception("Erreur lors de la mise à jour de l'inspecteur : " . $e->getMessage());
        }
    }

    // trouver l'inspectur par son ID
    public function find($id)
    {
       $result = parent::find($id);
       return $result ? $this->createEntity($result) : null;
    
    }

    //recuperer tout les inspecteurs
    public function all($columns = ['*'])
    {
        $result =  parent::all($columns);
        $inspecteurs = [];
        foreach ($result as $row) {
            $inspecteurs[] = $this->createEntity($row);
        }
        return $inspecteurs;
    }
    // supprimer un inspecteur
    public function delete($id)
    {
        return parent::delete($id);
    }
    // compter le nombre des inspecteurs
    public function count()
    {
        return parent::count();
    }

     // ============================================
     // verifier si un inspecteur existe par son email
     public function existsByEmail($email){
        return $this->find($email, "email") !== null;
     }

     // afficher un innspecteur avec les infos de l'utilisateur
     public function findWithUserInfo($id)
     {
         $sql = "SELECT u.*, i.* FROM utilisateur u JOIN inspecteur i ON u.id_utilisateur = i.id_utilisateur WHERE i.id_inspecteur = :id";
         $stmt = $this->db->prepare($sql);
         $stmt->execute([':id' => $id]);
         $result = $stmt->fetch();
         return $result ? $this->createEntity($result) : null;
     }

     // afficher tout les inspecteurs avec les infos de l'utilisateur
     public function findAllWithUserInfo()
     {
        $sql = "SELECT u.*, i.* FROM utilisateur u JOIN inspecteur i ON u.id_utilisateur = i.id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $inspecteurs = [];
        foreach ($results as $row) {
            $inspecteurs[] = $this->createEntity($row);
        }
        return $inspecteurs;

     }
     // verifier si l'email existe 
     public function emailExists($email)
     {
         $sql = "SELECT COUNT(*) FROM utilisateur WHERE email = :email";
         $stmt = $this->db->prepare($sql);
         $stmt->execute([':email' => $email]);
         return $stmt->fetchColumn() > 0;
     }
}

?>