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
        $experience_eleve_dao = new ExperienceEleveDAO();
        $niveau_dao = new NiveauDAO();
    }

    public function AjouterXP($id_utilisateur,$xp){
        $experience = $this->experience_eleve_dao->getIdUtilisateur($id_utilisateur);
        $nouvellexp = $experience->getXP($xp) + $xp;

        $experience->setExperience($nouvellexp);
        $this->experience_eleve_dao->update($experience);

        $niveau = $this->niveau_dao->getNiveau($id_niveau);
        $experience->setNiveau($niveau->getNiveau());

    }
}













?>