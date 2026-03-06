<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ ."/../../..";  // = .../src/main/App

require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Eleve/Models/Eleve.php';
require_once $root . '/ModuleUtilisateur/Eleve/Dao/EleveDAO.php';  // ←


use App\ModuleUtilisateur\Dao\EleveDAO;
use App\ModuleUtilisateur\Eleve\Models\Eleve;


echo "<h2>🧪 TEST ELEVE</h2>";

try{
    $eleve = new Eleve();
    $eleve->setNom('NDAYIKEZA');
    $eleve->setPrenom('VT');
    $eleve->setEmail('VT' . time() . '@gmail.com');
    $eleve->setMotDePasse('123');
    $eleve->setStatut('actif');
    $eleve->setDateNaissance('2005-01-01');
    $eleve->setLieuNaissance('BUJUMBURA');
    $eleve->setSexe('F');
    $eleve->setRole('eleve');
    $eleve->setTelephone('70143569');
    $eleve->setAdresse('KIGALI, RWANDA');
    $eleve->setDateInscription(date('Y-m-d'));
    $eleve->setMatricule('AMCM-'.time());

    $eleveDAO = new EleveDAO();
    $result = $eleveDAO->save( $eleve);
    if(!$result){
        die("Erreur lors de la création de l'élève.");
    }
    echo "<p>✅ Élève créé avec succès !</p>";
}catch(Exception $e){
    die("ERREUR: " . $e->getMessage());  
}










?>