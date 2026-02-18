<?php
namespace App\Dao\Academique;
use App\Config\Model;
use App\Models\Utilisateur\Utilisateur;
use PDO;
use PDOException;

class UtilisateurDAO extends Model {
    
    protected  $table = "utilisateur";
    protected  $primaryKy = "id_utilisateur";

    //etablir connexion a la bd
    public function __construct()
    {
        parent:: __construct();
    }

    /**
     * convertir un tableau en objet utilisateur
     */
    public function createEntity(array $data): Utilisateur {
        $utilisateur = new Utilisateur();
        $utilisateur->hydrate($data);
        return $utilisateur;
    }
    /**
     * suavegarder un utilisateur (creation ou  mise a jour)
     */
    public function save(Utilisateur $utilisateur){
        $data = [
            'nom' => $utilisateur->getNom(),
            'prenom' => $utilisateur->getPrenom(),
            'email' => $utilisateur->getEmail(),
            'mot_de_passe' => $utilisateur->getMotDePasse(),
            'role' => $utilisateur->getRole(),
            'statut' => $utilisateur->getStatut(),
            'telephone' => $utilisateur->getTelephone(),
            'photo_profil' => $utilisateur->getPhotoProfil(),
        ];
        //si c'est une mise a jours
        if($utilisateur->getIdUtilisateur()){
            return $this->update($utilisateur->getIdUtilisateur(),$data);
        }
        //SI C'EST UNE CREATION
        $id = $this->Create($data);
        if($id){
            $utilisateur->setIdUtilisateur($id);
            return true;
        }
    }
    /**
     * supprimr un utilisatuer
     */
    public function delete($id)
    {
        return parent::delete($id);
    }
    /**
     * trouver un utilisateur par son ID
     */
    public function find($id):?Utilisateur
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKy} = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->excute([$id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data){
            return $this->createEntity($data);
        }
        return null;
    }
    /** 
     * trouver un utilisateur par son email
     */
    public function fincdByEmail($email):?Utilisateur
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data){
            return $this->createEntity($data);
        }
        return null;
  
    }
    /**
     * trouver tous les utilisateurs
     */ public function fincdByRole($role):?Utilisateur
    {
        $sql = "SELECT * FROM {$this->table} WHERE role = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$role]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data){
            return $this->createEntity($data);
        }
        return null;
  
    }
    /**
     * trouver tous les utilisateurs
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'createEntity'], $data);
    }
    /**
     * changer le statut d'un utilisateur
     */
    public function changeStatut($id,$statut){
        $sql = "UPDATE {$this->table} SET statut = ? WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql); 
        return $stmt->execute([$statut,$id]);
    }
    /**
     * mettre a jours la derniere connexion d'un utilisateur
     */
    public function updateLastLogin($id){
        $sql = "UPDATE {$this->table} SET derniere_connexion = NOW() WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql); 
        return $stmt->execute([$id]);
    }
    /** 
     * compter les utilisateur par role
     */
    public function countByRole($role){
        $sql = "SELECT COUNT("*") AS total FROM {$this->table} WHERE role = ? ANS statut = 'actif";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$role]);
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $resultat['total'];
    }
    /**
     * chercher lesutilisateur par 
     */
    public function search(array $criteria = [],int $limit =20, int $offset = 0): array { 
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        
        if (!empty($criteria['role'])) {
            $sql .= " AND role = ?";
            $params[] = $criteria['role'];
        }
        
        if (!empty($criteria['statut'])) {
            $sql .= " AND statut = ?";
            $params[] = $criteria['statut'];
        }
        
        if (!empty($criteria['search'])) {
            $sql .= " AND (nom LIKE ? OR prenom LIKE ? OR email LIKE ?)";
            $searchTerm = "%{$criteria['search']}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY date_creation DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        $utilisateurs = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $utilisateurs[] = $this->createEntity($data);
        }
        
        return $utilisateurs;
    }
    /**
     * recuperer tout les utilisateur actif
     */
    public function fincdAllActive():array{
        $sql = "SELECT * FROM  {$this->table} WHERE statut = 'actif";
        $stmt = $this->db->query($sql);

        $utilisateur = [];
        while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
            $utilisateur[] = $this->createEntity($data);
        }
        return $utilisateur;
    }



}
?>