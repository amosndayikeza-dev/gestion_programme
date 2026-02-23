<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';  // = .../src/main/App
require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Inspecteur/Models/Inspecteur.php';
require_once $root . '/ModuleUtilisateur/Inspecteur/Dao/InspecteurDAO.php';

use App\ModuleUtilisateur\Inspecteur\Dao\InspecteurDAO;
use App\ModuleUtilisateur\Inspcteur\Models\Inspecteur;

echo "<h2>🧪 TEST INSPECTEUR</h2>";
try{
        
    $inspecteur = new Inspecteur();
    $inspecteur->setNom('FIFA');
    $inspecteur->setPrenom('FIFA');
    $inspecteur->setEmail('fifia' . time() . '@gmail.com');
    $inspecteur->setMotDePasse(password_hash('123', PASSWORD_DEFAULT));
    $inspecteur->setStatut('actif');
    $inspecteur->setZoneInspection('BUJUMBURA');
    $inspecteur->setNiveauHabilitation(10);
    $inspecteur->setRole('inspecteur');
    //$inspecteur->setDateEmbauche(date('Y-m-d'));
    $inspecteur->setTelephone('0701234567');

    $inspecteurDAO = new InspecteurDAO();
    $result = $inspecteurDAO->save($inspecteur);

    if(!$result){
        die("Erreur lors de la création de l'inspecteur.");
    }
}catch(PDOException $e){
    die("Erreur de base de données : " . $e->getMessage());
}














?>
