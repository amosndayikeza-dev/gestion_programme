<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../service/Utilisateur/UtilisateurService.php";
class UtilisateurController{
    private UtilisateurService $utilisateur_service;

    public function __construct()
    {
       $this->utilisateur_service = new UtilisateurService();
    }

    //Liste des utilisateur
    public function liste(){
        $this->utilisateur_service->ListeUtilisateur();
        require __DIR__ ."/../../views/utilisateur/liste.php";
    }

    //creer un utilisateur
    public function Creer(){
        if($_SERVER["REQUEST_METHOD"] == 'POST'){
            $this->utilisateur_service->AjouterUtilisateur(
                $_POST["nom"],
                $_POST['prenom'],
                $_POST['email'],
                $_POST['mot_de_passe'],
                $_POST['role'],
                $_POST['date_de_creation']
            );
            header("location: /utilisateurs");
            exit;
        }
        require __DIR__ ."/../../views/utilisateur/creer.php";
    }

    //Activer ou Desactiver utilisateur
    public function changerStatut(){
        $this->utilisateur_service->changerStatut(
            $_GET[["id_utilisateur"]],
            $_GET['statut']
        );
        header("location: /utilisateurs");
        exit;
    }
}









?>-