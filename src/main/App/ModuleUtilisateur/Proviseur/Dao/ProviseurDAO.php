<?php
namespace App\ModuleUtilisateur\Proviseur\Dao;

use App\ModuleUtilisateur\Proviseur\Models\Proviseur;
use App\core\Config\Model;
use PDO;
use PDOException;   

class ProviseurDAO extends Model
{
    protected $table = "proviseur";
    protected $primaryKey = "id_proviseur";

    public function __construct()
    {
        parent::__construct();
    }
    // creer un objet proviseur a partir d'un tableau
    public function createEntity($row){
        $proviseur = new Proviseur();
        return $proviseur->hydrate($row);
    }   

    // sauvegarder un proviseur (dans les 2 tables)

    public function save(Proviseur $proviseur)
{
    try {
        // 1. Vérifier que l'objet a les données requises
        if (empty($proviseur->getNom()) || empty($proviseur->getEmail())) {
            throw new \Exception("Données utilisateur manquantes");
        }
        
        // 2. Insertion utilisateur - REQUÊTE SIMPLIFIÉE
        $sql = "INSERT INTO utilisateur 
                (nom, prenom, email, mot_de_passe, role, statut, date_creation) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $proviseur->getNom(),
            $proviseur->getPrenom(),
            $proviseur->getEmail(),
            $proviseur->getMotDePasse(),
            'proviseur',
            $proviseur->getStatut()
        ]);
        
        // 3. VÉRIFICATION OBLIGATOIRE
        if (!$result) {
            $error = $stmt->errorInfo();
            throw new \Exception("ÉCHEC INSERT USER: " . $error[2]);
        }
        
        $userId = $this->db->lastInsertId();
        
        if (!$userId || $userId == 0) {
            throw new \Exception("ID USER INVALIDE: " . $userId);
        }
        
        // 4. ICI on est SÛR que l'utilisateur existe
        echo "✅ ID utilisateur créé: " . $userId . "<br>";
        
        // 5. Insertion proviseur
        $sql = "INSERT INTO proviseur 
                (id_proviseur, etablissement, duree_mandat, bureau, id_utilisateur) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $userId,
            $proviseur->getEtablissement(),
            $proviseur->getDureeMandat(),
            $proviseur->getBureau(),
            $userId
        ]);
        
        if (!$result) {
            $error = $stmt->errorInfo();
            throw new \Exception("ÉCHEC INSERT PROVISEUR: " . $error[2]);
        }
        
        return true;
        
    } catch (\Exception $e) {
        // Afficher l'erreur pour la voir dans le test
        echo "❌ " . $e->getMessage() . "<br>";
        error_log("Erreur: " . $e->getMessage());
        return false;
    }
}

    //modifier un proviseur
    public function updateProviseur(Proviseur $proviseur){  
        try{
            $id = $proviseur->getIdProviseur();
            if(!$this->find($id)){
                throw new \Exception("Proviseur with ID $id not found.");
            }
            // Mise à jour de l'utilisateur
            $stmt = $this->db->prepare("UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, statut = :statut, telephone = :telephone WHERE id_utilisateur = :id_utilisateur");
            $stmt->execute([
                ':nom' => $proviseur->getNom(),
                ':prenom' => $proviseur->getPrenom(),
                ':email' => $proviseur->getEmail(),
                ':mot_de_passe' => $proviseur->getMotDePasse(),
                ':statut' => $proviseur->getStatut(),
                ':telephone' => $proviseur->getTelephone(),
                ':id_utilisateur' => $proviseur->getIdUtilisateur()
            ]);
            // Mise à jour de la table proviseur
            $stmt = "UPDATE proviseur SET etablissement = :etablissement, bureau = :bureau WHERE id_utilisateur = :id_utilisateur";
            $stmt = $this->db->prepare($stmt);
            $stmt->execute([
                ':etablissement' => $proviseur->getEtablissement(),
                ':bureau' => $proviseur->getBureau(),
                ':id_utilisateur' => $proviseur->getIdUtilisateur()
             ]);

        }catch(PDOException $e){
            echo "Error updating proviseur: " . $e->getMessage();
        }catch(\Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    // trouver proviseur par ID
    public function find($id)
    {
        $result =  parent::find($id);
        if(! $result){
            return null;
        }
        return $this->createEntity($result);
    }

    // afficher tout les proviseur avec les infos de l'utilisateur
    public function all($columns = ['*'])
    {
        //requette avec jointure pour avoir les deux tables
        $sql = "SELECT u.*,p.* FROM utilisateur u INNER JOIN proviseur ON u.id_utilisateur = p.id_proviseur WHERE U.role = 'proviseur'";
        $stmt = $this->db->query($sql);

        $proviseur = [];

        while($data = $stmt->fetch()){
            $proviseur[] = $this->createEntity($data);
        }
        return $proviseur;
    }

    // selectionner seulement les elements de la table proviseur
    public function AllProviseur($columns = ['*'])
    {
        $resultats = parent::all($columns);
        $proviseur = [];

        foreach ($resultats as $data) {
        $proviseur[] = $this->createEntity($data);
        }

        return $proviseur;
    }
    // supprimer un proviseur par son ID    
    public function delete($id)
    {
        return parent::delete($id);
    }
    // compter le nombre des proviseurs
    public function count()
    {
        return parent::count();
    }
    // compter avec la condition 
    public function countWhere($condition,$param = [] ){
        return parent::countWhere($condition,$param);
    }
    // verifier si un proviseur existe
    public function exists($id){
        return $this->find($id) !== null;
    }



}
















?>