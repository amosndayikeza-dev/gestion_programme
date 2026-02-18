<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Utilisateur/ExperienceEleveDAO.php";
require_once __DIR__ ."../../../dao/Utilisateur/NiveauDAO.php";

class ExperienceEleveService{
    private ExperienceEleveDAO $experience_eleve_dao;
    private NiveauDAO $niveau_dao;

    public function __construct()
    {
        $this->experience_eleve_dao = new ExperienceEleveDAO();
        $this->niveau_dao = new NiveauDAO();
    }

    public function AjouterXP($id_utilisateur,$xp){
        $experience = $this->experience_eleve_dao->getIdUtilisateur($id_utilisateur);
        $nouvellexp = $experience->getXP($xp) + $xp;

        $experience->setExperience($nouvellexp);
        $this->experience_eleve_dao->update($experience);

        $niveau = $this->niveau_dao->getNiveau($id_niveau);
        $experience->setNiveau($niveau->getNiveau());
    }

    /**
     * creer une experience
     */
    public function createExperienceEleve($experience_eleve){
        return $this->experience_eleve_dao->CreateExperienceEleve($experience_eleve);
    }
    /**
     * modifier une experience eleve
     */
    public function modifierExperienceEleve( $experience_eleve){
        return $this->experience_eleve_dao->UpdateExperienceEleve($experience_eleve);
    }
    /**
     * afficher une experience eleve
     */
    public function afficherExperienceEleve($id_experience_eleve){
        return $this->experience_eleve_dao->getOneExperienceEleve($id_experience_eleve);
    }
    /**
     * afficher toutes les experiences eleves
     */
    public function afficherToutesLesExperiencesEleves(){
        return $this->experience_eleve_dao->getAllExperienceEleve();
    }
    /**
     * supprimer une experience eleve
     */
    public function supprimerExperienceEleve($id_experience_eleve){
        return $this->experience_eleve_dao->DeleteExperienceEleve($id_experience_eleve);
    }
    

}













?>