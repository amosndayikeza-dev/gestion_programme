<?php
namespace App\core\Config;
use PDO;
use PDOException;
class Database {
   protected $host = "localhost";
   protected $user = "root";
   protected $pwd = "";
   protected $database = "gestion_programmes";
   private $pdo = null;

      // Constructeur
      public function __construct(){
         try{
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8",$this->user,$this->pwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
         }catch(PDOException $e){
            echo "Fail to connect to the database:".$e->getMessage();
         }
      }
      
    public function getConnexion() {
        return $this->pdo;
    }
}
?>
