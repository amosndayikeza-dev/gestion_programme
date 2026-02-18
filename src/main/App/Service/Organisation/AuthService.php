<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../dao/Utilisateur/UtilisateurDAO.php';

class AuthService{
    private UtilisateurDAO $utilisateurDAO;

    public function __construct(){
        $this->utilisateurDAO = new UtilisateurDAO();
        //s'assurer que la ssessio est demarre
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }
    
    /**
     * AUTHENTFIER UN UTILISATEUR
     */
    public function Login($email,$mot_de_passe){
        //VERIFIER LES CHAMPS
        if(empty($email) OR empty($mot_de_passe)){
            throw new Exception("Email ou le mot de passe sont obligatoire");
        }

        //recuperer un utilisateur par son email
        $utilisateur = $this->utilisateurDAO->getOneUtilisateurByEmail($email);
        if(!$utilisateur){
            throw new Exception("Utilisateur introuvable");
        }

        if(! password_verify($mot_de_passe,$utilisateur->getMotDePasse())){
            throw new Exception("Mot de passe incorrect");
        }

        //creer une session
        $_SESSION['utilisateur'] = [
            ":id_utilisateur"=>$utilisateur->getIdUtilisateur(),
            ":email_utilisateur"=>$utilisateur->getEmail(),
            ":role"=>$utilisateur->getRole()
        ];

        return $utilisateur; //retourner un utilisateur qui st connecte
    }

    /**
     * Verifier si la session existe
     */
    public function LogOut(){
        //verifier si la session existe
        if(session_status() === PHP_SESSION_ACTIVE){
            //supprimer toutes les donnes de la session
            $_SESSION = [];

            //retrouire la session
            session_destroy();
        }
    }

    /**
     * verifier si l'utilisateur est connecte
     */
    public function verifierSession(){
        //verifier si les infos de l'utilisateur sont dans la sesion
        return isset($_SESSION["utilisateur"]);
    }
    /**
     * Verifier le role avant l'acces 
     */
    public function verifierRole(array $roleAutorise){
        //verifier la session
        if(! $this->verifierSession()){
            throw new Exception("Acces refuse : Utilisateur non connecte");
        }
        
        //recuper le role depuis la session
        $roleUtilisateur = $_SESSION["utilisateur"]['role'];

        //verifier si le role est autorise
        if(! in_array($roleUtilisateur,$roleAutorise)){
            throw new Exception("Acces refuse : permission insuffisantes");
        }
    }
}

?>