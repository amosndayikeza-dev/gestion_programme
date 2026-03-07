<?php
namespace App\ModuleUtilisateur\Inspecteur\Dao;

//use App\ModuleUtilisateur\Inspecteur\Models\Inspecteur;
use App\ModuleUtilisateur\Inspecteur\Models\Inspecteur;  // ✅ Correct
use App\core\Config\Model;
use PDO;
use PDOException;


class InspecteurDAO extends Model
{
    protected $table = "inspecteurs";
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
    public function save(Inspecteur $inspecteur){
    $this->db->beginTransaction();
    try{
        // 1. Insertion dans utilisateur
        $stmt = $this->db->prepare("INSERT INTO utilisateur(
            nom, prenom, email, mot_de_passe, role, statut, telephone
        ) VALUES (
            :nom, :prenom, :email, :mot_de_passe, :role, :statut, :telephone
        )");
        
        $result = $stmt->execute([
            ':nom' => $inspecteur->getNom(),
            ':prenom' => $inspecteur->getPrenom(),
            ':email' => $inspecteur->getEmail(),
            ':mot_de_passe' => $inspecteur->getMotDePasse(),
            ':role' => $inspecteur->getRole(),
            ':statut' => $inspecteur->getStatut(),
            ':telephone' => $inspecteur->getTelephone()
        ]);
        
        if(!$result){
            $this->db->rollBack();
            throw new \Exception("Failed to save utilisateur.");
        }
        
        $idUtilisateur = $this->db->lastInsertId();
        $inspecteur->setIdUtilisateur($idUtilisateur);
        $inspecteur->setIdInspecteur($idUtilisateur);  // Même ID !
        
        // 2. Insertion dans inspecteur - ✅ avec id_inspecteur
        $stmt = $this->db->prepare("INSERT INTO inspecteurs(
            id_inspecteur, specialite, grade, zone_geographique, 
            etablissements_assignes, date_nomination, date_fin_mission, 
            statut_mission, rapports_emis, derniere_inspection, 
            prochaine_inspection, type_inspections, niveau_habilitation, 
            vehicule_de_fonction, prime_inspection, formations_suivies, 
            certifications
        ) VALUES (
            :id_inspecteur, :specialite, :grade, :zone_geographique,
            :etablissements_assignes, :date_nomination, :date_fin_mission,
            :statut_mission, :rapports_emis, :derniere_inspection,
            :prochaine_inspection, :type_inspections, :niveau_habilitation,
            :vehicule_de_fonction, :prime_inspection, :formations_suivies,
            :certifications
        )");
        
        $result = $stmt->execute([
            ':id_inspecteur' => $inspecteur->getIdInspecteur(),
            ':specialite' => $inspecteur->getSpecialite(),
            ':grade' => $inspecteur->getGrade(),
            ':zone_geographique' => $inspecteur->getZoneGeographique(),
            ':etablissements_assignes' => $inspecteur->getEtablissementsAssignes(),
            ':date_nomination' => $inspecteur->getDateNomination(),
            ':date_fin_mission' => $inspecteur->getDateFinMission(),
            ':statut_mission' => $inspecteur->getStatutMission(),
            ':rapports_emis' => $inspecteur->getRapportsEmis(),
            ':derniere_inspection' => $inspecteur->getDerniereInspection(),
            ':prochaine_inspection' => $inspecteur->getProchaineInspection(),
            ':type_inspections' => $inspecteur->getTypeInspections(),
            ':niveau_habilitation' => $inspecteur->getNiveauHabilitation(),
            ':vehicule_de_fonction' => $inspecteur->getVehiculeDeFonction(),
            ':prime_inspection' => $inspecteur->getPrimeInspection(),
            ':formations_suivies' => $inspecteur->getFormationsSuivies(),
            ':certifications' => $inspecteur->getCertifications()
        ]);
        
        if(!$result){
            $this->db->rollBack();
            throw new \Exception("Failed to save inspecteur.");
        }
        
        $this->db->commit();
        return true;
        
    } catch(PDOException $e){
        $this->db->rollBack();
        error_log("Error saving inspecteur: " . $e->getMessage());
        return false;
    }
}
    /**
     * mettre a jour l'inspecteur
     */
public function updateInspecteur(Inspecteur $inspecteur)
{
    try {
        $id = $inspecteur->getIdInspecteur();
        if (!$this->find($id)) {
            throw new \Exception("Inspecteur with ID $id not found.");
        }
        
        // Mettre à jour l'utilisateur
        $stmt = $this->db->prepare("UPDATE utilisateur SET 
            nom = :nom, 
            prenom = :prenom, 
            email = :email, 
            telephone = :telephone, 
            statut = :statut 
            WHERE id_utilisateur = :id_utilisateur");
            
        $stmt->execute([
            ':nom' => $inspecteur->getNom(),
            ':prenom' => $inspecteur->getPrenom(),
            ':email' => $inspecteur->getEmail(),
            // ❌ SUPPRIMÉ : ":role"=> $inspecteur->getRapportsEmis(), // ← ERREUR: paramètre non utilisé dans la requête
            ':telephone' => $inspecteur->getTelephone(),
            ':statut' => $inspecteur->getStatut(),
            ':id_utilisateur' => $inspecteur->getIdUtilisateur()
        ]);

        // Mettre à jour l'inspecteur (seulement les champs modifiables)
        $stmt = $this->db->prepare("UPDATE inspecteurs SET 
            specialite = :specialite,
            grade = :grade,
            zone_geographique = :zone_geographique,
            niveau_habilitation = :niveau_habilitation,
            statut_mission = :statut_mission
            WHERE id_inspecteur = :id_inspecteur");
            
        $stmt->execute([
            ':specialite' => $inspecteur->getSpecialite(),
            ':grade' => $inspecteur->getGrade(),
            ':zone_geographique' => $inspecteur->getZoneGeographique(),
            ':niveau_habilitation' => $inspecteur->getNiveauHabilitation(),
            ':statut_mission' => $inspecteur->getStatutMission(),
            ':id_inspecteur' => $id
        ]);
        
        return true;

    } catch(PDOException $e) {
        throw new \Exception("Erreur : " . $e->getMessage());
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
         $sql = "SELECT u.*, i.* FROM utilisateur u JOIN inspecteurs i ON u.id_utilisateur = i.id_inspecteur WHERE i.id_inspecteur = :id";
         $stmt = $this->db->prepare($sql);
         $stmt->execute([':id' => $id]);
         $result = $stmt->fetch();
         return $result ? $this->createEntity($result) : null;
     }

     // afficher tout les inspecteurs avec les infos de l'utilisateur
    public function findAllWithUser() {
    $sql = "SELECT u.*, i.* 
            FROM utilisateur u
            INNER JOIN inspecteurs i ON u.id_utilisateur = i.id_inspecteur
            ORDER BY u.nom, u.prenom";
    
    $stmt = $this->db->query($sql);
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