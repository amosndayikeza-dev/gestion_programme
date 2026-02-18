<?php
namespace App\Dao\Utilisateur;
use App\Models\Utilisateur\Eleve;
use App\config\Model;
use PDO;


class EleveDAO extends Model{
    protected $table = "eleve";
    protected  $primaryKey = "id";

    public function __construct()
    {
        return parent::__construct();
    }

    /**
     * convertir un tableau en objet utilisateur
     */
    public function createEntity($data){
        $eleve = new Eleve();
        $eleve->hydrate($data);
        return $eleve;
    }
    /**
     * ENREGISTRER UN TULISATEUR
     */
    public function sava(Eleve $eleve){
        $data = $eleve->toArray();
        //n'est pas inclure l'ID pour la creation
        if(empty($data['id_eleve'])){
            unset($data['id_eleve']);
        }
        // si c'est la mise a jours
        if($eleve->getIdEleve()){
            return $this->update($eleve->getIdEleve(),$data);
        }   
        //SI C'EST UNE CREATION
        $id = $this->Create($data);
        if($id){
            $eleve->setIdEleve($id);
            return true;
        }
    }

        //supprimer un eleve
        public function delete($id)
        {
            return parent::delete($id);
        }   
        //trouver un eleve par son ID
        public function find($id){
            $data = parent::find($id);
            return $this->createEntity($data);
        }
        //afficher tous les eleve
        public function findAll(){
           $sql = "SELECT * FROM {$this->table}";
           $stmt = $this->db->query($sql);
           $eleves = [];
           while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $eleves[] = $this->createEntity($row);
           }
           return $eleves;
        }

        //trouver un eleve par son email
        public function findByEmail($email){
            $sql = "SELECT * FROM {$this->table} WHERE email = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if($data){
                return $this->createEntity($data);
            }else{
                return NULL;
            }
        }
        //trouvr un eleve par classe
        public function findByClasse($classe){
            $sql = "SELECT * FROM {$this->table} WHERE classe = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$classe]);
            $eleves = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $eleves[] = $this->createEntity($row);
            }
            return $eleves;
        }
        //trouver un eleve par tuteur
        public function findByTuteur($tuteur){
            $sql = "SELECT * FROM {$this->table} WHERE id_tuteur = ? ORDER BY nom,prenom";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$tuteur]);
            $eleve = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $eleve[] = $this->createEntity($row);
                }
            return $eleve; 
        }
        // chercher des eleves par nom ou prenom
        public function search($keyWord){
            $sql = "SELECT * FROM {$this->table} WHERE nom LIKE ? OR prenom LIKE ? ORDER BY nom,prenom";
            $keyWord = "%{$keyWord}%";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$keyWord,$keyWord]);
            $eleves = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $eleves[] = $this->createEntity($row);
            }
            return $eleves;
        }
        // compter les eleves actifs
        public function countActiveEleve(){
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE statut = 'actif'";
            $stmt = $this->db->query($sql);
            return $stmt->fetchColumn();
        }
        //generer un matricule unique pour un eleve
        private function generateMatricule($id){
            $annee = date('Y');
            $prefixe = 'EL';
            $numero = str_pad($id,4,'0',STR_PAD_LEFT);
            return $prefixe . $annee . $numero;
        }
}

    
        


















?>