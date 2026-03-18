<?php
namespace App\ModuleUtilisateur\Admin\Services;

use App\ModuleUtilisateur\Admin\Dao\AdminDAO;
use App\ModuleUtilisateur\Models\Admin\Administrateur as AdminAdministrateur;
use App\ModuleUtilisateur\Models\Administrateur;

/**
 * service gerant les operations metier sur les administrateur
 */

class AdminService{
/**
 * @var AdminDAO
 */
    private $adminDAO;

    public function __construct(){
        $this->adminDAO = new AdminDAO();
    }

    //retourne tout les utilisateurs

    public function getAllAdmins(){
        return $this->adminDAO->AllAdmin();
    }

    //retourne un admin par son id

    public function getAdminById($id){
        return $this->adminDAO->findWithUser($id);
    }

    /**
     * Valide les données d'un administrateur
     * @param array $data Données à valider
     * @param int|null $id ID en cas de modification (pour vérifier l'unicité de l'email)
     * @return array Tableau des erreurs (vide si tout est ok)
     */

    public function validate($data,$id = null){
        $error = [];
        //nom
        if(empty($data['nom'])){
            $error['nom'] = "Le nom est obligatoire.";

        }elseif (strlen($data['nom'] < 2 || strlen($data['nom'] > 50))){
            $error['nom'] = "Le nom doit contenier entre 2 et 50 caracteres. ";
        }

        //prenom
        if(empty($data['prenom'])){
              $errors['prenom'] = "Le prénom est obligatoire.";
        }elseif (strlen($data['prenom']) < 2 || strlen($data['prenom']) > 50) {
            $errors['prenom'] = "Le prénom doit contenir entre 2 et 50 caractères.";
        }

        //email
        if(empty($data['email'])){
           $errors['email'] = "L'email est obligatoire.";

        }elseif (!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
             $errors['email'] = "L'email n'est pas valide.";
        }else{
            // verifier l'unicite (sauf pour le meme ID)
            $existing = $this->adminDAO->findByEmail($data['email']);
            if($existing && $existing->getIdUtilisateur() != $id ){
                $errors['email'] = "Cet email est déjà utilisé.";
            }
        }

        //Mot de passe : obligatoire en creation , optionnel en modification

        if(empty($data['mot_de_passe'] )&& !$id){
              $errors['mot_de_passe'] = "Le mot de passe est obligatoire.";
        }elseif (!empty($data['mot_de_passe']) && strlen($data['mot_de_passe']) < 6) {
            $errors['mot_de_passe'] = "Le mot de passe doit contenir au moins 6 caractères.";
        }

        
        // Niveau d'accès (spécifique à l'admin)
        if (empty($data['niveau_acces'])) {
            $errors['niveau_acces'] = "Le niveau d'accès est obligatoire.";
        }

        return $error;
    }


    /**
     * Crée un nouvel administrateur
     * @param array $data
     * @return Administrateur|null
     */

    public function createAdmin($data){
        $admin = new AdminAdministrateur();
            $admin->setNom($data['nom']);
            $admin->setPrenom($data['prenom']);
            $admin->setEmail($data['email']);
            $admin->setMotDePasse($data['mot_de_passe'],PASSWORD_DEFAULT);
            $admin->setNiveauAcces($data['niveau_acces']);
            $admin->setStatut('actif');
            $admin->setRole('administrateur');
            $admin->setNiveauAcces($data['niveau_acces']);
            $admin->setDepartement($data['departement']);
            $admin->setDatePriseFonction($data['date_prise_fonction']);
            $admin->setDateFinFonction($data['date_fin_fonction']);
            $admin->setPermissionsSpeciales($data['permissions_speciales']);
            $admin->setDernierAudit($data['dernier_audit']);
            $admin->setAdresseIpAutorisees($data['adresse_ip_autorisees']);
            $admin->setAuthentification2Facteurs($data['authentification_2facteurs']);
            $admin->setCle2FA($data['cle_2fa']);

            if($this->adminDAO->save($admin)){
                return $admin;
            }else{
                return null;
        }
    }


        /**
     * Met à jour un administrateur existant
     * @param int $id
     * @param array $data
     * @return bool
     */

    public function updateAdmin($id,$data){
        $admin = $this->adminDAO->findWithUser($id);
        if(!$admin){
            return false;
        }
        
        $admin->setNom($data['nom']);
        $admin->setPrenom($data['prenom']);
        $admin->setEmail($data['email']);
        if(!empty($data['mot_de_passe'])){
            $admin->setMotDePasse(password_hash($data['mot_de_passe'],PASSWORD_DEFAULT));

        }

        $admin->setStatut($data['statut'] ?? $admin->getStatut());
        $admin->setNiveauAcces($data['niveau_acces']);
       
        return $this->adminDAO->update($admin);

    }


    /**
     * Supprime un administrateur
     * @param int $id
     * @return bool
     */

    public function deleteAdmin($id){
        $admin = $this->adminDAO->delete($id);
        if(!$admin){
            return false;
        }else{
            return true;
        }
    }


}












?>