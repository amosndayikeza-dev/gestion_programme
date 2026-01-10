<?php
class Database{
    protected $host ="localhost";
    protected $user ="root";
    protected $pwd ="";
    protected $database ="gestion_programme";
    private $pdo = NULL;

    //constructeur

 public function __construct()
 {
    $this->pdo = new PDO("mysql:host=$this->host;nbname=$this->database",$this->user,$this->pwd);
 }
 //trouver la connexion a la bd
 public function getConnexion(){
    return $this->pdo;
 }
}















?>