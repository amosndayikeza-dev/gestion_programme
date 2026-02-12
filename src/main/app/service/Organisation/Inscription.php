<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ ."../../../dao/Organisation/InscriptionDAO.php";
require_once __DIR__ ."../../../dao/Organisation/ClasseDAO.php";
require_once __DIR__ ."../../../dao/Utilisateur/UtilisateurDAO.php";

class InscriptionService{
    private InscriptionDAO $inscriptionDAO;
    private ClasseDAO $classeDAO;
    private UtilisateurDAO $utilisateurDAO;


    public function __construct()
    {
        $this->inscriptionDAO = new InscriptionDAO();
        $this->classeDAO = new ClasseDAO();
        $this->utilisateurDAO = new UtilisateurDAO();
    }

    //nettoyer les donnees
    private function cleanData($data){
        return htmlspecialchars(trim($data));
    }
    public function InscrirEleve($inscription){
        $inscription->setIdInscription($this->cleanData($inscription->getIdInscription()));
        $inscription->setIdUtilisateur($this->cleanData($inscription->getIdUtilisateur()));
        $inscription->setIdClasse($this->cleanData($inscription->getIdClasse()));
        $inscription->setStatut($this->cleanData($inscription->getStatut()));

        //verifier les donnees
        if(empty($inscription->getIdUtilisateur()) || empty($inscription->getIdClasse()) || empty($inscription->getStatut())){
            throw new Exception("Tous les champs sont obligatoires");
        }

        if($inscription->setIdInscription($inscription->getIdInscription())){
            return $this->inscriptionDAO->UpdateInscription($inscription);
        }else{
            return $this->inscriptionDAO->CreateInscription($inscription);
        }

        $this->inscriptionDAO->CreateInscription($inscription);
    }

    public function desinscrireEleve($id_utilisateur,$id_Classe){

       $this->inscriptionDAO->DeleteInscription($id_utilisateur, $id_Classe);
    }

    public function listerInscriptionsParClasse($id_Classe){
        return $this->inscriptionDAO->getByClasse($id_Classe);
    }

    public function listerInscriptionsParUtilisateur($id_utilisateur){
        return $this->inscriptionDAO->getByUtilisateur($id_utilisateur);
    }
    /**
     * modifier une inscription
     */
    public function modifierInscription(Inscription $inscription){
        return $this->inscriptionDAO->UpdateInscription($inscription);
    }
    /**
     * afficher touts les inscriptions
     */
    public function afficherToutesLesInscriptions(){
        return $this->inscriptionDAO->AfficherToutInscription();
    }
    /**
     * supprimer une inscription
     */
    public function supprimerInscription($id_inscription){
        return $this->inscriptionDAO->DeleteInscription($id_inscription);
    }

    /**
     * verifiaction d'une inscription
     */


}













?>