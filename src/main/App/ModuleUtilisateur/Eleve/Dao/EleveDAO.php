<?php
namespace App\ModuleUtilisateur\Dao;

use App\ModuleUtilisateur\Eleve\Models\Eleve;
use App\core\Config\Model;
use PDO;
use PDOException;   

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
     * Créer un objet Eleve à partir d'un tableau
     */
    public function createEntity($row)
    {
        $eleve = new Eleve();
        return $eleve->hydrate($row);
    }

    /**
     * Sauvegarder un élève (dans les 2 tables)
     */
    public function save(Eleve $eleve){
        $this->db->beginTransaction();
        try{
            //insertion utilisateur
            $stmt = $this->db->prepare("INSERT INTO utilisateur(nom, prenom, email, mot_de_passe, role, statut, telephone,date_creation,photo_profil) VALUES (:nom, :prenom, :email, :mot_de_passe, :role, :statut, :telephone, :date_creation, :photo_profil)");
            $stmt->execute([
                ':nom' => $eleve->getNom(),
                ':prenom' => $eleve->getPrenom(),
                ':email' => $eleve->getEmail(),
                ':mot_de_passe' => $eleve->getMotDePasse(),
                ':role' => $eleve->getRole(),
                ':statut' => $eleve->getStatut(),
                ':telephone' => $eleve->getTelephone(),
                ':date_creation' => $eleve->getDateCreation(),
                ':photo_profil' => $eleve->getPhotoProfil()

            ]);
            // Récupération de l'ID utilisateur généré
            $idUtilisateur = $this->db->lastInsertId();
            // Mise à jour de l'objet Eleve avec l'ID utilisateur
            $eleve->setIdUtilisateur($idUtilisateur);
            $eleve->setIdEleve($idUtilisateur); // ID de l'élève = ID de l'utilisateur
            //insertion eleve
            $stmt = $this->db->prepare("INSERT INTO eleve(id_utilisateur, id_classe_actuelle, id_tuteur, date_naissance, lieu_naissance, sexe, adresse, date_inscription, matricule)
             VALUES (:id_utilisateur, :id_classe_actuelle, :id_tuteur, :date_naissance, :lieu_naissance, :sexe, :adresse, :date_inscription, :matricule)");
            $resultEleve = $stmt->execute([
                ':id_utilisateur' => $idUtilisateur,
                ':id_classe_actuelle' => $eleve->getIdClasse(),
                ':id_tuteur' => $eleve->getIdTuteur(),  
                ':date_naissance' => $eleve->getDateNaissance(),
                ':lieu_naissance' => $eleve->getLieuNaissance(),
                ':sexe' => $eleve->getSexe(),
                ':adresse' => $eleve->getAdresse(),
                ':date_inscription' => $eleve->getDateInscription(),
                ':matricule' => $eleve->getMatricule(),
            ]);
            
            if(!$resultEleve){
                throw new \Exception("Erreur lors de l'insertion de l'élève");
            }
            $this->db->commit();
            return true;
        }catch(PDOException $e){
            $this->db->rollBack();
            throw $e;
        }
    }

    //Modifier un eleve
    public function updateEleve(Eleve $eleve){
        $this->db->beginTransaction();
        try{
            //verifier si l'ID de l'utilisateur existe
            $id = $eleve->getIdUtilisateur();
            if(!$id){
                throw new \Exception("ID de l'élève manquant pour la mise à jour");
            }
            // Mise à jour de l'utilisateur
            $stmt = $this->db->prepare("UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, statut = :statut, telephone = :telephone WHERE id_utilisateur = :id_utilisateur");
            $stmt->execute([
                ':nom' => $eleve->getNom(),
                ':prenom' => $eleve->getPrenom(),
                ':email' => $eleve->getEmail(),
                ':mot_de_passe' => $eleve->getMotDePasse(),
                ':statut' => $eleve->getStatut(),
                ':telephone' => $eleve->getTelephone(),
                ':id_utilisateur' => $eleve->getIdUtilisateur()
            ]);

            // Mise à jour de l'élève
            $stmt = $this->db->prepare("UPDATE eleve SET id_classe_actuelle = :id_classe_actuelle, id_tuteur = :id_tuteur, date_naissance = :date_naissance, lieu_naissance = :lieu_naissance, sexe = :sexe, adresse = :adresse, date_inscription = :date_inscription, matricule = :matricule WHERE id_eleve = :id_eleve");
            $resultEleve =$stmt->execute([
                ":id_classe_actuelle" => $eleve->getIdClasse(),
                ":id_tuteur" => $eleve->getIdTuteur(),
                ":date_naissance" => $eleve->getDateNaissance(),
                ":lieu_naissance" => $eleve->getLieuNaissance(),
                ":sexe" => $eleve->getSexe(),
                ":adresse" => $eleve->getAdresse(),
                ":date_inscription" => $eleve->getDateInscription(),
                ":matricule" => $eleve->getMatricule(),
                ":id_eleve" => $eleve->getIdEleve()
            ]);
                if(!$resultEleve){
                    throw new \Exception("Erreur lors de la mise à jour de l'élève");
                }
                $this->db->commit();
            return true;
        }catch(PDOException $e){
            $this->db->rollBack();
            throw $e;
        }
    }

    // trouver un eleve par son ID
    public function find($id){
        $result = parent::find($id, "eleve");
        return $result ? $this->createEntity($result) : null;
    }
    // recuperer tout les eleves
    public function all($columna = ["*"]){
        $results = parent::all("eleve", $columna);
        $eleves = [];
        foreach($results as $row){
            $eleves[] = $this->createEntity($row);
        }
        return $eleves;
    }
    // supprimer un eleve par son ID
    public function delete($id)
    {
        return parent::delete($id);
    }
    // compter le nombre des eleves
    public function count()
    {
        return parent::count();
    }
    // verifier si un eleve existe
    public function exists($id)
    {
        return $this->find($id) !== null;
    }
    // trouver un eleve avec les infos de l'utilisateur
    public function findWithUser($id){
           $sql = "SELECT u.*, e.* 
            FROM utilisateur u
            INNER JOIN eleve e ON u.id_utilisateur = e.id_utilisateur
            WHERE u.id_utilisateur = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    
    // Retourner null si rien trouvé
    if (!$data) {
        return null;
    }
    
    return $this->createEntity($data);
}
    
    // trouver tous les eleves avec les infos de l'utilisateur
    public function findAllWithUser($columns = ['*']){
        $sql = "SELECT u.*, e.* FROM utilisateur u INNER JOIN eleve e ON u.id_utilisateur = e.id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $eleves = [];
        foreach($results as $row){
            $eleves[] = $this->createEntity($row);
        }
        return $eleves;
    }

    // trouver un eleve par son Email
    public function findByEmail($email){    
        $sql = "SELECT u.*, e.* FROM utilisateur u LEFT JOIN eleve e ON u.id_utilisateur = e.id_utilisateur WHERE u.email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $this->createEntity($stmt->fetch(PDO::FETCH_ASSOC));
    }
    // verifier si un email de l'eleve existe
    public function emailExists($email){
        $sql = "SELECT COUNT(*) FROM utilisateur WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }



}

