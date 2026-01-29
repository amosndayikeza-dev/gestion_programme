<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../dao/Academique/MatiereDAO.php";

class MatiereService {
    private MatiereDAO $matiere_dao;
    public function __construct()
    {
       $this->matiere_dao = new MatierEDAO();
    }
    /**
     * AJOUTER MATIERE
     */
    public function ajouterMatiere(Matiere $matiere){
        return $this->matiere_dao->CreateMatiere($matiere);
    }
    /**
     * modifier matiere
     */
    public function modifierMatiere(Matiere $matiere){
        return $this->matiere_dao->UpdateMatiere($matiere);
    }
    /**
     * AFFICHER UNE MATIERE
     */
    public function afficherUneMatiere($id_matiere){
        return $this->matiere_dao->GetoneMatiere($id_matiere);
    }
    /**
     * afficher totes les matires
     */
    public function afficherToutesLesMatieres(){
        return $this->matiere_dao->AfficherToutesLesMatiere();
    }

    /**
     * SUPPRIMER UNE MATIERE
     */
    public function supprimerMatiere($id_matiere){
        return $this->matiere_dao->DeleteMatiere($id_matiere);
    }
}










?>