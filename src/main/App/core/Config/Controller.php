<?php
namespace App\Core\Config;

use Exception;

abstract class Controller{
    protected $db;

    public function __construct(){
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $database = new Database();
        $this->db = $database->getConnexion();
    
    }

    /**
     * Enregistre un message flash en session
     * @param string $key   Identifiant du message (ex: 'success', 'error')
     * @param mixed $value  Contenu du message
     */
    protected function setFlash(string $key, $value): void
    {
        $_SESSION['flash'][$key] = $value;
    }

    /**
     * Récupère et supprime un message flash de la session
     * @param string $key
     * @return mixed|null
     */
    protected function getFlash(string $key)
    {
        if (isset($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $value;
        }
        return null;
    }

    protected function render($view, $data = []){
        extract($data);//nconvertir chaque cle du tableau en variable php
        $viewPath = __DIR__ . "/../views/" . $view . ".php";

        if(file_exists(($viewPath))){
            require $viewPath;
        }else{
            throw new Exception("Vue non trouvée : ".$viewPath, "404");
        }
    }

    protected function redirect($url){
        header("Location : $url");
        exit;
    }

    protected function isAuthentificated(){
        return isset($_SESSION['user_id']);
    }
}











?>