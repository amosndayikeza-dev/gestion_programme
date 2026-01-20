<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ ."../../../service/Organisation/AuthService.php";

class AuthService {
    private AuthService $auth_service;

    public function __construct()
    {
       //Initialiser le service d'authentificatio
       $this->auth_service = new AuthService();
    }
    //Afficher le formaulaire d'inscription
    public function LoginForm(){
        require __DIR__ ."/../../views/auth/login.php";
    }

    //traiter le login
    public function Login(){
        //recuperer les donnes du formulaire
        $email = $_POST['email'] ?? "";
        $mot_de_passe  = $_POST['mpt_de_passe'] ?? "";
        //appeler un service pour authentifier l'utilisateur
        $utilisateur = $this->auth_service->Login($email,$mot_de_passe);
        if($utilisateur){
            //stocker l'utilisateur en session
            $_SESSION['utilisateur'] = $utilisateur;
            header("Location:/dashboard");
            exit;
        }else{
           $erreur = "Email ou mot de passe incorrect";
           require __DIR__ ."/../../views/auth/login.php";
        }

    }
    //deconnextion
    public function Logout(){
        session_destroy();
        header("Location:/login");
        exit;
    }
    
}


















?>