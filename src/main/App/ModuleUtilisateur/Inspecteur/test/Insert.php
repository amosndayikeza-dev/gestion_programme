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
use App\ModuleUtilisateur\Inspecteur\Models\Inspecteur;

echo "<h2>🧪 TEST INSPECTEUR</h2>";
try{
        
    $inspecteur = new Inspecteur();
        // Dans votre test, assurez-vous d'avoir TOUS les champs obligatoires :
    $inspecteur->setNom('FIFA');
    $inspecteur->setPrenom('FIFA');
    $inspecteur->setEmail('fifia' . time() . '@gmail.com');
    $inspecteur->setMotDePasse(password_hash('123', PASSWORD_DEFAULT));
    $inspecteur->setStatut('actif');
    $inspecteur->setRole('inspecteur');  // ← Vérifiez que 'inspecteur' existe dans ENUM
    $inspecteur->setTelephone('0701234567');

    // !!! CHAMPS OBLIGATOIRES POUR INSPECTEUR !!!
    $inspecteur->setSpecialite('Mathématiques');        // ← OBLIGATOIRE
    $inspecteur->setGrade('Inspecteur Principal');      // ← OBLIGATOIRE
    $inspecteur->setZoneGeographique('BUJUMBURA');      // ← OBLIGATOIRE (pas zoneInspection)
    $inspecteur->setDateNomination(date('Y-m-d'));      // ← OBLIGATOIRE

    // Optionnel
    $inspecteur->setNiveauHabilitation(10);

    $inspecteurDAO = new InspecteurDAO();
    $result = $inspecteurDAO->save($inspecteur);

    if(!$result){
        die("Erreur lors de la création de l'inspecteur.");
    }
    echo "<p>✅ Inspecteur créé avec succès ! ID: " . $inspecteur->getIdUtilisateur() . "</p>";
}catch(PDOException $e){
    die("Erreur de base de données : " . $e->getMessage());
}














?>
