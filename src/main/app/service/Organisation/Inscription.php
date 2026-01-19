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
        $inscriptionDAO = new InscriptionDAO();
        $classeDAO = new ClasseDAO();
        $UtilisateurDAO = new UtilisateurDAO();
    }

    public function InscrirEleve($idUtilisateur,$idClasse){
        if(! $this->utilisateurDAO->getOneUtilisateur($idUtilisateur)){
            throw new Exception("Utilisateur Introuvable");
        }
        if(! $this->classeDAO->getOneClasse($idClasse)){
            throw new Exception("Classe introuvable");
        }
       if ($this->inscriptionDAO->existe($idUtilisateur, $idClasse)) {
            throw new Exception("Déjà inscrit");
        }

        $inscription = new Inscription( null,$idUtilisateur,$idClasse,date('Y-m-d'),'ACTIVE');

        $this->inscriptionDAO->CreateInscription($inscription);
    }

    public function desinscrireEleve($idUtilisateur,$idClasse){
        $inscription = $this->inscriptionDAO->getByUtilisateurAndClasse($idUtilisateur,$idClasse);
        if(!$inscription){
            throw new Exception("Inscription introuvable");
        }

        $this->inscriptionDAO->deleteInscription($inscription->getIdInscription());
    }

    public function listerInscriptionsParClasse($idClasse){
        return $this->inscriptionDAO->getByClasse($idClasse);
    }

    public function verifierInscription($idUtilisateur,$idClasse){
        return $this->inscriptionDAO->existe($idUtilisateur, $idClasse);
    }

    public function listerInscriptionsParUtilisateur($idUtilisateur){
        return $this->inscriptionDAO->getByUtilisateur($idUtilisateur);
    }

}













?>