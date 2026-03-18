<?php
namespace App\ModuleUtilisateur\DecteurDiscipline\Services;

use App\ModuleUtilisateur\DirecteurDiscipline\Models\DirecteurDiscipline;
use App\ModuleUtilisateur\DirecteurDiscipline\Dao\DirecteurDisciplineDAO;

/**
 * service gerant les operations metier sur les directeur de discipline
 */
class DirecteurDisciplineService {
    private $directeurdisciplineDAO;

    public function __construct()
    {
        $this->directeurdisciplineDAO = new DirecteurDisciplineDAO();
    }

    
    /**
     * Retourne tous les directeurs de discipline avec leurs infos utilisateur
     * @return array
     */

    public function getAll(){
        return $this->directeurdisciplineDAO->findAllWithUser();
    }

     /**
     * Retourne un directeur par son ID
     * @param int $id
     * @return DirecteurDiscipline|null
     */
    public function getById($id){
        return $this->directeurdisciplineDAO->find($id);
    
    }

     /**
     * Valide les données d'un directeur de discipline
     * @param array $data Données à valider (nom, prenom, email, etc.)
     * @param int|null $id ID en cas de modification (pour l'unicité de l'email)
     * @return array Tableau des erreurs (vide si tout est OK)
     */

     public function validate($data,$id = null){
        $error = [];

        // champs utilisateur

         if (empty($data['nom'])) {
            $errors['nom'] = "Le nom est obligatoire.";
        } elseif (strlen($data['nom']) < 2 || strlen($data['nom']) > 50) {
            $errors['nom'] = "Le nom doit contenir entre 2 et 50 caractères.";
        }

         if (empty($data['prenom'])) {
            $errors['prenom'] = "Le prénom est obligatoire.";
        } elseif (strlen($data['prenom']) < 2 || strlen($data['prenom']) > 50) {
            $errors['prenom'] = "Le prénom doit contenir entre 2 et 50 caractères.";
        }

        if(empty('email')){
            $error['email'] = "L'email est obligatoire";
        }elseif(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
              $errors['email'] = "L'email n'est pas valide.";
     }else{
         // Vérifier l'unicité de l'email (sauf pour le même ID)
            $existing = $this->directeurdisciplineDAO->findByEmail($data['email']);
             
            if ($existing && $existing->getIdUtilisateur() != $id) {
                $errors['email'] = "Cet email est déjà utilisé.";
            }
     }

     
        // Mot de passe : obligatoire en création, optionnel en modification
    if(empty($data['mot_de_passe']) && !$id){ 
        $errors = "Le mot de passe est obligatoire";
    }elseif (!empty($data['mot_de_passe']) && strlen($data['mot_de_passe']) < 6) {
            $errors['mot_de_passe'] = "Le mot de passe doit contenir au moins 6 caractères.";
        }


      // Téléphone (optionnel mais validation si présent)
        if (!empty($data['telephone']) && !preg_match('/^[0-9]{8,15}$/', $data['telephone'])) {
            $errors['telephone'] = "Le téléphone doit contenir entre 8 et 15 chiffres.";
        }

         // --- Champs spécifiques au directeur de discipline ---
        if (empty($data['bureau'])) {
            $errors['bureau'] = "Le bureau est obligatoire.";
        } elseif (strlen($data['bureau']) > 50) {
            $errors['bureau'] = "Le bureau ne doit pas dépasser 50 caractères.";
        }

        
        // Plages de disponibilité (optionnel) – si présent, vérifier que c'est du JSON valide
        if(!empty($data['plage_disponibilite']) ){
           json_decode($data['plage_disponibilite']);
        
           if(json_last_error() !== JSON_ERROR_NONE){
            $error['plages_disponibilite'] = "Les plages de disponibilité doivent être au format JSON valide";

           }
        }
       // Date de début
        if (empty($data['date_debut'])) {
            $errors['date_debut'] = "La date de début est obligatoire.";
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['date_debut'])) {
            $errors['date_debut'] = "La date de début doit être au format YYYY-MM-DD.";
        }


        // Date de fin (optionnelle) – si présente, vérifier format et cohérence
        if (!empty($data['date_fin'])) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['date_fin'])) {
                $errors['date_fin'] = "La date de fin doit être au format YYYY-MM-DD.";
            } elseif (strtotime($data['date_fin']) < strtotime($data['date_debut'])) {
                $errors['date_fin'] = "La date de fin ne peut pas être antérieure à la date de début.";
            }
        }

        return $errors;
    }

    
    /**
     * Crée un nouveau directeur de discipline
     * @param array $data
     * @return DirecteurDiscipline|null
     */

    public function create($data){
        $directeur = new DirecteurDiscipline();

        // champs utilisateur
        $directeur->setNom('nom');
         $directeur->setPrenom($data['prenom']);
        $directeur->setEmail($data['email']);
        $directeur->setMotDePasse(password_hash($data['mot_de_passe'], PASSWORD_DEFAULT));
        $directeur->setTelephone($data['telephone'] ?? null);
        $directeur->setStatut('actif'); // ou depuis $data si présent
        $directeur->setRole('directeur_discipline');

        // Champs spécifiques
        $directeur->setBureau($data['bureau']);
        $directeur->setTelephonePro($data['telephone_pro'] ?? null);
        $directeur->setPlagesDisponibilite($data['plages_disponibilite'] ?? null);
        $directeur->setDateDebut($data['date_debut']);
        $directeur->setDateFin($data['date_fin'] ?? null);

        if($this->directeurdisciplineDAO->save($directeur)){
            return $directeur;
        }else{
            return null;
        }
    }

    
    /**
     * Met à jour un directeur de discipline existant
     * @param int $id
     * @param array $data
     * @return bool
     */

    public function update($id,$data){
        $directeur = $this->directeurdisciplineDAO->find($id);
        if(!$directeur){
            return false;
        }

        //Mise a jours des champs utilisateur
        $directeur->setNom($data['nom']);
        $directeur->setPrenom($data['prenom']);
        $directeur->setEmail($data['email']);
        if (!empty($data['mot_de_passe'])) {
            $directeur->setMotDePasse(password_hash($data['mot_de_passe'], PASSWORD_DEFAULT));
        }
        $directeur->setTelephone($data['telephone'] ?? $directeur->getTelephone());
        $directeur->setStatut($data['statut'] ?? $directeur->getStatut());

        // Mise à jour des champs spécifiques
        $directeur->setBureau($data['bureau']);
        $directeur->setTelephonePro($data['telephone_pro'] ?? $directeur->getTelephonePro());
        $directeur->setPlagesDisponibilite($data['plages_disponibilite'] ?? $directeur->getPlagesDisponibilite());
        $directeur->setDateDebut($data['date_debut']);
        $directeur->setDateFin($data['date_fin'] ?? $directeur->getDateFin());

        return $this->directeurdisciplineDAO->update($directeur);
    }
    
      /**
     * Supprime un directeur de discipline
     * @param int $id
     * @return bool
     */

      public function delete($id){
        return $this->directeurdisciplineDAO->delete($id);
      }


}











?>  