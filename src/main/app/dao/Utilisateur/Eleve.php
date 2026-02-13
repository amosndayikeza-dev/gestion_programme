<?php
namespace App\Dao\Utilisateur;
use App\Models\Utilisateur\Utilisateur;
use App\Models\Utilisateur\RoleEnum;
use App\Models\Utilisateur\Eleve;
use App\config\Model;
use PDO;
use PDOException;

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
        $data = [
            'nom' => $eleve->getNom(),
            'prenom' => $eleve->getPrenom(),
            'email' => $eleve->getEmail(),
            'mot_de_passe' => $eleve->getMotDePasse(),
            'role' => $eleve->getRole(),
            'statut' => $eleve->getStatut(),
            'telephone' => $eleve->getTelephone(),
            'photo_profil' => $eleve->getPhotoProfil(),
            'date_naissance' => $eleve->getDateNaissance(),
            'lieu_naissance' => $eleve->getLieuNaissance(),
            'sexe' => $eleve->getSexe(),
            'adresse' => $eleve->getAdresse(),
            'date_inscription' => $eleve->getDateInscription(),
            'matricule' => $eleve->getMatricule(),
            'id_utilisateur' => $eleve->getIdUtilisateur(),
            'id_classe' => $eleve->getIdClasse(),
            'id_tuteur' => $eleve->getIdTuteur()
        ];

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
        
}

















?>