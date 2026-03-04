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
   public function createEntity($row) {
    $proviseur = new Proviseur();
    
    // Hydrate avec TOUTES les données
    if (isset($row['id_utilisateur'])) {
        $proviseur->setIdUtilisateur($row['id_utilisateur']);
    }
    if (isset($row['id_proviseur'])) {
        $proviseur->setIdProviseur($row['id_proviseur']);
    }
    
    // Appel à hydrate pour le reste
    return $proviseur->hydrate($row);
 }  

    // sauvegarder un proviseur (dans les 2 tables)


    public function save(Proviseur $proviseur)
   {
    $this->db->beginTransaction();
    try {
        // 1. Vérifier que l'objet a les données requises
        if (empty($proviseur->getNom()) || empty($proviseur->getEmail())) {
            throw new \Exception("Données utilisateur manquantes");
        }
        
        // 2. Insertion utilisateur - REQUÊTE SIMPLIFIÉE
        $sql = "INSERT INTO utilisateur 
                (nom, prenom, email, mot_de_passe, role, statut, telephone,date_creation) 
                VALUES (:nom, :prenom, :email, :mot_de_passe, :role, :statut, :telephone, NOW())";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':nom' => $proviseur->getNom(),
            ':prenom' => $proviseur->getPrenom(),
            ':email' => $proviseur->getEmail(),
            ':mot_de_passe' => $proviseur->getMotDePasse(),
            ':role' => 'proviseur',
            ':statut' => $proviseur->getStatut(),
            ":telephone" => $proviseur->getTelephone()
        ]);
        
        // 3. VÉRIFICATION OBLIGATOIRE
        if (!$result) {
            $error = $stmt->errorInfo();
            throw new \Exception("ÉCHEC INSERT USER: " . $error[2]);
        }
        
        $userId = $this->db->lastInsertId();
        $proviseur->setIdUtilisateur($userId);
        
       
        // 5. Insertion proviseur
        $sql = "INSERT INTO proviseur 
                ( id_proviseur, etablissement, duree_mandat, bureau) 
                VALUES (:id_utilisateur, :etablissement, :duree_mandat, :bureau)";

        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':id_utilisateur' => $userId,
            ':etablissement' => $proviseur->getEtablissement(),
            ':duree_mandat' => $proviseur->getDureeMandat(),
            ':bureau' => $proviseur->getBureau()
        ]);
        
        if (!$result) {
            $error = $stmt->errorInfo();
            throw new \Exception("ÉCHEC INSERT PROVISEUR: " . $error[2]);
        }
        
        $this->db->commit();
        return true;
        
    } catch (\Exception $e) {
        // Afficher l'erreur pour la voir dans le test
        echo "❌ " . $e->getMessage() . "<br>";
        error_log("Erreur: " . $e->getMessage());
        return false;
    }
}

    //modifier un proviseur
    public function update(Proviseur $proviseur): bool
{
    try {
        // Vérifier que le proviseur existe (par son id_proviseur)
        if (!$this->exists($proviseur->getIdProviseur())) {
            throw new \Exception("Proviseur avec l'ID " . $proviseur->getIdProviseur() . " introuvable.");
        }

        // Démarrer une transaction
        $this->db->beginTransaction();

        // 1. Mise à jour de la table utilisateur
        $sqlUser = "UPDATE utilisateur SET 
                    nom = :nom, 
                    prenom = :prenom, 
                    email = :email, 
                    mot_de_passe = :mot_de_passe, 
                    statut = :statut, 
                    telephone = :telephone 
                    WHERE id_utilisateur = :id_utilisateur";
        $stmtUser = $this->db->prepare($sqlUser);
        $stmtUser->execute([
            ':nom'            => $proviseur->getNom(),
            ':prenom'         => $proviseur->getPrenom(),
            ':email'          => $proviseur->getEmail(),
            ':mot_de_passe'   => $proviseur->getMotDePasse(),
            ':statut'         => $proviseur->getStatut(),
            ':telephone'      => $proviseur->getTelephone(),
            ':id_utilisateur' => $proviseur->getIdUtilisateur()
        ]);

        // 2. Mise à jour de la table proviseur (avec tous les champs)
        $sqlProv = "UPDATE proviseur SET 
                    etablissement = :etablissement, 
                    bureau = :bureau,
                    duree_mandat = :duree_mandat
                    WHERE id_utilisateur = :id_utilisateur";
        $stmtProv = $this->db->prepare($sqlProv);
        $stmtProv->execute([
            ':etablissement'  => $proviseur->getEtablissement(),
            ':bureau'         => $proviseur->getBureau(),
            ':duree_mandat'   => $proviseur->getDureeMandat(),
            ':id_utilisateur' => $proviseur->getIdUtilisateur()
        ]);

        // Tout s'est bien passé → validation
        $this->db->commit();
        return true;

    } catch (\PDOException $e) {
        $this->db->rollBack();
        error_log("Erreur PDO dans updateProviseur : " . $e->getMessage());
        // Vous pouvez choisir de retourner false ou de relancer une exception
        return false;
    } catch (\Exception $e) {
        $this->db->rollBack();
        error_log("Erreur dans updateProviseur : " . $e->getMessage());
        return false;
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
        $sql = "SELECT u.*,p.* FROM utilisateur u INNER JOIN proviseur p ON u.id_utilisateur = p.id_proviseur WHERE U.role = 'proviseur'";
        $stmt = $this->db->query($sql);

        $proviseur = [];

        while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
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

    // trouver une proviseur avec les infos de l'utilisateur
    public function findWithUser($id){
        $sql = "SELECT u.*, p.* FROM utilisateur u INNER JOIN proviseur p ON u.id_utilisateur = p.id_proviseur WHERE u.id_utilisateur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }
        return $this->createEntity($result);
    }

    // afficher un proviseur avec les infos de l'utilisateur
    public function findAllWithUserInfos(){
        $sql = "SELECT u.*, p.* FROM utilisateur u INNER JOIN proviseur p ON u.id_utilisateur = p.id_proviseur WHERE u.role = 'proviseur'";
        $stmt = $this->db->query($sql);
        $proviseurs = [];
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $proviseurs[] = $this->createEntity($result);
        }
        return $proviseurs;
    }


}
















?>