<?php
namespace App\ModuleUtilisateur\Enseignant\Dao;

use App\ModuleUtilisateur\Enseignant\Models\Enseignant;
use App\core\Config\Model;
use PDO;
use PDOException;   

class EnseignantDAO extends Model{
    protected $table = "enseignant";
    protected $primaryKey = "id_enseignant";
    private $userTable = "utilisateur";

    public function __construct(){
        parent::__construct();
    }
        // creer un objet enseignant a partir d'un tableau
    public function createEntity($row){
        $enseignant = new Enseignant();
        return $enseignant->hydrate($row);
    }
    // sauvegarder un enseignant (dans les 2 tables)
    public function save(Enseignant $enseignant){
        try{
            //insertion utilisateur
            $stmt = $this->db->prepare("INSERT INTO utilisateur(nom, prenom, email, mot_de_passe, statut, telephone) VALUES (:nom, :prenom, :email, :mot_de_passe, :statut, :telephone)");
            $stmt->execute([
                ':nom' => $enseignant->getNom(),
                ':prenom' => $enseignant->getPrenom(),
                ':email' => $enseignant->getEmail(),
                ':mot_de_passe' => $enseignant->getMotDePasse(),
                ':statut' => $enseignant->getStatut(),
                ':telephone' => $enseignant->getTelephone()
            ]);
            // Récupération de l'ID utilisateur généré
            $idUtilisateur = $this->db->lastInsertId();
            // Mise à jour de l'objet Enseignant avec l'ID utilisateur
            $enseignant->setIdUtilisateur($idUtilisateur);
            // Insertion dans la table enseignant
            $stmt = $this->db->prepare("INSERT INTO enseignant(id_utilisateur, grade, specialite) VALUES (:id_utilisateur, :grade, :specialite)");
            $stmt->execute([
                ":id_utilisateur" => $enseignant->getIdUtilisateur(),
                ":grade" => $enseignant->getGrade(),
                ":specialite" => $enseignant->getSpecialite()
             ]);
            return true;

        }catch(PDOException $e){
            echo "Error saving enseignant: " . $e->getMessage();
        }
    }
    // modifier un enseignant
    public function updateEnseignant(Enseignant $enseignant){
        try{
            // verifier si l'ID de l'utilisateur existe
            $id = $enseignant->getIdEnseignant();
            if(!$this->find($id)){
                throw new \Exception("Enseignant with ID $id not found.");
            }
            // Mise à jour de l'utilisateur
            $stmt = $this->db->prepare("UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, statut = :statut, telephone = :telephone WHERE id_utilisateur = :id_utilisateur");
            $stmt->execute([
                ':nom' => $enseignant->getNom(),
                ':prenom' => $enseignant->getPrenom(),
                ':email' => $enseignant->getEmail(),
                ':mot_de_passe' => $enseignant->getMotDePasse(),
                ':statut' => $enseignant->getStatut(),
                ':telephone' => $enseignant->getTelephone(),
                ':id_utilisateur' => $enseignant->getIdUtilisateur()
            ]);
            // Mise à jour de l'enseignant
            $stmt = $this->db->prepare("UPDATE enseignant SET grade = :grade, specialite = :specialite WHERE id_enseignant = :id_enseignant");
            $stmt->execute([
                ":grade" => $enseignant->getGrade(),
                ":specialite" => $enseignant->getSpecialite(),
                ":id_enseignant" => $id
             ]);
            return true;
        }catch(PDOException $e){
            echo "Error updating enseignant: " . $e->getMessage();
            return false;
        }
    }
    // trouver un enseignant par son ID
    public function find($id)
    {
        $result =  parent::find($id);
        if(! $result){
            return null;
        }
        return $this->createEntity($result);
    }
    // trouver un enseignant par son email
    public function findByEmail($email)
    {
        $sql = "SELECT u.*,e.* FROM utilisateur u JOIN enseignant e ON u.id_utilisateur = e.id_utilisateur WHERE u.email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch();
        if(! $result){
            return null;
        }
        return $this->createEntity($result);
    }
    // supprimer un enseignant
    public function delete($id)
    {
        return parent::delete($id);
    }
    // compter le nombre des enseignants
    public function count()
    {
        return parent::count();
    }
    // verifier si un enseignant existe
    public function exists($id)
    {        return $this->find($id) !== null;
    }
    // trouver un enseignant avec les infos de l'utilisateur
    public function findWithUser($id){
        $sql = "SELECT u.*, e.* FROM utilisateur u INNER JOIN enseignant e ON u.id_utilisateur = e.id_utilisateur WHERE e.id_enseignant = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ? $this->createEntity($result) : null;
    }
    // afficher tout les enseignants avec les infos de l'utilisateur
    public function fincAllWithUser($columns = ['*']){
        $sql = "SELECT u.*, e.* FROM utilisateur u INNER JOIN enseignant e ON u.id_utilisateur = e.id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $enseignants = [];
        foreach($results as $row){
            $enseignants[] = $this->createEntity($row);
        }
        return $enseignants;
    }


}









?>