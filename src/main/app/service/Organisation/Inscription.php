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

    public function InscrirEleve($id_utilisateur,$id_Classe){
        if(! $this->utilisateurDAO->getOneUtilisateur($id_utilisateur)){
            throw new Exception("Utilisateur Introuvable");
        }
        if(! $this->classeDAO->getOneClasse($id_Classe)){
            throw new Exception("Classe introuvable");
        }
       if ($this->inscriptionDAO->existsInscription($id_utilisateur, $id_Classe)) {
            throw new Exception("Déjà inscrit");
        }

        $inscription = new Inscription( null,$id_utilisateur,$id_Classe,date('Y-m-d'),'ACTIVE');

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