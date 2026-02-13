<?php
namespace App\Dao\Admin;
use App\Models\Admin\Administrateur;
use App\Config\Model;
use DateTime;
use DateInterval;
use PDO;
use Exception;

class AdminDao extends Model
{
    protected $table = "administrateurs";
    protected $primaryKey = "id";

    public function __construct()
    {
        return parent::__construct();
    }
    /**
     * convertir un tableaux en un objet
     */
    public function createEntity(array $data){
        $administrateur = new Administrateur();
        return $administrateur->hydrate($data);
    }
    /**
     * suvegarder un admin (creation ou sauvegarder)
     */
    public function save($administrateur){
        $data = [
            'niveau'=>$administrateur->getNiveauAcces(),
            'departement'=>$administrateur->getDepartement(),
            'date_prise_fonction'=>$administrateur->getDatePriseFonction(),
            'date_fin_fonction'=>$administrateur->getDateFonction(),
            'permission_speciale'=>$administrateur->getPermissionSpeciale(),
            'dernier_audit'=>$administrateur->getDernierAudit(),
            'authentification2Facteurs' =>$administrateur->getAuthentification2Facteurs(),
            'cle_2FA' => $administrateur->getCle2FA(),
            'niveau_audit'=>$administrateur->getNiveauAudit(),
            'zone_intervention'=>$administrateur->getZoneIntervention()
        ];

        // si c'est une mise a jours
        if($administrateur->getIdAdministrateur()){
            return $this->update($administrateur->getIdAdministrateur(),$data);
        }
        //SI C'EST UNE CREATION
        $id = $this->Create($data);
        if($id){
            $administrateur->setIdAdministrateur($id);
            return true;
        }  
    }
    //supprimer un utilisateur
        public function delete($id){
            return parent::delete($id);

        } 
    //trouver un utilisateur par son ID
    public function find($id)
    {
        return parent::find($id);
    }
    //trouver un admin par son email
    public function findByEmail($email){
        return parent::findByEmail($email);
    }
    //trouver tout les admin
    public function all($columns = ['*'])
    {
        return parent::all($columns);
    }
    /**
     * changer le statut d'un utilisateur
     */
    public function changerStatut($id,$statut){
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

}
























?>